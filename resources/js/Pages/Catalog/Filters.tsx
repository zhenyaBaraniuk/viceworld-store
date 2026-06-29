import "@css/front/pages/catalog/filters.css";
import type { CatalogProps } from "@/types";
import { router } from "@inertiajs/react";
import * as Slider from "@radix-ui/react-slider";
import { useState } from "react";
import { route } from "@/lib/route";
import clsx from "clsx";

type Props = Pick<
    CatalogProps,
    "categories" | "filters" | "max_price" | "colors"
>;

const SIZES = ["XS", "S", "M", "L", "XL", "XXL"];

export default function Filters({
    categories,
    filters,
    colors,
    max_price,
}: Props) {
    const { parent_category_slug, ...queryFilters } = filters;
    const [priceValue, setPriceValue] = useState<number>(
        filters.price ?? max_price,
    );

    function handlePrice(value: number) {
        router.get(
            route("catalog.show", { slug: parent_category_slug }),
            {
                ...queryFilters,
                price: value || undefined,
            },
            {
                preserveState: true,
                replace: true,
                only: ["products", "filters"],
            },
        );
    }

    function handleFilter(key: string, value: string) {
        const current = queryFilters[key as keyof typeof queryFilters] as
            | string[]
            | undefined;

        const newArray = current?.includes(value)
            ? current.filter((v) => v !== value)
            : [...(current ?? []), value];

        const newFilters = Object.fromEntries(
            Object.entries({
                ...queryFilters,
                [key]: newArray.length ? newArray : undefined,
            }),
        );

        router.get(
            route("catalog.show", { slug: filters.parent_category_slug }),
            newFilters,
            {
                preserveState: true,
                replace: true,
                only: ["products", "filters"],
            },
        );
    }

    return (
        <aside className="filters hidden md:block">
            <div>
                <h3 className="filters__heading font-headline border-on-surface">
                    Category
                </h3>

                <ul className="filters__list">
                    {categories.map((category) => (
                        <li key={category.id}>
                            <label className="filters__label group">
                                <input
                                    type="checkbox"
                                    checked={
                                        filters.child_category_slug?.includes(
                                            category.slug,
                                        ) ?? false
                                    }
                                    onChange={() =>
                                        handleFilter(
                                            "child_category_slug",
                                            category.slug,
                                        )
                                    }
                                    className="filters__checkbox border-outline-variant focus:ring-0 checked:bg-primary"
                                />

                                <span className="filters__label-text font-body group-hover:text-primary">
                                    {category.name}
                                </span>
                            </label>
                        </li>
                    ))}
                </ul>
            </div>

            <div>
                <h3 className="filters__heading font-headline border-on-surface">
                    Size
                </h3>

                <div className="filters__size-grid">
                    {SIZES.map((size) => (
                        <button
                            key={size}
                            onClick={() => handleFilter("size", size)}
                            className={clsx("filters__size-btn font-headline", {
                                "border-primary bg-primary text-white":
                                    filters.size?.includes(size),
                                "border-outline-variant hover:border-primary":
                                    !filters.size?.includes(size),
                            })}
                        >
                            {size}
                        </button>
                    ))}
                </div>
            </div>

            <div>
                <h3 className="filters__heading font-headline border-on-surface">
                    Color
                </h3>

                <div className="filters__colors">
                    {colors.map((color) => (
                        <button
                            key={color.value}
                            data-tooltip={color.value}
                            onClick={() => handleFilter("color", color.value)}
                            style={{ backgroundColor: color.hex }}
                            className={clsx("filters__color-swatch", {
                                "outline-[3px] outline-offset-[3px]":
                                    filters.color?.includes(color.value),
                            })}
                        />
                    ))}
                </div>
            </div>

            <div>
                <h3 className="filters__heading font-headline border-on-surface">
                    Price Range
                </h3>

                <Slider.Root
                    className="relative flex items-center w-full h-5"
                    min={0}
                    max={max_price}
                    value={[priceValue]}
                    onValueChange={(values: number[]) =>
                        setPriceValue(values[0])
                    }
                    onValueCommit={(values: number[]) => handlePrice(values[0])}
                >
                    <Slider.Track className="filters__price-track bg-surface-container-high">
                        <Slider.Range className="filters__price-fill bg-primary" />
                    </Slider.Track>
                    <Slider.Thumb className="filters__price-handle bg-on-surface outline-none cursor-pointer" />
                </Slider.Root>

                <div className="filters__price-labels font-headline">
                    <span>$0</span>
                    <span>${priceValue}</span>
                </div>
            </div>
        </aside>
    );
}
