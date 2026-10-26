# Phase 1 Data Model: Product Labels

Derived from `spec.md` Key Entities (FR-001–FR-010) and `research.md` decisions 1–2. Mirrors the
existing `Attribute` / `AttributeTranslation` / `Product::related()` patterns already in this
codebase — no new modeling primitives are introduced.

## Label

Represents an admin-defined tag describing a product's positioning (e.g. "Core Collection",
"Limited Edition"). Corresponds to spec's **Label** entity.

| Field | Type | Notes |
|---|---|---|
| `id` | `ulid`, primary key | No auto-increment surrogate — matches `Attribute`, `Category`, `Product`. |

- No `$timestamps` (matches `Attribute`).
- Translatable via `translatedAttributes = ['name']` (matches `Attribute` exactly).
- Relationships:
  - `translations` — `HasMany<LabelTranslation>` (implicit, via `Translatable` trait).
  - `products` — `BelongsToMany<Product>` through `label_product`, **with pivot `position`**,
    ordered by pivot (`->withPivot('position')->orderByPivot('position')`), mirroring
    `Product::related()`.
- Validation rules (from FR-001/FR-002): `name` required per locale, string, reasonable max
  length (`255`, matching `Attribute`'s `name` `TextInput` rule) — enforced in the Filament form,
  not the DB schema (consistent with how `Attribute`'s `name` is validated today).
- No uniqueness constraint on `name` — spec's Edge Cases explicitly allow duplicate label names
  across different `Label` records.

## LabelTranslation

One translated name per `(label, locale)` pair. Corresponds to the translated-name part of the
spec's **Label** entity.

| Field | Type | Notes |
|---|---|---|
| `id` | `ulid`, primary key | Matches `AttributeTranslation`. |
| `label_id` | `ulid`, foreign key → `labels.id` | |
| `locale` | `string` | One of the app's configured locales (`uk`, `en` — see `config/translatable.php`). |
| `name` | `string` | Required, the translated display text (e.g. "Core Collection" / "Основна колекція"). |

- No `$timestamps` (matches `AttributeTranslation`).
- `fillable = ['name']` (matches `AttributeTranslation`; `label_id`/`locale` are managed by the
  `Translatable` trait, not mass-assigned directly).

## label_product (pivot)

Represents the spec's **Product–Label Association** entity, including the assignment order
resolved in Clarifications (FR-010).

| Field | Type | Notes |
|---|---|---|
| `label_id` | `ulid` | Part of composite primary key. |
| `product_id` | `ulid` | Part of composite primary key. |
| `position` | integer | Orders in which the administrator assigned this label to this product; drives display order per FR-010. Written by `LabelResource`/`ProductForm`'s `saveRelationshipsUsing()` from selection order — not user-editable directly. |

- No surrogate `id`, no timestamps (matches `attribute_value_product_variant` and
  `product_related`).
- Composite primary key on (`label_id`, `product_id`) — enforces FR-004's "no duplicate
  assignment of the same label to the same product twice" implicitly (re-assigning re-syncs the
  pivot row rather than duplicating it).

## Product (extended)

No new columns. Gains one relationship:

- `labels()` — `BelongsToMany<Label>` through `label_product`, `withPivot('position')`,
  `orderByPivot('position')` — the read side of the association above, used by both
  `ProductForm`'s `Select::make('labels')` and `ProductData::fromModel()`.

## Relationships Diagram

```
Product  ──┐
           │  belongsToMany (label_product: label_id, product_id, position)
Label    ──┘

Label ──hasMany──> LabelTranslation (label_id, locale, name)
```

## State / Lifecycle

No state machine — `Label` and the association are plain CRUD records (create / update / delete),
per spec's Edge Cases: deleting a `Label` cascades only to its `label_product` rows (detach), never
to the `Product` records themselves (FR-008).

## Data Transfer (frontend-facing shape)

`LabelData` (new `Spatie\LaravelData\Data` DTO, mirrors `AttributeValueData`):

| Field | Type |
|---|---|
| `id` | `string` |
| `name` | `string` (translated, current locale) |

`ProductData` gains:

```
/** @var array<LabelData> */
public array $labels;
```

populated as `$product->labels->map(fn ($label) => LabelData::fromModel($label))->values()->all()`
— already ordered correctly because the `labels()` relationship is `orderByPivot('position')`.
