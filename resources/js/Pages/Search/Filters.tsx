import "../../../css/front/pages/search/filters.css";

export default function Filters() {
    return (
        <aside className="filters">
            <div className="space-y-12">
                <div>
                    <h3 className="filters__title text-outline">Category</h3>

                    <ul className="space-y-4">
                        <li>
                            <label className="filters__category-label group">
                                <input
                                    type="checkbox"
                                    className="filters__category-checkbox border-on-surface rounded-none checked:bg-primary focus:ring-0"
                                />

                                <span className="filters__category-title group-hover:text-primary">
                                    Outerwear
                                </span>
                            </label>
                        </li>

                        <li>
                            <label className="filters__category-label group">
                                <input
                                    type="checkbox"
                                    className="filters__category-checkbox border-on-surface rounded-none checked:bg-primary focus:ring-0"
                                />

                                <span className="filters__category-title group-hover:text-primary">
                                    Jackets
                                </span>
                            </label>
                        </li>

                        <li>
                            <label className="filters__category-label group">
                                <input
                                    type="checkbox"
                                    className="filters__category-checkbox border-on-surface rounded-none checked:bg-primary focus:ring-0"
                                />

                                <span className="filters__category-title group-hover:text-primary">
                                    Hoodies
                                </span>
                            </label>
                        </li>

                        <li>
                            <label className="filters__category-label group">
                                <input
                                    type="checkbox"
                                    className="filters__category-checkbox border-on-surface rounded-none checked:bg-primary focus:ring-0"
                                />

                                <span className="filters__category-title group-hover:text-primary">
                                    Accessories
                                </span>
                            </label>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 className="filters__title text-outline">Size</h3>

                    <div className="grid grid-cols-3 gap-2">
                        <button className="filters__size-btn border border-outline-variant hover:border-on-surface transition-all">
                            XS
                        </button>

                        <button className="filters__size-btn bg-on-surface text-white">
                            S
                        </button>

                        <button className="filters__size-btn border border-outline-variant hover:border-on-surface transition-all">
                            M
                        </button>

                        <button className="filters__size-btn border border-outline-variant hover:border-on-surface transition-all">
                            L
                        </button>

                        <button className="filters__size-btn border border-outline-variant hover:border-on-surface transition-all">
                            XL
                        </button>

                        <button className="filters__size-btn border border-outline-variant hover:border-on-surface transition-all">
                            XXL
                        </button>
                    </div>
                </div>

                <div>
                    <h3 className="filters__title text-outline">Price Range</h3>

                    <div className="space-y-4">
                        <input
                            className="filters__price-range accent-primary bg-outline-variant"
                            max="1200"
                            min="50"
                            type="range"
                            value="495"
                        />

                        <div className="filters__price-select">
                            <span>$50</span>
                            <span>$1,200</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 className="filters__title text-outline">Color</h3>

                    <div className="filters__colors">
                        <button className="w-5 h-5 bg-black border border-outline-variant ring-1 ring-offset-2 ring-on-surface"></button>
                        <button className="w-5 h-5 bg-white border border-outline-variant"></button>
                        <button className="w-5 h-5 bg-primary border border-outline-variant"></button>
                        <button className="w-5 h-5 bg-neutral-400 border border-outline-variant"></button>
                        <button className="w-5 h-5 bg-red-600 border border-outline-variant"></button>
                    </div>
                </div>
            </div>
        </aside>
    );
}
