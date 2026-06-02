import type {Pagination} from "@/types";
import type { CategoryListItem, ProductItem } from "@/types/common/list-items";

export interface CatalogProps {
    products: Pagination<ProductItem>
    categories: CategoryListItem[]
    filters: {
        parent_category_slug: string,
        child_category_slug?: string[],
        size?: string[],
        color?: string[],
        price?: number,
    }
    max_price: number,
    colors: { value: string, hex: string }[]
}
