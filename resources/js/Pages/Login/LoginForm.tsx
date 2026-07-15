import { ArrowRight } from "lucide-react";
import { Link, useForm } from "@inertiajs/react";
import { route } from "@/lib/route";

export default function LoginForm() {
    const { data, processing, setData, post, errors } = useForm({
        email: "",
        password: "",
        remember_me: false,
    });

    const login = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(route("login.check"));
    };

    return (
        <div className="w-full max-w-md bg-white border border-transparent shadow-none p-8 md:p-12 relative z-10">
            <div className="mb-10">
                <h1 className="text-4xl font-black uppercase tracking-[-0.03em] leading-none mb-2">
                    Login
                </h1>
                <p className="text-neutral-500 text-sm tracking-tight">
                    Access your V!ceWorld account.
                </p>
            </div>

            <form onSubmit={login} className="space-y-8">
                <div className="group">
                    <label className="block font-headline text-xs font-bold uppercase tracking-widest mb-2 group-focus-within:text-primary transition-colors">
                        Email Address
                    </label>
                    <input
                        type="email"
                        placeholder="YOUR@EMAIL.COM"
                        value={data.email}
                        onChange={(e) => setData("email", e.target.value)}
                        className="w-full bg-surface-container-low border-0 border-b-2 border-outline-variant px-0 py-3 text-lg font-bold focus:border-primary transition-all sharp-edge placeholder:text-neutral-300"
                    />
                    {errors.email && (
                        <p className="text-primary text-sm mt-1">
                            {errors.email}
                        </p>
                    )}
                </div>

                <div className="group">
                    <label className="block font-headline text-xs font-bold uppercase tracking-widest mb-2 group-focus-within:text-primary transition-colors">
                        Password
                    </label>
                    <input
                        type="password"
                        placeholder="••••••••"
                        value={data.password}
                        onChange={(e) => setData("password", e.target.value)}
                        className="w-full bg-surface-container-low border-0 border-b-2 border-outline-variant px-0 py-3 text-lg font-bold focus:border-primary transition-all sharp-edge placeholder:text-neutral-300"
                    />
                    {errors.password && (
                        <p className="text-primary text-sm mt-1">
                            {errors.password}
                        </p>
                    )}
                </div>

                <div className="flex items-center justify-between text-xs font-bold uppercase tracking-tight font-headline">
                    <label className="flex items-center cursor-pointer select-none">
                        <input
                            type="checkbox"
                            checked={data.remember_me}
                            onChange={(e) =>
                                setData("remember_me", e.target.checked)
                            }
                            className="w-4 h-4 text-primary border-2 border-on-surface focus:ring-0 sharp-edge mr-2"
                        />

                        <span>Remember Me</span>
                    </label>
                </div>

                <button
                    type="submit"
                    disabled={processing}
                    className="w-full bg-[#0066FF] text-white py-5 px-6 flex items-center justify-between group active:scale-95 transition-all duration-100 sharp-edge"
                >
                    <span className="font-headline font-black text-xl tracking-tighter uppercase">
                        Login
                    </span>
                    <ArrowRight
                        className="material-symbols-outlined group-hover:translate-x-1 transition-transform"
                        size={20}
                    />
                </button>
            </form>

            <div className="mt-8 pt-8 border-t border-neutral-100 text-center">
                <p className="text-xs font-bold font-headline uppercase tracking-tight">
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
