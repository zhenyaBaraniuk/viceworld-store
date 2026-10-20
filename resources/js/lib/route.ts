import { usePage } from "@inertiajs/react";
import { useMemo } from "react";
import { route as r } from "ziggy-js";

type RouteName = Parameters<typeof r>[0];
type RouteParams = Record<string, string | number | boolean>;

type RouteFn = {
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    (): any;
    (name: RouteName, params?: RouteParams, absolute?: boolean): string;
};

function make(config?: typeof Ziggy): RouteFn {
    return ((name?: RouteName, params?: RouteParams, absolute?: boolean) =>
        name === undefined
            ? // eslint-disable-next-line @typescript-eslint/no-explicit-any
              (r as any)(undefined, undefined, undefined, config)
            : r(name, params as never, absolute, config)) as RouteFn;
}

export const route = make();

export function useRoute(): RouteFn {
    const { locale } = usePage().props;

    return useMemo(
        () => make({ ...Ziggy, defaults: { ...Ziggy.defaults, locale } }),
        [locale],
    );
}
