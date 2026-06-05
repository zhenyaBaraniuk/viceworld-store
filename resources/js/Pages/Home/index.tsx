import Header from "../../Components/Header";
import Footer from "../../Components/Footer";
import Hero from "./Hero";
import NewArrivals from "./NewArrivals";
import CategoryTiles from "./CategoryTiles";
import StoreLocations from "./StoreLocations";

export default function Home() {
    return (
        <>
            <Header />
            <main>
                <Hero />
                <NewArrivals />
                <CategoryTiles />
                <StoreLocations />
            </main>
            <Footer />
        </>
    );
}
