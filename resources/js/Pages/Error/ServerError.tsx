import "../../../css/front/pages/error/server-error.css";
import { useEffect, useState } from "react";

export default function ServerError() {
    const getUtc = () => new Date().toISOString().split("T")[1].split(".")[0];
    const [utc, setUtc] = useState(getUtc);

    useEffect(() => {
        const timer = setInterval(() => {
            setUtc(getUtc);
        }, 1000);

        return () => clearInterval(timer);
    }, []);

    return (
        <main className="page">
            <div className="backdrop">
                <h1 className="backdrop__number">500</h1>
            </div>

            <div className="gradient-overlay"></div>

            <div className="content">
                <h2 className="font-headline font-black text-white text-4xl md:text-6xl lg:text-7xl tracking-[-0.02em] mb-4 uppercase leading-[0.9]">
                    SOMETHING BROKE
                    <br />
                    ON OUR END.
                </h2>

                <p className="font-body font-black text-white text-lg md:text-xl tracking-tight mb-12 max-w-lg">
                    Our team has been notified. Try again in a moment.
                </p>

                <button className="bg-primary hover:bg-[#0050cb] text-white font-headline font-bold text-sm md:text-base px-10 py-5 transition-all duration-200 active:scale-95 tracking-wider">
                    TRY AGAIN
                </button>
            </div>

            <div className="meta">
                <div className="font-mono text-[10px] text-zinc-600 uppercase tracking-widest leading-relaxed">
                    ERR_500 / VICEWORLD_SYS
                    <br />
                    UTC: <span>{utc}</span>
                </div>
            </div>

            <div className="logo">
                <div className="font-headline font-black text-white text-xl tracking-tighter uppercase">
                    V<span className="text-primary">!</span>ceWorld
                </div>
            </div>

            <div className="absolute top-0 left-0 w-full h-px bg-zinc-900/50"></div>
            <div className="absolute bottom-0 left-0 w-full h-px bg-zinc-900/50"></div>
            <div className="absolute top-0 left-8 w-px h-full bg-zinc-900/20"></div>
            <div className="absolute top-0 right-8 w-px h-full bg-zinc-900/20"></div>
        </main>
    );
}
