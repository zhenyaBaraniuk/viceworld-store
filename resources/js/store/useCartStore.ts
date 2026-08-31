import { create } from "zustand";
import type { Cart } from "@/types/models/cart";
import { route } from "@/lib/route";
import axios from "axios";

interface CartState {
    items: Cart["cart_items"];
    totalPrice: number;
    isLoading: boolean;
    fetchCart: () => Promise<void>;
    addItem: (productVariantId: string, quantity: number) => Promise<void>;
    updateQuantity: (cartItemId: string, quantity: number) => Promise<void>;
    removeItem: (cartItemId: string) => Promise<void>;
    clearCart: () => Promise<void>;
}

let requestId = 0;

function applyCart(set: (partial: Partial<CartState>) => void, cart: Cart) {
    set({ items: cart.cart_items, totalPrice: cart.total_price });
}

export const useCartStore = create<CartState>((set) => ({
    items: [],
    totalPrice: 0,
    isLoading: false,

    fetchCart: async () => {
        const id = ++requestId;
        set({ isLoading: true });
        const { data } = await axios.get<Cart>(route("cart.index"));
        if (id === requestId) {
            applyCart(set, data);
        }
        set({ isLoading: false });
    },

    addItem: async (productVariantId: string, quantity: number) => {
        const id = ++requestId;
        const { data } = await axios.post<Cart>(route("cart.items.store"), {
            product_variant_id: productVariantId,
            quantity,
        });
        if (id === requestId) {
            applyCart(set, data);
        }
    },

    updateQuantity: async (cartItemId: string, quantity: number) => {
        const { data } = await axios.patch<Cart>(
            route("cart.items.update", { cartItem: cartItemId }),
            { quantity },
        );
        applyCart(set, data);
    },

    removeItem: async (cartItemId: string) => {
        const { data } = await axios.delete<Cart>(
            route("cart.items.destroy", { cartItem: cartItemId }),
        );
        applyCart(set, data);
    },

    clearCart: async () => {
        set({ isLoading: true });
        const { data } = await axios.delete<Cart>(route("cart.destroy"));
        applyCart(set, data);
        set({ isLoading: false });
    },
}));
