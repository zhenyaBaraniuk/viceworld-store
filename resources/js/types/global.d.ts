import "@inertiajs/core";
import { NavCategory } from "@/types/index";
import { Customer } from "@/types/models/customer";
import { route as routeFn } from "ziggy-js";

declare module "@inertiajs/core" {
    export interface InertiaConfig {
        sharedPageProps: {
            nav_categories: NavCategory[];
            auth: { customer: Customer | null };
        };
    }
}

declare global {
    var route: typeof routeFn;
}
