import {ChevronRight} from 'lucide-react';
import type {BreadcrumbsProps} from "@/types/shared/breadcrumbs";

export default function Breadcrumbs({items}: BreadcrumbsProps) {
    return (
        <nav className="mb-12">
            <ol className="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-neutral-500 font-headline">
                {items.map((item, index) => (
                    <li key={index}>
                        {item.href ? (
                            <>
                                <a className="hover:text-primary transition-colors" href={item.href}>
                                    {item.label}
                                </a>

                                <ChevronRight size={12} className="inline" />
                            </>
                        ) : (
                            <span className="text-on-surface">{item.label}</span>
                        )}
                    </li>
                ))}
            </ol>
        </nav>
    );
}
