# Laravel Migration Debugging Notes

This document is a practical debugging guide for working on this Laravel-based collections site during migration from older PHP / CodeIgniter-style applications. It is written as one continuous note so it can be picked up and put down easily.

The general approach is simple: when something is broken, do not guess too far ahead. First confirm the route is correct, then confirm the controller is being hit, then confirm the service call is returning what you think it is, and only then debug the Blade template or CSS. A lot of wasted time comes from assuming the problem is “in the view” when the data was actually empty, the route was wrong, or an exception was being swallowed.

A very useful first step in Laravel is to prove that the code path you think is running is actually running. The quickest way to do that is to put a `dd()` call in the controller method. For example:

```php
dd('reached guardbookHome');
Copy
If that string does not appear in the browser when the page loads, then the request is not hitting that method. At that point the likely causes are a wrong route, a wrong URL, route caching, or editing the wrong file.

If routing itself seems suspicious, the first terminal command to run is:

php artisan route:list
Copy
That shows what Laravel believes the registered routes are. This is especially useful in this project because there are collection-prefixed routes and dynamic collection registration.

Once the route is confirmed, the next thing to inspect is the data as early as possible. If a partial is blank, a list is empty, or a sidebar does not render, check the controller before blaming the view. For example:

dd($results);
Copy
or:

dd([
    'facets' => $facets,
    'filters' => config('skylight.filters'),
]);
Copy
A very reliable rule of thumb is to debug in this order: route, then controller, then service/repository, then view. It is much easier to reason about missing HTML once you know whether the controller passed any data to the template at all.

One common migration trap is the silent catch block. Code like this looks harmless:

catch (\Exception $e) {
    // ignore
}
Copy
but it can waste hours because it hides the real problem and allows the page to limp on with empty variables. During local development it is better to make exceptions visible. The quickest version is:

catch (\Throwable $e) {
    dd($e->getMessage(), $e);
}
Copy
A slightly safer version for local-only debugging is:

catch (\Throwable $e) {
    if (app()->environment('local')) {
        dd($e->getMessage(), $e);
    }

    report($e);
}
Copy
That way local development is loud and useful, but production can still fail more gracefully.

Blade has a few gotchas that are easy to trip over when converting old PHP templates. One important one is comments. Blade directives are not reliably disabled by plain PHP-style or HTML comments. So this is not a safe way to comment out Blade code:

/* @foreach(...) */
Copy
and neither is this:

<!-- @foreach(...) -->
Copy
Blade may still compile the directive. The correct Blade comment syntax is:

{{--
@foreach($items as $item)
    ...
@endforeach
--}}
Copy
Another important Blade rule is that {{ }} is for outputting content, not for assigning variables. So this is wrong:

$metafields = {{ config('skylight.metafields') }}
Copy
The right way is either to use a PHP block:

@php
    $metafields = config('skylight.metafields', []);
@endphp
Copy
or to skip the temporary variable entirely:

@foreach(config('skylight.metafields', []) as $label => $element)
Copy
While on config, always prefer safe defaults if there is any chance a key may be missing. For example:

config('skylight.metafields', [])
Copy
is safer than:

config('skylight.metafields')
Copy
because the latter may return null, which can then cause errors like:

foreach() argument must be of type array|object, null given
Copy
Another classic Blade migration issue is the unexpected end of file syntax error. In practice this almost always means one of the directive pairs is unbalanced. Typical missing closers are @endforeach, @endif, @endsection, or @endunless. The best defence is consistent indentation and keeping HTML structure aligned with Blade structure. As a simple example:

@foreach($items as $item)
    @if($item)
        ...
    @endif
@endforeach
Copy
If indentation starts to drift, it becomes much easier to lose track of what is still open.

During HTML migration, always be suspicious of div structure. Two stray closing </div> tags can produce symptoms that look like CSS bugs, JavaScript bugs, hidden elements, broken maps, or mysterious positioning problems. When the layout suddenly makes no sense, check the nesting before tweaking styles. Comparing the generated page source from the old site and the new site can be very effective here, especially around major wrapper elements.

Browser developer tools should be used alongside Laravel debugging, not after it. The browser console is useful for JavaScript errors, external API problems, and console.log(...) output. The Elements/Inspector tab is useful for checking if an element exists, whether it has dimensions, whether it is hidden, or whether it has been pushed outside a parent with overflow: hidden. The Network tab is useful for 403, 404, 500, blocked APIs, and failed backend requests.

Whenever things stop making sense after changing routes, config, or views, clear caches. The most useful one-shot command is:

php artisan optimize:clear
Copy
This clears cached config, cached routes, compiled views, and other optimised files. It is often the first thing to run after changing route registration, collection config, or Blade files.

Laravel’s dd() and dump() are basic but extremely useful. dd() means “dump and die”, so it prints the variable and stops execution:

dd($results);
Copy
dump() prints the variable and allows execution to continue:

dump($results);
Copy
The most useful places to put a dd() are at the start of a controller, after reading config, after a repository/service call, or inside an exception handler.

When working with collection-specific configuration, confirm what Laravel is using at runtime rather than assuming it. This kind of check is invaluable:

dd([
    'current_collection' => config('app.current_collection'),
    'appname' => config('skylight.appname'),
    'url_prefix' => config('skylight.url_prefix'),
    'container_id' => config('skylight.container_id'),
    'filters' => config('skylight.filters'),
]);
Copy
This is particularly useful in this application because the active collection affects routing, config, Solr queries, and view selection.

If a partial shows nothing, debug its input first. For example, if a facets partial renders nothing, dump $facets in the controller. If it is empty there, then the partial is probably fine and the real problem is upstream. A blank partial often means empty data, not broken Blade.

A very effective migration technique is to compare a working collection with a broken one. If one collection behaves and another does not, compare the runtime config values, route registration, active collection name, repository results, container IDs, Solr fields, and any request URLs or parameters built in the service layer. That is usually faster than trying to understand the entire application at once.

It is also worth remembering that not every bug is in the code. External infrastructure matters. If something worked in the old site and not in the new one, consider VPN access, Solr access restrictions, internal APIs, Google billing or key restrictions, or other environment assumptions. In practice, problems like “empty facets” may turn out to be a hidden 403 response from Solr, and a broken map may turn out to be a Google billing issue rather than a JavaScript problem.

When debugging repository or service-layer code, inspect the request context itself if possible. The useful pieces are usually the endpoint URL, query parameters, response status, and response body. A pattern like this is often helpful:

dd([
    'url' => $url,
    'params' => $params,
    'status' => $response->status(),
    'body' => $response->body(),
]);
Copy
This can quickly distinguish between “my parsing is wrong” and “the backend refused the request”.

As a general Blade rule, try not to mutate the underlying data structure in the template unless absolutely necessary. It is usually cleaner to derive a local display value instead. For example:

@php
    $uriValue = stripos($metadatavalue, 'http') !== false
        ? $metadatavalue
        : 'https://' . $metadatavalue;
@endphp
Copy
is easier to reason about than rewriting $record[$element][$n] inside the template.

When converting old PHP loops into Blade, preserve behaviour first and simplify later. Legacy code often carries implementation details that are not actually needed once the logic is understood. For example, old templates may manually track $n and index into an array, when in Blade the current loop value may already be enough. It is reasonable to keep the old logic during initial conversion, then simplify it once output matches the original.

A few Artisan commands are especially useful day to day. php artisan optimize:clear clears caches. php artisan route:list shows registered routes. php artisan tinker opens an interactive Laravel shell for testing config or services. php artisan view:clear clears compiled Blade views only. These are worth keeping close to hand during migration work.

A very handy local-only try/catch pattern when calling repository code is:

try {
    $results = $repository->searchWithHighlighting('*:*', [], 0, '', 0);
} catch (\Throwable $e) {
    if (app()->environment('local')) {
        dd([
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);
    }

    report($e);
}
Copy
This makes backend failures immediately visible during development without forcing production behaviour to be equally noisy.

If a page is blank or missing data, the fastest mental checklist is: is the route correct, is the controller method running, is the service returning data, is an exception being swallowed, and is the view receiving the variable I think it is? If Blade throws syntax errors, check for missing directive closers, misnested HTML, or wrongly commented template code. If the layout is weird, check closing divs, positioning context, wrapper structure, and overflow clipping. If external data is missing, consider VPN, API key restrictions, billing, and access to internal endpoints.

In practice, the most useful tiny cheats to remember are these. In controllers: dd($var);, dump($var);, config('key.name');, report($e);, and app()->environment();. In Blade: {{-- comment --}}, @php ... @endphp, {{ $value }}, and the standard directive pairs like @foreach ... @endforeach and @if ... @endif. In the terminal: php artisan optimize:clear, php artisan route:list, and php artisan tinker.

This file is intended to be a working note for the repository and can sit happily in something like docs/laravel-debugging-notes.md or docs/migration-debugging.md. It is most useful when converting legacy PHP views into Blade, troubleshooting collection-specific routes and config, debugging Solr-backed pages, and surfacing silent exceptions that would otherwise masquerade as view bugs. ```