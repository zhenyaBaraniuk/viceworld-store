import type { PaymentMethod } from "@/types/models/payment-method";
import type { Customer } from "@/types/pages/customer";

export interface CheckoutProps {
    payment_methods: PaymentMethod[];
    customer: Customer | null;
}
