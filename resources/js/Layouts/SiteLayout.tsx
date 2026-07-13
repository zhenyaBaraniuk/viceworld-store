import Header from "@/Components/Header";
import Footer from "@/Components/Footer";
import { ReactNode } from "react";

export default function SiteLayout({ children }: { children: ReactNode }) {
    return (
        <>
            <Header />
            <main>{children}</main>
            <Footer />
        </>
    );
}
