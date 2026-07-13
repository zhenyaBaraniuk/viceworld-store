import { Fragment, type JSX, type ReactNode } from "react";
import type { RichTextNode } from "@/types/common/rich-text";
import "../../css/front/components/rich-text.css";

function renderText(node: RichTextNode, key: number) {
    let el: ReactNode = node.text;

    for (const mark of node.marks ?? []) {
        switch (mark.type) {
            case "bold":
                el = <strong>{el}</strong>;
                break;
            case "italic":
                el = <em>{el}</em>;
                break;
            case "underline":
                el = <u>{el}</u>;
                break;
            case "strike":
                el = <s>{el}</s>;
                break;
            case "link":
                el = (
                    <a href={mark.attrs?.href} rel="noreferrer">
                        {el}
                    </a>
                );
                break;
        }
    }

    return <Fragment key={key}>{el}</Fragment>;
}

function renderNode(node: RichTextNode, key: number): ReactNode {
    const children = node.content?.map((child, i) => renderNode(child, i));

    switch (node.type) {
        case "doc":
            return <>{children}</>;
        case "paragraph":
            return <p key={key}>{children}</p>;
        case "heading": {
            const Tag =
                `h${node.attrs?.level ?? 2}` as keyof JSX.IntrinsicElements;
            return <Tag key={key}>{children}</Tag>;
        }
        case "bulletList":
            return <ul key={key}>{children}</ul>;
        case "orderedList":
            return <ol key={key}>{children}</ol>;
        case "listItem":
            return <li key={key}>{children}</li>;
        case "hardBreak":
            return <br key={key} />;
        case "text":
            return renderText(node, key);
    }
}

export default function RichText({
    content,
}: {
    content?: RichTextNode | null;
}) {
    return content ? (
        <div className="rich-text">{renderNode(content, 0)}</div>
    ) : null;
}
