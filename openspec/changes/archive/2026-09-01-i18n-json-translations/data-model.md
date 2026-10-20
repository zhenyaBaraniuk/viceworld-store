# Phase 1 Data Model: JSON-Based Static Text Translation Infrastructure

Both entities are content, not application data — neither has a database
table, an id, or a lifecycle beyond being hand-edited in a file and read back.

## Locale

A supported language variant.

| Field | Type | Notes |
|---|---|---|
| `code` | `"uk" \| "en"` | Matches the existing `Front\SetLocale::SUPPORTED` list — this feature does not add a third locale. |
| `is_default` | bool | True only for `uk` (`config('app.locale')`); used by the FR-005/FR-006 fallback redirect and by the missing-translation-file guard. |

Source of truth: `config('app.locale')` for the default, `Front\SetLocale::SUPPORTED`
(already existing) for the supported set. No new config file or table.

## Translation Entry

A single translated string.

| Field | Type | Notes |
|---|---|---|
| `key` | string | Flat, dot-namespaced (e.g. `"cart.empty"`, `"checkout.address.title"`). Unique within one locale's file — a duplicate JSON key would silently collide, so key naming during migration must stay disciplined (flagged for `/speckit-tasks`, not runtime-enforced). |
| `locale` | `"uk" \| "en"` | Which file (`lang/{locale}.json`) the entry lives in. |
| `value` | string | Plain static text only. Per Clarifications: **no embedded dynamic values** (FR-010) and **no plural-form variants** — one invariant string regardless of any nearby count. |

**Storage**: One JSON object per locale (`lang/uk.json`, `lang/en.json`), each a
flat `{ "key": "value", ... }` map. Versioned via git like any other source
file — no migration, no seeder.

**Relationships**: A Translation Entry belongs to exactly one Locale (the file
it's in). The same `key` *should* exist in both locale files (parity), but
this is not runtime-enforced: if a key is missing from one locale's file, the
FR-007 fallback (render the key itself) applies for that locale only — this is
expected, recoverable state during migration, not an error condition.

**Validation rules** (derived from Requirements):
- FR-002 / FR-009 — every key referenced by a migrated component must exist in
  at least the default locale's file for the page to be considered migrated;
  parity across both locale files is a code-review concern for
  `/speckit-tasks`, not a build-time check in this feature's scope.
- FR-010 — a value must not rely on any placeholder/interpolation syntax
  (e.g. `{count}`) because the lookup mechanism (`useTranslation`) provides no
  interpolation — nothing to validate at runtime, the capability simply
  doesn't exist.

**State transitions**: None. Entries are added, edited, or removed by directly
editing the JSON file; there is no draft/published lifecycle in scope.
