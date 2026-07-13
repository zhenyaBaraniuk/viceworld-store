import type { CatalogProps } from "@/types";
import ProductFilters from "@/Components/ProductFilters";
import { router } from "@inertiajs/react";
import { route } from "@/lib/route";

type Props = Pick<
    CatalogProps,
    "categories" | "filters" | "max_price" | "colors"
>;

export default function Filters({
    categories,
    filters,
    colors,
    max_price,
}: Props) {
    const { parent_category_slug, ...activeFilters } = filters;

    function onNavigate(next: typeof activeFilters) {
        router.get(
            route("catalog.show", { slug: parent_category_slug }),
            next,
            {
                preserveState: true,
                replace: true,
                only: ["products", "filters"],
            },
        );
    }

    return (
        <ProductFilters
            categories={categories}
            colors={colors}
            max_price={max_price}
            filters={activeFilters}
            categoryKey="child_category_slug"
            onNavigate={onNavigate}
        />
    );
}
