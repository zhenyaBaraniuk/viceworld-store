export interface Attrs {
    href?: string;
    level?: number;
}

export interface Mark {
    type: string;
    attrs?: Attrs;
}

export interface RichTextNode {
    type: string;
    attrs?: Attrs;
    content?: RichTextNode[];
    text?: string;
    marks?: Mark[];
}
