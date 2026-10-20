import "@inertiajs/core";
import { NavCategory } from "@/types/index";
import { Customer } from "@/types/models/customer";
import { route as routeFn, useRoute } from "ziggy-js";

declare module "@inertiajs/core" {
    export interface InertiaConfig {
        sharedPageProps: {
            locale: string;
            nav_categories: NavCategory[];
            auth: { customer: Customer | null };
            flash: Record<string, string | undefined>;
            translations: Record<string, string>;
        };
    }
}

declare global {
    var route: typeof routeFn;
    var Ziggy: NonNullable<Parameters<typeof useRoute>[0]>;
}
