import type { CustomerAddress } from "@/types/models/customer-address";

export type Customer = {
    first_name: string;
    last_name: string;
    email: string;
    phone: string | null;
    address: CustomerAddress | null;
};
