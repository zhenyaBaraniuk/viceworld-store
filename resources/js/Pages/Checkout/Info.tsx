import "../../../css/front/pages/checkout/info.css";
import FormField from "@/UI/FormField";
import { useForm } from "@inertiajs/react";
import { route } from "@/lib/route";
import clsx from "clsx";
import type { CheckoutProps } from "@/types";

const PAYMENT_ICONS: Record<string, string> = {
    liqpay: "/images/payment/liqpay.png",
    mono: "/images/payment/mono.png",
};

export default function Info({ payment_methods }: CheckoutProps) {
    const { data, post, setData, errors, processing } = useForm({
        email: "",
        phone: "",
        delivery_method: "courier",
        city: "",
        street: "",
        payment_method: "monobank",
    });

    const handleSubmit = () => {
        post(route("checkout.store"));
    };

    return (
        <div className="info space-y-24">
            <section>
                <h2 className="info__title font-headline">
                    1. Contact Information
                </h2>

                <div className="info__contacts">
                    <FormField
                        label="Email Address"
                        type="email"
                        placeholder="name.lastname@vice-world.com"
                        value={data.email}
                        onChange={(value) => setData("email", value)}
                        error={errors.email}
                    />

                    <FormField
                        label="Phone number"
                        type="tel"
                        placeholder="+380 •• ••• •• ••"
                        value={data.phone}
                        onChange={(value) => setData("phone", value)}
                        error={errors.phone}
                    />
                </div>
            </section>

            <section>
                <h2 className="info__title font-headline">
                    2. Delivery Method
                </h2>

                <div className="info__delivery">
                    <div
                        onClick={() => setData("delivery_method", "courier")}
                        className={clsx(
                            "info__delivery-form bg-white cursor-pointer transition-colors",
                            data.delivery_method === "courier"
                                ? "border-2 border-primary-container"
                                : "border-2 border-transparent hover:border-surface-container-highest",
                        )}
                    >
                        <div>
                            <div className="flex justify-between items-start mb-2">
                                <span className="font-headline font-bold uppercase tracking-tight text-lg">
                                    Courier Delivery
                                </span>

                                <span
                                    className={clsx(
                                        "material-symbols-outlined",
                                        data.delivery_method === "courier"
                                            ? "text-primary-container"
                                            : "text-outline",
                                    )}
                                    style={
                                        data.delivery_method === "courier"
                                            ? {
                                                  fontVariationSettings:
                                                      "'FILL' 1",
                                              }
                                            : undefined
                                    }
                                >
                                    {data.delivery_method === "courier"
                                        ? "check_circle"
                                        : "radio_button_unchecked"}
                                </span>
                            </div>

                            <div className="text-right">
                                <p className="info__delivery-price font-headline">
                                    ₴85.00
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        onClick={() => setData("delivery_method", "pickup")}
                        className={clsx(
                            "info__delivery-form bg-white cursor-pointer transition-colors",
                            data.delivery_method === "pickup"
                                ? "border-2 border-primary-container"
                                : "border-2 border-transparent hover:border-surface-container-highest",
                        )}
                    >
                        <div>
                            <div className="flex justify-between items-start mb-2">
                                <span className="font-headline font-bold uppercase tracking-tight text-lg">
                                    Pickup in Store
                                </span>

                                <span
                                    className={clsx(
                                        "material-symbols-outlined",
                                        data.delivery_method === "pickup"
                                            ? "text-primary-container"
                                            : "text-outline",
                                    )}
                                    style={
                                        data.delivery_method === "pickup"
                                            ? {
                                                  fontVariationSettings:
                                                      "'FILL' 1",
                                              }
                                            : undefined
                                    }
                                >
                                    {data.delivery_method === "pickup"
                                        ? "check_circle"
                                        : "radio_button_unchecked"}
                                </span>
                            </div>

                            <p className="text-xs uppercase text-outline font-bold tracking-wider">
                                Kyiv Flagship, Baseina 12
                            </p>
                        </div>
                    </div>
                </div>

                {data.delivery_method === "courier" && (
                    <div className="info__shipping mt-6">
                        <FormField
                            label="City"
                            placeholder="Kyiv"
                            value={data.city}
                            onChange={(value) => setData("city", value)}
                            error={errors.city}
                        />

                        <FormField
                            label="Street address"
                            placeholder="Khreshchatyk St, 22, Apt 4"
                            value={data.street}
                            onChange={(value) => setData("street", value)}
                            error={errors.street}
                        />
                    </div>
                )}
            </section>

            <section>
                <h2 className="info__title font-headline">3. Payment</h2>

                <div className="info__payment">
                    {payment_methods.map((method) => (
                        <div
                            key={method.value}
                            onClick={() =>
                                setData("payment_method", method.value)
                            }
                            className={clsx(
                                "info__payment-form bg-white group cursor-pointer transition-colors",
                                data.payment_method === method.value
                                    ? "border-2 border-primary-container"
                                    : "border-2 border-transparent hover:border-surface-container-highest",
                            )}
                        >
                            <div className="flex items-center gap-6">
                                <img
                                    src={PAYMENT_ICONS[method.value]}
                                    alt={method.name}
                                    className="info__payment-title"
                                />
                            </div>

                            <span
                                className={clsx(
                                    "material-symbols-outlined transition-colors",
                                    data.payment_method === method.value
                                        ? "text-primary-container"
                                        : "text-outline group-hover:text-primary-container",
                                )}
                                style={
                                    data.payment_method === method.value
                                        ? { fontVariationSettings: "'FILL' 1" }
                                        : undefined
                                }
                            >
                                {data.payment_method === method.value
                                    ? "check_circle"
                                    : "radio_button_unchecked"}
                            </span>
                        </div>
                    ))}
                </div>
            </section>

            <div className="info__btn">
                <button
                    onClick={handleSubmit}
                    disabled={processing}
                    className="info__btn-title bg-on-surface text-white font-headline hover:bg-primary-container transition-colors duration-300"
                >
                    Place order
                </button>
            </div>
        </div>
    );
}
