import '../../../css/front/pages/profile/navigation.css';

export default function Navigation() {
    return (
        <aside className="navigation md:col-span-3">
            <nav className="navigation__nav">
                <a className="navigation__nav-link bg-primary text-white font-display group"
                   href="/account/orders">
                    <span>Orders</span>

                    <span className="material-symbols-outlined group-hover:translate-x-1 transition-transform"
                          data-icon="arrow_forward">
                                arrow_forward
                    </span>
                </a>

                <a className="navigation__nav-link text-neutral-500 hover:text-neutral-900 font-display bg-surface-container-low transition-all"
                   href="/account/profile"
                >
                    <span>Profile</span>
                </a>

                <a className="navigation__nav-link text-neutral-500 hover:text-neutral-900 font-display bg-surface-container-low transition-all"
                   href="/account/settings"
                >
                    <span>Settings</span>
                </a>

                <a className="navigation__nav-link text-error font-display mt-12 hover:bg-error-container transition-all"
                   href="/logout"
                >
                    <span>Log Out</span>
                </a>
            </nav>
        </aside>
    );
}
