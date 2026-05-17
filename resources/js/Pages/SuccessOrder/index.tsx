import Header from "../../Components/Header";
import Footer from "../../Components/Footer";
import Body from "./Body";

export default function SuccessOrder() {
    return (
        <>
            <Header/>
            <main className="min-h-screen flex flex-col items-center">
                <Body/>
            </main>
            <Footer/>
        </>
    );
}
