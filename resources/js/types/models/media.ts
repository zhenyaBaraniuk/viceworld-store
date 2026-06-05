export interface Media {
    id: string;
    name: string;
    url: string;
    mime_type: string;
    collection: string | null;
    order: number;
}
