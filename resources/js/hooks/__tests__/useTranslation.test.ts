import { describe, expect, it } from "vitest";
import { translate } from "../useTranslation";

describe("translate", () => {
    it("returns the mapped value when the key exists", () => {
        const translations = { "nav.home": "Головна" };

        expect(translate(translations, "nav.home")).toBe("Головна");
    });

    it("returns the key itself when the key does not exist", () => {
        const translations = { "nav.home": "Головна" };

        expect(translate(translations, "nav.missing")).toBe("nav.missing");
    });
});
