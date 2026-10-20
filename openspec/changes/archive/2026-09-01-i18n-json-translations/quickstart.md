# Quickstart: Validate JSON-Based Static Text Translation Infrastructure

Manual, end-to-end validation once `/speckit-implement` has completed the
tasks from `tasks.md`. Run everything inside Laradock per Constitution
Principle II. References contracts/data-model instead of repeating them.

## Prerequisites

- `lang/uk.json` and `lang/en.json` exist with at least one shared key (see
  [contracts/translation-sharing.md](./contracts/translation-sharing.md) §1).
- `useTranslation()` exists at `resources/js/hooks/useTranslation.ts` and at
  least one migrated component (e.g. `Header.tsx`) calls it.
- `Route::fallback()` is registered per
  [contracts/translation-sharing.md](./contracts/translation-sharing.md) §4.
- `npm run build` (or `npm run dev`) has run so the frontend reflects the
  latest code.

## 1. Locale text swap (User Story 1)

```bash
# inside Laradock
php artisan serve
```

- Open `/uk/` — confirm the migrated component's text matches `lang/uk.json`.
- Open `/en/` — confirm the same component's text matches `lang/en.json`.
- Navigate between pages while staying on `/en/...` — confirm text stays
  English with no full page reload (Inertia navigation).

**Expected**: Text differs correctly by locale on every migrated page listed
in `data-model.md` / `spec.md` FR-009.

## 2. Edit without touching code (User Story 2)

- Change the value of one already-used key in `lang/uk.json` only.
- Reload the affected `/uk/...` page.

**Expected**: New text appears; no `.tsx`/`.php` file was touched.

## 3. Missing-key fallback (User Story 3)

- Temporarily delete one key from `lang/uk.json` (keep it in `lang/en.json`).
- Reload the `/uk/...` page that references it.

**Expected**: Page renders without error; the raw key name is visible in place
of the missing text (contract §3). Restore the key afterward.

## 4. Canonical-URL redirects (FR-005, FR-006, Edge Cases)

```bash
curl -I http://localhost:8000/catalog
curl -I http://localhost:8000/fr/catalog
curl -I http://localhost:8000/uk/this-page-does-not-exist
```

**Expected**:
- `/catalog` → `302` with `Location: /uk/catalog`
- `/fr/catalog` → `302` with `Location: /uk/catalog`
- `/uk/this-page-does-not-exist` → `404`, **not** another `Location` redirect
  (loop-prevention branch — if this one redirects, stop and re-check the
  fallback route logic before continuing).

## 5. Automated checks

```bash
composer check   # pint + rector (dry-run) + phpstan + phpunit
npm run fix       # typecheck + eslint --fix + prettier
npm run test:js   # vitest — useTranslation hook (lookup + fallback)
```

**Expected**: All four pass. Per Constitution Principle IV, the PHPUnit tests
for the fallback route and the Vitest tests for `useTranslation` must exist
and must have been red before the corresponding implementation task turned
them green (verified in `tasks.md`, not re-verified here).

## 6. Full purchase journey in one language (SC-004)

- Starting from `/en/`, browse: home → product → search → checkout → order
  success, staying on English-prefixed URLs throughout.

**Expected**: No untranslated (hardcoded-Ukrainian or fallback-key) fragments
visible on any of those five pages.
