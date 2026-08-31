<!--
Sync Impact Report
- Version change: 1.1.0 → 1.2.0
- Modified principles: none
- Added sections: none (Development Workflow expanded with a mandatory
  pre-done check gate: `composer check` for PHP changes, `npm run fix` for
  JS/TS changes)
- Removed sections: none
- Templates requiring follow-up: none checked automatically in this run.
-->

# V!ceWorld Constitution

## Core Principles

### I. Design System Compliance (Architectural Brutalism)
Every UI surface MUST follow the brutalist design system defined in
`.claude/rules/architecture.md` and the project's `DESIGN.md`: 0px border-radius
everywhere with no exceptions; no box-shadows and no gradients — depth comes only
from tonal layering; no 1px borders — separators are expressed through background
color changes only; transitions MUST use `linear` or `expo-out` easing, never
`ease-in-out`; input fields carry a bottom border only; the accent color
(`#0066FF`) is reserved for CTAs, the "!" in the logo, and active states.
Rationale: this is a portfolio piece — visual consistency with the approved
`design/` mockups is itself a deliverable, not a cosmetic afterthought.

### II. Environment Isolation via Laradock
All PHP-toolchain commands (`php artisan`, `composer`, `./vendor/bin/pint`,
`php artisan test`, etc.) MUST be run inside Laradock containers, never bare on
the host. Rationale: the host PHP version does not match the project's PHP
requirement (`^8.3` per `composer.json`); running bare on host produces
misleading failures unrelated to the actual code.

### III. i18n From Day One for New UI
Any new page or feature (customer auth, cart, checkout, profile, etc.) MUST
ship its user-facing text through translation keys (`lang/uk.json` /
`lang/en.json` on the frontend, `__()` + `lang/uk/*.php` / `lang/en/*.php` in
Filament admin resources) rather than hardcoded strings, even while the
broader i18n infrastructure (Day 6 of the sprint) is still incomplete.
Rationale: hardcoded Ukrainian labels already exist as recorded tech debt
(e.g. `ProductForm`); retrofitting translations after the fact is more
expensive than doing it inline.

### IV. Test-First for Spec-Driven Features (NON-NEGOTIABLE)
Any feature that goes through the Spec Kit flow (`/speckit-specify` →
`/speckit-plan` → `/speckit-tasks` → `/speckit-implement`) MUST have its tests
written and failing before the corresponding implementation task begins:
`tasks.md` MUST order test tasks ahead of the implementation tasks they cover,
and `/speckit-implement` MUST NOT mark an implementation task done until its
preceding test task exists and fails first (red), then passes after the
implementation (green). This applies with extra weight to cart, checkout,
order creation, and payment webhook logic — webhook handling MUST explicitly
test duplicate delivery (idempotency), a known edge case for payment
providers. Rationale: the payment core (LiqPay integration) is the technical
centerpiece of this portfolio project — its correctness is what the work is
meant to demonstrate, and tests written after the fact tend to just confirm
whatever the code already does rather than catch what it should do.

### V. Database Portability (MySQL Prod / SQLite Test)
Application code MUST NOT rely on MySQL-specific SQL behavior that would break
under the in-memory SQLite database used by the test suite. Migrations and
queries are written against the lowest common denominator of both engines
unless a feature genuinely requires a MySQL-only capability, in which case the
exception and its reason MUST be noted in the migration or query itself.
Rationale: `phpunit.xml` runs the full suite against SQLite `:memory:`; a
silent MySQL-only feature makes tests pass locally while lying about
production behavior.

### VI. Human-Owned Commits
All git commits and pushes are made by the project owner. AI assistance
(Claude Code) operates in an advisory capacity — code review, planning,
terminal command execution — and does not write, edit, or commit repository
source files without the owner's explicit, scoped, in-the-moment
authorization for that specific action. Rationale: this is a personal
portfolio project built by the owner for their own CV; authorship and
hands-on understanding of the code are part of the point.

## Technology Stack & Environment

Backend: Laravel 12, PHP `^8.3`, Filament `^5.0` admin panel at `/admin`.
Frontend: Inertia 3 + React + TypeScript, Tailwind CSS 4, Space Grotesk
(headlines) + Inter (body), Zustand for cart state. Database: MySQL in
production, in-memory SQLite in the test environment. Key packages: `liqpay`
(payments), `spatie/laravel-medialibrary` + `filament/spatie-laravel-media-library-plugin`
(media), `spatie/laravel-permission` (roles), `spatie/laravel-data` (DTOs),
`astrotomic/laravel-translatable` (model translations). Brand: V!ceWorld,
European urban streetwear, unisex with Men/Women/Kids sub-lines, first
physical location Kyiv. Full page/route map and design-file locations live in
`.claude/rules/architecture.md` — this constitution does not duplicate that
map, only the constraints that govern how code is written.

## Development Workflow

Work proceeds against `.claude/rules/TODO.md`, a 7-day sprint plan tracked
day-by-day. Sub-agents or AI-assisted planning tools (Spec Kit, Claude Code)
MAY be used to draft specs, plans, and tasks for a given day/feature, but the
owner reviews and applies the actual code changes per Principle VI. New
Filament resources are scaffolded via
`php artisan make:filament-resource ModelName --generate` and then adapted to
match the brutalist design system and i18n requirements above.

Before a change is considered ready, the owner MUST run the relevant gate
command(s) and they MUST pass: `composer check` (runs `pint` → `rector`
dry-run → `phpstan` → `test`, all inside Laradock per Principle II) for any
PHP change, and `npm run fix` (`typecheck` → `lint:fix` → `format`) for any
JS/TS change. A change touching both layers MUST pass both gates.

## Governance

This constitution supersedes ad-hoc practice for anything it explicitly
covers; where it is silent, `.claude/rules/*.md` and `CLAUDE.md` remain the
governing documents. Amendments are made by editing this file directly (by
the owner, or by AI assistance under an explicit one-time authorization per
Principle VI), MUST update the version per semantic versioning (MAJOR: a
principle is removed or redefined incompatibly; MINOR: a principle or section
is added or materially expanded; PATCH: wording/typo/clarity fixes with no
behavioral change), and MUST refresh the Sync Impact Report at the top of this
file. There is no separate PR-approval gate today — the project has a single
owner — so compliance review happens at the point a principle is invoked
during planning or code review, not as a blocking CI gate.

**Version**: 1.2.0 | **Ratified**: 2026-08-31 | **Last Amended**: 2026-08-31
