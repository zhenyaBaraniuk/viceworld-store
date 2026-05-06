import '../../../css/front/pages/catalog/catalog-hero.css';

export default function CatalogHero() {
    return (
        <div className="catalog-hero">
            <div className="catalog-hero__watermark">
                <h1 className="catalog-hero__watermark-title font-headline">
                    CATALOG
                </h1>
            </div>

            <div className="catalog-hero__content">
                <div>
                    <h2 className="catalog-hero__meta font-headline">
                        All Products
                    </h2>

                    <p className="catalog-hero__count font-headline text-primary">
                        124 items
                    </p>
                </div>

                <button className="catalog-hero__filter-btn md:hidden bg-on-surface text-white font-headline">
                     <span className="material-symbols-outlined text-sm">
                         tune
                     </span>

                    Filter & Sort
                </button>
            </div>
        </div>
    );
}
