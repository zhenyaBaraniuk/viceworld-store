import { ArrowLeft, ArrowRight } from "lucide-react";
import type { Pagination } from "@/types";
import { router } from "@inertiajs/react";

type PaginationProps = Pick<
    Pagination<unknown>,
    "current_page" | "last_page"
> & {
    queryParams?: Record<string, unknown>;
    url: string;
};

export default function Pagination({
    current_page,
    last_page,
    queryParams = {},
    url,
}: PaginationProps) {
    function goTo(page: number) {
        if (page < 1 || page > last_page) {
            return;
        }

        router.get(
            url,
            { ...queryParams, page },
            {
                preserveState: true,
                replace: true,
            },
        );
    }

    return (
        <div className="mt-24 grid grid-cols-3 items-center border-t-4 border-on-surface pt-8">
            <div>
                {current_page > 1 && (
                    <button
                        onClick={() => goTo(current_page - 1)}
                        className="font-headline font-black uppercase text-sm flex items-center gap-2 group"
                    >
                        <ArrowLeft
                            size={20}
                            className="group-hover:-translate-x-1 transition-transform"
                        />
                        PREVIOUS
                    </button>
                )}
            </div>

            <div className="flex gap-8 font-headline font-black justify-center">
                {Array.from({ length: last_page }, (_, i) => i + 1).map(
                    (page) => (
                        <span
                            key={page}
                            onClick={() => goTo(page)}
                            className={
                                page === current_page
                                    ? "text-primary border-b-2 border-primary"
                                    : "text-outline hover:text-on-surface cursor-pointer"
                            }
                        >
                            {String(page).padStart(2, "0")}
                        </span>
                    ),
                )}
            </div>

            <div>
                {current_page < last_page && (
                    <button
                        onClick={() => goTo(current_page + 1)}
                        className="font-headline font-black uppercase text-sm flex items-center gap-2 group justify-end"
                    >
                        <ArrowRight
                            size={20}
                            className="group-hover:translate-x-1 transition-transform"
                        />
                        NEXT
                    </button>
                )}
            </div>
        </div>
    );
}
