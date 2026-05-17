import '../../css/front/components/header.css';
import { useState } from 'react'
import {Search, User, ShoppingBag, Moon, Sun} from 'lucide-react'

export default function Header() {
    const [theme, setTheme] = useState<'light' | 'dark'>('light');
    const toggleTheme = () => { const next = theme === 'light' ? 'dark' : 'light';
        setTheme(next);

        if (next == 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }

    return (
        <header className="navbar bg-surface dark:bg-neutral-900 border-neutral-100 dark:border-neutral-800">
            <div className="navbar__inner">
                <div className="navbar__left">
                    <a className="navbar__logo text-neutral-900 dark:text-white" href="/">
                        V<span className="text-primary">!</span>ceWorld
                    </a>

                    <nav className="navbar__nav hidden md:flex">
                        <a className="nav-link nav-link--active text-primary dark:text-primary border-primary"
                            href="#"
                        >
                            Men
                        </a>
                        <a
                            className="nav-link text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-100"
                            href="#"
                        >
                            Women
                        </a>
                        <a
                            className="nav-link text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-100"
                            href="#"
                        >
                            Kids
                        </a>
                        <a
                            className="nav-link text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-100"
                            href="#"
                        >
                            Sale
                        </a>
                    </nav>
                </div>

                <div className="navbar__actions">
                    <button
                        className="navbar__action-btn text-neutral-900 dark:text-white">
                        <Search size={20}/>
                    </button>

                    <button
                        className="navbar_action-btn text-neutral-900 dark:text-white">
                        <User size={20}/>
                    </button>

                    <button
                        className="navbar_action-btn text-neutral-900 dark:text-white">
                        <ShoppingBag size={20}/>
                    </button>

                    <div className="navbar__lang">
                        <span className="navbar-lang-item text-neutral-400 hover:text-neutral-600">UA</span>

                        <span className="text-neutral-300">·</span>

                        <span className="text-primary">EN</span>
                    </div>

                    <button onClick={toggleTheme} className="navbar__theme text-neutral-900 dark:text-white">
                        { theme === 'dark' ? <Sun size={20} /> : <Moon size={20}/> }
                    </button>
                </div>
            </div>
        </header>
    );
}
