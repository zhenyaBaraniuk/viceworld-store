import { usePage } from "@inertiajs/react";

export function translate(
    translations: Record<string, string>,
    key: string,
): string {
    return translations[key] ?? key;
}

export function useTranslation() {
    const { props } = usePage<{ translations: Record<string, string> }>();

    const t = (key: string): string => translate(props.translations, key);

    return { t };
}
