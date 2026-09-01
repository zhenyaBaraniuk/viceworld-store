# Tasks: JSON-Based Static Text Translation Infrastructure

**Input**: Design documents from `/specs/001-i18n-json-translations/`

**Prerequisites**: plan.md, spec.md, research.md, data-model.md, contracts/translation-sharing.md, quickstart.md

**Tests**: Required — Constitution Principle IV (Test-First for Spec-Driven Features, NON-NEGOTIABLE). Every test task below MUST be written and MUST fail before its paired implementation task runs.

**Organization**: Tasks are grouped by user story (spec.md priorities P1/P2/P3) to enable independent implementation and testing of each story.

## Format: `[ID] [P?] [Story] Description`

- **[P]**: Can run in parallel (different files, no dependency on an incomplete task)
- **[Story]**: US1 / US2 / US3, per spec.md
- All commands run inside Laradock (Constitution Principle II)

---

## Phase 1: Setup

- [X] T001 [P] Add `vitest` as a devDependency and a `"test:js": "vitest run"` script to `package.json`, per research.md §5
- [X] T002 [P] Create empty flat-key JSON files `lang/uk.json` and `lang/en.json` (each containing `{}`) at the repo root, per data-model.md
- [X] T003 [P] Create the `resources/js/hooks/` directory with a `resources/js/hooks/__tests__/` subdirectory for the new hook and its test

**Checkpoint**: Empty scaffolding in place; no behavior yet.

---

## Phase 2: Foundational (Blocking Prerequisites)

**Purpose**: The translation-loading/sharing/lookup pipeline and the canonical-URL redirect — every user story below depends on this being in place.

**⚠️ CRITICAL**: No user story work can begin until this phase is complete.

### Tests for Foundational (write first, confirm they FAIL)

- [X] T004 [P] PHPUnit test for `App\Services\TranslationService::forLocale()` — asserts it returns the decoded flat map from `lang/{locale}.json` for a given locale, and an empty array (not an error) if the file is empty — in `tests/Feature/Localization/TranslationServiceTest.php`
- [X] T005 [P] PHPUnit test for the canonical-URL fallback route — asserts: (a) `GET /catalog` (no locale prefix) returns 302 to `/uk/catalog`; (b) `GET /fr/catalog` (unsupported prefix) returns 302 to `/uk/catalog`; (c) `GET /uk/this-page-does-not-exist` (valid prefix, unmatched path) returns 404 and is **not** a redirect — in `tests/Feature/Localization/LocaleFallbackRedirectTest.php`, per contracts/translation-sharing.md §4
- [X] T006 [P] Vitest test for `useTranslation()` — asserts `t(key)` returns the mapped value when `key` exists in the translations map, and returns `key` itself unmodified when it doesn't — in `resources/js/hooks/__tests__/useTranslation.test.ts`, per contracts/translation-sharing.md §3

### Implementation for Foundational

