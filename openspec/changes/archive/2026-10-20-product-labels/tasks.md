---

description: "Task list for Product Labels"
---

# Tasks: Product Labels

**Input**: Design documents from `/specs/002-product-labels/`

**Prerequisites**: plan.md, spec.md, research.md, data-model.md, contracts/product-page-props.md, quickstart.md

**Tests**: Included and REQUIRED — Constitution Principle IV (Test-First for Spec-Driven
Features, NON-NEGOTIABLE) applies to this feature because it went through the full
`/speckit-specify → /speckit-plan → /speckit-tasks` flow. Each user story's test task MUST be
written and confirmed failing (red) before that story's implementation tasks begin, and MUST
pass (green) only after them.

**Organization**: Tasks are grouped by user story (spec.md priorities P1/P2/P3) so each story is
independently implementable, testable, and shippable as an increment.

## Format: `[ID] [P?] [Story] Description`

- **[P]**: Can run in parallel (different files, no dependency on an incomplete task)
- **[Story]**: US1 / US2 / US3 — which spec.md user story this task belongs to
- Every task names its exact file path(s)

## Path Conventions

Single Laravel + Inertia repo (see plan.md → Project Structure): backend under `app/`,
`database/`, `tests/`; frontend under `resources/js/`. No separate `backend/`/`frontend/` roots.

---

## Phase 1: Setup

**Purpose**: Confirm the environment this feature will be built in is ready — no code changes.

- [ ] T001 Verify Laradock containers are running and `php artisan migrate:status` succeeds
      inside the container (Constitution Principle II — every command below runs in Laradock,
      never bare on host)

---

## Phase 2: Foundational (Blocking Prerequisites)

**Purpose**: The `Label` data layer — schema, models, policy, permissions — that every user
story reads or writes. No user story is independently testable until this phase is done.

**⚠️ CRITICAL**: Complete this phase before starting any user story phase.

