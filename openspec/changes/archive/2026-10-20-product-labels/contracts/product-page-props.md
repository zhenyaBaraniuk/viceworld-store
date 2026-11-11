# Contract: Product Page Inertia Props — `labels`

This app has no REST/JSON API surface for this feature; the only cross-layer contract is the
Inertia page props Laravel hands to React for `GET /{locale}/products/{slug}`. This document
pins down the `labels` addition to that contract so backend (`ProductData`) and frontend
(`Product` type) cannot drift.

## Shape

```ts
// resources/js/types/models/product.ts — Product.labels
labels: { id: string; name: string }[];
```

```php
// app/Data/Product/ProductData.php — ProductData::$labels
/** @var array<LabelData> */
public array $labels;

// LabelData
public string $id;
public string $name; // already resolved to the request's current locale server-side
```

## Guarantees

- `labels` is **always present** and is **always an array** (never `null`) — an unlabeled
  product serializes `labels: []`, not an omitted key. This is what lets `Product.tsx` use a
  simple `.length > 0` guard (FR-006) without an extra null-check.
- Array order **is** display order (FR-010) — the frontend MUST NOT re-sort `labels` (no
  alphabetical sort, no client-side reordering). Orders is fully determined server-side by
  `label_product.position`.
- `name` is already localized to the current request locale server-side (same pattern as
  `AttributeValueData::$name`, which resolves via `$attributeValue->attribute->name` →
  `HasTranslateAttributes::translated()`) — the frontend never receives raw per-locale objects
  for this field and does not need to pick a locale itself.
- Adding a label with a blank/missing translation for the *current* locale cannot happen from
  the frontend's perspective as an empty string in `name` — `astrotomic/laravel-translatable`'s
  configured `fallback_locale` (`en`, see `config/translatable.php`) resolves it server-side
  before serialization (per spec's Edge Cases: "missing translation" is a server-side fallback
  concern, not something `Product.tsx` handles).

## Example payload

Product with two labels, requested at `/uk/products/some-slug`:

```json
{
  "product": {
    "...": "...",
    "labels": [
      { "id": "01ARZ3NDEKTSV4RRFFQ69G5FAV", "name": "Основна колекція" },
      { "id": "01ARZ3NDEKTSV4RRFFQ69G5FAW", "name": "Лімітована серія" }
    ]
  }
}
```

Product with none:

```json
{ "product": { "...": "...", "labels": [] } }
```
