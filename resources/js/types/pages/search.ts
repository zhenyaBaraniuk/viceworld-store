import type { Pagination } from "@/types";
import type { CategoryListItem, ProductItem } from "@/types/common/list-items";

export interface SearchProps {
    products: Pagination<ProductItem>;
    categories: CategoryListItem[];
    filters: {
        category_slug?: string[];
        size?: string[];
        color?: string[];
        price?: number;
    };
    max_price: number;
    colors: { value: string; hex: string }[];
    query: string;
    total: number;
}
