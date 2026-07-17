import { ReactNode } from "react";
import Navigation from "@/Pages/Profile/Navigation";

export default function ProfileLayout({ children }: { children: ReactNode }) {
    return (
        <main className="max-w-[1440px] mx-auto px-6 md:px-12 pb-24">
            <div className="grid grid-cols-1 md:grid-cols-12 gap-12">
                <Navigation />
                <section className="md:col-span-9 p-8 md:p-16 lg:p-24 bg-surface dark:bg-neutral-950 overflow-hidden relative">
                    {children}
                </section>
            </div>
        </main>
    );
}
