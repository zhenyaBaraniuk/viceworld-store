import Hero from "./Hero";
import NewArrivals from "./NewArrivals";
import CategoryTiles from "./CategoryTiles";
import StoreLocations from "./StoreLocations";
import { HomeProps } from "@/types";
import { ReactNode } from "react";
import SiteLayout from "@/Layouts/SiteLayout";

function Home({ hero_product, new_arrivals, category_tiles }: HomeProps) {
    return (
        <div>
            <Hero hero_product={hero_product} />
            <NewArrivals new_arrivals={new_arrivals} />
            <CategoryTiles category_tiles={category_tiles} />
            <StoreLocations />
        </div>
    );
}

Home.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>;

export default Home;
