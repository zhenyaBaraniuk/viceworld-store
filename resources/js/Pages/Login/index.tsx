import { ReactNode } from "react";
import SiteLayout from "@/Layouts/SiteLayout";
import LoginForm from "@/Pages/Login/LoginForm";

function Login() {
    return (
        <main className="min-h-screen pt-24 pb-12 flex items-center justify-center">
            <LoginForm />
        </main>
    );
}

Login.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>;

export default Login;