*(No dedicated test task here: this phase is pure data-layer scaffolding mirroring the proven
`Attribute`/`AttributeTranslation` pattern (see research.md §1); its correctness is exercised
end-to-end by User Story 1's feature test, T008, which would fail without it.)*

- [ ] T002 [P] Create migration for `labels` table (`ulid` primary key only) in
      `database/migrations/xxxx_xx_xx_create_labels_table.php` — mirrors
      `database/migrations/2026_03_28_184702_create_attributes_table.php`
- [ ] T003 [P] Create migration for `label_translations` table (`id` ulid pk, `label_id` ulid,
      `locale` string, `name` string) in
      `database/migrations/xxxx_xx_xx_create_label_translations_table.php` — mirrors
      `database/migrations/2026_03_28_185004_create_attribute_translations_table.php`
- [ ] T004 [P] Create `Label` model in `app/Models/Label.php`: `HasUlids`, `Translatable`,
      `HasTranslateAttributes`, `$timestamps = false`, `translatedAttributes = ['name']` —
      mirrors `app/Models/Attribute.php` (per data-model.md, its `products()` relation is added
      later in T017, not here)
- [ ] T005 [P] Create `LabelTranslation` model in `app/Models/LabelTranslation.php`: `HasUlids`,
      `$timestamps = false`, `fillable = ['name']` — mirrors `app/Models/AttributeTranslation.php`
- [ ] T006 [P] Create `LabelPolicy` in `app/Policies/LabelPolicy.php` with `viewAny`/`create`/
      `update`/`delete` gated on `labels.list`/`labels.create`/`labels.edit`/`labels.delete` —
      mirrors `app/Policies/AttributePolicy.php`
- [ ] T007 Add `labels.list`, `labels.create`, `labels.edit`, `labels.delete` to the
      `$permissions` array and to the `content-manager` role's permission list in
      `database/seeders/RolesAndPermissionsSeeder.php`, alongside the existing `attributes.*`
      entries (the `admin` role already gets every permission via `Permission::all()`)

**Checkpoint**: `Label` records can exist and be authorized, but nothing creates or displays them
yet — proceed to User Story 1.

---

## Phase 3: User Story 1 - Admin manages the label catalog (Priority: P1) 🎯 MVP

**Goal**: An administrator can create, edit, and delete labels (translated per locale) from the
admin panel, independent of any product.

**Independent Test**: Open the admin Labels screen, create a label with `uk`+`en` names, edit it,
delete it — all without touching a product. See quickstart.md Scenario 1.

- [ ] T008 [P] [US1] Write `tests/Feature/Catalog/LabelManagementTest.php` (PHPUnit class,
      `RefreshDatabase`, mirrors `tests/Feature/Localization/ProductLocalizationTest.php`'s
      style): admin creates a label with `uk`+`en` names and it appears in the list (Acceptance
      Scenario 1); editing the name updates it everywhere `translated('name')` is read
      (Scenario 2); deleting an unassigned label removes it from the list (Scenario 3); a user
      without `labels.*` permissions is denied. Run it and confirm it fails (red) — `Label`
      exists (Phase 2) but no admin UI does yet.
- [ ] T009 [P] [US1] Add `lang/uk/labels.php` and `lang/en/labels.php` translation arrays (field
      label `name`, navigation label, table column label) — first instance of the
      `__()` + `lang/{locale}/*.php` pattern Constitution Principle III requires for new Filament
      UI (research.md §4); keys referenced by T010–T013
- [ ] T010 [P] [US1] Create `LabelForm` schema in
      `app/Filament/Resources/Labels/Schemas/LabelForm.php`: one `TextInput::make('name')`,
      `required()`, `maxLength(255)`, label via `__('labels.name')` — mirrors
      `app/Filament/Resources/Attributes/Schemas/AttributeForm.php`
- [ ] T011 [P] [US1] Create `LabelsTable` in
      `app/Filament/Resources/Labels/Tables/LabelsTable.php`: `TextColumn::make('name')` via
      `getStateUsing(fn ($record) => $record->translated('name'))`, searchable through the
      `translations` relation, `EditAction`, bulk `DeleteBulkAction` — mirrors
      `app/Filament/Resources/Attributes/Tables/AttributesTable.php` minus its `Values` column
      (no `attributeValues` relation on `Label`)
- [ ] T012 [P] [US1] Create Filament pages `CreateLabel`, `EditLabel`, `ListLabels` in
      `app/Filament/Resources/Labels/Pages/{CreateLabel,EditLabel,ListLabels}.php` — mirror
      `app/Filament/Resources/Attributes/Pages/{CreateAttribute,EditAttribute,ListAttributes}.php`
- [ ] T013 [US1] Create `LabelResource` in `app/Filament/Resources/Labels/LabelResource.php`
      wiring `LabelForm`/`LabelsTable`/pages, `navigationGroup = 'Catalog'`, an icon, and a
      translated navigation label — mirrors `app/Filament/Resources/Attributes/AttributeResource.php`
      with **no** `getRelations()` (labels have no nested values, per TODO.md scope)
- [ ] T014 [US1] Run `tests/Feature/Catalog/LabelManagementTest.php` inside Laradock, confirm it
      passes (green); run `composer check`

**Checkpoint**: User Story 1 is a complete, independently shippable increment — an administrator
can fully manage the label catalog. Proceed to User Story 2 to make labels assignable.

---

## Phase 4: User Story 2 - Admin assigns labels to a product (Priority: P2)

**Goal**: An administrator can assign any number of existing labels to a product, in a specific
(reorderable) order, from the product edit screen.

**Independent Test**: Open an existing product, select two labels in a specific order, save,
reopen and confirm both the selection and the order persisted. See quickstart.md Scenario 2.

**Depends on**: User Story 1 (needs `Label` records to select from and the admin UI that creates
them).

- [ ] T015 [P] [US2] Write `tests/Feature/Catalog/ProductLabelAssignmentTest.php`: assigning two
      labels in a chosen order persists that order (Acceptance Scenario 1); removing one keeps
      the remaining labels' relative order (Scenario 2); searching the picker by name matches
      regardless of current admin locale (Scenario 3). Run it and confirm it fails (red) — no
      pivot table or relation exists yet.
- [ ] T016 [US2] Create migration for `label_product` pivot (`label_id` ulid, `product_id` ulid,
      `position` integer, composite primary key on `label_id`+`product_id`, no surrogate id, no
      timestamps) in `database/migrations/xxxx_xx_xx_create_label_product_table.php` — mirrors
      `database/migrations/2026_03_28_183748_create_attribute_value_product_variant_table.php`
- [ ] T017 [P] [US2] Add `products(): BelongsToMany` to `app/Models/Label.php`, through
      `label_product`, `withPivot('position')`, `orderByPivot('position')` (data-model.md §
      label_product)
- [ ] T018 [P] [US2] Add `labels(): BelongsToMany` to `app/Models/Product.php`, through
      `label_product`, `withPivot('position')`, `orderByPivot('position')` — same pivot, read
      side of the relation used by T019 and, in User Story 3, by `ProductData`
- [ ] T019 [US2] Add `Select::make('labels')` to
      `app/Filament/Resources/Products/Schemas/ProductForm.php`:
      `->relationship('labels', 'id')`, `getOptionLabelFromRecordUsing` via
      `$label->translated('name')`, `multiple()`, `searchable()`, `preload()`, `reorderable()`,
      and a `saveRelationshipsUsing()` that writes `position` from selection order — mirrors the
      existing `related` field's `saveRelationshipsUsing()` in the same file
      (`app/Filament/Resources/Products/Schemas/ProductForm.php`, `related` field)
- [ ] T020 [US2] Run `tests/Feature/Catalog/ProductLabelAssignmentTest.php` inside Laradock,
      confirm it passes (green); run `composer check`

**Checkpoint**: Products can now carry an ordered set of labels via the admin panel. Proceed to
User Story 3 to surface them to customers.

---

## Phase 5: User Story 3 - Customer sees a product's labels on the product page (Priority: P3)

**Goal**: A product's assigned labels render on its public page, translated and in assignment
order; no label area renders for a product with none.

**Independent Test**: Visit the public page of a labeled product and an unlabeled one; confirm
rendering matches contracts/product-page-props.md. See quickstart.md Scenario 3.

**Depends on**: User Story 2 (needs real label↔product assignments, and `Product::labels()`
from T018, to have something to serialize and display).

- [ ] T021 [P] [US3] Write `tests/Feature/Catalog/ProductPageLabelsTest.php` (PHPUnit,
      `RefreshDatabase`, asserting on Inertia props the way
      `tests/Feature/Localization/ProductLocalizationTest.php` does): a product with labels
      returns them translated and in assignment order under `product.labels` (Acceptance
      Scenario 1); a product with none returns `product.labels === []` (Scenario 2). Run it and
      confirm it fails (red) — `ProductData` does not expose `labels` yet.
- [ ] T022 [P] [US3] Create `LabelData` DTO in `app/Data/Label/LabelData.php`
      (`Spatie\LaravelData\Data`, fields `id: string`, `name: string`,
      `fromModel()` via `$label->translated('name')`) — mirrors
      `app/Data/AttributeValue/AttributeValueData.php`
- [ ] T023 [US3] Extend `app/Data/Product/ProductData.php`: add
      `/** @var array<LabelData> */ public array $labels` to the constructor, and populate it in
      `fromModel()` via
      `$product->labels->map(fn ($label) => LabelData::fromModel($label))->values()->all()`
      (already ordered — `Product::labels()` is `orderByPivot('position')`)
- [ ] T024 [P] [US3] Extend `Product` interface in `resources/js/types/models/product.ts`: add
      `labels: { id: string; name: string }[];`
- [ ] T025 [US3] In `resources/js/Pages/Product/Product.tsx`, replace the
      `<p className="product-info__meta text-primary">{t("product.meta_tag")}</p>` block
      (currently ~line 70) with a guarded render:
      `{product.labels.length > 0 && (<p className="product-info__meta text-primary">{product.labels.map(l => l.name).join(" • ")}</p>)}`
- [ ] T026 [US3] Run `tests/Feature/Catalog/ProductPageLabelsTest.php` inside Laradock, confirm
      it passes (green); run `npm run fix` and `composer check`

**Checkpoint**: All three user stories are complete — the hardcoded meta tag is fully replaced by
an admin-managed, ordered, per-product label system.

---

## Phase 6: Polish & Cross-Cutting Concerns

**Purpose**: Remove the dead hardcode this feature replaces and confirm the whole feature passes
the project's quality gates together (not just per-story).

- [ ] T027 [P] Remove the now-unused `product.meta_tag` key from `lang/uk.json` and
      `lang/en.json` (FR-009 — no dead translation key left behind once `Product.tsx` no longer
      reads it)
- [ ] T028 Run `composer check` (pint → rector dry-run → phpstan → full `php artisan test`) and
      `npm run fix` (typecheck → lint:fix → format) inside Laradock for the feature as a whole,
      confirming both gates pass end-to-end (Constitution Development Workflow)

---

## Dependencies & Execution Order

- **Phase 1 (Setup)** → **Phase 2 (Foundational)**: strictly sequential, blocks everything below.
- **Phase 3 (US1)** depends only on Phase 2.
- **Phase 4 (US2)** depends on Phase 3 (needs `Label` records + the admin UI that creates them)
  in addition to Phase 2.
- **Phase 5 (US3)** depends on Phase 4 (needs real assignments and `Product::labels()`, added in
  T018/T019) in addition to Phase 2.
- **Phase 6 (Polish)** depends on all of Phase 3–5 being done.
- This chain matches spec.md's own "Why this priority" rationale for each story — they are
  intentionally sequential (P1 → P2 → P3), not parallelizable at the story level, even though
  individual tasks within a phase can be.

## Parallel Execution Examples

- **Phase 2**: T002, T003, T004, T005, T006, T007 touch six independent files and can all be
  written in parallel.
- **Phase 3 (US1)**: T008 (test) and T009 (lang files) can start together; once T009 is done,
  T010, T011, T012 (Form/Table/Pages — three independent files that all consume the lang keys)
  can proceed in parallel; T013 (LabelResource) must wait for T010–T012.
- **Phase 4 (US2)**: T015 (test) can start immediately; T017 and T018 (the two model relations)
  are independent files and can run in parallel; T019 (ProductForm) waits for both.
- **Phase 5 (US3)**: T021 (test), T022 (LabelData), and T024 (TS type) are independent files and
  can run in parallel; T023 (ProductData) waits for T022; T025 (Product.tsx) waits for T024.

## Implementation Strategy

**MVP = Phase 1 + Phase 2 + Phase 3 (User Story 1 only, T001–T014)**. This alone delivers a real,
demoable increment: an administrator can fully manage a translated label catalog in `/admin`,
with no dependency on product assignment or storefront rendering yet.

**Incremental delivery**: ship US1 → ship US2 (labels become assignable) → ship US3 (labels
become customer-visible, hardcode removed) → Polish. Each checkpoint above is a valid stopping
point if priorities shift.

Per Constitution Principle VI, this `tasks.md` is a draft for the project owner to execute (or to
direct AI assistance through, one authorized task at a time) — no task in this list has been
carried out by generating this document.
