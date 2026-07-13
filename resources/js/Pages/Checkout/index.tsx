import Header from "../../Components/Header";
import Footer from "../../Components/Footer";
import Steps from "./Steps";
import Info from "./Info";
import Summary from "./Summary";

export default function CheckoutPage() {
    return (
        <>
            <Header />
            <main className="max-w-[1440px] mx-auto px-6 md:px-12 pb-24 pt-20">
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-16">
                    <div className="lg:col-span-8">
                        <Steps />
                        <Info />
                    </div>

                    <Summary />
                </div>
            </main>
            <Footer />
        </>
    );
}
