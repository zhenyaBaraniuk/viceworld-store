import type { ProductItem } from "@/types/common/list-items";

export interface CategoryTile {
    name: string;
    slug: string;
    image_url: string;
}

export interface HomeProps {
    hero_product: ProductItem;
    new_arrivals: ProductItem[];
    category_tiles: CategoryTile[];
}
