import type { CustomerAddress } from "@/types/models/customer-address";

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
