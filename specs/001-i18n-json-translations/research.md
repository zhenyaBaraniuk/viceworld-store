# Phase 0 Research: JSON-Based Static Text Translation Infrastructure

All items from Technical Context are resolved below via direct inspection of
the existing codebase (`routes/web.php`, `app/Http/Middleware/**`,
`resources/js/**`, `composer.json`, `package.json`). No `NEEDS CLARIFICATION`
markers remain.

## 1. Translation storage & loading

**Decision**: Store translations as `lang/{locale}.json` — Laravel's native
JSON-translation-file location — with flat, dot-namespaced keys (e.g.
`"cart.empty"`). Load them with a small `App\Services\TranslationService` that
reads and `json_decode`s the file for a given locale, rather than looping
Laravel's `__()`/`trans()` helper per key.

**Rationale**: The file location matches an existing Laravel convention (no
new config needed, `lang_path()` just works), while the flat dot-key scheme is
the explicit stakeholder decision recorded in `spec.md` (Assumptions). A direct
file read is the simplest way to hand the *entire* map to the frontend in one
shot, which `__()` (designed for one-key-at-a-time lookups) isn't built for.

**Alternatives considered**:
- Laravel's literal-sentence-as-key JSON convention (e.g. `{"Welcome": "..."}`)
  — rejected, the stakeholder explicitly wants namespaced keys, not full source
  sentences.
- Nested JSON objects (`{"cart": {"empty": "..."}}`) — rejected during
  `/speckit-clarify`-adjacent discussion in favor of flat keys, to keep lookup
  a direct object-property access with no path-walking.

## 2. Sharing the translation map to the frontend

**Decision**: Add `App\Http\Middleware\SharedData\TranslationSharedData`,
mirroring the existing `MenuSharedData` class, with a `resolve(Request): array`
method returning `['translations' => fn () => $this->translationService->forLocale(app()->getLocale())]`.
Inject and spread it into `App\Http\Middleware\Admin\HandleInertiaRequests::share()`
the same way `MenuSharedData` already is.

**Rationale**: `HandleInertiaRequests` (despite its `Admin` namespace, it is
registered globally in `bootstrap/app.php` and runs on every web request)
already shares `locale` and already follows a "small resolver class per shared
concern" pattern via `MenuSharedData`. Reusing that exact pattern is more
consistent than inventing a new one or inlining file I/O into the middleware
body.

**Alternatives considered**:
- Inlining the JSON read directly in `share()` — rejected, breaks the
  established separation-of-concerns pattern already in this codebase.
- A second, translation-specific Inertia middleware — rejected, unnecessary
  when the existing global middleware already does this job for `locale`.

## 3. Canonical-URL redirect for missing/unsupported locale prefixes (FR-005, FR-006)

**Decision**: Add a `Route::fallback()` handler (Laravel's lowest-priority
route, fires only when nothing else matches) that inspects the first URL path
segment:
- If it is **not** one of the two supported locale codes (`en`, `uk`) — including
  an empty path — redirect (302) to the same path with the default locale
  prepended.
- If it **is** already a supported locale code but the path still matched
  nothing, return a genuine 404 response instead of redirecting again.

**Rationale**: This is the only way to satisfy FR-005/FR-006 for arbitrary
paths — the pre-existing `Route::redirect('/', '/'.config('app.locale'))`
only covers the bare root. The second branch (already-valid-locale ⇒ 404, not
redirect) exists specifically to prevent an infinite redirect loop: a naive
fallback that *always* prepends the default locale would turn a request for
`/uk/nonexistent-page` into a redirect to `/uk/uk/nonexistent-page`, which
still matches nothing and redirects again, forever. This loop was discovered by
tracing exactly this request through the existing route table during research
— it is not a hypothetical.

**Alternatives considered**:
- Loosening the existing `{locale}` route group's `whereIn(['en','uk'])` to
  accept any string, letting `Front\SetLocale`'s existing (currently
  unreachable) "unsupported locale → default" branch handle it — rejected,
  because `SetLocale` swaps the locale silently while leaving the wrong URL in
  the address bar, which does not produce the one-canonical-URL-per-page
  outcome FR-005/FR-006 require.

## 4. Missing-key fallback (FR-007)

**Decision**: `useTranslation()`'s `t(key)` returns the `key` string itself,
unmodified, whenever that key is absent from the currently-shared
`translations` map.

**Rationale**: Simplest possible behavior; keeps gaps visible (and therefore
fixable) during the ongoing text migration, matching the Assumption already
recorded in `spec.md`.

**Alternatives considered**:
- Falling back to the other locale's value — rejected, `spec.md` explicitly
  ruled this out (would silently mask a real gap).
- Console-warn only, rendering nothing — rejected, FR-007 requires the page to
  show a visible fallback, not just a dev-only warning.

## 5. Frontend test tooling (Constitution Principle IV compliance)

**Decision**: Add `vitest` as a new devDependency with a `test:js` script in
`package.json`. `useTranslation()` is a pure function once given a translations
map (no DOM rendering required to exercise its lookup/fallback logic), so
plain Vitest is sufficient — no React Testing Library needed for this feature.

**Rationale**: Constitution Principle IV is explicitly NON-NEGOTIABLE and
requires a failing test before implementation for any spec-driven feature.
`package.json` currently has zero JS test runner configured — without adding
one, FR-007 and FR-010 (both frontend-only concerns) could not be red→green
tested at all, which would be a silent, undocumented violation rather than a
justified exception.

**Alternatives considered**:
- Skip frontend automated tests, rely on TypeScript type-checking + the manual
  `quickstart.md` walkthrough — rejected, this leaves two functional
  requirements with no automated regression coverage and no entry in
  Complexity Tracking to justify the gap; adding Vitest is proportionate given
  the hook is trivially pure-function-testable.
