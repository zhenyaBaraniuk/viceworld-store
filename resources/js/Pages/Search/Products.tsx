import "../../../css/front/pages/search/products.css";
import type { SearchProps } from "@/types";
import { useEffect, useState } from "react";
import { Link, router } from "@inertiajs/react";
import { route } from "@/lib/route";
import Pagination from "@/Navigation/Pagination";

type Props = Pick<SearchProps, "products" | "filters" | "query">;

export default function Products({ products, filters, query }: Props) {
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        const removeStart = router.on("start", () => setLoading(true));
        const removeFinish = router.on("finish", () => setLoading(false));

        return () => {
            removeStart();
            removeFinish();
        };
    }, []);

    const [first, ...rest] = products.data;

    return (
        <section className="products">
            <div
                className={`products__main transition-opacity duration-300 ${loading ? "opacity-40" : "opacity-100"}`}
            >
                {first && (
                    <Link
                        key={first.name}
                        href={route("product.show", { slug: first.slug })}
                        className="md:col-span-2 group"
                    >
                        <div className="products__head bg-surface-container-low">
                            <img
                                alt={first.name}
                                src={first.main_image_url ?? undefined}
                                className="products__head-img transition-transform duration-700 group-hover:scale-105"
                            />
                        </div>
                        <div className="products__head-payload">
                            <div>
                                <p className="products__head-category text-outline">
                                    {first.category_name}
                                </p>
                                <h4 className="products__head-title font-headline">
                                    {first.name}
                                </h4>
                            </div>
                            <p className="products__head-price text-primary">
                                ${first.price}
                            </p>
                        </div>
                    </Link>
                )}

                {rest.map((product) => (
                    <Link
                        key={product.slug}
                        href={route("product.show", { slug: product.slug })}
                        className="group"
                    >
                        <div className="products__product bg-surface-container-low">
                            <img
                                alt={product.name}
                                src={product.main_image_url ?? undefined}
                                className="products__product-img transition-transform duration-700 group-hover:scale-105"
                            />
                        </div>
                        <div className="mt-4">
                            <p className="products__product-category text-outline">
                                {product.category_name}
                            </p>

                            <h4 className="products__product-title font-headline">
                                {product.name}
                            </h4>

                            <p className="products__product-price text-primary">
                                ${product.price}
                            </p>
                        </div>
                    </Link>
                ))}
            </div>

            <Pagination
                current_page={products.current_page}
                last_page={products.last_page}
                queryParams={{ ...filters, q: query }}
                url={route("search")}
            />
        </section>
    );
}
