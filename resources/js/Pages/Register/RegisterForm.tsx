import "@css/front/pages/auth/auth-form.css";
import { Link, useForm } from "@inertiajs/react";
import { route } from "@/lib/route";
import { ArrowRight } from "lucide-react";
import FormField from "@/UI/FormField";

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
                        <FormField
                            className="relative"
                            type="text"
                            placeholder="name"
                            label="First Name"
                            value={data.first_name}
                            onChange={(value) => setData("first_name", value)}
                            error={errors.first_name}
                        />

                        <FormField
                            className="relative"
                            type="text"
                            placeholder="last name"
                            label="Last Name"
                            value={data.last_name}
                            onChange={(value) => setData("last_name", value)}
                            error={errors.last_name}
                        />
                    </div>

                    <FormField
                        className="relative"
                        type="email"
                        placeholder="CORE@VICEWORLD.COM"
                        label="Email Address"
                        value={data.email}
                        onChange={(value) => setData("email", value)}
                        error={errors.email}
                    />

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <FormField
                            className="relative"
                            type="password"
                            placeholder="••••••••"
                            label="Password"
                            value={data.password}
                            onChange={(value) => setData("password", value)}
                            error={errors.password}
                        />

                        <FormField
                            className="relative"
                            type="password"
                            placeholder="••••••••"
                            label="Confirm Password"
                            value={data.password_confirmation}
                            onChange={(value) =>
                                setData("password_confirmation", value)
                            }
                            error={errors.password_confirmation}
                        />
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
