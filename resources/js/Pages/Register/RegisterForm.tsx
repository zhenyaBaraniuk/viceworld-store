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
        <div className="w-full max-w-[1440px] mx-auto px-6 flex justify-center border-t border-neutral-200">
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
                            <label className="block text-[10px] uppercase font-bold tracking-widest text-neutral-400 mb-1">
                                First Name
                            </label>
                            <input
                                type="text"
                                placeholder="name"
                                value={data.first_name}
                                onChange={(e) =>
                                    setData("first_name", e.target.value)
                                }
                                className="w-full bg-transparent border-t-0 border-x-0 border-b-2 border-neutral-200 py-3 font-headline font-bold uppercase tracking-tight input-brutalist transition-all placeholder:text-neutral-300"
                            />
                            {errors.first_name && (
                                <p className="text-primary text-sm mt-1">
                                    {errors.first_name}
                                </p>
                            )}
                        </div>

                        <div className="relative group">
                            <label className="block text-[10px] uppercase font-bold tracking-widest text-neutral-400 mb-1">
                                Last Name
                            </label>
                            <input
                                type="text"
                                placeholder="Last name"
                                value={data.last_name}
                                onChange={(e) =>
                                    setData("last_name", e.target.value)
                                }
                                className="w-full bg-transparent border-t-0 border-x-0 border-b-2 border-neutral-200 py-3 font-headline font-bold uppercase tracking-tight input-brutalist transition-all placeholder:text-neutral-300"
                            />
                            {errors.last_name && (
                                <p className="text-primary text-sm mt-1">
                                    {errors.last_name}
                                </p>
                            )}
                        </div>
                    </div>
                    <div className="relative group">
                        <label className="block text-[10px] uppercase font-bold tracking-widest text-neutral-400 mb-1">
                            Email Address
                        </label>
                        <input
                            type="email"
                            className="w-full bg-transparent border-t-0 border-x-0 border-b-2 border-neutral-200 py-3 font-headline font-bold uppercase tracking-tight input-brutalist transition-all placeholder:text-neutral-300"
                            value={data.email}
                            onChange={(e) => setData("email", e.target.value)}
                            placeholder="CORE@VICEWORLD.COM"
                        />
                        {errors.email && (
                            <p className="text-primary text-sm mt-1">
                                {errors.email}
                            </p>
                        )}
                    </div>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div className="relative group">
                            <label className="block text-[10px] uppercase font-bold tracking-widest text-neutral-400 mb-1">
                                Password
                            </label>
                            <input
                                type="password"
                                value={data.password}
                                onChange={(e) =>
                                    setData("password", e.target.value)
                                }
                                className="w-full bg-transparent border-t-0 border-x-0 border-b-2 border-neutral-200 py-3 font-headline font-bold uppercase tracking-tight input-brutalist transition-all placeholder:text-neutral-300"
                                placeholder="••••••••"
                            />
                            {errors.password && (
                                <p className="text-primary text-sm mt-1">
                                    {errors.password}
                                </p>
                            )}
                        </div>
                        <div className="relative group">
                            <label className="block text-[10px] uppercase font-bold tracking-widest text-neutral-400 mb-1">
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
                                className="w-full bg-transparent border-t-0 border-x-0 border-b-2 border-neutral-200 py-3 font-headline font-bold uppercase tracking-tight input-brutalist transition-all placeholder:text-neutral-300"
                                placeholder="••••••••"
                            />
                        </div>
                    </div>

                    <div className="pt-6 space-y-4">
                        <button
                            type="submit"
                            disabled={processing}
                            className="w-full bg-primary text-white font-headline font-black uppercase text-xl py-5 tracking-tighter btn-hover-effect transition-transform flex justify-between items-center px-8"
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
