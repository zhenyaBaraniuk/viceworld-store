export default function Pagination() {
    return (
        <div className="mt-24 flex items-center justify-between border-t-4 border-on-surface pt-8">
            <button className="font-headline font-black uppercase text-sm flex items-center gap-2 group">
                <span className="material-symbols-outlined group-hover:-translate-x-1 transition-transform">arrow_back
                </span>
                Previous
            </button>

            <div className="flex gap-8 font-headline font-black">
                <span className="text-primary border-b-2 border-primary">01</span>
                <span className="text-outline hover:text-on-surface cursor-pointer">02</span>
                <span className="text-outline hover:text-on-surface cursor-pointer">03</span>
                <span className="text-outline hover:text-on-surface cursor-pointer">...</span>
                <span className="text-outline hover:text-on-surface cursor-pointer">12</span>
            </div>

            <button className="font-headline font-black uppercase text-sm flex items-center gap-2 group">
                Next
                <span className="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward
                </span>
            </button>
        </div>
    );
}
