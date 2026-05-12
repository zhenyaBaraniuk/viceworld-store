import '../../../css/front/pages/product/additional-products.css';

export default function AdditionalProducts() {
    return (
        <section className="additional-products">
            <h2 className="additional-products__title">Complete the Look</h2>

            <div className="additional-products__grid">
                <div className="group cursor-pointer">
                    <div className="additional-products__item-media bg-surface-container-low">
                        <img
                            className="additional-products__item-img grayscale group-hover:grayscale-0"
                            data-alt="Dark denim tactical trousers"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuAPC1S08qhbcC7qPhtJZ7IZCWHAehKUW521Lkre9kjEtQJIQMrnyZu7XqEGIIWBfTHSJM4kBbZGuNVsshYHFLpKvaOgFrdEvkD-mYqZMhKlIa1mUxakXcUEy981Mw0G1ZggEImbVzbIOwOEK8V3cautJb0_urQ49ClA78H9bJ4yGEsAN7YT829gnxh1u8vODFWWrg1SaMXvBPHHBECmpU25GlezeGHIJPUbdHdlIjZYFpGK6FrcAxj3PE0NuGyQYDEs3WVIrCnnfCOl"
                        />

                        <button
                            className="additional-products__item-add bg-white group-hover:opacity-100 group-hover:translate-y-0">
                            <span className="material-symbols-outlined" data-icon="add">
                                add
                            </span>
                        </button>
                    </div>

                    <div className="space-y-1">
                        <h4 className="additional-products__item-name">Tactical Denim V1</h4>
                        <p className="text-xs text-neutral-500">$210.00</p>
                    </div>
                </div>

                <div className="group cursor-pointer">
                    <div className="additional-products__item-media bg-surface-container-low">
                        <img className="additional-products__item-img grayscale group-hover:grayscale-0"
                            data-alt="White premium heavyweight cotton t-shirt"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDir0O_mbBfHyzPQIHUdOzK2V8yZROneRowSSGEX2eQYiaxVbUxf42iDlP2tyVI-OnRbGim_9Zq-aw-PRxKzlZ_3E0I2IbEaDHQSGp8sukftO_sTEoCvORdcLx8OeGN3XIxUwyPXSaG1syFHr--DsU_p7B8UrD9YqlRGfjAkEsW5AiGvkZQ5ngbS9FXP-FWmfC4YKZ8e59oYA2rAHHjCJRWELHGAs1aebr5yWs4qax6x42QvtLL_YWeM0CXYaf11DBEA0IY-E-ofNhR"
                        />

                        <button className="additional-products__item-add bg-white group-hover:opacity-100 group-hover:translate-y-0">
                            <span className="material-symbols-outlined" data-icon="add">
                                add
                            </span>
                        </button>
                    </div>

                    <div className="space-y-1">
                        <h4 className="additional-products__item-name">Base Layer Tee</h4>
                        <p className="text-xs text-neutral-500">$85.00</p>
                    </div>
                </div>

                <div className="group cursor-pointer">
                    <div className="additional-products__item-media bg-surface-container-low">
                        <img className="additional-products__item-img grayscale group-hover:grayscale-0"
                            data-alt="Technical urban sneakers black and blue"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDGy7FT-cmSfXwT20cdUaAw_YPgOVTTR_8cKF0Ge8MSk5ANzQkk247MqRaQXab8OLQkDeJVr68byWKt8Rnn_Blevbzyy0AkOy_WNB2H4jh0319-PXBBZz8QeZd_ophFfZeFe_emW-L2dAYcjeuFBFyQBM1-5rNwREUMz4Fum7u6KtdZiaeIu4YrfXvV5jIJqvIUo1iNQgI9nOQZh_X-75muk2WRi9dEyI27sCQw9w5SFsGgslNGKinZ_dllCPouvz-0izqcM0KyBb3c"
                        />
                        <button
                            className="additional-products__item-add bg-white group-hover:opacity-100 group-hover:translate-y-0">
                            <span className="material-symbols-outlined" data-icon="add">add</span>
                        </button>
                    </div>

                    <div className="space-y-1">
                        <h4 className="additional-products__item-name">Ghost-01 Runners</h4>
                        <p className="text-xs text-neutral-500">$320.00</p>
                    </div>
                </div>

                <div className="group cursor-pointer">
                    <div className="additional-products__item-media bg-surface-container-low">
                        <img className="additional-products__item-img grayscale group-hover:grayscale-0"
                            data-alt="Technical crossbody sling bag black"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuA3_h4U4qh3qVbBX_jK-8KqP4GOX8qVTpp1LsbDnRndyTeqaZJFbA0Q9ZQ5MoktbrDyYBxiq7JkbS3_V52mkic-lFXgWNoJgSmRAxqY6kowhOM7IGlx7PNp7qpkAeODGuFH_N_tyOGYp7kCJrtgMqrBqOWHxD58deP-uz15nB14AihZQ0gYbuAyU6vPeJ0oDYRTgEXA1rpEGkxf4liG-J6-xaNZXyZ25wEk8OQKQ4I6tyINPeZKNPSZp6YFFwtadnUizWS7lDxUhww3"
                        />
                        <button
                            className="additional-products__item-add bg-white group-hover:opacity-100 group-hover:translate-y-0">
                            <span className="material-symbols-outlined" data-icon="add">add</span>
                        </button>
                    </div>

                    <div className="space-y-1">
                        <h4 className="additional-products__item-name">Modular Sling Bag</h4>
                        <p className="text-xs text-neutral-500">$145.00</p>
                    </div>
                </div>
            </div>
        </section>
    );
}
