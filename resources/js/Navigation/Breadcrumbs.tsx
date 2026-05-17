export default function Breadcrumbs() {
    return (
        <nav className="mb-12">
            <ol className="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-neutral-500 font-headline">
                <li>
                    <a className="hover:text-primary transition-colors" href="#">Home</a>

                    <span className="material-symbols-outlined text-[10px]" data-icon="chevron_right">
                            chevron_right
                    </span>
                </li>

                <li>
                    <a className="hover:text-primary transition-colors" href="#">Men</a>

                    <span className="material-symbols-outlined text-[10px]" data-icon="chevron_right">
                            chevron_right
                    </span>
                </li>

                <li className="text-on-surface">Jackets</li>
            </ol>
        </nav>
    );
}
