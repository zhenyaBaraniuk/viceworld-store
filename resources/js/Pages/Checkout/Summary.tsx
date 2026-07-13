import "../../../css/front/pages/checkout/summary.css";

export default function Summary() {
    return (
        <div className="lg:col-span-4">
            <div className="summary bg-white">
                <h3 className="summary__title font-headline border-b-[6px] border-on-surface">
                    Order Summary
                </h3>

                <div className="summary__order space-y-10">
                    <div className="summary__order-info">
                        <div className="summary__order-img bg-surface-container">
                            <img
                                alt="Product"
                                className="w-full h-full object-cover mix-blend-multiply"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDHdqw6TvVY2GaDKDKJVRRmddkinEHTLR503dtxiIcJ9gKwXyt1rbx7jKfXMYOS4VxmOcuKoxggO5eW9tnA5bg0Ze2z2GFapEXp_s9bQmcVptCcw_ZFRQnX5dmbpee4Mm5Q-AugvGD9ACf55Czgt_fvd83kly2H0Tjz_RaYw_maMgwMWKdvumsHVW35Fvv1X_G0NL83orJ48WqdnERqcyc8zGTyd8jMtCrI3x6xqilMJSmWFdbdmMH_OfXuncdLGfnHN5drR674qEmC"
                            />
                        </div>

                        <div className="summary__product py-1">
                            <div>
                                <h4 className="summary__product-title font-headline">
                                    V!CE OVERSIZED HOODIE "NEON-01"
                                </h4>

                                <p className="summary__product-size text-outline">
                                    Size: XL / Stealth Black
                                </p>
                            </div>

                            <p className="summary__product-price font-headline">
                                ₴4,500.00
                            </p>
                        </div>
                    </div>

                    <div className="summary__order-info">
                        <div className="summary__order-img bg-surface-container">
                            <img
                                alt="Product"
                                className="w-full h-full object-cover mix-blend-multiply"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuArcr52GVSV73CIqaDloNifCAtSbZHGi0IQnIEuy7YFPUgZWYaM3deqARzG4SH3SIlJja4WPIDCXc1I5W8srp0qCPyRXkYk2zsF2twnGeBxU-PSYFFqpDeOcFV1yuBzIOPca34FVB7-QFhwomAoGOkoZ7QUMhNp-bKVn0ZMeJN32EcsVbXT7xf-oRzJuHZWHvkehbnQr6OVzEVNksvsxLpr59n-rkxAXgkB49zHddI7Iq-qq1ZK5DyB5a5Nd1KOvBtXS4Ut6XTGRPez"
                            />
                        </div>

                        <div className="summary__product py-1">
                            <div>
                                <h4 className="summary__product-title font-headline">
                                    ARCHITECTURAL CARGO PANTS
                                </h4>

                                <p className="summary__product-size text-outline">
                                    Size: 34 / Concrete Grey
                                </p>
                            </div>

                            <p className="summary__product-price font-headline">
                                ₴3,200.00
                            </p>
                        </div>
                    </div>
                </div>

                <div className="summary__bill space-y-5 border-t border-surface-container-highest">
                    <div className="summary__bill-chapters font-headline">
                        <span className="text-outline">Subtotal</span>
                        <span>₴7,700.00</span>
                    </div>
                    <div className="summary__bill-chapters font-headline">
                        <span className="text-outline">Shipping</span>
                        <span className="text-primary-container">
                            Next Step
                        </span>
                    </div>
                    <div className="summary__bill-chapters font-headline">
                        <span className="text-outline">Tax</span>
                        <span>₴0.00</span>
                    </div>

                    <div className="summary__total border-t-[4px] border-on-surface">
                        <span className="summary__total-span font-headline">
                            Total
                        </span>
                        <div className="text-right">
                            <span className="summary__total-currency text-outline">
                                UAH
                            </span>

                            <span className="summary__total-price font-headline">
                                ₴7,700.00
                            </span>
                        </div>
                    </div>
                </div>

                <div className="summary__promocode group">
                    <div className="relative">
                        <input
                            className="summary__promocode-input bg-transparent border-t-0 border-l-0 border-r-0 border-b-2 border-surface-container-highest transition-colors focus:border-primary-container placeholder:text-outline-variant"
                            placeholder="PROMO CODE"
                            type="text"
                        />

                        <button className="summary__promocode-btn font-headline text-primary-container">
                            Apply
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
}
