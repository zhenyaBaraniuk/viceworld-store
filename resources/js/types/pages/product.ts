import type {Product} from "@/types";
import type {CategoryListItem, ProductShortItem} from "@/types/common/list-items";

export interface ProductProps {
    product: Product;
    category: CategoryListItem;
    related_products: ProductShortItem[];
}
