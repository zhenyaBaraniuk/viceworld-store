# Feature Specification: JSON-Based Static Text Translation Infrastructure

**Feature Branch**: `001-i18n-json-translations`

**Created**: 2026-08-31

**Status**: Draft

**Input**: User description: "i18n infrastructure for static UI text using flat JSON translation files (lang/uk.json + lang/en.json), NOT laravel-gettext. Requirements: Translation storage: lang/uk.json and lang/en.json at project root, flat string keys mapping to translated strings, one file per locale (uk, en). Locale detection: URL-prefix based, {locale}/... route group, consistent with the existing {locale}-group route structure planned for Day 3 auth routes. Sharing to frontend: current locale's full translation map is shared to every Inertia page via HandleInertiaRequests middleware, so no extra request is needed per page. Frontend consumption: a useTranslation hook (or equivalent helper) reads the shared translation map from the Inertia page props and exposes a t(key) lookup function to React components. Scope: migrate ALL existing static text currently hardcoded in the frontend (Header, Footer, Home, Catalog, Product, Search, Checkout, SuccessOrder, Profile pages/components) to use translation keys. Out of scope: Filament admin panel i18n, Elasticsearch/product-content translation, the language switcher UI toggle itself."

## Clarifications

### Session 2026-08-31

- Q: Do any of the static text strings need to include dynamic values, like a cart item count, an order number, or a price, inserted into otherwise-translated text? → A: No — dynamic values are always rendered separately from translated text; translations stay pure static labels.
- Q: When a static label's wording changes based on a nearby dynamic count (e.g. Ukrainian "1 товар" / "2 товари" / "5 товарів"), does the translation system need to support selecting a plural form by count? → A: No — a single invariant static form is used regardless of count; grammatical plural agreement is out of scope for this feature.
- Q: When a visitor requests a URL with no locale prefix, should the site redirect to the default-locale-prefixed URL or render in place without changing the address? → A: Redirect (302) to the default-locale-prefixed URL, giving one canonical URL per page.

## User Scenarios & Testing *(mandatory)*

### User Story 1 - Visitor reads the site in their chosen language (Priority: P1)

A visitor navigates to a URL prefixed with their preferred language (Ukrainian or
English) and every piece of static text on the page — navigation, hero, footer,
newsletter form, catalog, product, search, checkout, order confirmation, and
profile screens — appears in that language.

**Why this priority**: This is the entire point of the feature. Without it, the
store cannot present a coherent bilingual experience to its unisex, pan-European
target audience described in the brand brief. Every other story only improves how
the translations are maintained.

**Independent Test**: Visit the same page under both the `/uk/...` and `/en/...`
prefixes and confirm every static string on the page differs correctly between the
two, with nothing left over in the "wrong" language.

**Acceptance Scenarios**:

1. **Given** a visitor opens the home page at the English-prefixed URL, **When**
   the page finishes loading, **Then** all static text on the page (navigation,
   hero, footer, newsletter form) is shown in English.
2. **Given** a visitor opens the catalog page at the Ukrainian-prefixed URL,
   **When** the page finishes loading, **Then** all static text on the page is
   shown in Ukrainian.
3. **Given** a visitor is on an English-prefixed page, **When** they navigate to
   another page while keeping the English prefix, **Then** the new page also
   renders fully in English with no extra page reload required beyond normal
   navigation.

---

### User Story 2 - Content owner edits copy without touching component code (Priority: P2)

Someone correcting or improving UI wording changes a translated string in one
place and sees it reflected on the site, without any developer editing a React
component.

**Why this priority**: Decouples wording changes from code changes, which matters
for a project where the same person often does both design/content and
engineering — small copy tweaks currently require finding and editing hardcoded
strings inside component files.

**Independent Test**: Change the value of an existing, already-used translation
key in one locale's translation source, reload the affected page, and confirm the
new text appears with zero changes to any component file.

**Acceptance Scenarios**:

1. **Given** a translation key is already used on a page, **When** its value is
   updated in the locale's translation source, **Then** the rendered page shows
   the updated text after a normal reload, with no component code changed.

---

### User Story 3 - Page stays usable when a translation is missing (Priority: P3)

While the migration of existing hardcoded text to translation keys is still in
progress (or if a key is later added on one side but not the other), a page that
references a not-yet-translated key still renders correctly instead of breaking.

**Why this priority**: Protects against a broken page during the migration itself
and against regressions afterward — a missing key must degrade gracefully, not
crash a page or leave a visible gap.

**Independent Test**: Temporarily remove one key from a locale's translation
source, load a page that references it, and confirm the page still renders with a
clearly identifiable placeholder instead of an error or blank space.

**Acceptance Scenarios**:

1. **Given** a component references a translation key, **When** that key is
   absent from the active locale's translation source, **Then** the page still
   renders without error and shows the key name itself as a visible fallback.

---

### Edge Cases

- What happens when a visitor requests a URL with no locale prefix at all (e.g.
  `/catalog`)? → Visitor is redirected to the default-locale-prefixed equivalent
  (e.g. `/uk/catalog`) rather than the page being served at the un-prefixed
  address or an error being shown.
- What happens when a visitor requests an unsupported locale prefix (e.g.
  `/fr/catalog`)? → Redirected to the default-locale-prefixed equivalent, the
  same as an un-prefixed URL, rather than a 404, since only Ukrainian and
  English are in scope.