- [X] T007 Implement `App\Services\TranslationService` (reads and `json_decode`s `lang/{locale}.json` via `lang_path()`) in `app/Services/TranslationService.php` — makes T004 pass
- [X] T008 Implement `App\Http\Middleware\SharedData\TranslationSharedData` (mirrors the existing `MenuSharedData` pattern; `resolve()` returns `['translations' => fn () => $this->translationService->forLocale(app()->getLocale())]`) in `app/Http/Middleware/SharedData/TranslationSharedData.php` — depends on T007
- [X] T009 Inject `TranslationSharedData` into `App\Http\Middleware\Admin\HandleInertiaRequests` and spread its `resolve()` output into `share()`, in `app/Http/Middleware/Admin/HandleInertiaRequests.php` — depends on T008
- [X] T010 Add a `Route::fallback()` handler in `routes/web.php` implementing the table in contracts/translation-sharing.md §4 (redirect when the first path segment isn't a supported locale; plain 404 when it already is one) — makes T005 pass
- [X] T011 [P] Implement `useTranslation()` in `resources/js/hooks/useTranslation.ts` (reads `usePage().props.translations`, exposes `t(key): string` per contracts/translation-sharing.md §3) — makes T006 pass
- [X] T012 [P] Add `translations: Record<string, string>` to `sharedPageProps` in `resources/js/types/global.d.ts`

**Checkpoint**: Translation data flows end-to-end (file → shared prop → `t()`), the redirect/404 contract holds, and T004–T006 are green. User story implementation can now begin.

---

## Phase 3: User Story 1 - Visitor reads the site in their chosen language (Priority: P1) 🎯 MVP

**Goal**: Every static text on Header, Footer, Home, Catalog, Product, Search, Checkout, SuccessOrder, and Profile renders in the locale indicated by the URL (FR-002, FR-009).

**Independent Test**: Visit the same page under `/uk/...` and `/en/...` and confirm every static string differs correctly between the two.

### Tests for User Story 1 (write first, confirm they FAIL)

- [X] T013 [P] [US1] PHPUnit test: `/uk/` and `/en/` Inertia responses carry different, correctly-mapped translated copy for Header/Footer-sourced keys, in `tests/Feature/Localization/HeaderFooterLocalizationTest.php`
- [X] T014 [P] [US1] PHPUnit test: `/uk/` vs `/en/` home page differs for Hero/CategoryTiles/NewArrivals/StoreLocations copy, in `tests/Feature/Localization/HomeLocalizationTest.php`
- [X] T015 [P] [US1] PHPUnit test: Catalog page copy differs by locale, in `tests/Feature/Localization/CatalogLocalizationTest.php`
- [X] T016 [P] [US1] PHPUnit test: Product page copy differs by locale, in `tests/Feature/Localization/ProductLocalizationTest.php`
- [X] T017 [P] [US1] PHPUnit test: Search page copy differs by locale, in `tests/Feature/Localization/SearchLocalizationTest.php`
- [X] T018 [P] [US1] PHPUnit test: Checkout page copy differs by locale, in `tests/Feature/Localization/CheckoutLocalizationTest.php`
- [X] T019 [P] [US1] PHPUnit test: SuccessOrder page copy differs by locale, in `tests/Feature/Localization/SuccessOrderLocalizationTest.php`
- [X] T020 [P] [US1] PHPUnit test: Profile pages copy differs by locale, in `tests/Feature/Localization/ProfileLocalizationTest.php`

### Implementation for User Story 1

- [X] T021 [US1] Add Header/Footer keys to `lang/uk.json` + `lang/en.json`; migrate `resources/js/Components/Header.tsx` and `resources/js/Components/Footer.tsx` to `useTranslation()` — makes T013 pass; depends on T011
- [X] T022 [P] [US1] Add Home-area keys to both locale files; migrate `resources/js/Pages/Home/index.tsx`, `Hero.tsx`, `CategoryTiles.tsx`, `NewArrivals.tsx`, `StoreLocations.tsx` — makes T014 pass
- [X] T023 [P] [US1] Add Catalog keys to both locale files; migrate the Catalog page/components under `resources/js/Pages/Catalog/` — makes T015 pass
- [X] T024 [P] [US1] Add Product keys to both locale files; migrate `resources/js/Pages/Product/` — makes T016 pass
- [X] T025 [P] [US1] Add Search keys to both locale files; migrate `resources/js/Pages/Search/` — makes T017 pass
- [X] T026 [P] [US1] Add Checkout keys to both locale files; migrate `resources/js/Pages/Checkout/` — makes T018 pass
- [X] T027 [P] [US1] Add SuccessOrder keys to both locale files; migrate `resources/js/Pages/SuccessOrder/` — makes T019 pass
- [X] T028 [P] [US1] Add Profile keys to both locale files; migrate `resources/js/Pages/Profile/` — makes T020 pass

**Checkpoint**: US1 fully functional and independently testable — FR-002 and FR-009 satisfied for every listed area.

---

## Phase 4: User Story 2 - Content owner edits copy without touching component code (Priority: P2)

**Goal**: A wording change in one locale file is enough — no component edit required (FR-003).

**Independent Test**: Change an already-used key's value in one locale file, reload, confirm the new text with zero component changes.

### Tests for User Story 2 (write first, confirm it FAILS)

- [X] T029 [US2] PHPUnit test: changing the value of an existing, already-referenced key in `lang/uk.json` (via a test fixture copy) changes the corresponding Inertia response prop, with the assertion structured so it would fail if any component needed touching — in `tests/Feature/Localization/EditTranslationWithoutCodeTest.php`

### Implementation for User Story 2

- [X] T030 [US2] Add `lang/README.md` documenting the flat dot-key convention for content owners (one file per locale, no `{placeholder}` interpolation, no plural-form variants — per the Clarifications in spec.md) — makes the editing workflow behind T029 discoverable without reading the full spec

**Checkpoint**: US2 independently testable — proven by construction from Foundational + US1, with regression coverage and a documented workflow.

---

## Phase 5: User Story 3 - Page stays usable when a translation is missing (Priority: P3)

**Goal**: A page referencing a not-yet-translated key still renders, showing the key itself rather than crashing (FR-007).

**Independent Test**: Remove one key from a locale file, load a page that references it, confirm a clean render with a visible fallback instead of an error.

### Tests for User Story 3 (write first, confirm it FAILS)

- [X] T031 [US3] PHPUnit test: a migrated page (e.g. Home) still returns HTTP 200 when one of its referenced keys is deliberately absent from `lang/uk.json`, simulating partial migration — in `tests/Feature/Localization/MissingKeyDoesNotBreakPageTest.php`

**Note**: The actual key-name fallback *rendering* is already covered by T006's Vitest test and implemented in T011 (Foundational) — this phase adds page-level regression coverage on top, not new fallback logic.

**Checkpoint**: All three user stories independently functional and tested.

---

## Phase 6: Polish & Cross-Cutting Concerns

- [X] T032 PHPUnit test validating SC-004: walk the full purchase journey (home → product → search → checkout → success-order) as five sequential GET requests under a single locale prefix (e.g. `/en/...`), asserting none of the five Inertia responses contains a translation fallback (a raw, untranslated key) for any key migrated in US1 — in `tests/Feature/Localization/PurchaseJourneyLocalizationTest.php`. Not a red-first TDD task like T004–T006/T013–T020 — it validates the already-implemented US1 migration + Foundational redirect infra end-to-end, so write it after Phase 3–5 are done and expect it green immediately; a failure here means something broke on a page *transition*, not on an individual page.
- [X] T033 [P] Run `composer check` (pint → rector dry-run → phpstan → test) and fix any findings, per Constitution Development Workflow
- [X] T034 [P] Run `npm run fix` (typecheck → lint:fix → format) and fix any findings, per Constitution Development Workflow
- [X] T035 [P] Run `npm run test:js` and `composer test` to confirm the full suite (T004–T006, T013–T020, T029, T031, T032) is green
- [X] T036 Execute `specs/001-i18n-json-translations/quickstart.md` end-to-end, including the redirect-loop check in its §4

---

## Dependencies & Execution Order

### Phase Dependencies

- **Setup (Phase 1)**: No dependencies
- **Foundational (Phase 2)**: Depends on Setup — BLOCKS all user stories
- **User Stories (Phase 3-5)**: All depend on Foundational; US1/US2/US3 are independently testable from each other once Foundational is done
- **Polish (Phase 6)**: Depends on all desired user stories being complete

### Within Each Phase

- Test tasks MUST be written and confirmed failing before their paired implementation task (Constitution Principle IV)
- T007 → T008 → T009 → (T010 independent of T008/T009, depends only on T005 existing) — see task descriptions for exact per-task dependencies
- T021 depends on T011 (the hook must exist before a component can call it); T022–T028 depend on the same but are otherwise mutually independent (`[P]`)

### Parallel Opportunities

- T001–T003 (Setup) — all parallel
- T004–T006 (Foundational tests) — all parallel
- T011, T012 (Foundational implementation) — parallel with each other, after T007–T010
- T013–T020 (US1 tests) — all parallel
- T022–T028 (US1 implementation, after T021 establishes the pattern once) — all parallel
- T033–T035 (Polish) — parallel; T032 runs before them (it's the thing they're gating on being green)

---

## Parallel Example: User Story 1

```bash
# Tests, launched together:
Task: "PHPUnit test: Home page copy differs by locale in tests/Feature/Localization/HomeLocalizationTest.php"
Task: "PHPUnit test: Catalog page copy differs by locale in tests/Feature/Localization/CatalogLocalizationTest.php"
Task: "PHPUnit test: Product page copy differs by locale in tests/Feature/Localization/ProductLocalizationTest.php"

# Implementation, launched together once T021 lands the useTranslation() pattern on Header/Footer:
Task: "Migrate resources/js/Pages/Home/* to useTranslation()"
Task: "Migrate resources/js/Pages/Catalog/* to useTranslation()"
Task: "Migrate resources/js/Pages/Product/* to useTranslation()"
```

---

## Implementation Strategy

### MVP First (User Story 1 Only)

1. Phase 1: Setup
2. Phase 2: Foundational (critical — blocks everything)
3. Phase 3: User Story 1 — this alone delivers a fully bilingual storefront
4. **STOP and VALIDATE**: run quickstart.md §1 and §4
5. Demo if ready

### Incremental Delivery

1. Setup + Foundational → translation pipeline ready, redirect/404 contract in place
2. US1 → full bilingual storefront (MVP)
3. US2 → regression proof + docs that editing stays code-free
4. US3 → regression proof that partial migration never breaks a page
5. Polish → gate commands green, quickstart fully walked

---

## Notes

- `[P]` tasks touch different files with no dependency on an incomplete task
- Every test task must fail before its paired implementation task begins (Constitution Principle IV, NON-NEGOTIABLE)
- Commit after each task or logical group (the project owner commits — Constitution Principle VI)
- Stop at any checkpoint to validate a story independently before moving on
