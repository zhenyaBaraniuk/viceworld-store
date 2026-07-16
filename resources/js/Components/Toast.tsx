import "@css/front/components/toast.css";
import { useEffect, useState, useRef } from "react";
import * as RadixToast from "@radix-ui/react-toast";
import { usePage } from "@inertiajs/react";
import { X } from "lucide-react";

type Flash = Record<string, string | undefined>;

export const Toast = () => {
    const { flash } = usePage().props as { flash: Flash };
    const [open, setOpen] = useState(false);
    const timerRef = useRef(0);

    const triggerToast = () => {
        setOpen(false);
        window.clearTimeout(timerRef.current);
        timerRef.current = window.setTimeout(() => {
            setOpen(true);
        }, 100);
    };

    useEffect(() => {
        if (Object.values(flash).some(Boolean)) {
            triggerToast();
        }
        return () => window.clearTimeout(timerRef.current);
    }, [flash]);

    const [type, message] = Object.entries(flash).find(([, v]) => v) ?? [];

    if (!message) {
        return null;
    }

    return (
        <RadixToast.Provider swipeDirection="right" duration={3000}>
            <RadixToast.Root
                open={open}
                onOpenChange={setOpen}
                className={`toast toast--${type}`}
            >
                <RadixToast.Description>{message}</RadixToast.Description>

                <RadixToast.Close className="toast-close" aria-label="Close">
                    <X size={16} />
                </RadixToast.Close>
            </RadixToast.Root>
            <RadixToast.Viewport className="toast-viewport" />
        </RadixToast.Provider>
    );
};
