import "@css/front/pages/auth/auth-form.css";
import {ArrowRight} from "lucide-react";
import {Link, useForm} from "@inertiajs/react";
import {route} from "@/lib/route";
import FormField from "@/UI/FormField";

export default function LoginForm() {
    const {data, processing, setData, post, errors} = useForm({
        email: "",
        password: "",
        remember_me: false,
    });

    const login = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(route("login.check"));
    };

    return (
        <div
            className="auth-form w-full max-w-md bg-white border border-transparent shadow-none p-8 md:p-12 relative z-10">
            <div className="mb-10">
                <h1 className="text-4xl font-black uppercase tracking-[-0.03em] leading-none mb-2">
                    Login
                </h1>
                <p className="text-neutral-500 text-sm tracking-tight">
                    Access your V!ceWorld account.
                </p>
            </div>

            <form onSubmit={login} className="space-y-8">
                <FormField
                    label="Email Address"
                    type="email"
                    placeholder="YOUR@EMAIL.COM"
                    value={data.email}
                    onChange={(value) => setData("email", value)}
                    error={errors.email}
                />

                <FormField
                    label="Password"
                    type="password"
                    placeholder="••••••••"
                    value={data.password}
                    onChange={(value) => setData("password", value)}
                    error={errors.password}
                />

                <div className="flex items-center justify-between text-xs font-bold uppercase tracking-tight">
                    <label className="flex items-center cursor-pointer select-none">
                        <input
                            type="checkbox"
                            checked={data.remember_me}
                            onChange={(e) =>
                                setData("remember_me", e.target.checked)
                            }
                            className="w-4 h-4 text-primary border-2 border-neutral-300 focus:ring-0 mr-2"
                        />

                        <span>Remember Me</span>
                    </label>
                </div>

                <button
                    type="submit"
                    disabled={processing}
                    className="auth-form__submit bg-primary text-white"
                >
                    Login
                    <ArrowRight className="transition-transform" size={20} />
                </button>
            </form>

            <div className="mt-8 pt-8 border-t border-neutral-100 text-center">
                <p className="text-xs font-bold uppercase tracking-tight">
                    <span className="text-neutral-400">
                        Don't have an account?
                    </span>
                    <Link
                        href={route("register")}
                        className="text-primary hover:underline underline-offset-4 ml-1"
                    >
                        Create One
                    </Link>
                </p>
            </div>
        </div>
    );
}
