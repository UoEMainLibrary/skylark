<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

class StceciliasEditorContent
{
    public static function normalize(?string $html): ?string
    {
        if (blank($html)) {
            return $html;
        }

        $document = new DOMDocument;
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML('<?xml encoding="UTF-8"><html><body>'.$html.'</body></html>');
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $blockTags = ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'ul', 'ol', 'blockquote', 'table', 'hr', 'pre'];
        $containers = iterator_to_array($document->getElementsByTagName('div'));
        foreach (array_reverse($containers) as $container) {
            $hasBlockChildren = false;
            foreach ($container->childNodes as $child) {
                if ($child instanceof DOMElement && in_array($child->tagName, $blockTags, true)) {
                    $hasBlockChildren = true;

                    break;
                }
            }

            if (! $hasBlockChildren) {
                $paragraph = $document->createElement('p');
                while ($container->firstChild) {
                    $paragraph->appendChild($container->firstChild);
                }
                $container->parentNode->replaceChild($paragraph, $container);

                continue;
            }

            while ($container->firstChild) {
                $container->parentNode->insertBefore($container->firstChild, $container);
            }
            $container->parentNode->removeChild($container);
        }

        $body = $document->getElementsByTagName('body')->item(0);
        $paragraph = null;
        foreach (iterator_to_array($body->childNodes) as $node) {
            if ($node instanceof DOMElement && in_array($node->tagName, $blockTags, true)) {
                $paragraph = null;

                continue;
            }

            if ($paragraph === null) {
                if (trim($node->textContent) === '' && ! ($node instanceof DOMElement)) {
                    $body->removeChild($node);

                    continue;
                }
                $paragraph = $document->createElement('p');
                $body->insertBefore($paragraph, $node);
            }
            $paragraph->appendChild($node);
        }

        return implode('', array_map(fn (DOMNode $node): string => $document->saveHTML($node), iterator_to_array($body->childNodes)));
    }
}
