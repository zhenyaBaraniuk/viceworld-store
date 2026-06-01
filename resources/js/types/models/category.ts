export interface Category {
    id: string,
    parent_id: string | null,
    name: string,
    slug: string,
    description: string | null,
    gender_line: string,
    is_active: boolean,
    children?: Category[],
}
