import "../../../css/front/pages/profile/order.css";

export default function Order() {
    return (
        <section className="md:col-span-9">
            <div className="bg-surface-container-low p-1 border-0">
                <div className="overflow-x-auto">
                    <table className="order__table">
                        <thead>
                            <tr className="bg-surface-container-high">
                                <th className="order__table-tr text-header">
                                    ORDER
                                </th>
                                <th className="order__table-tr text-header">
                                    Date
                                </th>
                                <th className="order__table-tr text-header">
                                    Status
                                </th>
                                <th className="order__table-tr text-header text-right">
                                    Total
                                </th>
                                <th className="order__table-tr text-header" />
                            </tr>
                        </thead>

                        <tbody className="divide-y divide-surface-variant">
                            <tr className="hover:bg-white transition-colors group">
                                <td className="p-6">
                                    <div className="order__table-body">
                                        <div className="order__table-payload bg-neutral-200">
                                            <img
                                                alt="Product"
                                                className="order__table-img"
                                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBxLlf23X2QAevvgZF8_hQH0tEQ2R2zlOG5YlpRpNzu3rxgdmJWyotzR4kc9rkprjbO5tQPVCzlfNG9RQsWn7QcE0nKzRagqv9GQrX8vH11j-lmMNp4Z1xzomym8OJsyEcpy35rg3G17k5PP96yIB749rmjOhTLZBFj-xBeQsWsLApnjdc5s7tMlN0NikLsF6ZiFQfyMzILh8EQWl-fMXQYPi9SEKKVpnXND90xFNQGo7ePuThupc40aSfj-teEVKUCZ3SGnOdCAiZ3"
                                            />

                                            <span className="order__table-badge bg-neutral-900 text-white px-1">
                                                +2
                                            </span>
                                        </div>

                                        <span className="order__table-title font-mono  text-neutral-400">
                                            VW-882910-B
                                        </span>
                                    </div>
                                </td>

                                <td className="p-6 font-medium font-body uppercase text-sm">
                                    OCT 24, 2023
                                </td>

                                <td className="p-6">
                                    <span className="bg-primary text-white px-3 py-1 text-[10px] font-black uppercase tracking-wider">
                                        Delivered
                                    </span>
                                </td>

                                <td className="p-6 text-right font-bold text-lg">
                                    $442.00
                                </td>

                                <td className="p-6 text-right">
                                    <button className="text-primary font-black uppercase text-xs tracking-widest border-b-2 border-transparent hover:border-primary transition-all">
                                        View
                                    </button>
                                </td>
                            </tr>

                            <tr className="hover:bg-white transition-colors group">
                                <td className="p-6">
                                    <div className="order__table-body">
                                        <div className="order__table-payload bg-neutral-200">
                                            <img
                                                alt="Product"
                                                className="order__table-img"
                                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDn048w1qWrJu3kilL2jxc6ypd9nOMa4aM-C3yO_OeFxSKQplmDcvfvvDUfNoPCrEkjnM4i1TM8aE-CX9Z5ChIhLvNpGfPLFVKIw83339Ua9RBX1vOEi_hXvBrVLffa4zT56iDPoqewsD_7RWFGQ891oLDJv-hU5TwgN_G7nijiphHL0uSAwGFgK-yTlFR1-omFIk4hC3Q9ceBv2vw0GclWkGjFJDxLIxB3Lj2A-eW25EmzqZ4jYkfvct6Zzc62d5pajqzCP_SYEWaJ"
                                            />

                                            <span className="order__table-badge bg-neutral-900 text-white px-1">
                                                +1
                                            </span>
                                        </div>
                                        <span className="order__table-title font-mono text-neutral-400">
                                            VW-772154-A
                                        </span>
                                    </div>
                                </td>

                                <td className="order__table-date font-body">
                                    SEP 12, 2023
                                </td>

                                <td className="p-6">
                                    <span className="order__table-status bg-neutral-900  text-white">
                                        Shipped
                                    </span>
                                </td>

                                <td className="order__table-total">
                                    $1,205.50
                                </td>

                                <td className="p-6 text-right">
                                    <button className="order__table-view text-primary border-b-2 border-transparent hover:border-primary transition-all">
                                        View
                                    </button>
                                </td>
                            </tr>

                            <tr className="hover:bg-white transition-colors group">
                                <td className="p-6">
                                    <div className="order__table-body">
                                        <div className="order__table-payload bg-neutral-200">
                                            <img
                                                alt="Product"
                                                className="order__table-img"
                                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDIWIwLxphAhREdZlGTWmj46VCeimZ5ParzElB26fPbxTM1X6x5Oqbc8_vli_pixIhXF_jnYrDXrFKmj0yt2LlBH3le4vbrXYK8g8niOUsRFwp1vxlAyVxc62Axl2xudwVISWDn9o-XRTLPxV92_U98NEFLPSOmDcww-F2z8IZioifEsjqTynhn5t6Sms8_Uu_qOk9euwm7YsaSiMbfbdIr6cpuH3eDBhq-HJE2IPrb8aaL_GoP1pnqtzWUZOT8oqcchZ-sVj1c9dHp"
                                            />
                                        </div>
                                        <span className="order__table-title font-mono text-neutral-400">
                                            VW-661092-X
                                        </span>
                                    </div>
                                </td>

                                <td className="order__table-date font-body">
                                    AUG 05, 2023
                                </td>

                                <td className="p-6">
                                    <span className="order__table-status bg-neutral-300 text-neutral-800">
                                        Pending
                                    </span>
                                </td>

                                <td className="order__table-total">$89.00</td>

                                <td className="p-6 text-right">
                                    <button className="order__table-view text-primary border-b-2 border-transparent hover:border-primary transition-all">
                                        View
                                    </button>
                                </td>
                            </tr>

                            <tr className="hover:bg-white transition-colors group">
                                <td className="p-6">
                                    <div className="order__table-body">
                                        <div className="order__table-payload bg-neutral-200">
                                            <img
                                                alt="Product"
                                                className="order__table-img"
                                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBJhr8suLvtegEPXP8YDFLJDdzalRo6aCwc2IYXXJWRXDcg6kCETOdBW2Tnl-I-TD2RSWsf3DAM6gJ6QU_2J-1dU3fSWS3zlzro7U4go7dyh-QA4fVVMOPI7sEhAWKUrXgPVwmYv9PbKvldCZtCE3qRitadVdt6Sg8AO1WwcywfWtjSlBQlgOQgy_6jJnrSjktWBeURyWA3NOJ3CaJh7eC3NsNo2mW6uskPI-SjpEEgICdYWPCDfZYKl07IIxGS4WyJ7RGJgBm-Iz42"
                                            />
                                        </div>
                                        <span className="order__table-title font-mono text-neutral-400">
                                            VW-550912-C
                                        </span>
                                    </div>
                                </td>

                                <td className="order__table-date font-body">
                                    JUL 19, 2023
                                </td>

                                <td className="p-6">
                                    <span className="order__table-status bg-primary text-white">
                                        Delivered
                                    </span>
                                </td>

                                <td className="order__table-total">$312.00</td>

                                <td className="p-6 text-right">
                                    <button className="order__table-view text-primary border-b-2 border-transparent hover:border-primary transition-all">
                                        View
                                    </button>
                                </td>
                            </tr>
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
                        Track Your Shipments
                    </p>
                    <p className="text-sm text-neutral-600 font-body">
                        Real-time GPS tracking is available for all premium
                        members on orders over $500.
                    </p>
                </div>
            </div>
        </section>
    );
}
