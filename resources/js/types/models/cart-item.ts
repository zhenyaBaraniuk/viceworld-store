import type { Media } from "@/types";
import type { AttributeValue } from "@/types/models/attribute-value";

export interface CartItem {
    id: string;
    quantity: number;
    product_name: string;
    product_slug: string;
    image: Media | null;
    price: string;
    attribute_values: AttributeValue[];
}
