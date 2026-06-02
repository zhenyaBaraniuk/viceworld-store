import '@css/front/pages/catalog/products.css';
import type {CatalogProps} from "@/types";
import Pagination from "@/Navigation/Pagination";
import {useEffect, useState} from "react";
import {Link, router} from "@inertiajs/react";

type Props = Pick<CatalogProps, 'products' | 'filters'>;

export default function Products({products, filters}: Props) {
    const [loading, setLoading] = useState(false);
    const { parent_category_slug, ...queryFilters } = filters;

    useEffect(() => {
        const removeStart = router.on('start', () => setLoading(true));
        const removeFinish = router.on('finish', () => setLoading(false));

        return () => {
            removeStart();
            removeFinish();
        }
    }, []);

    return (
        <section className="products">
            <div
                className={`grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-16 gap-x-8 transition-opacity duration-300 ${loading ?
                    'opacity-40' : 'opacity-100'}`}
            >
                {products.data.map((product) => (
                    <Link
                        key={product.slug}
                        href={route('product.show', {slug: product.slug})}
                        className="product-card group cursor-pointer">
                        <div className="product-card__media bg-surface-container-low">
                            <img
                                alt={product.name}
                                src={product.main_image || undefined}
                            />
                        </div>

                        <div className="space-y-1">
                            <p className="product-card__category font-headline text-primary">
                                {product.category_name}
                            </p>

                            <h4 className="product-card__title font-headline">
                                {product.name}
                            </h4>

                            <p className="product-card__price font-headline">${product.price}</p>
                        </div>
                    </Link>
                ))}
            </div>

            <Pagination current_page={products.current_page}
                        last_page={products.last_page}
                        queryParams={queryFilters}
                        url={route('catalog.show', {slug: parent_category_slug})}
            />
        </section>
    );
}
