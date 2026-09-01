# Translations

`uk.json` and `en.json` hold every static UI string on the storefront. Each
file is a **flat** JSON object — no nesting, no arrays.

```json
{
    "header.search_dialog_title": "Пошук",
    "footer.nav_title": "Навігація"
}
```

## Editing existing copy

Change the value for a key in either file and save. No component edit is
required — the frontend reads the value at request time via `useTranslation()`.

## Adding a new key

1. Add the key to **both** `uk.json` and `en.json` with the same key name.
2. Reference it in the component with `t("your.key")` (see
   `resources/js/hooks/useTranslation.ts`).

## Conventions

- **Flat, dot-namespaced keys** — e.g. `"checkout.place_order"`, not nested
  objects like `{"checkout": {"place_order": "..."}}`.
- **Plain strings only.** No `{placeholder}` interpolation and no
  plural-form variants — if a string needs a dynamic value, compose it in
  JSX around the translated static parts (e.g.
  `` `${total} ${t("search.results_for")}` ``), not inside the translation
  value itself.
- **Key parity isn't enforced at runtime.** If a key is missing from one
  locale's file, that locale renders the raw key string instead of crashing
  (see `useTranslation()`'s fallback). Keep both files in sync by hand.
