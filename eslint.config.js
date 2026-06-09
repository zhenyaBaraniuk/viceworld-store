import js from "@eslint/js";
import globals from "globals";
import tseslint from "typescript-eslint";
import reactPlugin from "eslint-plugin-react";
import { defineConfig } from "eslint/config";
import eslintConfigPrettier from "eslint-config-prettier";

export default defineConfig([
    {
        files: ["**/*.{js,mjs,cjs,ts,mts,cts,jsx,tsx}"],
        plugins: { js, react: reactPlugin },
        extends: ["js/recommended"],
        languageOptions: { globals: globals.browser },
        rules: {
            "react/jsx-key": "error",
            "react/no-unknown-property": "error",
            "react/self-closing-comp": "warn",
        },
    },
    tseslint.configs.recommended,
    eslintConfigPrettier,
]);
