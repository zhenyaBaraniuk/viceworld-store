import "../../../css/front/pages/home/hero.css";

export default function Hero() {
    return (
        <section className="hero bg-neutral-200">
            <img
                alt="Editorial streetwear model portrait"
                className="absolute inset-0 w-full h-full object-cover grayscale brightness-75 object-top"
                data-alt="Editorial streetwear model in minimalist urban setting"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDIW1o8qaw0sCHUCyEdQxVjezM_wWB3x46TWiHH0gpHVrHhwx7ZPMGvopspHGR7DgIKfIsKucPCsZGW1tDMm1A72s-BTkGPl8AGCrDphffXFs0Lq90AObkf253G6k9g8w6hMdOOzEqvpDAp594Q2aYO452FRQcqiHf9ldNSA7Z1VhYlj673r70OuTZ6Veavn5pzvezrgYQp_j4h-0X6QGUXb0WeucqkKTjdurJd320F9lJolEYtXvAbQHSuhgLATBK9DH8XsK4AizUj"
            />

            <div className="hero-content">
                <h1 className="hero__title text-white">
                    V<span className="text-primary">!</span>ceWorld
                </h1>
                <button className="hero__cta bg-primary text-white  hover:bg-black">
                    Shop now
                </button>
            </div>

            <div className="hero__label hidden lg:block">
                <span className="hero__label-text text-white">
                    Collection 2024 / Brutalism
                </span>
            </div>
        </section>
    );
}
