import Header from "../../Components/Header";
import SearchHeader from "../Search/SearchHeader";
import Filters from "../Search/Filters";
import Products from "../Search/Products";
import Footer from "../../Components/Footer";
import type { SearchProps } from "@/types";

export default function Search({
    products,
    categories,
    filters,
    colors,
    max_price,
    query,
    total,
}: SearchProps) {
    return (
        <>
            <Header />
            <main className="max-w-[1440px] mx-auto px-6 md:px-12 pb-24">
                <SearchHeader query={query} total={total} />
                <div className="flex flex-col lg:flex-row gap-16">
                    <Filters
                        categories={categories}
                        filters={filters}
                        max_price={max_price}
                        colors={colors}
                        query={query}
                    />
                    <Products
                        products={products}
                        filters={filters}
                        query={query}
                    />
                </div>
            </main>
            <Footer />
        </>
    );
}
