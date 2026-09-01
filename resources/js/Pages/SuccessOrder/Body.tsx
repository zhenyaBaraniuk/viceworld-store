import "../../../css/front/pages/success-order/body.css";

export default function Body() {
    return (
        <>
            <div className="success max-w-4xl">
                <div className="mb-8">
                    <div className="success__status bg-primary-container">
                        <span className="success__status-icon material-symbols-outlined text-white">
                            check
                        </span>
                    </div>
                </div>

                <div className="success__text">
                    <span className="success__text-status font-headline text-primary-container">
                        Order Status: Paid
                    </span>

                    <h1 className="success__text-confirm font-headline text-on-surface">
                        CONFIRMED
                        <br />
                        &amp; SHIPPED
                    </h1>
                </div>

                <div className="success__number border-y-2 border-on-surface">
                    <p className="success__number-id font-headline text-on-surface">
                        ID: VW-2024-81
                    </p>
                </div>

                <div className="success__delivery bg-on-surface border-on-surface">
                    <div className="bg-surface p-10 text-left">
                        <h3 className="success__delivery-title font-headline text-outline">
                            Delivery Window
                        </h3>

                        <p className="success__delivery-data font-headline text-on-surface ">
                            Oct 24 — Oct 26
                        </p>

                        <p className="success__delivery-text font-body text-on-surface-variant">
                            Tracking documentation dispatched to registered
                            electronic mail address.
                        </p>
                    </div>

                    <div className="bg-surface p-10 text-left">
                        <h3 className="success__delivery-title font-headline text-outline ">
                            Shipping Destination
                        </h3>

                        <p className="success__delivery-data font-headline text-on-surface leading-tight">
                            122 Architecture St.
                            <br />
                            Berlin, DE 10115
                        </p>
                    </div>
                </div>

                <div className="success__buttons">
                    <a
                        className="success__buttons-shop bg-on-surface text-white font-headline hover:bg-primary-container transition-colors duration-150"
                        href="#"
                    >
                        Shop Again
                        <span className="material-symbols-outlined text-sm">
                            north_east
                        </span>
                    </a>

                    <a
                        className="success__buttons-track border-2 bg-transparent border-on-surface text-on-surface font-headline hover:bg-on-surface hover:text-white transition-colors duration-150"
                        href="#"
                    >
                        Track Parcel
                    </a>
                </div>
            </div>

            <div className="success__visual border-t-2 border-on-surface">
                <img
                    alt="Streetwear aesthetic"
                    className="success__visual-img grayscale brightness-90 contrast-125"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDHr2_bjS7O_u3iAnXV_K_DO1IrB2wiCOYhyBUG5Bjdry8v3uxd_lDJR7xRdkXzn07te5iS5X0N5AkeNfIF-K4mY1Uj0zswhZB2xMiQ7Hmb-5_gOCrECGkM0rcrQLEoXp6tHCPeQNMcc8DD6F-LRxklt0vJsGA92_DongFCaVbkvGf4oLEKkynfMPpGDjVYBsayx2KgxBzykR8UJtMAeZe3rt9rUIGd0Y4VICk4XEO_scgvIT0ZAMR0J9ODGbz3dFw4Dklp5Fw_P7AI"
                />

                <div className="success__visual-overlay">
                    <h2 className="success__visual-text font-headline text-white/90 mix-blend-overlay">
                        ESTABLISHED
                    </h2>
                </div>
            </div>
        </>
    );
}
