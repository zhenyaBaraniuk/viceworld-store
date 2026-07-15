import "../../css/front/components/header.css";
import { Link, router, usePage } from "@inertiajs/react";
import { route } from "@/lib/route";
import { useState } from "react";
import { Moon, Search, ShoppingBag, Sun, User, X } from "lucide-react";
import LangSwitcher from "@/Components/LangSwitcher";
import * as Dialog from "@radix-ui/react-dialog";
import {Customer, NavCategory} from "@/types";
import clsx from "clsx";

export default function Header() {
    const { nav_categories } = usePage().props as {
        nav_categories: NavCategory[];
        auth: {customer: Customer | null};
    };

    const [value, setValue] = useState("");
    const [theme, setTheme] = useState<"light" | "dark">("light");

    function handleSubmit(e: React.SubmitEvent<HTMLFormElement>) {
        e.preventDefault();

        router.get(route("search"), { q: value });
    }

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
                    <Link
                        className="navbar__logo text-neutral-900 dark:text-white"
                        href={route("home")}
                    >
                        V<span className="text-primary">!</span>ceWorld
                    </Link>

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
                    <Dialog.Root>
                        <Dialog.Trigger asChild>
                            <button className="navbar__action-btn text-neutral-900 dark:text-white">
                                <Search size={20} />
                            </button>
                        </Dialog.Trigger>

                        <Dialog.Portal>
                            <Dialog.Overlay className="dialog-overlay" />

                            <Dialog.Content className="dialog-content bg-surface dark:bg-neutral-900">
                                <Dialog.Title className="dialog-title">
                                    Search
                                </Dialog.Title>

                                <form onSubmit={handleSubmit}>
                                    <input
                                        autoFocus
                                        value={value}
                                        onChange={(e) =>
                                            setValue(e.target.value)
                                        }
                                        className="dialog-input border-neutral-900 dark:border-white placeholder:text-neutral-400"
                                    />
                                </form>

                                <Dialog.Close asChild>
                                    <button className="close-btn text-neutral-900 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800">
                                        <X size={20} />
                                    </button>
                                </Dialog.Close>
                            </Dialog.Content>
                        </Dialog.Portal>
                    </Dialog.Root>

                    <Link
                        href={route("login")}
                        className="navbar_action-btn text-neutral-900 dark:text-white"
                    >
                        <User size={20} />
                    </Link>

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
