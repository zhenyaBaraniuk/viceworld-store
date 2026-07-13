import AdditionalProducts from "./AdditionalProducts";
import Breadcrumbs from "../../Navigation/Breadcrumbs";
import Product from "./Product";
import { route } from "@/lib/route";
import type { ProductProps } from "@/types";
import SiteLayout from "@/Layouts/SiteLayout";
import { ReactNode } from "react";

function ProductPage({ product, category, related_products }: ProductProps) {
    return (
        <div className="max-w-[1440px] mx-auto px-6 md:px-12 pb-24 pt-20">
            <Breadcrumbs
                items={[
                    { label: "Home", href: "/" },
                    {
                        label: category.name,
                        href: route("catalog.show", {
                            slug: category.slug,
                        }),
                    },
                    { label: product.name },
                ]}
            />

            <Product product={product} />
            <AdditionalProducts related_products={related_products} />
        </div>
    );
}

ProductPage.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>;

export default ProductPage;
