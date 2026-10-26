import type { Media } from "@/types/models/media";

export type OrderStatus =
    | "pending"
    | "paid"
    | "processing"
    | "shipped"
    | "delivered"
    | "cancelled"
    | "refunded";

export interface Order {
    id: string;
    status: OrderStatus;
    total_amount: string;
    created_at: string;
    image: Media | null;
    items_count: number;
}
