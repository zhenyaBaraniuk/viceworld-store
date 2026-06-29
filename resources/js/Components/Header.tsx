import "../../css/front/components/header.css";
import {route} from "@/lib/route";
import {useState} from "react";
import {Moon, Search, ShoppingBag, Sun, User} from "lucide-react";
import {Link, usePage} from "@inertiajs/react";
import LangSwitcher from "@/Components/LangSwitcher";
import {NavCategory} from "@/types";
import clsx from "clsx";

export default function Header() {
    const { nav_categories } = usePage().props as {
        nav_categories: NavCategory[];
    };

    const [theme, setTheme] = useState<"light" | "dark">("light");

    const isCategoryActive = (slug: string) =>
        route().current("catalog.show", { slug });

    const toggleTheme = () => {
        const next = theme === "light" ? "dark" : "light";

        setTheme(next);

        if (next === "dark") {
            document.documentElement.classList.add("dark");
        } else {
            document.documentElement.classList.remove("dark");
        }
    };

    return (
        <header className="navbar bg-surface dark:bg-neutral-900 border-neutral-100 dark:border-neutral-800">
            <div className="navbar__inner">
                <div className="navbar__left">
                    <a
                        className="navbar__logo text-neutral-900 dark:text-white"
                        href={route("home")}
                    >
                        V<span className="text-primary">!</span>ceWorld
                    </a>

                    <nav className="navbar__nav hidden md:flex">
                        {nav_categories.map((category) => (
                            <Link
                                key={category.id}
                                href={route("catalog.show", {
                                    slug: category.slug,
                                })}
                                className={clsx("nav-link", {
                                    "nav-link--active text-primary dark:text-primary border-primary":
                                        isCategoryActive(category.slug),
                                    "text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white":
                                        !isCategoryActive(category.slug),
                                })}
                            >
                                {category.name}
                            </Link>
                        ))}
                    </nav>
                </div>

                <div className="navbar__actions">
                    <button className="navbar__action-btn text-neutral-900 dark:text-white">
                        <Search size={20} />
                    </button>

                    <button className="navbar_action-btn text-neutral-900 dark:text-white">
                        <User size={20} />
                    </button>

                    <button className="navbar_action-btn text-neutral-900 dark:text-white">
                        <ShoppingBag size={20} />
                    </button>

                    <LangSwitcher />

                    <button
                        onClick={toggleTheme}
                        className="navbar__theme text-neutral-900 dark:text-white"
                    >
                        {theme === "dark" ? (
                            <Sun size={20} />
                        ) : (
                            <Moon size={20} />
                        )}
                    </button>
                </div>
            </div>
        </header>
    );
}
