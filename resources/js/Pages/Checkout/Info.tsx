import "../../../css/front/pages/checkout/info.css";

export default function Info() {
    return (
        <div className="info space-y-24">
            <section>
                <h2 className="info__title font-headline">
                    1. Contact Information
                </h2>

                <div className="info__contacts">
                    <div className="relative">
                        <label className="info__contacts-label  text-outline">
                            Email Address
                        </label>

                        <input
                            className="info__contacts-input bg-transparent border-t-0 border-l-0 border-r-0 border-b-2 border-surface-container-highest text-lg transition-colors focus:border-primary-container"
                            placeholder="k.lagerfeld@v-world.com"
                            type="email"
                        />
                    </div>

                    <div className="relative">
                        <label className="info__contacts-label text-outline">
                            Phone number
                        </label>

                        <input
                            className="info__contacts-input bg-transparent border-t-0 border-l-0 border-r-0 border-b-2 border-surface-container-highest text-lg transition-colors focus:border-primary-container"
                            placeholder="+380 •• ••• •• ••"
                            type="tel"
                        />
                    </div>
                </div>
            </section>

            <section>
                <h2 className="info__title font-headline">
                    Shipping Destination
                </h2>

                <div className="info__shipping">
                    <div className="info__country md:col-span-2">
                        <label className="info__shipping-label text-outline">
                            Country / Region
                        </label>

                        <select className="info__country-name bg-transparent border-t-0 border-l-0 border-r-0 border-b-2 border-surface-container-highest text-lg transition-colors focus:border-primary-container">
                            <option>Ukraine</option>
                            <option>Poland</option>
                            <option>Germany</option>
                            <option>United Kingdom</option>
                        </select>
                    </div>

                    <div className="info__city">
                        <label className="info__shipping-label text-outline">
                            City
                        </label>

                        <input
                            className="info__city-input bg-transparent border-t-0 border-l-0 border-r-0 border-b-2 border-surface-container-highest text-lg font-medium transition-colors focus:border-primary-container"
                            placeholder="Kyiv"
                            type="text"
                        />
                    </div>

                    <div className="info__zip">
                        <label className="info__shipping-label text-outline">
                            Zip / Postal Code
                        </label>

                        <input
                            className="info__zip-input bg-transparent border-t-0 border-l-0 border-r-0 border-b-2 border-surface-container-highest text-lg font-medium transition-colors focus:border-primary-container"
                            placeholder="01001"
                            type="text"
                        />
                    </div>

                    <div className="info__address md:col-span-2">
                        <label className="info__shipping-label text-outline">
                            Street Address
                        </label>

                        <input
                            className="info__address-input bg-transparent border-t-0 border-l-0 border-r-0 border-b-2 border-surface-container-highest  text-lg font-medium transition-colors focus:border-primary-container"
                            placeholder="Khreshchatyk St, 22, Apt 4"
                            type="text"
                        />
                    </div>
                </div>
            </section>

            <section className="opacity-30 pointer-events-none">
                <h2 className="info__title font-headline">
                    2. Delivery Method
                </h2>

                <div className="info__delivery">
                    <div className="info__delivery-form border-2 border-primary-container bg-white">
                        <div>
                            <div className="flex justify-between items-start mb-2">
                                <span className="font-headline font-bold uppercase tracking-tight text-lg">
                                    Nova Poshta
                                </span>

                                <span
                                    className="material-symbols-outlined text-primary-container"
                                    style={{
                                        fontVariationSettings: "'FILL' 1",
                                    }}
                                >
                                    check_circle
                                </span>
                            </div>

                            <p className="info__delivery-title text-xs text-outline">
                                Branch Delivery
                            </p>
                        </div>

                        <div className="text-right">
                            <p className="info__delivery-price font-headline">
                                ₴85.00
                            </p>
                        </div>
                    </div>

                    <div className="border-2 border-transparent bg-white hover:border-surface-container-highest transition-colors">
                        <div>
                            <div className="flex justify-between items-start mb-2">
                                <span className="font-headline font-bold uppercase tracking-tight text-lg">
                                    Pickup in Store
                                </span>

                                <p className="text-xs uppercase text-outline font-bold tracking-wider">
                                    Kyiv Flagship, Baseina 12
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section className="opacity-30 pointer-events-none">
                <h2 className="info__title font-headline">3. Payment</h2>

                <div className="info__payment">
                    <div className="info__payment-form bg-white border-transparent group">
                        <div className="flex items-center gap-6">
                            <span className="info__payment-title material-symbols-outlined">
                                payments
                            </span>

                            <div>
                                <p className="info__payment-name font-headline">
                                    LiqPay
                                </p>

                                <p className="info__payment-subnames text-outline">
                                    Visa / Mastercard / Apple Pay
                                </p>
                            </div>
                        </div>

                        <span className="material-symbols-outlined text-outline group-hover:text-primary-container transition-colors">
                            radio_button_unchecked
                        </span>
                    </div>
                </div>
            </section>

            <div className="info__btn">
                <button className="info__btn-title bg-on-surface text-white font-headline hover:bg-primary-container transition-colors duration-300">
                    Continue to Delivery
                </button>
            </div>
        </div>
    );
}
