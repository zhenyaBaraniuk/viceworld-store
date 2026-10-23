import "@css/front/components/password-input.css";
import { Eye, EyeOff } from "lucide-react";
import { InputHTMLAttributes, useState } from "react";
import { useTranslation } from "@/hooks/useTranslation";

type PasswordInputProps = Omit<InputHTMLAttributes<HTMLInputElement>, "type">;

export default function PasswordInput(props: PasswordInputProps) {
    const { t } = useTranslation();
    const [visible, setVisible] = useState(false);
    const Icon = visible ? EyeOff : Eye;

    return (
        <div className="password-input">
            <input {...props} type={visible ? "text" : "password"} />
            <button
                type="button"
                className="password-input__toggle"
                onClick={() => setVisible((v) => !v)}
                aria-pressed={visible}
                aria-label={t(
                    visible ? "common.hide_password" : "common.show_password",
                )}
            >
                <Icon size={20} />
            </button>
        </div>
    );
}
