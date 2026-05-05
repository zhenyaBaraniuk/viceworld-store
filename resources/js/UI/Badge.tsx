type BadgeProps = {
    children: React.ReactNode,
    variant?: string,
}
export default function Badge({children, variant}: BadgeProps) {
    const styles: Record<string, string> = {
        default: 'bg-neutral-200 text-neutral-900',
        delivered: 'bg-primary text-white',
        shipped: 'bg-neutral-900 text-white',
        pending: 'bg-neutral-200 text-neutral-900',
    }

    return (
        <span className={`${styles[variant ?? 'default']} px-3 py-1 text-[10px] font-black uppercase tracking-wider`}>
            {children}
        </span>
    );
}
