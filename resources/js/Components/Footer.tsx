import "../../css/front/components/footer.css";
import { ArrowRight } from "lucide-react";

export default function Footer() {
    const year = new Date().getFullYear();

    return (
        <footer className="site-footer bg-black border-primary">
            <div className="site-footer__backdrop">
                <span className="site-footer__backdrop-text text-white/5">
                    VICEWORLD
                </span>
            </div>

            <div className="site-footer__inner">
                <div className="flex flex-col gap-10">
                    <a className="site-footer__logo text-white" href="/">
                        V<span className="text-primary">!</span>CEWORLD
                    </a>

                    <div className="site-footer__coords">
                        <p className="site-footer__col-title text-neutral-500">
                            Coordinates / Store Network
                        </p>

                        <div className="flex flex-col gap-2">
                            <p className="site-footer__col-title text-white">
                                KYIV — 50.4501° N, 30.5234° E
                            </p>
                            <p className="site-footer__col-title text-neutral-500">
                                BERLIN SOON — 52.5200° N, 13.4050° E
                            </p>
                            <p className="site-footer__col-title text-neutral-500">
                                TOKYO SOON — 35.6762° N, 139.6503° E
                            </p>
                        </div>
                    </div>
                </div>

                <div className="flex flex-col gap-8">
                    <h4 className="site-footer__col-title text-primary">
                        Navigation
                    </h4>
                    <div className="flex flex-col gap-4">
                        <a
                            className="site-footer__nav-link text-neutral-500 hover:text-white"
                            href="#"
                        >
                            Newsletter
                        </a>
                        <a
                            className="site-footer__nav-link text-neutral-500 hover:text-white"
                            href="#"
                        >
                            Terms
                        </a>
                        <a
                            className="site-footer__nav-link text-neutral-500 hover:text-white"
                            href="#"
                        >
                            Privacy
                        </a>
                        <a
                            className="site-footer__nav-link text-neutral-500 hover:text-white"
                            href="#"
                        >
                            Cookie Policy
                        </a>
                    </div>
                </div>

                <div className="flex flex-col gap-8">
                    <h4 className="site-footer__col-title text-primary">
                        Union Hub
                    </h4>

                    <p className="site-footer__nav-link text-neutral-400">
                        Access limited drops via archival subscription.
                    </p>

                    <div className="site-footer__newsletter-form border-neutral-800">
                        <input
                            className="site-footer__newsletter-input text-white placeholder:text-neutral-800"
                            placeholder="ENTER@COMMUNICATIONS.INT"
                            type="email"
                        />
                        <button className="text-white p-3 hover:text-primary">
                            <ArrowRight size={20} />
                        </button>
                    </div>

                    <div className="site-footer__socials">
                        <a
                            className="site-footer__social-link text-white underline hover:text-primary"
                            href="#"
                        >
                            INSTAGRAM
                        </a>
                        <a
                            className="site-footer__social-link text-neutral-500 hover:text-primary"
                            href="#"
                        >
                            TWITTER
                        </a>
                    </div>
                </div>
            </div>

            <div className="site-footer__bottom border-neutral-900">
                <p className="site-footer__copyright text-neutral-700">
                    © {year} V!ceWorld. Architectural Brutalism.
                </p>
            </div>
        </footer>
    );
}
