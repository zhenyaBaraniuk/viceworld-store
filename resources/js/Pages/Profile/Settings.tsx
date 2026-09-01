import "../../../css/front/components/watermark.css";
import "../../../css/front/pages/profile/profile-header.css";
import "../../../css/front/pages/profile/profile-form.css";
import "@css/front/components/field-error.css";
import { ReactNode } from "react";
import SiteLayout from "@/Layouts/SiteLayout";
import { ProfileProps } from "@/types/pages/profile";
import { useForm } from "@inertiajs/react";
import { route } from "@/lib/route";
import ProfileLayout from "@/Layouts/ProfileLayout";

function Settings({ customer }: ProfileProps) {
    const passwordForm = useForm({
        current_password: "",
        new_password: "",
    });

    const addressForm = useForm({
        city: customer.address?.city ?? "",
        street: customer.address?.street ?? "",
        building: customer.address?.building ?? "",
        apartment: customer.address?.apartment ?? "",
    });

    const submitPassword = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        passwordForm.post(route("account.settings.password"), {
            onSuccess: () => passwordForm.reset(),
        });
    };

    const submitAddress = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        addressForm.post(route("account.settings.address"), {
            onSuccess: () => addressForm.reset(),
        });
    };

    return (
        <>
            <div className="watermark">
                <span className="watermark__text">SETTINGS</span>
            </div>

            <div className="profile-header">
                <h1 className="profile-header__title text-neutral-900 dark:text-white">
                    Settings
                </h1>

                <div className="space-y-24">
                    <section>
                        <form onSubmit={submitPassword}>
                            <div className="flex items-center gap-4 mb-8">
                                <span className="h-px flex-1 bg-on-surface" />
                                <h2 className="text-2xl font-black">
                                    Security
                                </h2>
                            </div>
                            <div className="profile-form">
                                <div className="flex flex-col gap-2">
                                    <div className="group">
                                        <label className="profile-form__label text-neutral-400 group-hover:text-primary">
                                            Current Password
                                        </label>
                                        <div className="profile-form__input-wrap border-neutral-200 dark:border-neutral-800">
                                            <input
                                                type="password"
                                                value={
                                                    passwordForm.data
                                                        .current_password
                                                }
                                                onChange={(e) =>
                                                    passwordForm.setData(
                                                        "current_password",
                                                        e.target.value,
                                                    )
                                                }
                                                className="profile-form__input text-neutral-900 dark:text-white"
                                                placeholder="••••••••"
                                            />
                                        </div>
                                        {passwordForm.errors
                                            .current_password && (
                                            <p className="field-error text-primary">
                                                {
                                                    passwordForm.errors
                                                        .current_password
                                                }
                                            </p>
                                        )}
                                    </div>
                                </div>
                                <div className="flex flex-col gap-2">
                                    <div className="group">
                                        <label className="profile-form__label text-neutral-400 group-hover:text-primary">
                                            New Password
                                        </label>
                                        <div className="profile-form__input-wrap border-neutral-200 dark:border-neutral-800">
                                            <input
                                                type="password"
                                                value={
                                                    passwordForm.data
                                                        .new_password
                                                }
                                                onChange={(e) =>
                                                    passwordForm.setData(
                                                        "new_password",
                                                        e.target.value,
                                                    )
                                                }
                                                className="profile-form__input text-neutral-900 dark:text-white"
                                                placeholder="MIN 8 CHARS"
                                            />
                                        </div>
                                        {passwordForm.errors.new_password && (
                                            <p className="field-error text-primary">
                                                {
                                                    passwordForm.errors
                                                        .new_password
                                                }
                                            </p>
                                        )}
                                    </div>
                                </div>
                            </div>
                            <div className="mt-20">
                                <button
                                    type="submit"
                                    disabled={passwordForm.processing}
                                    className="profile-form__button bg-primary text-white"
                                >
                                    <span className="relative z-10 text-xl">
                                        Save Password
                                    </span>
                                    <div className="profile-form__button-bg bg-neutral-900" />
                                </button>
                            </div>
                        </form>
                    </section>

                    <section>
                        <form onSubmit={submitAddress}>
                            <div className="flex items-center gap-4 mb-8">
                                <span className="h-px flex-1 bg-on-surface" />
                                <h2 className="text-2xl font-black">
                                    Shipping Address
                                </h2>
                            </div>
                            <div className="profile-form">
                                <div className="flex flex-col gap-2 md:col-span-2">
                                    <div className="group">
                                        <label className="profile-form__label text-neutral-400 group-hover:text-primary">
                                            Street Address
                                        </label>
                                        <div className="profile-form__input-wrap border-neutral-200 dark:border-neutral-800">
                                            <input
                                                type="text"
                                                placeholder="BERLINER STRASSE 102"
                                                value={addressForm.data.street}
                                                onChange={(e) =>
                                                    addressForm.setData(
                                                        "street",
                                                        e.target.value,
                                                    )
                                                }
                                                className="profile-form__input text-neutral-900 dark:text-white"
                                            />
                                        </div>
                                        {addressForm.errors.street && (
                                            <p className="field-error text-primary">
                                                {addressForm.errors.street}
                                            </p>
                                        )}
                                    </div>
                                </div>
                                <div className="flex flex-col gap-2">
                                    <div className="group">
                                        <label className="profile-form__label text-neutral-400 group-hover:text-primary">
                                            Building / Name
                                        </label>
                                        <div className="profile-form__input-wrap border-neutral-200 dark:border-neutral-800">
                                            <input
                                                type="text"
                                                placeholder="METROPOL TOWER"
                                                value={
                                                    addressForm.data.building
                                                }
                                                onChange={(e) =>
                                                    addressForm.setData(
                                                        "building",
                                                        e.target.value,
                                                    )
                                                }
                                                className="profile-form__input text-neutral-900 dark:text-white"
                                            />
                                        </div>
                                        {addressForm.errors.building && (
                                            <p className="field-error text-primary">
                                                {addressForm.errors.building}
                                            </p>
                                        )}
                                    </div>
                                </div>
                                <div className="flex flex-col gap-2">
                                    <div className="group">
                                        <label className="profile-form__label text-neutral-400 group-hover:text-primary">
                                            Apartment / Suite
                                        </label>
                                        <div className="profile-form__input-wrap border-neutral-200 dark:border-neutral-800">
                                            <input
                                                type="text"
                                                placeholder="APT 4B"
                                                value={
                                                    addressForm.data
                                                        .apartment ?? ""
                                                }
                                                onChange={(e) =>
                                                    addressForm.setData(
                                                        "apartment",
                                                        e.target.value,
                                                    )
                                                }
                                                className="profile-form__input text-neutral-900 dark:text-white"
                                            />
                                        </div>
                                        {addressForm.errors.apartment && (
                                            <p className="field-error text-primary">
                                                {addressForm.errors.apartment}
                                            </p>
                                        )}
                                    </div>
                                </div>
                                <div className="flex flex-col gap-2">
                                    <div className="group">
                                        <label className="profile-form__label text-neutral-400 group-hover:text-primary">
                                            City
                                        </label>
                                        <div className="profile-form__input-wrap border-neutral-200 dark:border-neutral-800">
                                            <input
                                                type="text"
                                                placeholder="BERLIN"
                                                value={
                                                    addressForm.data.city ?? ""
                                                }
                                                onChange={(e) =>
                                                    addressForm.setData(
                                                        "city",
                                                        e.target.value,
                                                    )
                                                }
                                                className="profile-form__input text-neutral-900 dark:text-white"
                                            />
                                        </div>
                                        {addressForm.errors.city && (
                                            <p className="field-error text-primary">
                                                {addressForm.errors.city}
                                            </p>
                                        )}
                                    </div>
                                </div>
                            </div>

                            <div className="mt-20">
                                <button
                                    type="submit"
                                    disabled={addressForm.processing}
                                    className="profile-form__button bg-primary text-white"
                                >
                                    <span className="relative z-10 text-xl">
                                        Save Changes
                                    </span>
                                    <div className="profile-form__button-bg bg-neutral-900" />
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </>
    );
}

Settings.layout = (page: ReactNode) => (
    <SiteLayout>
        <ProfileLayout>{page}</ProfileLayout>
    </SiteLayout>
);

export default Settings;
