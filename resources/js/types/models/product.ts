import type { ProductVariant } from "@/types/models/product-variant";
import type { Media } from "@/types/models/media";

export interface Product {
    id: string;
    name: string;
    slug: string;
    price: string;
    description: string | null;
    main_image: Media | null;
    video: Media | null;
    images: Media[] | null;
    product_variants: ProductVariant[];
}
