type ButtonProps = {
    children: React.ReactNode;
    variant?: "primary" | "secondary";
    onClick?: () => void;
};
export default function Button({
    children,
    variant = "primary",
    onClick,
}: ButtonProps) {
    const styles = {
        primary: "bg-primary text-white",
        secondary: "bg-neutral-900 text-white",
    };

    return (
        <button
            onClick={onClick}
            className={`${styles[variant]} px-6 py-3 uppercase font-display font-bold tracking-tight text-sm active:scale-95
  transition-transform duration-100`}
        >
            {children}
        </button>
    );
}
