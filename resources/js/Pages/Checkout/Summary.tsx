import "../../../css/front/pages/checkout/summary.css";
import { useCartStore } from "@/store/useCartStore";
import { useTranslation } from "@/hooks/useTranslation";
import { useRoute } from "@/lib/route";
import { Link } from "@inertiajs/react";
import { Minus, Plus, X } from "lucide-react";
import { useState } from "react";

export default function Summary() {
    const route = useRoute();
    const { t } = useTranslation();
    const items = useCartStore((state) => state.items);
    const totalPrice = useCartStore((state) => state.totalPrice);
    const updateQuantity = useCartStore((state) => state.updateQuantity);
    const removeItem = useCartStore((state) => state.removeItem);
    const [pendingId, setPendingId] = useState<string | null>(null);

    const runForItem = (itemId: string, action: () => Promise<void>) => {
        setPendingId(itemId);

        action()
            .catch((error) => {
                console.error("Failed to update cart", error);
            })
            .finally(() => setPendingId(null));
    };

    return (
        <div className="lg:col-span-4">
            <div className="summary bg-white">
                <h3 className="summary__title font-headline border-b-[6px] border-on-surface">
                    {t("checkout.order_summary")}
                </h3>

                <div className="summary__order space-y-10">
                    {items.map((item) => (
                        <div key={item.id} className="summary__order-info">
                            <Link
                                href={route("product.show", {
                                    slug: item.product_slug,
                                })}
                                className="summary__order-img bg-surface-container"
                            >
                                <img
                                    alt={item.image?.name}
                                    src={item.image?.url ?? undefined}
                                    className="w-full h-full object-cover mix-blend-multiply"
                                />
                            </Link>

                            <div className="summary__product py-1">
                                <div>
                                    <h4 className="summary__product-title font-headline">
                                        <Link
                                            href={route("product.show", {
                                                slug: item.product_slug,
                                            })}
                                            className="summary__product-link"
                                        >
                                            {item.product_name}
                                        </Link>
                                    </h4>

                                    <p className="summary__product-size text-outline">
                                        {item.attribute_values
                                            .map(
                                                (attributeValue) =>
                                                    attributeValue.value,
                                            )
                                            .join(" / ")}
                                    </p>

                                    <div className="summary__qty">
                                        <button
                                            type="button"
                                            className="summary__qty-btn"
                                            disabled={
                                                pendingId === item.id ||
                                                item.quantity <= 1
                                            }
                                            aria-label={t(
                                                "checkout.decrease_qty",
                                            )}
                                            onClick={() =>
                                                runForItem(item.id, () =>
                                                    updateQuantity(
                                                        item.id,
                                                        item.quantity - 1,
                                                    ),
                                                )
                                            }
                                        >
                                            <Minus size={14} />
                                        </button>
                                        <span className="summary__qty-value font-headline">
                                            {item.quantity}
                                        </span>
                                        <button
                                            type="button"
                                            className="summary__qty-btn"
                                            disabled={pendingId === item.id}
                                            aria-label={t(
                                                "checkout.increase_qty",
                                            )}
                                            onClick={() =>
                                                runForItem(item.id, () =>
                                                    updateQuantity(
                                                        item.id,
                                                        item.quantity + 1,
                                                    ),
                                                )
                                            }
                                        >
                                            <Plus size={14} />
                                        </button>
                                        <button
                                            type="button"
                                            className="summary__qty-btn summary__qty-remove"
                                            disabled={pendingId === item.id}
                                            aria-label={t(
                                                "checkout.remove_item",
                                            )}
                                            onClick={() =>
                                                runForItem(item.id, () =>
                                                    removeItem(item.id),
                                                )
                                            }
                                        >
                                            <X size={14} />
                                        </button>
                                    </div>
                                </div>

                                <p className="summary__product-price font-headline">
                                    ₴
                                    {(
                                        Number(item.price) * item.quantity
                                    ).toFixed(2)}
                                </p>
                            </div>
                        </div>
                    ))}
                </div>

                <div className="summary__bill space-y-5 border-t border-surface-container-highest">
                    <div className="summary__bill-chapters font-headline">
                        <span className="text-outline">
                            {t("checkout.subtotal")}
                        </span>
                        <span>₴{totalPrice}</span>
                    </div>
                    <div className="summary__bill-chapters font-headline">
                        <span className="text-outline">
                            {t("checkout.shipping_label")}
                        </span>
                        <span className="text-primary-container">
                            {t("checkout.shipping_next_step")}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    );
}
