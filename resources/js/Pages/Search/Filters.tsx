import { SearchProps } from "@/types";
import ProductFilters from "@/Components/ProductFilters";
import { router } from "@inertiajs/react";
import { route } from "@/lib/route";

type Props = Pick<
    SearchProps,
    "categories" | "filters" | "max_price" | "colors" | "query"
>;

export default function Filters({
    categories,
    filters,
    colors,
    max_price,
    query,
}: Props) {
    function onNavigate(next: typeof filters) {
        router.get(
            route("search"),
            { q: query, ...next },
            {
                preserveState: true,
                replace: true,
                only: ["products", "filters", "total"],
            },
        );
    }

    return (
        <ProductFilters
            categories={categories}
            colors={colors}
            max_price={max_price}
            filters={filters}
            categoryKey="category_slug"
            onNavigate={onNavigate}
        />
    );
}
