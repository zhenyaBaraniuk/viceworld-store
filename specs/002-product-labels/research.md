# Phase 0 Research: Product Labels

All items in the plan's Technical Context are resolved directly from existing, established
patterns in this codebase — no exploratory spikes were needed. This file records the decisions
and why the (obvious) alternative was rejected, so `/speckit-tasks` and `/speckit-implement` do
not have to re-derive them.

## 1. Label as a first-class Translatable model (not an enum, not JSON on Product)

- **Decision**: `Label` is its own Eloquent model (`HasUlids`, `Translatable`) backed by
  `labels` + `label_translations` tables, mirroring `App\Models\Attribute` /
  `App\Models\AttributeTranslation` exactly.
- **Rationale**: Spec SC-001 requires an admin to introduce a new label with zero code/deploy
  changes, and FR-001 requires a translated name per locale — both rule out a PHP enum. Reusing
  `astrotomic/laravel-translatable` (already the project's only translation mechanism for model
  data — see `Category`, `Attribute`, `Product`) avoids inventing a second one.
- **Alternatives considered**:
  - PHP enum of fixed labels — rejected, contradicts SC-001 (admin-editable without a deploy).
  - JSON column of `{locale: text}` directly on `products` — rejected, does not support reusing
    one label across many products (FR-004), and duplicates translation logic instead of reusing
    `Translatable`.

## 2. Product–Label association carries an explicit order (`position`)

- **Decision**: Pivot table `label_product` (`label_id`, `product_id`, `position`, composite
  primary key on `label_id` + `product_id` — no surrogate id, no timestamps), attached via
  Filament's `Select::make('labels')->relationship('labels', 'id')->reorderable()` with a
  `saveRelationshipsUsing()` that writes `position` from selection order.
- **Rationale**: The Clarifications session in `spec.md` resolved display order to
  "assignment order, not alphabetical or creation-date" (FR-010). This exact shape — a
  many-to-many pivot with a `position` column, populated by a reorderable multi-select on the
  product form — already exists in this codebase for `Product::related()` /
  `ProductForm`'s `related` field (`product_related` pivot,
  `withPivot('position')->orderByPivot('position')`). No new UX or persistence pattern is
  introduced.
- **Alternatives considered**:
  - Plain `BelongsToMany` with no `position`, relying on pivot insertion order — rejected,
    insertion order is not a documented/guaranteed durable ordering once rows are re-synced on
    every save (Filament's `relationship()` sync does not guarantee row order is preserved by
    the underlying query without an explicit column to order by).

## 3. Label admin resource gets its own permission set

- **Decision**: New Filament resource `App\Filament\Resources\Labels\LabelResource` (structure
  mirrors `Attributes/` exactly, minus the values relation manager), governed by a new
  `App\Policies\LabelPolicy`, with `labels.list` / `labels.create` / `labels.edit` /
  `labels.delete` added to `RolesAndPermissionsSeeder` — granted to `admin` (via
  `Permission::all()`) and to `content-manager` (explicit list, alongside `attributes.*` /
  `categories.*`).
- **Rationale**: Every existing catalog entity (`products`, `categories`, `attributes`) has its
  own full CRUD permission set in the seeder; there is no precedent in this codebase for a
  catalog resource riding on another resource's permission. Assigning labels *to* a product
  stays gated by the existing `products.edit` permission (it happens on the product form, same
  as attribute-value assignment already does) — only managing the label *catalog itself* needs
  the new permission set.
- **Alternatives considered**: Gate `LabelResource` behind the existing `attributes.*`
  permissions (labels and attributes both live in "Catalog") — rejected, conflates two
  independent entities' access control for no stated reason in the spec, and breaks the
  one-permission-set-per-resource convention.

## 4. New admin UI copy must use translation keys, not hardcoded strings

- **Decision**: `LabelResource`'s field labels, navigation label, and table column labels go
  through `__()` + `lang/uk/*.php` / `lang/en/*.php`, even though `AttributeResource` (the
  pattern this feature otherwise mirrors) uses hardcoded English strings (`->label('Name')`
  etc.).
- **Rationale**: Constitution Principle III ("i18n From Day One for New UI") is explicitly
  NON-NEGOTIABLE and calls out that pre-existing hardcoded strings are recorded tech debt, not a
  pattern to extend. `AttributeResource`'s hardcoding predates the constitution's current
  version and is not grounds to add more of the same debt.
- **Alternatives considered**: Copy `AttributeResource` byte-for-byte including hardcoded labels
  — rejected as a direct constitution violation for new code.

## 5. Storefront rendering replaces the static meta line in place

- **Decision**: `Product.tsx`'s `<p className="product-info__meta text-primary">` block renders
  `product.labels.map(l => l.name).join(" • ")` guarded by `product.labels.length > 0`,
  reusing the existing `product-info__meta` CSS class and the "•" separator the hardcoded string
  already used, so the approved brutalist design mock's visual output is unchanged.
- **Rationale**: Spec FR-006 requires the block to disappear entirely when a product has no
  labels; spec Assumptions explicitly rule out new visual treatments (pills, colors, icons) for
  v1. Reusing the existing class avoids a CSS change and keeps this a data-source swap, not a
  redesign.
- **Alternatives considered**: Per-label styled badges — rejected, out of scope per spec
  Assumptions and no such component exists in the approved `design/product_page_final` mock.

## 6. Test placement and style

- **Decision**: PHPUnit class-based feature tests (not Pest — this codebase's existing tests
  under `tests/Feature/` are all class-based, e.g.
  `tests/Feature/Localization/ProductLocalizationTest.php`), `RefreshDatabase`, new
  `tests/Feature/Catalog/` subdirectory (parallel to the existing `Localization`/`Payments`
  domain grouping).
- **Rationale**: Matches the one clear existing convention rather than introducing Pest
  alongside it. Per Constitution Principle IV, these tests are written and failing before the
  implementation tasks that make them pass (enforced in `tasks.md` ordering, not here).
- **Alternatives considered**: Pest — available as a dependency
  (`pestphp/pest-plugin` in `composer.json`) but no existing test in the repo uses Pest syntax;
  introducing it here would fragment the test suite's style for no feature-specific reason.

## Resolved Technical Context

| Item | Value |
|---|---|
| Language/Version | PHP `^8.3` (Laravel 12) |
| Primary Dependencies | Filament `^5.0`, `astrotomic/laravel-translatable` `^11.16`, `spatie/laravel-permission`, `spatie/laravel-data`, Inertia React 3 + React 19 + TypeScript |
| Storage | MySQL (production) / in-memory SQLite (tests) — via existing `ulid` + relational pivot conventions, no MySQL-only features |
| Testing | PHPUnit `^12.5`, class-based, `RefreshDatabase`, run inside Laradock |
| Target Platform | Laravel web app (`/admin` Filament panel + public Inertia storefront) |
| Project Type | Web application (single Laravel repo, backend `app/` + frontend `resources/js/`) |
| Performance Goals | No feature-specific target beyond existing catalog CRUD/page-load norms — not called out in spec |
| Constraints | Laradock-only command execution (Constitution II); brutalist design system (Constitution I); i18n for new UI (Constitution III) |
| Scale/Scope | Small admin-managed catalog list (tens of labels, matching `Attribute`'s scale) — no scale requirement in spec |
