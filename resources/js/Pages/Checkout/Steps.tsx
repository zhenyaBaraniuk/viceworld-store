import "../../../css/front/pages/checkout/steps.css";

export default function Steps() {
    return (
        <div className="steps max-w-2xl">
            <div className="steps__address group">
                <div className="steps__number bg-primary-container text-white font-headline">
                    1
                </div>

                <span className="steps__label font-headline text-primary-container">
                    Address
                </span>
            </div>

            <div className="steps__delivery bg-surface-container-highest"></div>

            <div className="steps__address group opacity-20">
                <div className="steps__number bg-surface-container-highest text-on-surface font-headline">
                    2
                </div>

                <span className="steps__label font-headline">Delivery</span>
            </div>

            <div className="steps__payment bg-surface-container-highest"></div>

            <div className="steps__address group opacity-20">
                <div className="steps__number bg-surface-container-highest text-on-surface font-headline">
                    3
                </div>

                <span className="steps__label font-headline">Payment</span>
            </div>
        </div>
    );
}
