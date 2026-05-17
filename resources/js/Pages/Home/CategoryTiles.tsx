import '../../../css/front/pages/home/category-tiles.css';

export default function CategoryTiles() {
    return (
        <section className="category-tiles bg-neutral-900">
            <div className="category-tiles__grid">
                <div className="category-tiles__item group border-neutral-800">
                    <img
                        alt="Men collection"
                        className="category-tiles__item-img group-hover:opacity-100 transition-opacity duration-500"
                        data-alt="Men fashion editorial in concrete environment"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuB-lieBTum7GI7oXn95a1QbYTJJ4dwcVZP-Yo5mmk2uQ44Wf-MUZ02BPi8eu25cJJrWvFR2D5BzL3zXaad5NDMFjMRIN2A_O5oLWKZR6H7PtyWpvsJ3mENuhb0DIYatmtqZ3MaUShvZflcl9TF17PG2Xs2N11rN76g63z3Qi8GTBOPpaWxPqa-p9MdTxD7KiTYTi98ziGklta1x5PQGnXsBvcrDzT5dTeqFknfr2daOtiPMwx6HPCRTvCNHi8DL7rSZWkKpxy6oZUmu"
                    />

                    <div className="category-tiles__item-overlay">
                        <h2 className="category-tiles__item-title text-white group-hover:translate-y-0 transition-transform duration-500 group-hover:opacity-100">
                            Men
                        </h2>
                    </div>

                    <div className="category-tiles__label">
                        <span className="category-tiles__label-text text-white  font-bold">
                            Volume 01
                        </span>
                    </div>
                </div>

                <div className="category-tiles__item group border-neutral-800">
                    <img
                        alt="Women collection"
                        className="category-tiles__item-img group-hover:opacity-100 transition-opacity duration-500"
                        data-alt="Women streetwear editorial high fashion"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuBe6d-lD-iFe87XdeEQC0sIZZBqqOxfAWvQwIeXozYYhqGWx1nlHwZIcJeAGU2LQWwcqecsyr-hjUmSxz6bKAku8q_eqPD5NPFjEphFtLM8YXx8lUQRQgss2IcZtxDSNwgiO_Tf5SFjJ6rUDKG8OsmNjLZgiA4yUGz7hLzD124DqsQDExH_okmGNnOtvohZvGP8G7WzKyBG3edLRl8Z06czxHvFB1ldNyBJVoHDv5c2EBoA3I0YPPCbYyxf1Fg1qHc5zDYPQHW9x2OE"
                    />

                    <div className="category-tiles__item-overlay">
                        <h2 className="category-tiles__item-title font-black text-white group-hover:translate-y-0 transition-transform duration-500 group-hover:opacity-100">
                            Women
                        </h2>
                    </div>

                    <div className="category-tiles__label">
                        <span className="category-tiles__label-text text-white font-bold">
                            Volume 02
                        </span>
                    </div>
                </div>

                <div className="category-tiles__item group border-neutral-800">
                    <img
                        alt="Kids collection"
                        className="category-tiles__item-img group-hover:opacity-100 transition-opacity duration-500"
                        data-alt="Kids streetwear editorial urban style"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuDjpqJme4n5dLj_ROhzml7qF2Y05tTXlPjwOZ6gPXXkOtGBG1RqxiP-cmBCGJe4zC8IKS6pbaiVjZQlGX1TRuegJXkKN7jvjup3MaAG3sKGAxe7pVXTnhDJ02R6YI-A1U3H7vxxdVV2Eb8BxEuUajWOV4UFAtKu8DNzRmDVX63tjYh-Ob6iy9HSdlSMVvFGrN6KbZWbwKzANuCXHlUhe-lVdiW-gSlwj4CLA_AYo_5deqAWLsOvUdfRMzAoXnjNzleDP-1sOjbdqFk5"
                    />

                    <div className="category-tiles__item-overlay">
                        <h2 className="category-tiles__item-title font-black text-white group-hover:translate-y-0 transition-transform duration-500 group-hover:opacity-100">
                            Kids
                        </h2>
                    </div>

                    <div className="category-tiles__label">
                        <span className="category-tiles__label-text text-white font-bold">
                            Volume 03
                        </span>
                    </div>
                </div>
            </div>
        </section>
    )
}
