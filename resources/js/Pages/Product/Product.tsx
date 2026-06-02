import '../../../css/front/pages/product/product.css';
import {ProductProps} from "@/types/pages/product";

type Props = Pick<ProductProps, 'product'>;

export default function Product({product}: Props) {
    const productSize = product.product_variants
        .flatMap(variant => variant.attribute_values)
        .filter(attribute => attribute.name === 'Size')
        .filter((attribute, i, arr) => arr.findIndex(x => x.value === attribute.value) === i)

    return (
        <div className="product">
            <div>
                <div className="lg:sticky lg:top-24 space-y-4">
                    <div className="product-gallery__grid">
                        <div className="product-gallery__video bg-surface-container-low group">
                            <video
                                className="product-gallery__video-video"
                                poster={product.main_image || undefined}
                            >
                                <source src="" type="video/mp4"/>
                            </video>

                            <div className="product-gallery__badge bg-primary text-white  font-['Space_Grotesk']">
                                ▶ VIDEO
                            </div>

                            <div className="product-gallery__overlay bg-black/30 group-hover:bg-black/10">
                                <div
                                    className="product-gallery__play-btn bg-white rounded-full transform group-hover:scale-110">
                                    <span className="material-symbols-outlined text-black text-3xl fill-1">
                                        play_arrow
                                    </span>
                                </div>
                            </div>

                            <div
                                className="product-gallery__controls bg-gradient-to-t from-black/60 to-transparent group-hover:opacity-100">
                                <div className="flex space-x-4 items-center">
                                    <span className="material-symbols-outlined text-white text-sm">
                                        pause
                                    </span>

                                    <div className="product-gallery__progress bg-white/30 rounded-full">
                                        <div className="product-gallery__progress-fill bg-white">
                                        </div>
                                    </div>

                                    <span className="material-symbols-outlined text-white text-sm">
                                        volume_up
                                    </span>
                                </div>
                            </div>
                        </div>

                        {
                            product.images?.map((url, index) => (
                                <div
                                    key={index}
                                    className="product-gallery__thumb bg-surface-container-low">
                                    <img
                                        className="product-gallery__thumb-img"
                                        alt={product.name}
                                        src={url}
                                    />
                                </div>
                            ))
                        }
                    </div>
                </div>
            </div>

            <div className="space-y-10">
                <header className="space-y-4">
                    <div className="product-info">
                        <h1 className="product-info__title font-headline">
                            {product.name}
                        </h1>

                        <span className="product-info__price font-headline">
                                ${product.price}
                        </span>
                    </div>

                    <p className="product-info__meta text-primary">
                        Core Collection • Limited Edition
                    </p>
                </header>

                <div className="space-y-6">
                    <div className="space-y-4">
                        <div className="flex justify-between items-end">
                            <span className="text-xs font-bold uppercase tracking-widest text-neutral-500">
                                Select size
                            </span>

                            <span className="text-xs font-bold uppercase tracking-widest text-neutral-400">
                                Size guide
                            </span>
                        </div>

                        <div className="product-info__sizes">
                            {
                                productSize.map((size) => (
                                    <button
                                        key={size.value}
                                        className="product-info__size-btn hover:bg-on-surface hover:text-white"
                                    >
                                        {size.value}
                                    </button>
                                ))
                            }
                        </div>
                    </div>

                    <button
                        className="product-info__ai-btn text-primary hover:underline group">
                        <span>Not sure about your size? Ask AI</span>

                        <span
                            className="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform"
                            data-icon="trending_flat">
                                trending_flat
                            </span>
                    </button>
                </div>

                <div className="space-y-4">
                    <button
                        className="product-info__btn text-white active:scale-[0.98] hover:bg-primary">
                        Add to Cart
                    </button>

                    <button
                        className="product-info__btn-card border-on-surface hover:bg-on-surface hover:text-white">
                        Buy with Apple pay
                    </button>
                </div>

                <div className="product-info__details border-neutral-200">
                    <div className="space-y-4">
                        <h3 className="text-sm font-black">Description</h3>
                        <p className="text-neutral-600 leading-relaxed font-body">
                            {product.description}
                        </p>
                    </div>

                    <div className="product-info__features bg-surface-container-low">
                        <div className="space-y-2">
                            <span className="material-symbols-outlined text-primary"
                                data-icon="bolt"
                            >
                                bolt
                            </span>

                            <p className="text-[10px] font-black uppercase">
                                Rapid deployment
                            </p>
                            <p>4-way stretch tech</p>
                        </div>

                        <div className="space-y-2">
                            <span className="material-symbols-outlined text-primary"
                                  data-icon="shield">shield
                            </span>

                            <p className="text-[10px] font-black uppercase">Urban Armor</p>
                            <p className="text-[10px] text-neutral-500">Abrasion resistant</p>
                        </div>
                    </div>

                    <div className="space-y-4">
                        <details className="group border-b border-neutral-200 pb-4">
                            <summary className="product-info__accordion-summary">
                                Shipping &amp; Returns
                                <span
                                    className="material-symbols-outlined group-open:rotate-180 transition-transform"
                                    data-icon="expand_more"
                                >
                                        expand_more
                                    </span>
                            </summary>

                            <div className="pt-4 text-xs text-neutral-500 font-body">
                                Worldwide express shipping available. 14-day return policy for
                                unused items in original packaging.
                            </div>
                        </details>

                        <details className="group border-b border-neutral-200 pb-4">
                            <summary className="product-info__accordion-summary">
                                Fabric Details
                                <span className="material-symbols-outlined group-open:rotate-180 transition-transform"
                                      data-icon="expand_more">expand_more
                                    </span>
                            </summary>

                            <div className="pt-4 text-xs text-neutral-500 font-body">
                                Shell: 100% Recycled Nylon. Lining: 100% Cupro. Trim: 100%
                                Vegetable Tanned Leather.
                            </div>
                        </details>
                    </div>
                </div>
            </div>
        </div>
    );
}
