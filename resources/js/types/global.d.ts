import '@inertiajs/core'
import {NavCategory} from "@/types/index";
import { route as routeFn } from 'ziggy-js';

declare module "@inertiajs/core" {
    export interface InertiaConfig {
        sharedPageProps: {
            nav_categories: NavCategory[];
        };
    }
}


declare global {
    var route: typeof routeFn;
}
