import { router, usePage } from "@inertiajs/react";
import { Fragment } from "react";

const LOCALES = [
    { code: "uk", label: "UA" },
    { code: "en", label: "EN" },
] as const;

export default function LangSwitcher() {
    const { url, props } = usePage<{
        locale: string;
    }>();

    const current = props.locale;

    const switchTo = (locale: string) => {
        if (locale === current) {
            return;
        }

        const segments = url.split("/").filter(Boolean);

        if (segments.length === 0) {
            segments.push(locale);
        } else {
            segments[0] = locale;
        }

        router.get("/" + segments.join("/"));
    };

    return (
        <div className="navbar__lang">
            {LOCALES.map(({ code, label }, i) => (
                <Fragment key={code}>
                    {i > 0 && <span className="text-neutral-300">·</span>}

                    <span
                        className={`navbar-lang-item cursor-pointer ${
                            current === code
                                ? "text-primary"
                                : "text-neutral-400 hover:text-neutral-600"
                        }`}
                        onClick={() => switchTo(code)}
                    >
                        {label}
                    </span>
                </Fragment>
            ))}
        </div>
    );
}
