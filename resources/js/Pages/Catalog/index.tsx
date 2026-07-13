import Filters from "./Filters";
import Products from "./Products";
import CatalogHero from "./CatalogHero";
import SiteLayout from "@/Layouts/SiteLayout";
import type { CatalogProps } from "@/types";
import { ReactNode } from "react";

function Catalog({
    products,
    categories,
    filters,
    colors,
    max_price,
}: CatalogProps) {
    return (
        <div className="max-w-[1440px] mx-auto px-6 md:px-12 pb-24">
            <CatalogHero />
            <div className="flex flex-col md:flex-row gap-12">
                <Filters
                    categories={categories}
                    filters={filters}
                    max_price={max_price}
                    colors={colors}
                />
                <Products products={products} filters={filters} />
            </div>
        </div>
    );
}

Catalog.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>;

export default Catalog;
