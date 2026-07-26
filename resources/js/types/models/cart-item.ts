import type { Media } from "@/types";

export interface CartItem {
    id: string;
    quantity: number;
    product_name: string;
    product_slug: string;
    image: Media | null;
    price: string;
}
