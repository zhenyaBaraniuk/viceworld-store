import '../../../css/front/pages/catalog/filters.css';

export default function Filters() {
    return (
        <aside className="filters hidden md:block">
            <div>
                <h3 className="filters__heading font-headline border-on-surface">
                    Category
                </h3>

                <ul className="filters__list">
                    <li>
                        <label className="filters__label group">
                            <input
                                className="filters__checkbox border-outline-variant focus:ring-0 checked:bg-primary"
                                type="checkbox"/>

                            <span className="filters__label-text font-body group-hover:text-primary">
                                Outerwear
                            </span>
                        </label>
                    </li>

                    <li>
                        <label className="filters__label group">
                            <input
                                className="filters__checkbox border-outline-variant focus:ring-0 checked:bg-primary"
                                type="checkbox"/>

                            <span className="filters__label-text font-body group-hover:text-primary">
                                Tees &amp; Tops
                            </span>
                        </label>
                    </li>

                    <li>
                        <label className="filters__label group">
                            <input
                                className="filters__checkbox border-outline-variant focus:ring-0 checked:bg-primary"
                                type="checkbox"/>

                            <span className="filters__label-text font-body group-hover:text-primary">
                                Bottoms
                            </span>
                        </label>
                    </li>

                    <li>
                        <label className="filters__label group">
                            <input
                                className="filters__checkbox border-outline-variant focus:ring-0 checked:bg-primary"
                                type="checkbox"/>

                            <span className="filters__label-text font-body group-hover:text-primary">
                                Accessories
                            </span>
                        </label>
                    </li>
                </ul>
            </div>

            <div>
                <h3 className="filters__heading font-headline border-on-surface">
                    Size
                </h3>

                <div className="filters__size-grid">
                    <button
                        className="filters__size-btn border-outline-variant hover:border-primary font-headline">
                        XS
                    </button>

                    <button
                        className="filters__size-btn border-primary bg-primary text-white font-headline">
                        S
                    </button>

                    <button
                        className="filters__size-btn border-outline-variant hover:border-primary font-headline">
                        M
                    </button>

                    <button
                        className="filters__size-btn border-outline-variant hover:border-primary font-headline">
                        L
                    </button>

                    <button
                        className="filters__size-btn border-outline-variant hover:border-primary font-headline">
                        XL
                    </button>

                    <button
                        className="filters__size-btn border-outline-variant hover:border-primary font-headline">
                        XXL
                    </button>
                </div>
            </div>

            <div>
                <h3 className="filters__heading font-headline border-on-surface">
                    Color
                </h3>

                <div className="filters__colors">
                    <button
                        className="filters__color-swatch bg-black border-outline-variant outline outline-offset-2 outline-primary"></button>
                    <button className="filters__color-swatch bg-white border-outline-variant"></button>
                    <button className="filters__color-swatch bg-primary border-outline-variant"></button>
                    <button className="filters__color-swatch bg-neutral-400 border-outline-variant"></button>
                    <button className="filters__color-swatch bg-red-600 border-outline-variant"></button>
                </div>
            </div>

            <div>
                <h3 className="filters__heading font-headline border-on-surface">
                    Price Range
                </h3>

                <div className="space-y-4">
                    <div className="filters__price-track bg-surface-container-high">
                        <div className="filters__price-fill bg-primary"></div>
                        <div className="filters__price-handle left-0 bg-on-surface"></div>
                        <div className="filters__price-handle right-1/4 bg-on-surface"></div>
                    </div>

                    <div className="filters__price-labels font-headline">
                        <span>$0</span>
                        <span>$250</span>
                    </div>
                </div>
            </div>
        </aside>
    );
}
