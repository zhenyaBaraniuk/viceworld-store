import "../../../css/front/pages/profile/order.css";
import { ReactNode } from "react";
import { usePage } from "@inertiajs/react";
import { useTranslation } from "@/hooks/useTranslation";
import type { OrderProps } from "@/types/pages/profile";
import type { OrderStatus } from "@/types/models/order";
import SiteLayout from "@/Layouts/SiteLayout";
import ProfileLayout from "@/Layouts/ProfileLayout";

const STATUS_STYLES: Record<OrderStatus, { label: string; className: string }> =
    {
        pending: {
            label: "profile.order_status_pending",
            className: "bg-neutral-300 text-neutral-800",
        },
        paid: {
            label: "profile.order_status_paid",
            className: "bg-primary text-white",
        },
        processing: {
            label: "profile.order_status_processing",
            className: "bg-neutral-900 text-white",
        },
        shipped: {
            label: "profile.order_status_shipped",
            className: "bg-neutral-900 text-white",
        },
        delivered: {
            label: "profile.order_status_delivered",
            className: "bg-primary text-white",
        },
        cancelled: {
            label: "profile.order_status_cancelled",
            className: "bg-error-container text-error",
        },
        refunded: {
            label: "profile.order_status_refunded",
            className: "bg-neutral-300 text-neutral-800",
        },
    };

function Orders({ orders }: OrderProps) {
    const { t } = useTranslation();
    const { locale } = usePage<{ locale: string }>().props;

    const formatDate = (iso: string) =>
        new Date(iso).toLocaleDateString(locale, {
            day: "2-digit",
            month: "short",
            year: "numeric",
        });

    const formatTotal = (amount: string) =>
        new Intl.NumberFormat(locale, {
            style: "currency",
            currency: "UAH",
        }).format(Number(amount));

    return (
        <>
            <div className="bg-surface-container-low p-1 border-0">
                <div className="overflow-x-auto">
                    <table className="order__table">
                        <thead>
                            <tr className="bg-surface-container-high">
                                <th className="order__table-tr text-header">
                                    {t("profile.order_table_order_header")}
                                </th>
                                <th className="order__table-tr text-header">
                                    {t("profile.order_table_date_header")}
                                </th>
                                <th className="order__table-tr text-header">
                                    {t("profile.order_table_status_header")}
                                </th>
                                <th className="order__table-tr text-header text-right">
                                    {t("profile.order_table_total_header")}
                                </th>
                                <th className="order__table-tr text-header" />
                            </tr>
                        </thead>

                        <tbody className="divide-y divide-surface-variant">
                            {orders.length === 0 && (
                                <tr>
                                    <td
                                        colSpan={5}
                                        className="p-6 text-center text-neutral-500 font-body"
                                    >
                                        {t("profile.orders_empty")}
                                    </td>
                                </tr>
                            )}

                            {orders.map((order) => {
                                const status = STATUS_STYLES[order.status];

                                return (
                                    <tr
                                        key={order.id}
                                        className="hover:bg-white transition-colors group"
                                    >
                                        <td className="p-6">
                                            <div className="order__table-body">
                                                <div className="order__table-payload bg-neutral-200">
                                                    {order.image && (
                                                        <img
                                                            alt={t(
                                                                "profile.order_product_alt",
                                                            )}
                                                            className="order__table-img"
                                                            src={
                                                                order.image.url
                                                            }
                                                        />
                                                    )}

                                                    {order.items_count > 1 && (
                                                        <span className="order__table-badge bg-neutral-900 text-white px-1">
                                                            +
                                                            {order.items_count -
                                                                1}
                                                        </span>
                                                    )}
                                                </div>
                                            </div>
                                        </td>

                                        <td className="order__table-date font-body">
                                            {formatDate(order.created_at)}
                                        </td>

                                        <td className="p-6">
                                            <span
                                                className={`order__table-status ${status.className}`}
                                            >
                                                {t(status.label)}
                                            </span>
                                        </td>

                                        <td className="order__table-total">
                                            {formatTotal(order.total_amount)}
                                        </td>

                                        <td className="p-6 text-right">
                                            <button className="order__table-view text-primary border-b-2 border-transparent hover:border-primary transition-all">
                                                {t("profile.order_view_button")}
                                            </button>
                                        </td>
                                    </tr>
                                );
                            })}
                        </tbody>
                    </table>
                </div>
            </div>

            <div className="mt-12 p-8 border-t-[4px] border-primary bg-surface-container-high flex items-center space-x-6">
                <div className="bg-white p-4">
                    <span
                        className="material-symbols-outlined text-4xl text-primary"
                        data-icon="local_shipping"
                    >
                        local_shipping
                    </span>
                </div>

                <div>
                    <p className="text-header font-black text-xl">
                        {t("profile.track_shipments_title")}
                    </p>
                    <p className="text-sm text-neutral-600 font-body">
                        {t("profile.track_shipments_text")}
                    </p>
                </div>
            </div>
        </>
    );
}

Orders.layout = (page: ReactNode) => (
    <SiteLayout>
        <ProfileLayout>{page}</ProfileLayout>
    </SiteLayout>
);

export default Orders;
