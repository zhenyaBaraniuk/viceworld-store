import "../../../css/front/pages/profile/navigation.css";
import { Link } from "@inertiajs/react";
import { route } from "@/lib/route";
import { RouteList } from "ziggy-js";
import { ArrowRight } from "lucide-react";
import { useTranslation } from "@/hooks/useTranslation";

export default function Navigation() {
    const { t } = useTranslation();

    const NAV_ITEMS: { label: string; routeName: keyof RouteList }[] = [
        { label: t("profile.nav_profile"), routeName: "account.show" },
        { label: t("profile.nav_settings"), routeName: "account.settings" },
    ];

    return (
        <aside className="navigation md:col-span-3">
            <nav className="navigation__nav">
                {NAV_ITEMS.map(({ label, routeName }) => {
                    const active = route().current(routeName);

                    return (
                        <Link
                            key={routeName}
                            href={route(routeName)}
                            className={
                                active
                                    ? "navigation__nav-link bg-primary text-white font-display group"
                                    : "navigation__nav-link text-neutral-500 hover:text-neutral-900 font-display bg-surface-container-low transition-all"
                            }
                        >
                            <span>{label}</span>
                            {active && <ArrowRight size={20} />}
                        </Link>
                    );
                })}

                <Link
                    method="post"
                    className="navigation__nav-link text-error font-display mt-12 hover:bg-error-container transition-all"
                    href={route("logout")}
                >
                    <span>{t("profile.nav_logout")}</span>
                </Link>
            </nav>
        </aside>
    );
}
