export interface CustomerAddress {
    city: string;
    street: string;
    building: string;
    apartment: string | null;
    is_default: boolean;
}
