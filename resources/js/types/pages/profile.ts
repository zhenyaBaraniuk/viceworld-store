import type { Customer } from "@/types/pages/customer";
import type { Order } from "@/types/models/order";

export type ProfileProps = {
    customer: Customer;
};

export type OrderProps = {
    orders: Order[];
};
