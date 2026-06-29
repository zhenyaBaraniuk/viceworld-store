import { route as r } from "ziggy-js";

type RouteName = Parameters<typeof r>[0];

// eslint-disable-next-line @typescript-eslint/no-explicit-any
export function route(): any;

export function route(
    name: RouteName,
    params?: Record<string, string | number | boolean>,
    absolute?: boolean,
): string;

export function route(
    name?: RouteName,
    params?: Record<string, string | number | boolean>,
    absolute?: boolean,
) {
    return name === undefined
        ? // eslint-disable-next-line @typescript-eslint/no-explicit-any
          (r as any)()
        : r(name, params as never, absolute);
}
