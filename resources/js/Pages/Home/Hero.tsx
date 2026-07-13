import "../../../css/front/pages/home/hero.css";
import { HomeProps } from "@/types";
import { route } from "@/lib/route";
import { Link } from "@inertiajs/react";

type Props = Pick<HomeProps, "hero_product">;

export default function Hero({ hero_product }: Props) {
    return (
        <section className="hero bg-neutral-200">
            <img
                alt={hero_product.name}
                src={hero_product.main_image_url ?? undefined}
                className="absolute inset-0 w-full h-full object-cover grayscale brightness-75 object-center"
            />

            <div className="hero-content">
                <h1 className="hero__title text-white">
                    V<span className="text-primary">!</span>ceWorld
                </h1>
                <Link
                    href={route("search")}
                    className="hero__cta bg-primary text-white  hover:bg-black"
                >
                    Shop now
                </Link>
            </div>

            <div className="hero__label hidden lg:block">
                <span className="hero__label-text text-white">
                    Collection {new Date().getFullYear()} / Brutalism
                </span>
            </div>
        </section>
    );
}
