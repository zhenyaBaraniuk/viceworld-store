import "@css/front/pages/auth/auth-form.css";
import { Link, useForm } from "@inertiajs/react";
import { route } from "@/lib/route";
import { ArrowRight } from "lucide-react";

export default function RegisterForm() {
    const { data, processing, setData, post, errors } = useForm({
        first_name: "",
        last_name: "",
        email: "",
        password: "",
        password_confirmation: "",
    });

    const register = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(route("register.store"));
    };

    return (
        <div className="auth-form w-full max-w-[1440px] mx-auto px-6 flex justify-center border-t border-neutral-200">
            <div className="w-full max-w-xl bg-white p-8 md:p-16 flex flex-col justify-center">
                <div className="mb-12">
                    <h2 className="text-5xl font-black uppercase tracking-tighter mb-2 font-headline">
                        Registration
                    </h2>
                    <p className="text-neutral-500 font-medium">
                        Structure over comfort. Access starts here.
                    </p>
                </div>

                <form onSubmit={register} className="space-y-8">
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div className="relative group">
                            <label className="auth-form__label text-neutral-400">
                                First Name
                            </label>
                            <input
                                type="text"
                                placeholder="name"
                                value={data.first_name}
                                onChange={(e) =>
                                    setData("first_name", e.target.value)
                                }
                                className="auth-form__input border-neutral-200 placeholder:text-neutral-300"
                            />
                            {errors.first_name && (
                                <p className="auth-form__error text-primary">
                                    {errors.first_name}
                                </p>
                            )}
                        </div>

                        <div className="relative group">
                            <label className="auth-form__label text-neutral-400">
                                Last Name
                            </label>
                            <input
                                type="text"
                                placeholder="Last name"
                                value={data.last_name}
                                onChange={(e) =>
                                    setData("last_name", e.target.value)
                                }
                                className="auth-form__input border-neutral-200 placeholder:text-neutral-300"
                            />
                            {errors.last_name && (
                                <p className="auth-form__error text-primary">
                                    {errors.last_name}
                                </p>
                            )}
                        </div>
                    </div>
                    <div className="relative group">
                        <label className="auth-form__label text-neutral-400">
                            Email Address
                        </label>
                        <input
                            type="email"
                            value={data.email}
                            onChange={(e) => setData("email", e.target.value)}
                            placeholder="CORE@VICEWORLD.COM"
                            className="auth-form__input border-neutral-200 placeholder:text-neutral-300"
                        />
                        {errors.email && (
                            <p className="auth-form__error text-primary">
                                {errors.email}
                            </p>
                        )}
                    </div>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div className="relative group">
                            <label className="auth-form__label text-neutral-400">
                                Password
                            </label>
                            <input
                                type="password"
                                value={data.password}
                                onChange={(e) =>
                                    setData("password", e.target.value)
                                }
                                className="auth-form__input border-neutral-200 placeholder:text-neutral-300"
                                placeholder="••••••••"
                            />
                            {errors.password && (
                                <p className="auth-form__error text-primary">
                                    {errors.password}
                                </p>
                            )}
                        </div>
                        <div className="relative group">
                            <label className="auth-form__label text-neutral-400">
                                Confirm Password
                            </label>
                            <input
                                type="password"
                                value={data.password_confirmation}
                                onChange={(e) =>
                                    setData(
                                        "password_confirmation",
                                        e.target.value,
                                    )
                                }
                                className="auth-form__input border-neutral-200 placeholder:text-neutral-300"
                                placeholder="••••••••"
                            />
                        </div>
                    </div>

                    <div className="pt-6 space-y-4">
                        <button
                            type="submit"
                            disabled={processing}
                            className="auth-form__submit bg-primary text-white"
                        >
                            Create Account
                            <ArrowRight size={20} />
                        </button>

                        <div className="flex items-center justify-between">
                            <span className="text-xs uppercase font-bold text-neutral-400">
                                Already a member?
                            </span>
                            <Link
                                href={route("login")}
                                className="text-xs uppercase font-black tracking-widest border-b-2 border-neutral-900 pb-1 hover:text-primary hover:border-primary transition-all"
                            >
                                Sign In
                            </Link>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    );
}
