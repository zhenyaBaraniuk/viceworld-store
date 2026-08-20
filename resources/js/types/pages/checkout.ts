import type { PaymentMethod } from "@/types/models/payment-method";

export interface CheckoutProps {
    payment_methods: PaymentMethod[];
}
