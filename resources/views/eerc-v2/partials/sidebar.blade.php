{{-- Subject & Person facet sidebar --}}
<aside class="space-y-6" aria-label="Browse by category">
    @if(isset($subjectFacet) && !empty($subjectFacet['terms']))
    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
        <div class="bg-resp-slate-500 px-4 py-3">
            <h3 class="text-sm font-semibold tracking-wide text-white uppercase">Subject</h3>
        </div>
        <ul class="divide-y divide-gray-100">
            @foreach($subjectFacet['terms'] as $term)
            <li class="group">
                <a href='{{ url('/eerc/search/*:*/Subject:"' . str_replace(' ', '+', urldecode($term['name'])) . '"') }}'
                   class="flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 transition-colors hover:bg-resp-teal-50 hover:text-resp-teal-700">
                    <span class="group-hover:underline">{{ $term['display_name'] }}</span>
                    <span class="ml-2 inline-flex items-center rounded-full bg-resp-plum px-2.5 py-0.5 text-xs font-medium text-white">
                        {{ $term['count'] }}
                    </span>
                </a>
            </li>
            @endforeach
            @if(count($subjectFacet['terms']) >= 10)
            <li>
                <a href="{{ route('eerc.browse', ['facet' => 'Subject']) }}"
                   class="block px-4 py-2.5 text-center text-sm font-medium text-resp-teal-600 transition-colors hover:bg-resp-teal-50">
                    View all subjects &rarr;
                </a>
            </li>
            @endif
        </ul>
    </div>
    @endif

    @if(isset($personFacet) && !empty($personFacet['terms']))
    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
        <div class="bg-resp-slate-500 px-4 py-3">
            <h3 class="text-sm font-semibold tracking-wide text-white uppercase">Person</h3>
        </div>
        <ul class="divide-y divide-gray-100">
            @foreach($personFacet['terms'] as $term)
            <li class="group">
                <a href='{{ url('/eerc/search/*:*/Person:"' . str_replace(' ', '+', urldecode($term['name'])) . '"') }}'
                   class="flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 transition-colors hover:bg-resp-teal-50 hover:text-resp-teal-700">
                    <span class="group-hover:underline">{{ $term['display_name'] }}</span>
                    <span class="ml-2 inline-flex items-center rounded-full bg-resp-plum px-2.5 py-0.5 text-xs font-medium text-white">
                        {{ $term['count'] }}
                    </span>
                </a>
            </li>
            @endforeach
            @if(count($personFacet['terms']) >= 10)
            <li>
                <a href="{{ route('eerc.browse', ['facet' => 'Person']) }}"
                   class="block px-4 py-2.5 text-center text-sm font-medium text-resp-teal-600 transition-colors hover:bg-resp-teal-50">
                    View all people &rarr;
                </a>
            </li>
            @endif
        </ul>
    </div>
    @endif
</aside>
