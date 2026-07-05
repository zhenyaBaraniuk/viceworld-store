import type { CategoryListItem } from "@/types/common/list-items";

export interface ProductFiltersProps {
    categories: CategoryListItem[];
    colors: { value: string; hex: string }[];
    max_price: number;
    filters: Record<string, unknown> & { price?: number };
    categoryKey: string;
    onNavigate: (next: Record<string, unknown>) => void;
}
