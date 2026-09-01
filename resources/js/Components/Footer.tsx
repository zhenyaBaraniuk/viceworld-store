import "../../css/front/components/footer.css";
import { ArrowRight } from "lucide-react";
import { useForm } from "@inertiajs/react";
import { route } from "@/lib/route";
import { useTranslation } from "@/hooks/useTranslation";

export default function Footer() {
    const { t } = useTranslation();
    const year = new Date().getFullYear();

    const { data, setData, post, errors, wasSuccessful } = useForm({
        email: "",
    });

    const subscribe = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(route("newsletter.subscribe"), {
            preserveScroll: true,
            onSuccess: () => setData("email", ""),
        });
    };

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
                            {t("footer.coordinates_title")}
                        </p>

                        <div className="flex flex-col gap-2">
                            <p className="site-footer__col-title text-white">
                                {t("footer.store_kyiv")}
                            </p>
                            <p className="site-footer__col-title text-neutral-500">
                                {t("footer.store_berlin")}
                            </p>
                            <p className="site-footer__col-title text-neutral-500">
                                {t("footer.store_tokyo")}
                            </p>
                        </div>
                    </div>
                </div>

                <div className="flex flex-col gap-8">
                    <h4 className="site-footer__col-title text-primary">
                        {t("footer.nav_title")}
                    </h4>
                    <div className="flex flex-col gap-4">
                        <a
                            className="site-footer__nav-link text-neutral-500 hover:text-white"
                            href="#"
                        >
                            {t("footer.nav_newsletter")}
                        </a>
                        <a
                            className="site-footer__nav-link text-neutral-500 hover:text-white"
                            href="#"
                        >
                            {t("footer.nav_terms")}
                        </a>
                        <a
                            className="site-footer__nav-link text-neutral-500 hover:text-white"
                            href="#"
                        >
                            {t("footer.nav_privacy")}
                        </a>
                        <a
                            className="site-footer__nav-link text-neutral-500 hover:text-white"
                            href="#"
                        >
                            {t("footer.nav_cookie")}
                        </a>
                    </div>
                </div>

                <div className="flex flex-col gap-8">
                    <h4 className="site-footer__col-title text-primary">
                        {t("footer.union_hub_title")}
                    </h4>

                    <p className="site-footer__nav-link text-neutral-400">
                        {t("footer.union_hub_description")}
                    </p>

                    <form
                        onSubmit={subscribe}
                        className="site-footer__newsletter-form border-neutral-800"
                    >
                        <input
                            className="site-footer__newsletter-input text-white placeholder:text-neutral-800"
                            placeholder={t("footer.newsletter_placeholder")}
                            type="email"
                            value={data.email}
                            onChange={(e) => setData("email", e.target.value)}
                        />

                        <button className="text-white p-3 hover:text-primary">
                            <ArrowRight size={20} />
                        </button>
                    </form>
                    {errors.email && (
                        <p className="text-primary text-sm">{errors.email}</p>
                    )}
                    {wasSuccessful && (
                        <p className="text-primary text-sm font-bold uppercase tracking-widest">
                            {t("footer.subscribed")}
                        </p>
                    )}

                    <div className="site-footer__socials">
                        <a
                            className="site-footer__social-link text-white underline hover:text-primary"
                            href="#"
                        >
                            {t("footer.social_instagram")}
                        </a>
                        <a
                            className="site-footer__social-link text-neutral-500 hover:text-primary"
                            href="#"
                        >
                            {t("footer.social_twitter")}
                        </a>
                    </div>
                </div>
            </div>

            <div className="site-footer__bottom border-neutral-900">
                <p className="site-footer__copyright text-neutral-700">
                    © {year} {t("footer.copyright_suffix")}
                </p>
            </div>
        </footer>
    );
}
