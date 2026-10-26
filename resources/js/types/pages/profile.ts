import type { CustomerAddress } from "@/types/models/customer-address";
import type { Order } from "@/types/models/order";

export interface CustomerData {
    first_name: string;
    last_name: string;
    email: string;
    phone: string | null;
    address: CustomerAddress | null;
}

export type ProfileProps = {
    customer: CustomerData;
};

export type OrderProps = {
    orders: Order[];
};
