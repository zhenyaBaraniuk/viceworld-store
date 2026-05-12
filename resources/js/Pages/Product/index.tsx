import Header from "../../Components/Header";
import Footer from "../../Components/Footer";
import AdditionalProducts from "./AdditionalProducts";
import Breadcrumbs from "../../Navigation/Breadcrumbs";
import Product from "./Product";

export default function ProductPage() {
    return (
        <>
            <Header />
            <main className="max-w-[1440px] mx-auto px-6 md:px-12 pb-24 pt-20">
                <Breadcrumbs />

                <Product />
                <AdditionalProducts />
            </main>
            <Footer/>
        </>
    );
}
