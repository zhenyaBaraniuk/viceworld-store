import Header from "../../Components/Header";
import SearchHeader from "../Search/SearchHeader";
import Filters from "../Search/Filters";
import Products from "../Search/Products";
import Footer from "../../Components/Footer";

export default function Search() {
    return (
        <>
            <Header/>
            <main className="max-w-[1440px] mx-auto px-6 md:px-12 pb-24">
                <SearchHeader />
                <div className="flex flex-col lg:flex-row gap-16">
                    <Filters/>
                    <Products/>
                </div>
            </main>
            <Footer/>
        </>
    );
}
