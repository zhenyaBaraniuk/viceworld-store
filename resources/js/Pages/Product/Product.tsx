import '../../../css/front/pages/product/product.css';

export default function Product() {
    return (
        <div className="product">
            <div>
                <div className="lg:sticky lg:top-24 space-y-4">
                    <div className="product-gallery__grid">
                        <div className="product-gallery__video bg-surface-container-low group">
                            <video
                                className="product-gallery__video-video"
                                poster="https://lh3.googleusercontent.com/aida-public/AB6AXuBRio0FQkbeEqbtjYHvzWv6aqEdi6p4UOcNY82p8vIqgJzasxvIyFe0n87VyhSO_qGrTE3Lpj9ItJY9Q9t_t-duTsDsGL40eL_VJoDAmurHpMrGmEOZ2__w5bciHhIXvIbo_O2tYdxnT6HLzZuiJ2zaEhtakbxp4nOpr1gZrrJSuw-CQ_x-glmw2aTD1JUJDZxVZ1J9lhZofJLF6D8VTdBeJdWvNNn82cZT1-lW-XVgUbUhZQrx3c9q1K45VeMaZTtsXT_13TJ8fA0x"
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

                        <div className="product-gallery__thumb bg-surface-container-low">
                            <img className="product-gallery__thumb-img"
                                 data-alt="Close up of black leather biker jacket detail"
                                 src="https://lh3.googleusercontent.com/aida-public/AB6AXuC0Fwe10mwsUjikaDTs4MYRDsp6pLTJVDMw3obqw3xbJNpGLOhhHkF7TwsGTCY3NBcGGrMVY78Au4RYeDhB-sykOlv3H9ppYPAaaRdgf5YoRpwJyigcZkoNxbJ00Ci32XmDdfrE_swZ6x0RUg6nYF2jGEcnl0TS__2oAwXnmGq9oxZKISOjvqGyYrEKg0DnIpNwqeWTTgErVL8-HQPbuIxjQiQHtVkeiE8bTq6AD5wiKc9l2crWNBV83KcLpDjU7jw9RDsQYpUVtunj"
                            />
                        </div>

                        <div className="product-gallery__thumb bg-surface-container-low">
                            <img className="product-gallery__thumb-img"
                                 data-alt="Model wearing black urban streetwear jacket front view"
                                 src="https://lh3.googleusercontent.com/aida-public/AB6AXuBRio0FQkbeEqbtjYHvzWv6aqEdi6p4UOcNY82p8vIqgJzasxvIyFe0n87VyhSO_qGrTE3Lpj9ItJY9Q9t_t-duTsDsGL40eL_VJoDAmurHpMrGmEOZ2__w5bciHhIXvIbo_O2tYdxnT6HLzZuiJ2zaEhtakbxp4nOpr1gZrrJSuw-CQ_x-glmw2aTD1JUJDZxVZ1J9lhZofJLF6D8VTdBeJdWvNNn82cZT1-lW-XVgUbUhZQrx3c9q1K45VeMaZTtsXT_13TJ8fA0x"
                            />
                        </div>

                        <div className="product-gallery__thumb bg-surface-container-low">
                            <img className="product-gallery__thumb-img"
                                 data-alt="Model wearing black urban streetwear jacket back view"
                                 src="https://lh3.googleusercontent.com/aida-public/AB6AXuAhRPV_vpdKW0I6qdhKprSu5ZcGySy0tiB1X_rxyPkWpWpaZqDGV2IfX94oWvUh7lRXNgVBKKpxR-O5HtGzAme4fBQmlN4j37Okb2OE_gzLpNTvsZaMjYTp4KTY6cDx4J_km6bsqMuotUBOhDMsI91D9UxMHJJJmVNqIrJaqdbOSHiMctQugaWRv7frj8-P6HEbSC0iUeqdmPeSdpQSiLlLxSwEY3gfUCB8PalVRvJbMs2eExwQxPL4rlXpdDHi4sgkNecKE3d0jDV9"
                            />
                        </div>

                        <div className="product-gallery__thumb bg-surface-container-low">
                            <img className="product-gallery__thumb-img"
                                 data-alt="Product detail of zippers and pocket architecture"
                                 src="https://lh3.googleusercontent.com/aida-public/AB6AXuAYG_ABP8aKDNrpLsHaiyb_zMdlnxV82BiCQcLuSCwfsUscCRuptCjnyoakz7hXGvAL5VMZpu8aOjwbG3toE87npmvHgy0zYU7qfVmRvlAap_5gtakRf8i6HK4zR8czZoQXWh0tfGCYytzWOfhL1psMU1Nv2OnWV5QR-KQmUHIxI7zsEp3pVNxVQdjMfw6mDB0pPnwxa2yjQ4B3NN6eKh9QzZlwTzqhXp2vsNNgbEfdIBVSdhLPCvRoKFrtOmPujnsKE-WCCwA1Fmaa"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div className="space-y-10">
                <header className="space-y-4">
                    <div className="product-info">
                        <h1 className="product-info__title font-headline">
                            V!ce-01 Tactical Bomber
                        </h1>

                        <span className="product-info__price font-headline">
                                $495.00
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
                            <button className="product-info__size-btn hover:bg-on-surface hover:text-white">
                                S
                            </button>
                            <button
                                className="product-info__size-btn hover:border-on-surface bg-primary text-white border-primary">
                                M
                            </button>
                            <button className="product-info__size-btn hover:bg-on-surface hover:text-white">
                                L
                            </button>
                            <button className="product-info__size-btn hover:bg-on-surface hover:text-white">
                                XL
                            </button>
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
                            The V!ce-01 Tactical Bomber is a masterclass in architectural
                            brutalism applied to functional streetwear. Constructed from
                            high-density Italian nylon with weather-resistant membrane.
                            Featuring modular pockets, reinforced seams, and our signature
                            Electric Blue inner lining. Designed for the urban dweller who
                            demands both aesthetic authority and technical performance.
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
