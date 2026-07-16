export interface Customer {
    id: number;
    first_name: string;
    last_name: string;
    email: string;
    phone: string | null;
    email_verified_at: string | null;
}
