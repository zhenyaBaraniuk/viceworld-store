import '../../../css/front/pages/error/not-found.css';

export default function NotFound() {
    return (
        <main className="page">
            <div
                className="backdrop">
                <h1 className="backdrop__number">
                    404
                </h1>
            </div>

            <div className="gradient-overlay">
            </div>

            <div className="content">
                <h2 className="font-headline font-black text-4xl md:text-6xl tracking-[-0.02em] mb-4 text-white">
                    THIS PAGE DOESN'T EXIST
                </h2>

                <p className="text-white text-lg md:text-xl font-medium mb-12 max-w-md">
                    It may have moved, been removed, or never existed.
                </p>

                <div className="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                    <button
                        className="bg-primary text-white px-10 py-5 font-headline font-bold tracking-tight text-lg active:scale-95 transition-transform">
                        GO HOME
                    </button>

                    <button
                        className="bg-transparent border-2 border-white text-white px-10 py-5 font-headline font-bold tracking-tight text-lg active:scale-95 transition-transform">
                        VIEW CATALOG
                    </button>
                </div>
            </div>

            <div className="logo">
                <div className="flex items-center gap-2">
                    <span className="font-headline text-2xl font-black tracking-[-0.02em] uppercase text-white">
                        V<span className="text-primary">!</span>ceWorld
                    </span>
                </div>
            </div>

            <div className="error-code">
                <span
                    className="font-headline font-light text-sm tracking-widest transform rotate-90 origin-bottom-right text-white">
                    ERRORCODE_0X404_NOTFOUND
                </span>
            </div>
        </main>
    );
}
