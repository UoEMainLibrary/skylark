{{--
    External link with WCAG SC 3.2.2 new-window disclosure.

    Always renders:
      - target="_blank" rel="noopener"
      - persistent underline (audit recommendation: links underlined by default)
      - a small inline icon next to the link
      - an sr-only " (opens in a new tab)" message for assistive tech

    Variables:
      $href  - destination URL
      $label - visible link text (plain string; pass real Unicode characters)
      $class - optional extra CSS classes for the anchor
--}}
@php
    $extLinkClass = trim('underline underline-offset-2 hover:decoration-2 '.($class ?? ''));
@endphp
<a href="{{ $href }}" target="_blank" rel="noopener" class="{{ $extLinkClass }}">{{ $label }}<span class="sr-only"> (opens in a new tab)</span><svg class="ms-1 inline-block h-3 w-3 -translate-y-px align-baseline opacity-70" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg></a>
