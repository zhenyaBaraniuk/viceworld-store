import "../../css/front/components/product-filters.css";
import { useState } from "react";
import clsx from "clsx";
import type { ProductFiltersProps as Props } from "@/types";
import * as Slider from "@radix-ui/react-slider";

const SIZES = ["XS", "S", "M", "L", "XL", "XXL"];

export default function ProductFilters({
    categories,
    colors,
    max_price,
    filters,
    categoryKey,
    onNavigate,
}: Props) {
    const [priceValue, setPriceValue] = useState<number>(
        filters.price ?? max_price,
    );

    function handlePrice(value: number) {
        onNavigate({ ...filters, price: value || undefined });
    }

    function handleFilter(key: string, value: string) {
        const current = filters[key] as string[] | undefined;

        const newArray = current?.includes(value)
            ? current.filter((v) => v !== value)
            : [...(current ?? []), value];

        onNavigate({
            ...filters,
            [key]: newArray.length ? newArray : undefined,
        });
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
                                    checked={(
                                        filters[categoryKey] as
                                            | string[]
                                            | undefined
                                    )?.includes(category.slug)}
                                    onChange={() =>
                                        handleFilter(categoryKey, category.slug)
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
                                "border-primary bg-primary text-white": (
                                    filters.size as string[] | undefined
                                )?.includes(size),
                                "border-outline-variant hover:border-primary":
                                    !(
                                        filters.size as string[] | undefined
                                    )?.includes(size),
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
                                "outline-[3px] outline-offset-[3px]": (
                                    filters.color as string[] | undefined
                                )?.includes(color.value),
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
