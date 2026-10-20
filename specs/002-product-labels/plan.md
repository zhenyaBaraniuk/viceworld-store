# Implementation Plan: Product Labels

**Branch**: `002-product-labels` | **Date**: 2026-09-11 | **Spec**: [spec.md](./spec.md)

**Input**: Feature specification from `/specs/002-product-labels/spec.md`

**Note**: This template is filled in by the `/speckit-plan` command; its definition describes the execution workflow.

## Summary

Replace the hardcoded `product.meta_tag` storefront text ("Core Collection • Limited Edition")
with an admin-managed **Label** catalog: a new Filament resource lets an administrator create,
edit, and delete translated labels (mirroring the existing `Attribute` pattern), assign any
number of them to a product in a specific order (mirroring the existing "related products"
reorderable-pivot pattern), and the public product page renders that product's labels — in
assignment order, in the viewer's locale — or nothing at all when a product has none.

## Technical Context

**Language/Version**: PHP `^8.3` (Laravel 12)

**Primary Dependencies**: Filament `^5.0`, `astrotomic/laravel-translatable` `^11.16`, `spatie/laravel-permission`, `spatie/laravel-data`, Inertia React 3 + React 19 + TypeScript 6

**Storage**: MySQL (production) / in-memory SQLite (tests) — `ulid` primary keys, plain relational pivot, no MySQL-only features (Constitution V)

**Testing**: PHPUnit `^12.5`, class-based feature tests, `RefreshDatabase`, executed inside Laradock

**Target Platform**: Laravel web app — Filament admin panel at `/admin` + public Inertia storefront

**Project Type**: Web application (single Laravel repo: `app/` backend, `resources/js/` frontend)

**Performance Goals**: None feature-specific — not called out in `spec.md`; inherits existing catalog CRUD/page-load norms

**Constraints**: Laradock-only command execution (Constitution II); brutalist design system, no new visual treatment (Constitution I); admin UI copy via translation keys, not hardcoded strings (Constitution III)

**Scale/Scope**: Small admin-managed list (tens of labels, same order of magnitude as `Attribute`) — no scale requirement in spec

*(All items resolved from existing codebase convention — see `research.md` for the decision + rejected alternative behind each one. No NEEDS CLARIFICATION remain.)*

## Constitution Check

*GATE: Must pass before Phase 0 research. Re-checked after Phase 1 design (see bottom of this section).*

| Principle | Status | Notes |
|---|---|---|
| I. Design System Compliance | PASS | No new visual treatment — reuses the existing `product-info__meta` class and "•" separator; no new colors/borders/shadows introduced (`research.md` §5). |
| II. Environment Isolation via Laradock | PASS | Plan and `quickstart.md` specify all `php artisan`/`composer` commands run inside Laradock; no bare-host execution proposed. |
| III. i18n From Day One for New UI | PASS, with an explicit deviation from the mirrored pattern | New `LabelResource` admin UI strings MUST use `__()` + `lang/*` files, even though the `AttributeResource` it otherwise mirrors hardcodes English strings (recorded tech debt, not to be propagated) — `research.md` §4. |
| IV. Test-First for Spec-Driven Features | PASS (gate applies going into `/speckit-tasks`) | `research.md` §6 and `quickstart.md` name the required `tests/Feature/Catalog/*` coverage; `/speckit-tasks` MUST order those tests before the implementation tasks they cover, per this principle. |
| V. Database Portability | PASS | New tables (`labels`, `label_translations`, `label_product`) use only `ulid`/`string`/`integer` columns and a composite primary key — same shape as the existing `attributes`/`attribute_translations`/`attribute_value_product_variant` tables, already proven portable across MySQL and SQLite. |
| VI. Human-Owned Commits | PASS | This plan and its artifacts are drafts for the owner to implement; no source files outside `specs/002-product-labels/` were touched by this command. |

No violations requiring justification — **Complexity Tracking is not needed** for this feature.

**Post-Phase-1 re-check**: Unchanged. `data-model.md` and `contracts/product-page-props.md`
introduce no new entities, permissions, or UI beyond what was already evaluated above — all six
principles still PASS.

## Project Structure

### Documentation (this feature)

```text
specs/002-product-labels/
├── plan.md              # This file (/speckit-plan command output)
├── research.md          # Phase 0 output (/speckit-plan command)
├── data-model.md         # Phase 1 output (/speckit-plan command)
├── quickstart.md         # Phase 1 output (/speckit-plan command)
├── contracts/
│   └── product-page-props.md   # Phase 1 output (/speckit-plan command)
└── tasks.md              # Phase 2 output (/speckit-tasks command - NOT created by /speckit-plan)
```

### Source Code (repository root)

```text
database/migrations/
├── ..._create_labels_table.php
├── ..._create_label_translations_table.php
└── ..._create_label_product_table.php

database/seeders/
└── RolesAndPermissionsSeeder.php          # add labels.list/create/edit/delete

app/Models/
├── Label.php                               # new — mirrors Attribute.php
├── LabelTranslation.php                    # new — mirrors AttributeTranslation.php
└── Product.php                             # extend — add labels(): BelongsToMany

app/Policies/
└── LabelPolicy.php                         # new — mirrors AttributePolicy.php

app/Filament/Resources/Labels/              # new — mirrors Filament/Resources/Attributes/
├── LabelResource.php
├── Pages/{CreateLabel,EditLabel,ListLabels}.php
├── Schemas/LabelForm.php
└── Tables/LabelsTable.php

app/Filament/Resources/Products/Schemas/
└── ProductForm.php                         # extend — add labels Select field

app/Data/Label/
└── LabelData.php                           # new — mirrors AttributeValueData.php

app/Data/Product/
└── ProductData.php                         # extend — add labels: array<LabelData>

resources/js/types/models/
└── product.ts                              # extend — add labels field

resources/js/Pages/Product/
└── Product.tsx                             # extend — replace static meta_tag block

tests/Feature/Catalog/                      # new domain grouping (parallel to Localization/Payments)
└── *Test.php                               # label CRUD, assignment/order, ProductData shape, page rendering
```

**Structure Decision**: This is a single Laravel + Inertia monolith, not a split
frontend/backend repo — the "Web application" template option is adapted to this project's real
layout (`app/` for backend, `resources/js/` for frontend, both inside one repo) rather than the
generic `backend/`+`frontend/` placeholder tree. Every new/changed path above is an addition
alongside an existing sibling file this feature mirrors (named in `research.md`), so no new
top-level structure is introduced.

## Complexity Tracking

*Not applicable — no Constitution Check violations.*
