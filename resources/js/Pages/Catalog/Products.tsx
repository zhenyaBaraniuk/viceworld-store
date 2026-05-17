import '../../../css/front/pages/catalog/products.css';
import Pagination from "./Pagination";

export default function Products() {
    return (
        <section className="products">
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-16 gap-x-8">
                <div className="product-card group cursor-pointer">
                    <div className="product-card__media bg-surface-container-low">
                        <img
                             data-alt="Model wearing oversized black hoodie front view"
                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuAWgaFBBX39FMXPwbNFl2rr_CBnh8c8c1XVKXeJ_8Mrlgz8bW2nfrvWmYaI_TmJxOYBnOq8l8u-5OO2Q4h1D8o8bcL3jO4Zlxc1LlbS9u13Uzk3Q_K0rg47WaIXt8QgLUSX7Gf9-xg9SBp72YiB--iMlsyBIBj8z6QkMsJY092_eC9mphRuF9bxdsqe0IysSbM4nzxHo89mA7Ux8z7ig5DQCWnsvlKznpJdyAu9HetNxlumSc4BcmJDnPiC8znFkTF3YWLaJbzpwHTl"/>

                        <img className="product-card__secondary-img"
                             data-alt="Model wearing oversized black hoodie back detail"
                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuCT5dx4tzQiqi9D8z5joWhn-6NQLs-QWeXtQ0uYW3wQyct4THM_dXdP8DbRuUXXktlueoc348dgC5W9wwWp07twpTQOieeRbQRmDNbhETXERUpdZzEni1zbRa90GHORW_RAYqGnNTLZ1H-jDrlZoG5cZLmUc_5UwpTS29HOaLIiDLSw6Nm7_VxTmnZyueAZb3uhGu3_9iddBCJiiEYltrt-ME9JeSlEk1PskfUnN2qqkbURW10QeT1eublfBnF-cofm30VAo3IhiWnb"/>

                        <div
                            className="product-card__badge bg-primary text-white  font-headline">
                            New Arrival
                        </div>
                    </div>

                    <div className="space-y-1">
                        <p className="product-card__category font-headline text-primary">
                            Outerwear
                        </p>

                        <h4 className="product-card__title font-headline">
                            V!ce Tech Hoodie 01
                        </h4>

                        <p className="product-card__price font-headline">$145.00</p>
                    </div>
                </div>

                <div className="product-card group cursor-pointer">
                    <div className="product-card__media bg-surface-container-low">
                        <img data-alt="Oversized white graphic t-shirt on model"
                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuCy8ccwqIflxJ355JpK8CisUEFqeTX8K-bZESiTD6v4NpVvyvO2PVgvVDxahJ46MmnA_DTCGXhgZ5URokk4KB1ikTpX3ui9bqIHMzFzQG1z6CxubbCiZGgllMZInsNUaxtKHMq9MTERav1wsUnVJGBMrP9irHkyGRiIE7RwBvPh4UNLc-NK6HUeB1CdyHEOPbA_VhByRwzY0Jtvqg9uMwczolcTAyeIwyJFaiB16EiIeyMc1ukfZojXpRonv_FfkR2eLw4pIGzNRf0S"/>

                        <img className="product-card__secondary-img"
                             data-alt="Close up of graphic print on white t-shirt"
                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuDViTvX6qNQQ7QPMbWvxJn7A88RXd_gMsBTs4tOQZo9IT2ymQOqvs2K06KWt6j2Y-Npg7mfX7IG_k-KkHwAAFIGwpuFJk0u0pfEjyg5IlSOQzkfKT19R5gdBk96lg-mAsEF7EI0SmFygeD96s48FFOvBwc7TadB253UY4t8mwlOqWeRhHEqcDdunxp-Qrl4GnVo5L0JZ7iwePZhVDkoZ9BW0RwQbQZe5Z8D9tVeRGLZA_mWja3GFmI-bWnyT9HknkqRHhssOLZ2Efob"/>
                    </div>

                    <div className="space-y-1">
                        <p className="product-card__category font-headline text-outline">
                            Tees
                        </p>

                        <h4 className="product-card__title font-headline">
                            Metropolis Graphic Tee
                        </h4>

                        <p className="product-card__price font-headline">$65.00</p>
                    </div>
                </div>

                <div className="product-card group cursor-pointer">
                    <div className="product-card__media bg-surface-container-low">
                        <img data-alt="Loose fit indigo denim jeans"
                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuCZOgwLdcb4kRSkQYnbBnxfDRsHnxzP4LHUkh0kSKnORpxoUSjOk6_DRPF94c9OKYcUI3RDkMXgWmyUpUPJMbyf6zHcNQRJvttzk8qcf2o0Eyc4VSZuchOe1GLecQsQmiyBrUUuZsj2dTHtqaUmMHl1y7s35dZ_et2AeZBGv89fmjemeGVqHkr-3-xRJSyJyqD-I5JWFaCFEdyOSUvODiDc7a0By7yCDKZQdvGyqbBkuCAHBON6ja-xdIZ9ZN_7wVGnRiiccOXSj3Dw"/>

                        <img className="product-card__secondary-img"
                             data-alt="Detail of denim texture and stitching"
                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuDvmbhOnpgGig1X0hO-4O10amzAb8l7DqewCq5bG53zTbMm0CL7eDnmqT7bb84nmwUa2mwxO5z1IpigfCI6PyyRXwg-lZF44Tylks7v7W-wzblO7wWDLSh9iHQIffmaMonYH1OvloL0QrO8PTeRwjdfQneDBsRs4-SkTxk5s0zVhuZtUAgtRBraNVoDoPwn79Z4Ow30oONiQEvuuiSI9HO9ZBqUScL6H3NZlz_Pd8YrqAzS1ZEzakwWIlrzPgcFFTIYekAXsMcJrn1U"/>
                    </div>

                    <div className="space-y-1">
                        <p className="product-card__category font-headline text-outline">
                            Bottoms
                        </p>

                        <h4 className="product-card__title font-headline">
                            Raw Edge Indigo Denim
                        </h4>

                        <p className="product-card__price font-headline">$180.00</p>
                    </div>
                </div>

                <div className="product-card group cursor-pointer">
                    <div className="product-card__media bg-surface-container-low">
                        <img data-alt="Minimalist black cap with logo"
                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuC-VuT5WyZGO-efphDrfxPu5Sv1SObuO5kuDYCbrOHZc5YPI-793qHpwdlGm1zD1SIE2h3c9cbr3UBORQsL-4tMiFuB4fhw866sakDvj-VxXMqfZEIZ0x5UXnGgqDmWVzKsyG85zJXh-skNTXlnUuPUVt6AE-3YJZLyizbCetfOxXSyPtZGtTuyEX6P5_W8hiu6U2Y01rveEuw025Y0v2UIFdbtVETk6SiGUthTZHr2auXnXQ561p3mvrS83j1mUa5PIK_cyKr3xMq_"/>

                        <img className="product-card__secondary-img"
                             data-alt="Side profile of black cap"
                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuC_05oj3zKc64SDCC_q7s8m3EzkSziOznTxzfSk-TRbn3F4CwMOeN7FGvImypNU2RArUs8pFXDDCLinOQqim9zfy-isofs4iGGMv-z6bbBMFp5yMOhyToM_frFDOrJm-N4XTE1V6qq01LErF5UEp9MbTYY4tVrcDnGpvYezcuGBiO2ZMFMRhaZ79L4LkkBvTWJiCUHGZmf9qv6kklDlFaFNI3n36gitQIBdGw7DdSYVH9gc1awd3-f6vKb_nOSSS7d6Rjz68gEPy1Fg"/>
                    </div>

                    <div className="space-y-1">
                        <p className="product-card__category font-headline text-outline">
                            Accessories
                        </p>

                        <h4 className="product-card__title font-headline">
                            Structured Logo Cap
                        </h4>

                        <p className="product-card__price font-headline">$45.00</p>
                    </div>
                </div>

                <div className="product-card group cursor-pointer">
                    <div className="product-card__media bg-surface-container-low">
                        <img data-alt="Neon blue windbreaker jacket"
                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuBEtJKg76TNMR10o6JsrbQnm81Xs3tcOmAaa6Lqpb31vOBFxoCgBah_JKjtB8S0mCbIL0FwU3aKxYSze6xeb0x9-bO-GgSNLPG73-ohdsSrVmt6Bzo8ZyxVN-DdgzanIquuuk2WBZM4H1unQxOgzwp9SpwqQi9yhqtRSG1ZApoSUblMVaxTG8ltuKdJeL2O_MugLYMLSWcSJy312hOpNH8jvDXqUTNGUXCIaLLaXD7SbZZ1LQTiZxpYuJ1z_nReyLh-L9EozkEiC0tk"/>

                        <img className="product-card__secondary-img"
                             data-alt="Model in blue windbreaker movement shot"
                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuBtPT6gBF00PPQvzP2TEFzCPT_BUcABKlc4e5uFeuqR7LZ3pyETPB7m7WptBNYPQ6eFo40O0Gb3o9YWnxznDmkPEyv9xRD5csXYpRm9BUdiBvRjeH35ZGRe8XjtzM5Pmh35jRABGuvcvev5qQ9jQdy3Ed4PXe01iSyG6kxHwlc3LEK1J6a6iTgf8wmO56aA6t-wMsASXt8c2w1Va7s_QhmLGKbNsMUUqTwyt5_Iaakd6Z1YKJFd7tLMnjxVc5_6W-RSbJDwx2FecbXw"/>
                    </div>

                    <div className="space-y-1">
                        <p className="product-card__category font-headline text-outline">Outerwear</p>

                        <h4 className="product-card__title font-headline">
                            Velocity Shell Jacket
                        </h4>

                        <p className="product-card__price font-headline">$220.00</p>
                    </div>
                </div>

                <div className="product-card group cursor-pointer">
                    <div className="product-card__media bg-surface-container-low">
                        <img data-alt="Minimalist black cap with logo"
                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuC-VuT5WyZGO-efphDrfxPu5Sv1SObuO5kuDYCbrOHZc5YPI-793qHpwdlGm1zD1SIE2h3c9cbr3UBORQsL-4tMiFuB4fhw866sakDvj-VxXMqfZEIZ0x5UXnGgqDmWVzKsyG85zJXh-skNTXlnUuPUVt6AE-3YJZLyizbCetfOxXSyPtZGtTuyEX6P5_W8hiu6U2Y01rveEuw025Y0v2UIFdbtVETk6SiGUthTZHr2auXnXQ561p3mvrS83j1mUa5PIK_cyKr3xMq_"/>

                        <img className="product-card__secondary-img"
                             data-alt="Side profile of black cap"
                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuC_05oj3zKc64SDCC_q7s8m3EzkSziOznTxzfSk-TRbn3F4CwMOeN7FGvImypNU2RArUs8pFXDDCLinOQqim9zfy-isofs4iGGMv-z6bbBMFp5yMOhyToM_frFDOrJm-N4XTE1V6qq01LErF5UEp9MbTYY4tVrcDnGpvYezcuGBiO2ZMFMRhaZ79L4LkkBvTWJiCUHGZmf9qv6kklDlFaFNI3n36gitQIBdGw7DdSYVH9gc1awd3-f6vKb_nOSSS7d6Rjz68gEPy1Fg"/>
                    </div>

                    <div className="space-y-1">
                        <p className="product-card__category font-headline text-outline">
                            Accessories
                        </p>

                        <h4 className="product-card__title font-headline">
                            Structured Logo Cap
                        </h4>

                        <p className="product-card__price font-headline">$45.00</p>
                    </div>
                </div>

                <div className="product-card group cursor-pointer">
                    <div className="product-card__media bg-surface-container-low">
                        <img data-alt="Black leather moto jacket"
                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuA9ZGFP3QyIHE2B0wFVxsihD0FsnJb8i7bgtdKvqiKwcwefxBatRFxvZ1g_LgkU8VQfmb5IRMLQr7v-LYTBEq56GcwGCY2fAAoqVNErcAUzOdImpSecTIYGUKutrGsNseti9z13sONpRrxIHXCdkzxRxaBgoDyXRxPVB5_-3mtf_wBEORNKWPHg7wmHjOuWi3aim71fJ7g0AumykbvBIJRfBCm8fdCjn039qBlj05hXYnpLIhQpoJ9e8B3ZasfTjUjFUU1XFTOfI9lc"/>

                        <img className="product-card__secondary-img"
                             data-alt="Leather jacket texture close up"
                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuAF0zdwixTUZ_-CQLjyhr7TaESuRUtzGzO633DiSxeKNOdf6kbhlWZneTZlBzpUiClohFoYdRbp1akGhJP4C66-YUVY2Ziz7_E7IprfplduEaMPorfvwkGUqHgP8fFwLlHlvd9Se1gqRJCF6dSH4j0A62H36Dhmnh14i7OvuZkiESM773vqr6aA8lFJK-GRJqLWt7gdSTN-zzuvUcpvphkWaTrP6m-tn-4O3DRIk-rmfTx8yrz5y7yA1N8wKPCryDb9MWeAibf_CA9J"/>
                    </div>

                    <div className="space-y-1">
                        <p className="product-card__category font-headline text-outline">Outerwear</p>

                        <h4 className="product-card__title font-headline">
                            Archival Moto Leather
                        </h4>

                        <p className="product-card__price font-headline">$550.00</p>
                    </div>
                </div>
            </div>

            <Pagination />
        </section>
    );
}