- What happens when a page is only partially migrated (some components already
  use translation keys, others still hardcoded)? → Already-migrated parts must
  correctly switch language; not-yet-migrated parts are a known, tracked gap, not
  a defect of this feature.
- What happens when a count-adjacent label would read grammatically awkward for
  some numbers (e.g. a Ukrainian noun needing a different form for 1 vs. 2 vs.
  5)? → Accepted as out of scope; the label uses one invariant static form
  regardless of the nearby count.

## Requirements *(mandatory)*

### Functional Requirements

- **FR-001**: System MUST support at least two locales — Ukrainian and English —
  each identified by a distinct segment at the start of the URL path.
- **FR-002**: System MUST render all static UI text on every currently existing
  public page (home, catalog, product, search, checkout, order success, profile,
  header, footer, newsletter form) in the locale indicated by the current URL.
- **FR-003**: A content owner MUST be able to add or change a translated string
  for a given locale by editing that locale's translation source only, with no
  change required to any frontend component.
- **FR-004**: System MUST make the complete translation set for the active locale
  available to a page on its initial load, without a separate follow-up request
  being needed to fetch translations after the page has already loaded.
- **FR-005**: When a requested URL has no locale prefix, System MUST redirect
  the visitor to the equivalent default-locale-prefixed URL, so each page has
  exactly one canonical address rather than being reachable at both a prefixed
  and an un-prefixed URL.
- **FR-006**: When a requested URL's locale prefix is not one of the supported
  locales, System MUST redirect to the equivalent default-locale-prefixed URL,
  the same way an un-prefixed URL is handled (FR-005), rather than showing an
  error.
- **FR-007**: When a translation key referenced by a page is missing for the
  active locale, System MUST still render the page successfully and MUST show a
  clearly identifiable fallback (the key name) in place of the missing text,
  rather than crashing or leaving blank space.
- **FR-008**: System MUST provide one consistent way for frontend components to
  look up translated text by key, used uniformly across all migrated pages, so a
  page never mixes translated and still-hardcoded static text for the same class
  of content once migration of that page is complete.
- **FR-009**: All static text currently hardcoded in Header, Footer, Home,
  Catalog, Product, Search, Checkout, SuccessOrder, and Profile MUST be migrated
  to translation keys such that none of these areas has remaining hardcoded
  Ukrainian or English UI copy once this feature is complete.
- **FR-010**: Translation strings MUST contain only static text, with no embedded
  dynamic values (counts, order numbers, prices, names, etc.). Pages that mix a
  translated label with a dynamic value (e.g. an item count or an order number)
  MUST render the dynamic value separately from the translated string, not by
  interpolating it into translation source content.

### Key Entities

- **Translation Entry**: A plain static translated string identified by a key,
  scoped to one locale, containing no embedded dynamic values. Lives in that
  locale's translation source rather than a database table — content, not
  application data.
- **Locale**: A supported language variant (Ukrainian or English), identified by
  its URL prefix, with one locale designated as the default used when no prefix
  or an unsupported prefix is present.

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: 100% of static text on the nine listed page/component areas
  (Header, Footer, Home, Catalog, Product, Search, Checkout, SuccessOrder,
  Profile) changes correctly when a visitor switches between the two supported
  locale URL prefixes.
- **SC-002**: A wording correction to an already-used string is achieved by
  editing exactly one translation source per affected locale, with zero
  component-file edits.
- **SC-003**: Zero pages error out, crash, or render blank content due to a
  missing or untranslated string at any point during or after the migration.
- **SC-004**: A visitor can browse the full existing purchase journey (home →
  product → search → checkout → order success) entirely in either supported
  language with no untranslated fragments visible on those pages.

## Assumptions

- Default locale is Ukrainian, matching the store's primary market (Kyiv) per
  `.claude/rules/architecture.md`.
- A URL with no locale prefix redirects to the default-locale-prefixed
  equivalent (302), consistent with the `{locale}`-prefixed route structure
  already planned for the Day 3 auth routes in `.claude/rules/TODO.md`, and
  giving each page one canonical URL.
- An unrecognized locale prefix redirects to the default-locale-prefixed
  equivalent rather than a 404, matching how an un-prefixed URL is handled,
  since only Ukrainian and English are in scope for this feature.
- A missing translation key falls back to displaying the key itself, so gaps
  remain visible (and therefore fixable) during the ongoing migration rather than
  silently showing blank text.
- Translation source format is a flat-key JSON file per locale (not the
  `laravel-gettext` package) — an explicit constraint from the project owner, not
  a detail left to the implementation phase.
- The visible language-switcher control mentioned in
  `.claude/rules/architecture.md` (navbar UA/EN toggle) is a separate feature;
  this spec only guarantees the translation storage/lookup exists for that
  control to drive.
- Filament admin panel labels and per-product content translation (name/
  description) are out of scope, tracked separately under Day 2 and Day 6 of
  `.claude/rules/TODO.md`.
- Grammatical plural-form agreement (e.g. Ukrainian one/few/many noun forms) for
  labels adjacent to a dynamic count is out of scope for this feature; a single
  invariant static form is used regardless of the nearby number, consistent with
  FR-010's separation of dynamic values from translated text.
