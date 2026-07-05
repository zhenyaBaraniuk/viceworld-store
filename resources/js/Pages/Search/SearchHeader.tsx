import "../../../css/front/pages/search/search-header.css";
import type { SearchProps } from "@/types";
import { useState } from "react";
import { route } from "@/lib/route";
import { router } from "@inertiajs/react";
import { ArrowRight } from "lucide-react";

type Props = Pick<SearchProps, "query" | "total">;

export default function SearchHeader({ query, total }: Props) {
    const [input, setInput] = useState(query);

    function handleSearch(e: React.SubmitEvent) {
        e.preventDefault();
        router.get(route("search"), { q: input }, { preserveState: false });
    }

    return (
        <section className="search-header">
            <form
                onSubmit={handleSearch}
                className="search-header__title group"
            >
                <h1 className="text-3xl md:text-5xl font-headline font-black uppercase leading-tight">
                    <input
                        type="text"
                        value={input}
                        onChange={(e) => setInput(e.target.value)}
                        placeholder="Search..."
                        className="bg-transparent w-full uppercase placeholder:text-outline"
                        autoFocus
                    />
                </h1>

                <button
                    type="submit"
                    className="search-header__arrow text-primary"
                >
                    <ArrowRight className="flex" size={48} />
                </button>
            </form>

            <div className="search-header__result border-outline-variant">
                <h2 className="search-header__result-title text-on-surface">
                    {query
                        ? `${total} results for '${query}'`
                        : `${total} products`}
                </h2>
            </div>
        </section>
    );
}
