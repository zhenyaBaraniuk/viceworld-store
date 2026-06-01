import type {Pagination} from "@/types";
import type {Category} from "@/types";
import type {Product} from "@/types";

export type CategoryListItem = Pick<Category, 'id' | 'name' | 'slug'>
export type ProductItem = Pick<Product, 'price' | 'name' | 'slug' | 'main_image'> & {
    category_name: string
}

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
