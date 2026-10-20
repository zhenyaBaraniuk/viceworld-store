# Implementation Plan: JSON-Based Static Text Translation Infrastructure

**Branch**: `001-i18n-json-translations` | **Date**: 2026-08-31 | **Spec**: [spec.md](./spec.md)

**Input**: Feature specification from `/specs/001-i18n-json-translations/spec.md`

## Summary

Add a flat-key JSON translation store (`lang/uk.json`, `lang/en.json`) shared to
every Inertia page via the existing global `HandleInertiaRequests` middleware, a
`useTranslation()` frontend hook for looking up strings by key with a
visible-key fallback when a translation is missing, and a canonical-URL fallback
route so any request without (or with an unsupported) locale prefix redirects to
the default-locale-prefixed equivalent instead of erroring. All static text
currently hardcoded across Header, Footer, Home, Catalog, Product, Search,
Checkout, SuccessOrder, and Profile is migrated to use the new lookup.

## Technical Context

**Language/Version**: PHP `^8.3` (Laravel 12) backend; TypeScript `^6.0` + React `^19` frontend (Inertia 3 via `@inertiajs/react`)

**Primary Dependencies**: Laravel 12, Inertia.js, `ziggy-js` (route() helper), Vite 8. New: Vitest (frontend unit test runner — none currently exists in the repo; required to satisfy Constitution Principle IV for the new `useTranslation` hook)

**Storage**: Flat-key JSON files, `lang/uk.json` and `lang/en.json` at the project root — Laravel's native JSON-translation-file location. No database table.

**Testing**: PHPUnit (Feature tests, in-memory SQLite) for backend routing/middleware/sharing; new Vitest unit tests for the frontend `useTranslation` hook

**Target Platform**: Web storefront; all PHP-toolchain commands run inside Laradock per Constitution Principle II

**Project Type**: Web application — Laravel backend + Inertia/React frontend in a single repository (not a split frontend/backend directory layout)

**Performance Goals**: Translation payload MUST ship with the initial Inertia response (FR-004), no follow-up request; expected size is well under 50KB for the realistic key count of this store, negligible next to the existing JS bundle

**Constraints**: MUST NOT change the URL or behavior of the already-shipped `{locale}` prefix routes (`Front\SetLocale` middleware, existing `whereIn(['en','uk'])` route constraint) — only add handling for the two edge cases it doesn't yet cover (no prefix, unsupported prefix); `composer check` and `npm run fix` MUST pass before the feature is considered done (Development Workflow gate)

**Scale/Scope**: 9 page/component areas (Header, Footer, Home + its 4 subcomponents, Catalog, Product, Search, Checkout, SuccessOrder, Profile) currently carry hardcoded English UI copy (the storefront has no localization at all yet — only the separately-tracked Filament admin has hardcoded Ukrainian labels) to be migrated to keyed lookups in both locales; exact key inventory happens during `/speckit-tasks`.

## Constitution Check

*GATE: Must pass before Phase 0 research. Re-check after Phase 1 design.*

| Principle | Status | Notes |
|---|---|---|
| I. Design System Compliance | PASS | No new visual surface; a missing-key fallback renders as plain text using existing typography, no new brutalist-relevant UI introduced. |
| II. Environment Isolation via Laradock | PASS | All `php artisan`/`composer` work for this feature runs inside Laradock. |
| III. i18n From Day One for New UI | PASS | This feature is the i18n infrastructure itself; FR-009 retrofits all prior hardcoded areas. |
| IV. Test-First for Spec-Driven Features (NON-NEGOTIABLE) | PASS (with an addition) | Backend logic (fallback route, translation sharing) is testable today via existing PHPUnit/SQLite. The frontend has **no test runner at all** — a real gate risk for FR-007/FR-010, which are frontend-only concerns. Resolved by adding a minimal Vitest setup (see research.md §5) so `tasks.md` can order a failing hook test before the hook is implemented, rather than skipping frontend coverage. |
| V. Database Portability | PASS (N/A) | No migrations, no DB tables — translations are files. |
| VI. Human-Owned Commits | PASS | Planning artifacts only; implementation and commits remain with the project owner. |

No unjustified violations. Complexity Tracking table is empty — the one gap found (missing frontend test runner) is resolved with a proportionate, minimal addition rather than a documented exception.

## Project Structure

### Documentation (this feature)

```text
specs/001-i18n-json-translations/
├── plan.md              # This file
├── research.md          # Phase 0 output
├── data-model.md         # Phase 1 output
├── quickstart.md        # Phase 1 output
├── contracts/            # Phase 1 output
│   └── translation-sharing.md
└── tasks.md             # Phase 2 output (/speckit-tasks — not created here)
```

### Source Code (repository root)

```text
lang/
├── uk.json                                   # NEW — flat-key Ukrainian strings
└── en.json                                   # NEW — flat-key English strings

app/
├── Services/
│   └── TranslationService.php                # NEW — reads/decodes lang/{locale}.json
└── Http/
    └── Middleware/
        ├── Front/SetLocale.php               # EXISTING — locale detection, unchanged
        ├── Admin/HandleInertiaRequests.php   # EXISTING — inject TranslationSharedData
        └── SharedData/
            ├── MenuSharedData.php            # EXISTING — precedent for the pattern below
            └── TranslationSharedData.php     # NEW — resolves the `translations` shared prop

routes/
└── web.php                                   # MODIFIED — add Route::fallback() for canonical-locale redirect

resources/js/
├── hooks/
│   └── useTranslation.ts                     # NEW — t(key) lookup + missing-key fallback
├── types/
│   └── global.d.ts                           # MODIFIED — add `translations` to sharedPageProps
├── Components/ , Pages/, Layouts/            # MODIFIED — migrated to use useTranslation()

tests/
└── Feature/
    └── Localization/                         # NEW — PHPUnit: fallback redirect, shared translations

resources/js/hooks/__tests__/
└── useTranslation.test.ts                    # NEW — Vitest: hook lookup + fallback behavior

package.json                                  # MODIFIED — add vitest devDependency + "test:js" script
```

**Structure Decision**: This is a monolithic Laravel + Inertia app, not a split
frontend/backend repo — new backend code follows the existing
`app/Http/Middleware/SharedData/` pattern already established by
`MenuSharedData`, and new frontend code follows the existing `resources/js/`
layout (a new `hooks/` directory, since none exists yet for shared React hooks).

## Complexity Tracking

*No entries — no unjustified Constitution violations (see Constitution Check above).*
