import type { ProductVariant } from "@/types/models/product-variant";

export interface Product {
    id: string,
    name: string,
    slug: string,
    price: string,
    description: string | null,
    main_image: string | null,
    images: string[] | null,
    product_variants: ProductVariant[],
}
