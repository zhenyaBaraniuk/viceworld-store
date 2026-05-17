import {ArrowLeft, ArrowRight} from 'lucide-react'

type PaginationProps = {
    currentPage: number
    totalPages: number
    onPageChange: (page: number) => void
}

export default function Pagination({ currentPage, totalPages}: PaginationProps) {
    return (
        <div className="mt-24 flex items-center justify-between border-t-4 border-on-surface pt-8">
            <button className="font-headline font-black uppercase text-sm flex items-center gap-2 group">
                <ArrowLeft size={20} className="group-hover:-translate-x-1 transition-transform">
                    PREVIOUS
                </ArrowLeft>
            </button>

            {
                Array.from({ length: totalPages }, ())
            }
            <div className="flex gap-8 font-headline font-black">
                <span className="text-primary border-b-2 border-primary">01</span>
                <span className="text-outline hover:text-on-surface cursor-pointer">02</span>
                <span className="text-outline hover:text-on-surface cursor-pointer">03</span>
                <span className="text-outline hover:text-on-surface cursor-pointer">...</span>
                <span className="text-outline hover:text-on-surface cursor-pointer">12</span>
            </div>

            <button className="font-headline font-black uppercase text-sm flex items-center gap-2 group">
                <ArrowRight size={20} className="group-hover:-translate-x-1 transition-transform">
                    NEXT
                </ArrowRight>
            </button>
        </div>
    );
}
