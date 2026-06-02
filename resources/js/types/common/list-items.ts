import type { Category } from "@/types/models/category";
import type { Product } from "@/types/models/product";

export type CategoryListItem = Pick<Category, 'id' | 'name' | 'slug'>

export type ProductShortItem = Pick<Product, 'price' | 'name' | 'slug' | 'main_image'>

export type ProductItem = Pick<Product, 'price' | 'name' | 'slug' | 'main_image'> & {
    category_name: string
}
