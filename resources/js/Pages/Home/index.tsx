import Header from "../../Components/Header";
import Footer from "../../Components/Footer";
import Hero from "./Hero";
import NewArrivals from "./NewArrivals";
import CategoryTiles from "./CategoryTiles";
import StoreLocations from "./StoreLocations";
import { HomeProps } from "@/types";

export default function Home({
    hero_product,
    new_arrivals,
    category_tiles,
}: HomeProps) {
    return (
        <>
            <Header />
            <main>
                <Hero hero_product={hero_product} />
                <NewArrivals new_arrivals={new_arrivals} />
                <CategoryTiles category_tiles={category_tiles} />
                <StoreLocations />
            </main>
            <Footer />
        </>
    );
}
