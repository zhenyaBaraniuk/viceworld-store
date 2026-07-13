import "../../../css/front/pages/home/category-tiles.css";

import { HomeProps } from "@/types";
import { route } from "@/lib/route";
import { Link } from "@inertiajs/react";

type Props = Pick<HomeProps, "category_tiles">;

export default function CategoryTiles({ category_tiles }: Props) {
    return (
        <section className="category-tiles bg-neutral-900">
            <div className="category-tiles__grid">
                {category_tiles.map((category_tile, index) => (
                    <Link
                        key={category_tile.slug}
                        href={route("catalog.show", {
                            slug: category_tile.slug,
                        })}
                        className="category-tiles__item group border-neutral-800"
                    >
                        <img
                            alt={category_tile.name}
                            className="category-tiles__item-img group-hover:opacity-100 transition-opacity duration-500"
                            src={category_tile.image_url}
                        />

                        <div className="category-tiles__item-overlay">
                            <h2 className="category-tiles__item-title text-white group-hover:translate-y-0 transition-transform duration-500 group-hover:opacity-100">
                                {category_tile.name}
                            </h2>
                        </div>

                        <div className="category-tiles__label">
                            <span className="category-tiles__label-text text-white  font-bold">
                                Volume 0{index + 1}
                            </span>
                        </div>
                    </Link>
                ))}
            </div>
        </section>
    );
}
