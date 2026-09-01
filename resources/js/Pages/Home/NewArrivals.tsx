import "../../../css/front/pages/home/new-arrivals.css";
import { HomeProps } from "@/types";
import { route } from "@/lib/route";
import { Link } from "@inertiajs/react";
import { useTranslation } from "@/hooks/useTranslation";

type Props = Pick<HomeProps, "new_arrivals">;

export default function NewArrivals({ new_arrivals }: Props) {
    const { t } = useTranslation();

    return (
        <section className="new-arrivals">
            <div className="new-arrivals__header">
                <h2 className="new-arrivals__title">
                    {t("home.new_arrivals_title")}
                </h2>
                <Link href={route("search")} className="new-arrivals__link">
                    {t("home.new_arrivals_view_all")}
                </Link>
            </div>

            <div className="new-arrivals__grid">
                {new_arrivals.map((new_arrival) => (
                    <Link
                        key={new_arrival.slug}
                        href={route("product.show", { slug: new_arrival.slug })}
                        className="new-arrivals__card"
                    >
                        <div className="new-arrivals__card-image">
                            <img
                                alt={new_arrival.name}
                                className="new-arrivals__card-img"
                                src={new_arrival.main_image_url ?? undefined}
                            />
                            <div className="new-arrivals__badge">
                                {t("home.new_arrivals_badge")}
                            </div>
                        </div>

                        <div className="new-arrivals__card-info">
                            <div>
                                <h3 className="new-arrivals__card-name">
                                    {new_arrival.name}
                                </h3>
                                <p className="new-arrivals__card-category">
                                    {new_arrival.category_name}
                                </p>
                            </div>
                            <span className="new-arrivals__card-price">
                                {new_arrival.price}
                            </span>
                        </div>
                    </Link>
                ))}
            </div>
        </section>
    );
}
