import '../../../css/front/pages/searh/products.css';

export default function Products() {
    return (
        <section className="products">
            <div className="products__main">
                <div className="md:col-span-2 group">
                    <div className="products__head bg-surface-container-low">
                        <img
                            alt="Model wearing premium technical streetwear jacket"
                            className="products__head-img transition-transform duration-700 group-hover:scale-105"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCUKG8mLxIDZm6Vn2Wg4fBT_VBLhKLZ55eUP6GvICrhTvNiN1Z2mtfRri7Dg8XMJ4DLTLryickT0muIC_kmNEcQFh8hP8OsB45P6ArqXd_n-YgjaanGxZyM9zhDc8ZlX95GYGDFjssh2gBjJv78X068W3ebQ1hMJA1YdQy_inLpbTRZUUaxFH0YgTlBl3pxifUVBWTjziUli8hjR2yAcFfOGEnrTfApYduDe9N07ctP5k2f0-ZwDy-2kXbNyubNvs0AYoB-3r93W0wm"
                        />

                        <div
                            className="products__head-badge bg-primary text-white">
                            Limited Release
                        </div>
                    </div>

                    <div className="products__head-payload">
                        <div>
                            <p className="products__head-category text-outline">
                                Tech-Shell / Series 01
                            </p>
                            <h4 className="products__head-title font-headline">
                                V!CE ARCANE PARKA
                            </h4>
                        </div>

                        <p className="products__head-price text-primary">
                            $495.00
                        </p>
                    </div>
                </div>

                <div className="group">
                    <div className="products__product bg-surface-container-low">
                        <img
                            alt="Leather bomber jacket"
                            className="products__product-img transition-transform duration-700 group-hover:scale-105"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDio3B8FLDwW6GECqyYJ7jSt4Y4dmEeE2XKCZsGRATiQoxdG_PYUYva1pWIH5qvhIXqMhAKncf2kLl7YMhZfBm1WKxwaNz2tMu6DmxJ2RdIVTyxQ_2KtCn1oZzW7_cu9j93NYAQ0uqk1VxJXUaRidgG_gMMHvko-MXlStMk-HYOYcgsij_ITqzemoh096kfSHyJmwOz8fWjxXNx-hfJe9mOrYV2pbK9pMcmQu8sz4Rq_jVmenAIs6RVwxa-x97O9sdR2sYEPP8peFm4"
                        />
                    </div>

                    <div className="mt-4">
                        <p className="products__product-category text-outline">
                            Leather / Core
                        </p>

                        <h4 className="products__product-title font-headline">
                            ONYX BIKER JACKET
                        </h4>

                        <p className="products__product-price text-primary">
                            $820.00
                        </p>
                    </div>
                </div>

                <div className="group">
                    <div className="products__product bg-surface-container-low">
                        <img
                            alt="Electric blue puffer jacket"
                            className="products__product-img transition-transform duration-700 group-hover:scale-105"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBoaWkyaSCjkPZKnofkP3NXTFU2cxzfU0VnpmkHyFXKHWeKzbKMKzZzSfibmebrJvhrysBtZFTiekU4GwrB4Tdy5ZZ9i3TppJ2UjjsP9eArplrCqa4RBVNQXvtOMKTdDaiZbCAp0-2zIMjkp_wIuiqeyJZanX3i3heqQj0g5kOUj8KkeHhaCDwCSw04MWjeV6SeL2HPOzmZn0sK-k3MPBOfWQwX9F72tBZNu0CjgP7Gb7-KBGkjK4zRBTXbMVm-DQM3ZYNGPzwP-z2"
                        />

                        <div className="products__product-badge bg-on-surface text-white">
                            New Arrival
                        </div>
                    </div>

                    <div className="mt-4">
                        <p className="products__product-category text-outline">
                            Insulated / Arctic
                        </p>

                        <h4 className="products__product-title font-headline">
                            ELECTRIC BLUE PUFFER
                        </h4>

                        <p className="products__product-price text-primary">
                            $550.00
                        </p>
                    </div>
                </div>

                <div className="group">
                    <div className="products__product bg-surface-container-low">
                        <img
                            alt="Khaki utility field jacket"
                            className="products__product-img transition-transform duration-700 group-hover:scale-105"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBfn8DSNAQHtl5q67LKsA32SpSUzvyD1kjf0qJkH2W9uJlWXk1tdZGq0w4tXy6WFsvHXoxhPYqRFPGVcZuT_OXC0WgUu2FfJ2F0Lii1s5IG53841wDctMmOQvrwWNpQK1ul-jK_5CzRI-fdPynesU3hLE8UKdDMe48UF5pGfc8eIQlNqxH6fmPP1aSvEqU-JSF06ovesmz4hfqHwgHdvh4Aw_HWqPNicb-5CtyyRhgo9sQhpLXbRSB9mIRKwI2Ypkr870TTowrmGdG1"
                        />
                    </div>

                    <div className="mt-4">
                        <p className="products__product-category text-outline">
                            Military / Utility
                        </p>

                        <h4 className="products__product-title font-headline">
                            M-65 MODULAR FIELD
                        </h4>

                        <p className="products__product-price text-primary">
                            $410.00
                        </p>
                    </div>
                </div>
            </div>

            <div className="products__load">
                <button className="products__load-btn bg-on-surface text-white hover:bg-primary transition-all duration-300">
                    Load More Results
                </button>
            </div>
        </section>
    );
}
