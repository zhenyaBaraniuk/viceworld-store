# Feature Specification: Product Labels

**Feature Branch**: `002-product-labels`

**Created**: 2026-09-11

**Status**: Draft

**Input**: User description: "Замінити хардкод product.meta_tag (Core Collection • Limited Edition) на окремий адмін-модуль лейблів: адміністратор створює лейбли в адмінці та присвоює їх товарам."

## Clarifications

### Session 2026-09-11

- Q: Коли товару присвоєно декілька лейблів одразу, у якому порядку показувати їх на сторінці товару? → A: У порядку, в якому адміністратор їх присвоїв товару (не алфавітний, не за датою створення лейбла).

## User Scenarios & Testing *(mandatory)*

### User Story 1 - Admin manages the label catalog (Priority: P1)

As an administrator, I want to create, edit, and delete labels (e.g. "Core Collection", "Limited Edition") in the admin panel, with a translated name for each supported locale, so that the set of available labels is not fixed in source code.

**Why this priority**: Without a label catalog to draw from, nothing else in this feature can exist — it is the foundation both other stories depend on.

**Independent Test**: Can be fully tested by opening the label management screen in the admin panel, creating a label with a UA and EN name, editing it, and deleting it — without touching any product.

**Acceptance Scenarios**:

1. **Given** the admin panel label screen, **When** the administrator creates a new label with a name in each supported locale, **Then** the label appears in the label list and is available for assignment to products.
2. **Given** an existing label, **When** the administrator edits its name, **Then** the updated name is reflected everywhere the label is shown (admin list, product assignment picker, storefront).
3. **Given** an existing label not assigned to any product, **When** the administrator deletes it, **Then** it no longer appears in the label list or in the product assignment picker.

---

### User Story 2 - Admin assigns labels to a product (Priority: P2)

As an administrator, I want to assign zero or more labels to a product from the product edit screen, so that each product can carry the labels that actually apply to it instead of a single fixed value.

**Why this priority**: This connects the label catalog (Story 1) to real products — it is the second half of replacing the hardcode, and delivers visible admin value once Story 1 exists.

**Independent Test**: Can be fully tested by opening an existing product's edit screen, selecting one or more labels from the catalog created in Story 1, saving, and reopening the product to confirm the selection (and its order) persisted.

**Acceptance Scenarios**:

1. **Given** a product with no labels, **When** the administrator assigns one or more existing labels and saves, **Then** those labels are stored against the product, in the order they were assigned, and shown as selected when the product is reopened for editing.
2. **Given** a product with assigned labels, **When** the administrator removes one and saves, **Then** only the remaining labels stay associated with the product, preserving their relative order.
3. **Given** the label picker on the product screen, **When** the administrator searches by label name, **Then** matching labels appear regardless of the current UI locale's translation.

---

### User Story 3 - Customer sees a product's labels on the product page (Priority: P3)

As a customer viewing a product page, I want to see the labels assigned to that specific product (translated into my language), so that I understand things like whether it's part of a limited or core collection at a glance.

**Why this priority**: This is the customer-facing payoff of the feature, but it has no value until labels exist and are assigned (Stories 1 and 2), so it is correctly last.

**Independent Test**: Can be fully tested by visiting the public page of a product that has labels assigned and confirming the translated label text renders in assignment order; then visiting a product with no labels and confirming no label area renders.

**Acceptance Scenarios**:

1. **Given** a product with one or more assigned labels, **When** a customer opens its product page, **Then** the labels are displayed in the customer's current locale.
2. **Given** a product with no assigned labels, **When** a customer opens its product page, **Then** no label area is rendered (no empty placeholder or leftover static text).
3. **Given** a product with multiple assigned labels, **When** a customer opens its product page, **Then** all assigned labels are displayed together in a single, readable line, in the order the administrator assigned them.

### Edge Cases

- What happens when an administrator deletes a label that is still assigned to one or more products? The association MUST be removed without deleting or otherwise affecting the products themselves.
- What happens when a label's translation is missing for the customer's current locale? A reasonable fallback (e.g. the other configured locale) MUST be shown rather than a blank or broken string.
- What happens when a product has many labels assigned at once? All of them MUST still render legibly on the product page, in assignment order, rather than being silently truncated or reordered.
- What happens when two labels are given the exact same name? Both MUST be allowed to exist and be assigned independently (labels are not required to be globally unique by name).

## Requirements *(mandatory)*

### Functional Requirements

- **FR-001**: System MUST allow an administrator to create a label with a translated name for each locale the storefront supports.
- **FR-002**: System MUST allow an administrator to edit and delete an existing label from the admin panel.
- **FR-003**: System MUST allow an administrator to assign any number of existing labels (including zero) to a product, and to change that assignment later.
- **FR-004**: System MUST support the same label being assigned to multiple products, and a single product carrying multiple labels at once.
- **FR-005**: System MUST display a product's assigned labels on its public product page, translated into the viewer's current locale.
- **FR-006**: System MUST NOT render any label area on a product page for a product with zero assigned labels.
- **FR-007**: System MUST restrict label creation, editing, and deletion to administrators with the appropriate catalog-management permission, consistent with how other catalog data (e.g. categories, attributes) is already access-controlled.
- **FR-008**: Deleting a label MUST NOT delete or otherwise modify the products it was assigned to — only the association is removed.
- **FR-009**: The previously hardcoded static text this feature replaces MUST be fully removed from the storefront once label data drives that area of the product page.
- **FR-010**: When a product has multiple assigned labels, System MUST display them in the order the administrator assigned them, not alphabetically or by label creation date.

### Key Entities

- **Label**: A short, admin-defined tag describing a product's positioning (e.g. "Core Collection", "Limited Edition"). Has a translated display name per locale. Independent of size/color product attributes.
- **Product–Label Association**: A many-to-many link between a Product and the Labels assigned to it; a product may have any number of labels (including none), a label may be reused across many products, and the association records the order in which labels were assigned so display order is preserved.

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: An administrator can introduce a brand-new label and make it available for product assignment without any source-code or deployment change.
- **SC-002**: An administrator can change which labels a given product displays in under 30 seconds from the product edit screen.
- **SC-003**: 100% of products with at least one assigned label show those labels, in assignment order, on their public product page; 100% of products with none show no label area.
- **SC-004**: Zero remaining references to the previously hardcoded label text exist in the storefront after this feature ships.

## Assumptions

- Only the storefront's existing supported locales (Ukrainian and English) need translated label names for v1, matching how other translatable catalog data (categories, attributes) is handled today.
- Labels are simple translated tags for v1 — no color or icon is required, since none is called for by the current scope. Display order follows the order in which the administrator assigned labels to the product (see Clarifications).
- Deleting a label that is in use is allowed and simply detaches it from any product; no separate "in use" warning or block is required for v1.
- There is no customer-facing label browsing/filtering (e.g. "shop by label") in this feature — labels are display-only on the product page.
- The existing hardcoded meta-tag text is removed entirely once this feature ships, rather than kept as a fallback.
