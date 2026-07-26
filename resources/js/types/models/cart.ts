import type { CartItem } from "@/types/models/cart-item";

export interface Cart {
    customer_id: string | null;
    session_id: string | null;
    total_price: number;
    cart_items: CartItem[];
}
