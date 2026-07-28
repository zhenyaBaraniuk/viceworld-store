import "../../../css/front/pages/checkout/summary.css";
import { useCartStore } from "@/store/useCartStore";

export default function Summary() {
    const items = useCartStore((state) => state.items);
    const totalPrice = useCartStore((state) => state.totalPrice);

    return (
        <div className="lg:col-span-4">
            <div className="summary bg-white">
                <h3 className="summary__title font-headline border-b-[6px] border-on-surface">
                    Order Summary
                </h3>

                <div className="summary__order space-y-10">
                    {items.map((item) => (
                        <div
                            key={item.product_slug}
                            className="summary__order-info"
                        >
                            <div className="summary__order-img bg-surface-container">
                                <img
                                    alt={item.image?.name}
                                    src={item.image?.url ?? undefined}
                                    className="w-full h-full object-cover mix-blend-multiply"
                                />
                            </div>

                            <div className="summary__product py-1">
                                <div>
                                    <h4 className="summary__product-title font-headline">
                                        {item.product_name}
                                    </h4>

                                    <p className="summary__product-size text-outline">
                                        {item.attribute_values
                                            .map(
                                                (attributeValue) =>
                                                    attributeValue.value,
                                            )
                                            .join(" / ")}
                                    </p>
                                </div>

                                <p className="summary__product-price font-headline">
                                    ₴{item.price}
                                </p>
                            </div>
                        </div>
                    ))}
                </div>

                <div className="summary__bill space-y-5 border-t border-surface-container-highest">
                    <div className="summary__bill-chapters font-headline">
                        <span className="text-outline">Subtotal</span>
                        <span>₴{totalPrice}</span>
                    </div>
                    <div className="summary__bill-chapters font-headline">
                        <span className="text-outline">Shipping</span>
                        <span className="text-primary-container">
                            Next Step
                        </span>
                    </div>
                </div>
            </div>
        </div>
    );
}
