import "../../../css/front/pages/home/store-locations.css";
import { useTranslation } from "@/hooks/useTranslation";

export default function StoreLocations() {
    const { t } = useTranslation();

    return (
        <section className="store-locations">
            <div className="store-locations__info">
                <h2 className="store-locations__info-title">
                    V<span className="text-primary">!</span>ceWorld{" "}
                    {t("store_locations.title_text")}
                    <span className="text-primary">.</span>
                </h2>

                <p className="store-locations__info-text text-neutral-600">
                    {t("store_locations.description")}
                </p>

                <div className="store-locations__philosophy bg-primary text-white">
                    <p className="store-locations__philosophy-label">
                        {t("store_locations.philosophy_label")}
                    </p>

                    <p className="store-locations__philosophy-text">
                        {t("store_locations.philosophy_line1")}
                        <br />
                        {t("store_locations.philosophy_line2")}
                    </p>
                </div>
            </div>

            <div className="store-locations__stores">
                <h3 className="store-locations__stores-title text-neutral-400">
                    {t("store_locations.stores_title")}
                </h3>

                <div className="store-locations__card bg-surface-container-low group hover:bg-white">
                    <div>
                        <h4 className="store-locations__card-name">
                            {t("store_locations.kyiv_name")}
                        </h4>
                        <p className="store-locations__card-address text-neutral-500">
                            {t("store_locations.kyiv_address")}
                        </p>
                    </div>
                    <div className="store-locations__card-meta">
                        <p className="store-locations__card-hours">
                            {t("store_locations.kyiv_hours")}
                        </p>
                        <a
                            className="store-locations__card-link text-primary group-hover:underline"
                            href="#"
                        >
                            {t("store_locations.view_on_map")}
                        </a>
                    </div>
                </div>

                <div className="store-locations__card bg-surface-container-low group hover:bg-white">
                    <div>
                        <h4 className="store-locations__card-name">
                            {t("store_locations.berlin_name")}
                        </h4>
                        <p className="store-locations__card-address text-neutral-500">
                            {t("store_locations.berlin_address")}
                        </p>
                    </div>
                    <div className="store-locations__card-meta">
                        <p className="store-locations__card-hours">
                            {t("store_locations.berlin_hours")}
                        </p>
                        <a
                            className="store-locations__card-link text-primary group-hover:underline"
                            href="#"
                        >
                            {t("store_locations.view_on_map")}
                        </a>
                    </div>
                </div>

                <div className="store-locations__card bg-surface-container-low group hover:bg-white">
                    <div>
                        <h4 className="store-locations__card-name">
                            {t("store_locations.tokyo_name")}
                        </h4>
                        <p className="store-locations__card-address text-neutral-500">
                            {t("store_locations.tokyo_address")}
                        </p>
                    </div>
                    <div className="store-locations__card-meta">
                        <p className="store-locations__card-hours">
                            {t("store_locations.tokyo_hours")}
                        </p>
                        <a
                            className="store-locations__card-link text-primary group-hover:underline"
                            href="#"
                        >
                            {t("store_locations.view_on_map")}
                        </a>
                    </div>
                </div>

                <div className="store-locations__card store-locations__card--inactive bg-surface-container-low group hover:bg-white hover:grayscale-0 hover:opacity-100">
                    <div>
                        <h4 className="store-locations__card-name text-neutral-400 group-hover:text-on-surface">
                            {t("store_locations.paris_name")}
                        </h4>
                        <p className="store-locations__card-address text-neutral-500">
                            {t("store_locations.paris_status")}
                        </p>
                    </div>
                    <div className="store-locations__card-meta">
                        <span
                            className="material-symbols-outlined text-neutral-300"
                            data-icon="lock"
                        >
                            lock
                        </span>
                    </div>
                </div>
            </div>
        </section>
    );
}
