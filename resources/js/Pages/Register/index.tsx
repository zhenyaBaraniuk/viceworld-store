import { ReactNode } from "react";
import SiteLayout from "@/Layouts/SiteLayout";
import RegisterForm from "@/Pages/Register/RegisterForm";

function Register() {
    return (
        <main className="min-h-screen pt-24 pb-12 flex items-center justify-center">
            <RegisterForm />
        </main>
    );
}

Register.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>;

export default Register;
