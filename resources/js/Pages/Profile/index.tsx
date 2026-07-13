import Header from "../../Components/Header";
import Footer from "../../Components/Footer";
import Navigation from "./Navigation";
import Order from "./Order";

export default function Profile() {
    return (
        <>
            <Header />
            <main className="max-w-[1440px] mx-auto px-6 md:px-12 pb-24">
                <div className="mb-16">
                    <h1 className="text-7xl font-black text-header mb-4">
                        Account
                    </h1>

                    <p className="text-neutral-500 uppercase tracking-widest text-sm font-bold">
                        Order History &amp; Management
                    </p>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-12 gap-12">
                    <Navigation />
                    <Order />
                </div>
            </main>
            <Footer />
        </>
    );
}
