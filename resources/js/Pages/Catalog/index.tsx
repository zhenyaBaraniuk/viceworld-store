import Header from "../../Components/Header";
import Footer from "../../Components/Footer";
import Filters from "./Filters";
import Products from "./Products";
import CatalogHero from "./CatalogHero";

export default function Catalog() {
    return (
        <>
            <Header/>
            <main className="max-w-[1440px] mx-auto px-6 md:px-12 pb-24">
                <CatalogHero/>
                <div className="flex flex-col md:flex-row gap-12">
                    <Filters/>
                    <Products/>
                </div>
            </main>
            <Footer/>
        </>
    );
}
