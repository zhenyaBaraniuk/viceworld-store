export interface ProductVariant {
    id: string;
    price: string | null;
    is_active: boolean;
    attribute_values: { value: string; hex: string | null; name: string }[];
}
