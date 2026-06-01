export interface Product {
    id: string,
    name: string,
    slug: string,
    category_id: string,
    price: string,
    status: string,
    description: string | null,
    gender_line: string,
    is_featured: boolean,
    main_image: string | null,
}
