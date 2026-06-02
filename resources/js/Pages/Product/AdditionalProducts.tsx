import '../../../css/front/pages/product/additional-products.css';
import {ProductProps} from "@/types/pages/product";
import {Link} from "@inertiajs/react";

type Props = Pick<ProductProps, 'related_products'>;

export default function AdditionalProducts({related_products}: Props) {
    return (
        <section className="additional-products">
            <h2 className="additional-products__title">Complete the Look</h2>

            <div className="additional-products__grid">

                {related_products.map((related_product) => (
                    <Link
                        key={related_product.slug}
                        href={route('product.show', {slug: related_product.slug})}
                    >
                        <div className="group cursor-pointer">
                            <div className="additional-products__item-media bg-surface-container-low">
                                <img
                                    className="additional-products__item-img grayscale group-hover:grayscale-0"
                                    alt={related_product.name}
                                    src={related_product.main_image || undefined}
                                />

                                <button
                                    className="additional-products__item-add bg-white group-hover:opacity-100 group-hover:translate-y-0">
                                        <span className="material-symbols-outlined" data-icon="add">
                                            add
                                        </span>
                                </button>
                            </div>

                            <div className="space-y-1">
                                <h4 className="additional-products__item-name">{related_product.name}</h4>
                                <p className="text-xs text-neutral-500">${related_product.price}</p>
                            </div>
                        </div>
                    </Link>
                ))}
            </div>
        </section>
    );
}
