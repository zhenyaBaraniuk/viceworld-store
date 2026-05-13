import '../../../css/front/pages/searh/search-header.css';

export default function SearchHeader() {
    return (
        <section className="search-header">
            <div className="search-header__title group">
                <h1 className="text-6xl md:text-8xl font-headline font-black uppercase leading-tight">
                    JACKET
                </h1>

                <div className="search-header__arrow text-primary">
                    <span
                        className="material-symbols-outlined text-5xl"
                        data-icon="arrow_forward">
                        arrow_forward
                    </span>
                </div>
            </div>

            <div className="search-header__result border-outline-variant">
                <h2 className="search-header__result-title text-on-surface">
                    24 results for 'jacket'
                </h2>

                <div className="search-header__result-filters">
                    <button className="search-header__result-btn hover:text-primary transition-colors">
                        <span className="material-symbols-outlined text-lg" data-icon="tune">
                            tune
                        </span>
                        Filters
                    </button>

                    <div className="h-4 w-px bg-outline-variant"></div>

                    <button className="search-header__result-btn hover:text-primary transition-colors">
                        Sort: Relevant

                        <span className="material-symbols-outlined text-lg" data-icon="expand_more">
                            expand_more
                        </span>
                    </button>
                </div>
            </div>
        </section>
    );
}
