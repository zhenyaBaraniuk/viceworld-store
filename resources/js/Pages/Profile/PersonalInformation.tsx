import "../../../css/front/components/watermark.css";
import "../../../css/front/pages/profile/profile-header.css";
import "../../../css/front/pages/profile/profile-form.css";
import { ReactNode } from "react";
import SiteLayout from "@/Layouts/SiteLayout";
import { ProfileProps } from "@/types/pages/profile";
import { useForm } from "@inertiajs/react";
import { route } from "@/lib/route";
import ProfileLayout from "@/Layouts/ProfileLayout";

function PersonalInformation({ customer }: ProfileProps) {
    const { data, processing, setData, post, errors } = useForm({
        first_name: customer.first_name,
        last_name: customer.last_name,
        email: customer.email,
        phone: customer.phone ?? "",
    });

    const updateCustomerData = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();
        post(route("account.update"));
    };

    return (
        <form onSubmit={updateCustomerData}>
            <div className="watermark">
                <span className="watermark__text">PROFILE</span>
            </div>

            <div className="profile-header">
                <h1 className="profile-header__title text-neutral-900 dark:text-white">
                    PERSONAL <br />
                    INFORMATION
                </h1>

                <div className="profile-form">
                    <div className="group">
                        <label className="profile-form__label text-neutral-400 group-hover:text-primary">
                            First Name
                        </label>
                        <div className="profile-form__input-wrap border-neutral-200 dark:border-neutral-800">
                            <input
                                type="text"
                                placeholder="name"
                                value={data.first_name}
                                onChange={(e) =>
                                    setData("first_name", e.target.value)
                                }
                                className="profile-form__input text-neutral-900 dark:text-white"
                            />
                        </div>
                        {errors.first_name && (
                            <p className="auth-form__error text-primary">
                                {errors.first_name}
                            </p>
                        )}
                    </div>
                    <div className="group">
                        <label className="profile-form__label text-neutral-400 group-hover:text-primary">
                            Last Name
                        </label>
                        <div className="profile-form__input-wrap border-neutral-200 dark:border-neutral-800">
                            <input
                                type="text"
                                placeholder="last name"
                                value={data.last_name}
                                onChange={(e) =>
                                    setData("last_name", e.target.value)
                                }
                                className="profile-form__input text-neutral-900 dark:text-white"
                            />
                        </div>
                        {errors.last_name && (
                            <p className="auth-form__error text-primary">
                                {errors.last_name}
                            </p>
                        )}
                    </div>
                    <div className="group md:col-span-2">
                        <label className="profile-form__label text-neutral-400 group-hover:text-primary">
                            Email Address
                        </label>
                        <div className="profile-form__input-wrap border-neutral-200 dark:border-neutral-800 flex justify-between items-center">
                            <input
                                type="email"
                                placeholder="email"
                                value={data.email}
                                onChange={(e) =>
                                    setData("email", e.target.value)
                                }
                                className="profile-form__input text-neutral-900 dark:text-white"
                            />
                            <span className="material-symbols-outlined text-neutral-300">
                                verified
                            </span>
                        </div>
                        {errors.email && (
                            <p className="auth-form__error text-primary">
                                {errors.email}
                            </p>
                        )}
                    </div>
                    <div className="group md:col-span-2">
                        <label className="profile-form__label text-neutral-400 group-hover:text-primary">
                            Phone
                        </label>
                        <div className="profile-form__input-wrap border-neutral-200 dark:border-neutral-800">
                            <input
                                type="tel"
                                placeholder="phone"
                                value={data.phone}
                                onChange={(e) =>
                                    setData("phone", e.target.value)
                                }
                                className="profile-form__input text-neutral-900 dark:text-white"
                            />
                        </div>
                        {errors.phone && (
                            <p className="auth-form__error text-primary">
                                {errors.phone}
                            </p>
                        )}
                    </div>
                </div>

                <div className="mt-20">
                    <button
                        type="submit"
                        disabled={processing}
                        className="profile-form__button bg-primary text-white font-display"
                    >
                        <span className="relative z-10 text-xl">
                            EDIT PROFILE
                        </span>
                        <div className="profile-form__button-bg bg-neutral-900 " />
                    </button>
                </div>
            </div>
        </form>
    );
}

PersonalInformation.layout = (page: ReactNode) => (
    <SiteLayout>
        <ProfileLayout>{page}</ProfileLayout>
    </SiteLayout>
);

export default PersonalInformation;
