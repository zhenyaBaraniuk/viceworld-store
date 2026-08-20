import "@css/front/components/form-field.css";
import "@css/front/components/field-error.css";
import clsx from "clsx";

type FormFieldProps = {
    label: string;
    type?: string;
    placeholder?: string;
    value: string;
    onChange: (value: string) => void;
    error?: string;
    className?: string;
};

export default function FormField({
    label,
    type = "text",
    placeholder,
    value,
    onChange,
    error,
    className,
}: FormFieldProps) {
    return (
        <div className={clsx("group", className)}>
            <label className="form-field__label text-neutral-400">
                {label}
            </label>
            <input
                type={type}
                placeholder={placeholder}
                value={value}
                onChange={(e) => onChange(e.target.value)}
                className="form-field__input border-neutral-200 placeholder:text-neutral-300"
            />
            {error && <p className="field-error text-primary">{error}</p>}
        </div>
    );
}
