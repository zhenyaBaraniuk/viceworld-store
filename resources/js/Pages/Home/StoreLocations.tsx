import '../../../css/front/pages/home/store-locations.css';

export default function StoreLocations() {
    return (
        <section className="store-locations">
            <div className="store-locations__info">
                <h2 className="store-locations__info-title">
                    V<span className="text-primary">!</span>ceWorld just arrived<span className="text-primary">.</span>
                </h2>

                <p className="store-locations__info-text text-neutral-600">
                    An architectural approach to streetwear. We don't design clothes; we
                    construct silhouettes that define the urban landscape. Precision in
                    every stitch. Power in every layer.
                </p>

                <div className="store-locations__philosophy bg-primary text-white">
                    <p className="store-locations__philosophy-label">
                        Core Philosophy
                    </p>

                    <p className="store-locations__philosophy-text">
                        Structure over Comfort.<br/>Impact over Trend.
                    </p>
                </div>
            </div>

            <div className="store-locations__stores">
                <h3 className="store-locations__stores-title text-neutral-400">
                    Global Hubs / Store Locations
                </h3>

                <div className="store-locations__card bg-surface-container-low group hover:bg-white">
                    <div>
                        <h4 className="store-locations__card-name">Kyiv</h4>
                        <p className="store-locations__card-address text-neutral-500">vul. Saksahanskoho, 2</p>
                    </div>
                    <div className="store-locations__card-meta">
                        <p className="store-locations__card-hours">10:00–21:00</p>
                        <a className="store-locations__card-link text-primary group-hover:underline" href="#">View on Map</a>
                    </div>
                </div>

                <div className="store-locations__card bg-surface-container-low group hover:bg-white">
                    <div>
                        <h4 className="store-locations__card-name">Berlin</h4>
                        <p className="store-locations__card-address text-neutral-500">Mitte, Torstraße 102</p>
                    </div>
                    <div className="store-locations__card-meta">
                        <p className="store-locations__card-hours">11:00–20:00</p>
                        <a className="store-locations__card-link text-primary group-hover:underline" href="#">View on Map</a>
                    </div>
                </div>

                <div className="store-locations__card bg-surface-container-low group hover:bg-white">
                    <div>
                        <h4 className="store-locations__card-name">Tokyo</h4>
                        <p className="store-locations__card-address text-neutral-500">Shibuya City, Jinnan 1-chome</p>
                    </div>
                    <div className="store-locations__card-meta">
                        <p className="store-locations__card-hours">11:00–22:00</p>
                        <a className="store-locations__card-link text-primary group-hover:underline" href="#">View on Map</a>
                    </div>
                </div>

                <div className="store-locations__card store-locations__card--inactive bg-surface-container-low group hover:bg-white hover:grayscale-0 hover:opacity-100">
                    <div>
                        <h4 className="store-locations__card-name text-neutral-400 group-hover:text-on-surface">Paris</h4>
                        <p className="store-locations__card-address text-neutral-500">Coming Spring 2025</p>
                    </div>
                    <div className="store-locations__card-meta">
                        <span className="material-symbols-outlined text-neutral-300" data-icon="lock">lock</span>
                    </div>
                </div>
            </div>
        </section>
    );
}