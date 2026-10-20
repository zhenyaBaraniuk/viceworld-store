# Contract: Translation Storage, Sharing & Locale-Routing

Internal contract between the Laravel backend and the Inertia/React frontend
for this feature. No public/external API is exposed — see plan.md's
Constitution Check for why a lighter contracts doc (rather than an OpenAPI
spec) is appropriate here.

## 1. Translation file schema

`lang/uk.json` and `lang/en.json`, each a flat JSON object:

```json
{
  "nav.home": "Головна",
  "cart.empty": "Кошик порожній",
  "checkout.address.title": "Адреса доставки"
}
```

- Keys: dot-namespaced strings, unique within a file.
- Values: plain strings only. No arrays, no nested objects, no `{placeholder}`
  interpolation syntax, no plural-form variants (FR-010, and the Clarifications
  in spec.md).

## 2. Inertia shared prop

Every Inertia response carries:

```ts
// resources/js/types/global.d.ts — sharedPageProps addition
translations: Record<string, string>;
```

- Source: `App\Http\Middleware\SharedData\TranslationSharedData::resolve()`,
  which returns the fully decoded map for `app()->getLocale()` — i.e. the
  *entire* map for the active locale, not just the keys used by the current
  page (FR-004: no follow-up request).
- Consumed by `useTranslation()` on the frontend, which reads
  `usePage().props.translations` and exposes `t(key): string`.

## 3. `t(key)` lookup contract

| Input | Output |
|---|---|
| `key` present in the active locale's `translations` map | The mapped value |
| `key` absent from the active locale's `translations` map | The `key` string itself, unmodified (FR-007) |

`t()` never throws and never returns `undefined`/`null` — every call resolves
to a displayable string.

## 4. Locale-prefix routing contract

| Request path | Response |
|---|---|
| `/{supported-locale}/...` (e.g. `/uk/catalog`) | Existing behavior, unchanged — handled by `Front\SetLocale` inside the existing route group. |
| `/` (bare root) | 302 → `/{default-locale}` — existing behavior (`Route::redirect('/', ...)`), unchanged. |
| Any other path with no locale prefix (e.g. `/catalog`) | **NEW** — 302 → `/{default-locale}/catalog` |
| Any path with an unsupported locale prefix (e.g. `/fr/catalog`) | **NEW** — 302 → `/{default-locale}/catalog` (the unsupported segment is replaced, not kept) |
| `/{supported-locale}/...` where nothing after it matches a real route (e.g. `/uk/this-does-not-exist`) | **NEW** — 404, *not* a redirect (loop-prevention branch — see research.md §3) |

`{default-locale}` is `config('app.locale')` (currently `uk`).
