import type { AttributeValue } from "@/types/models/attribute-value";

export interface ProductVariant {
    id: string;
    price: string | null;
    is_active: boolean;
    attribute_values: AttributeValue[];
}
