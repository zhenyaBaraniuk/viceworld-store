import "../../../css/front/pages/product/product.css";
import { ProductProps } from "@/types/pages/product";
import ProductGallery from "@/Pages/Product/ProductGallery";
import RichText from "@/Components/RichText";
import { useCartStore } from "@/store/useCartStore";
import { useState } from "react";
import clsx from "clsx";
import { useTranslation } from "@/hooks/useTranslation";

type Props = Pick<ProductProps, "product">;

export default function Product({ product }: Props) {
    const { t } = useTranslation();
    const [selectedSize, setSelectedSize] = useState<string | null>(null);
    const [showSizeError, setShowSizeError] = useState(false);
    const addItem = useCartStore((state) => state.addItem);

    const selectedVariant = product.product_variants.find((variant) =>
        variant.attribute_values.some(
            (attr) => attr.name === "Size" && attr.value === selectedSize,
        ),
    );

    const handleAddToCart = () => {
        if (!selectedVariant) {
            setShowSizeError(true);
            return;
        }

        setShowSizeError(false);

        addItem(selectedVariant.id, 1).catch((error) => {
            console.error("Failed to add item", error);
        });
    };

    const productSize = product.product_variants
        .flatMap((variant) => variant.attribute_values)
        .filter((attribute) => attribute.name === "Size")
        .filter(
            (attribute, i, arr) =>
                arr.findIndex((x) => x.value === attribute.value) === i,
        );

    return (
        <div className="product">
            <div>
                <div className="lg:sticky lg:top-24 space-y-4">
                    <ProductGallery
                        name={product.name}
                        video={product.video}
                        images={product.images}
                        main_image={product.main_image}
                    />
                </div>
            </div>

            <div className="space-y-10">
                <header className="space-y-4">
                    <div className="product-info">
                        <h1 className="product-info__title font-headline">
                            {product.name}
                        </h1>

                        <span className="product-info__price font-headline">
                            ${product.price}
                        </span>
                    </div>

                    <p className="product-info__meta text-primary">
                        {t("product.meta_tag")}
                    </p>
                </header>

                <div className="space-y-6">
                    <div className="space-y-4">
                        <div className="flex justify-between items-end">
                            <span className="text-xs font-bold uppercase tracking-widest text-neutral-500">
                                {t("product.select_size")}
                            </span>

                            <span className="text-xs font-bold uppercase tracking-widest text-neutral-400">
                                {t("product.size_guide")}
                            </span>
                        </div>

                        <div className="product-info__sizes">
                            {productSize.map((size) => (
                                <button
                                    key={size.value}
                                    onClick={() => {
                                        setSelectedSize((prev) =>
                                            prev === size.value
                                                ? null
                                                : size.value,
                                        );
                                        setShowSizeError(false);
                                    }}
                                    className={clsx(
                                        "product-info__size-btn hover:bg-on-surface hover:text-white",
                                        selectedSize === size.value &&
                                            "bg-primary text-white border-primary",
                                    )}
                                >
                                    {size.value}
                                </button>
                            ))}
                        </div>
                        {showSizeError && (
                            <p className="text-xs text-error font-bold uppercase tracking-widest">
                                {t("product.size_error")}
                            </p>
                        )}
                    </div>

                    <button className="product-info__ai-btn text-primary hover:underline group">
                        <span>{t("product.ai_size_advisor")}</span>

                        <span
                            className="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform"
                            data-icon="trending_flat"
                        >
                            trending_flat
                        </span>
                    </button>
                </div>

                <div className="space-y-4">
                    <button
                        className="product-info__btn text-white active:scale-[0.98] hover:bg-primary"
                        onClick={handleAddToCart}
                    >
                        {t("product.add_to_cart")}
                    </button>
                </div>

                <div className="product-info__details border-neutral-200">
                    <div className="space-y-4">
                        <h3 className="text-sm font-black">
                            {t("product.description_heading")}
                        </h3>
                        <div className="text-neutral-600 leading-relaxed font-body">
                            <RichText content={product.description} />
                        </div>
                    </div>

                    <div className="product-info__features bg-surface-container-low">
                        <div className="space-y-2">
                            <span
                                className="material-symbols-outlined text-primary"
                                data-icon="bolt"
                            >
                                bolt
                            </span>

                            <p className="text-[10px] font-black uppercase">
                                {t("product.feature_rapid_deployment")}
                            </p>
                            <p>{t("product.feature_rapid_deployment_desc")}</p>
                        </div>

                        <div className="space-y-2">
                            <span
                                className="material-symbols-outlined text-primary"
                                data-icon="shield"
                            >
                                shield
                            </span>

                            <p className="text-[10px] font-black uppercase">
                                {t("product.feature_urban_armor")}
                            </p>
                            <p className="text-[10px] text-neutral-500">
                                {t("product.feature_urban_armor_desc")}
                            </p>
                        </div>
                    </div>

                    <div className="space-y-4">
                        <details className="group border-b border-neutral-200 pb-4">
                            <summary className="product-info__accordion-summary">
                                {t("product.shipping_returns_heading")}
                                <span
                                    className="material-symbols-outlined group-open:rotate-180 transition-transform"
                                    data-icon="expand_more"
                                >
                                    expand_more
                                </span>
                            </summary>

                            <div className="pt-4 text-xs text-neutral-500 font-body">
                                {t("product.shipping_returns_text")}
                            </div>
                        </details>

                        <details className="group border-b border-neutral-200 pb-4">
                            <summary className="product-info__accordion-summary">
                                {t("product.fabric_details_heading")}
                                <span
                                    className="material-symbols-outlined group-open:rotate-180 transition-transform"
                                    data-icon="expand_more"
                                >
                                    expand_more
                                </span>
                            </summary>

                            <div className="pt-4 text-xs text-neutral-500 font-body">
                                {t("product.fabric_details_text")}
                            </div>
                        </details>
                    </div>
                </div>
            </div>
        </div>
    );
}
