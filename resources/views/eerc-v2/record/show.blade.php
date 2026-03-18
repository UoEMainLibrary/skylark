@extends('layouts.eerc-v2')

@section('title', ($record['Title'] ?? 'Record') . ' - RESP Archive')

@section('content')
<div class="lg:grid lg:grid-cols-4 lg:gap-8">
    <div class="lg:col-span-3">
        {{-- Title --}}
        <h1 class="text-2xl font-bold tracking-tight text-gray-900">
            @php
                $titleValue = is_array($record['Title'] ?? null) ? ($record['Title'][0] ?? 'Untitled') : ($record['Title'] ?? 'Untitled');
                $stripTitle = strip_tags($titleValue);
                echo strpos($stripTitle, ',') !== false ? substr($stripTitle, 0, strpos($stripTitle, ',')) : $stripTitle;
            @endphp
        </h1>

        {{-- Metadata table --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <table class="w-full">
                <tbody class="divide-y divide-gray-100">
                    @php
                        $interviewer = '';
                        $transcripts = [];
                    @endphp

                    @foreach($recordDisplay as $displayField)
                        @if(isset($record[$displayField]) && !empty($record[$displayField]))
                            @php
                                $shouldDisplay = true;

                                if ($displayField === 'Interviewer') {
                                    $interviewer = is_array($record[$displayField]) ? ($record[$displayField][0] ?? '') : $record[$displayField];
                                }

                                if ($displayField === 'Notable persons / organisations') {
                                    $notableValues = is_array($record[$displayField]) ? $record[$displayField] : [$record[$displayField]];
                                    $notableValues = array_filter($notableValues, fn($v) => trim($v) !== trim($interviewer));
                                    if (empty($notableValues)) {
                                        $shouldDisplay = false;
                                    }
                                    $record[$displayField] = array_values($notableValues);
                                }
                            @endphp

                            @if($shouldDisplay)
                                <tr>
                                    <th class="w-40 bg-gray-50 px-4 py-3 text-left text-sm font-medium text-gray-600 align-top">{{ $displayField }}</th>
                                    <td class="px-4 py-3 text-sm text-gray-800">
                                        @if($displayField === 'Subject' && in_array($displayField, $filters))
                                            <div class="flex flex-wrap gap-1.5">
                                            @php $subjects = is_array($record[$displayField]) ? $record[$displayField] : [$record[$displayField]]; @endphp
                                            @foreach($subjects as $index => $subject)
                                                @php $encodedSubject = urlencode($subject); @endphp
                                                <a href="{{ url('/eerc/search/*:*/Subject:%22' . urlencode($encodedSubject) . '%22') }}"
                                                   class="inline-flex items-center rounded-full bg-resp-teal-50 px-2.5 py-0.5 text-xs font-medium text-resp-teal-700 hover:bg-resp-teal-100"
                                                   title="Search for items with the subject: {{ $subject }}">{{ $subject }}</a>
                                            @endforeach
                                            </div>
                                        @elseif($displayField === 'Extent')
                                            @php
                                                $extents = is_array($record[$displayField]) ? $record[$displayField] : [$record[$displayField]];
                                                $extentParts = [];
                                                foreach ($extents as $extent) {
                                                    if (is_array($extent) && isset($extent['number'], $extent['extent_type'])) {
                                                        $extentParts[] = $extent['number'] . ' ' . $extent['extent_type'];
                                                    }
                                                }
                                                echo implode(', ', $extentParts);
                                            @endphp
                                        @elseif($displayField === 'Dates')
                                            @php
                                                $dates = is_array($record[$displayField]) ? $record[$displayField] : [$record[$displayField]];
                                                foreach ($dates as $date) {
                                                    if (is_array($date)) {
                                                        if (isset($date['label']) && $date['label'] === 'coverage' && isset($date['expression'])) {
                                                            echo $date['label'] . ': ' . $date['expression'] . '<br/>';
                                                        } elseif (isset($date['label'], $date['begin'])) {
                                                            echo $date['label'] . ': ' . $date['begin'] . '<br/>';
                                                        }
                                                    }
                                                }
                                            @endphp
                                        @elseif($displayField === 'Audio links and images')
                                            @php
                                                $digitalObjectIds = is_array($record[$displayField]) ? $record[$displayField] : [$record[$displayField]];
                                                $photos = [];
                                                $audioFiles = [];
                                                $videoFiles = [];

                                                foreach ($digitalObjectIds as $digitalObjectId) {
                                                    try {
                                                        $solrBase = config('skylight.solr_base');
                                                        $solrCore = config('skylight.solr_core');
                                                        $url = "{$solrBase}{$solrCore}/select";

                                                        $response = \Illuminate\Support\Facades\Http::timeout(5)->get($url, [
                                                            'q' => 'id:"' . $digitalObjectId . '"',
                                                            'wt' => 'json',
                                                            'indent' => 'true'
                                                        ]);

                                                        if ($response->successful()) {
                                                            $jsonData = $response->json();
                                                            $jsonField = $jsonData['response']['docs'][0]['json'] ?? null;

                                                            if ($jsonField) {
                                                                $jsonArray = is_array($jsonField) ? $jsonField : [$jsonField];
                                                                foreach ($jsonArray as $digitalObj) {
                                                                    $digitalObj = is_string($digitalObj) ? json_decode($digitalObj, true) : $digitalObj;

                                                                    if (isset($digitalObj['file_versions'][0])) {
                                                                        $doFile = $digitalObj['title'] ?? '';
                                                                        $doUrl = $digitalObj['file_versions'][0]['file_uri'] ?? '';

                                                                        if (str_ends_with(strtolower($doFile), '.mp3') || str_ends_with(strtolower($doFile), '.wav')) {
                                                                            $audioFiles[] = ['url' => $doUrl, 'file' => $doFile];
                                                                        } elseif (str_ends_with(strtolower($doFile), '.jpg') || str_ends_with(strtolower($doFile), '.jpeg')) {
                                                                            $doTitleShort = substr($doFile, 0, strrpos($doFile, '.'));
                                                                            $photos[] = ['url' => $doUrl, 'title' => $doTitleShort];
                                                                        } elseif (str_ends_with(strtolower($doFile), '.pdf')) {
                                                                            $doTitleShort = substr($doFile, 0, strrpos($doFile, '.'));
                                                                            $transcripts[] = ['url' => $doUrl, 'title' => $doTitleShort];
                                                                        } elseif (str_ends_with(strtolower($doFile), '.mp4') || str_ends_with(strtolower($doFile), '.mov') || str_ends_with(strtolower($doFile), '.m4v')) {
                                                                            $videoFiles[] = ['url' => $doUrl, 'file' => $doFile];
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    } catch (\Exception $e) {}
                                                }
                                            @endphp

                                            @if(count($photos) > 0)
                                                <div class="flex flex-wrap gap-3 mb-4">
                                                    @foreach($photos as $photo)
                                                        <a href="{{ $photo['url'] }}" title="Photograph {{ $photo['title'] }}">
                                                            <img src="{{ $photo['url'] }}" alt="Photograph {{ $photo['title'] }}" class="w-60 rounded-lg shadow-sm">
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif

                                            @if(count($audioFiles) > 0)
                                                <div class="space-y-2">
                                                    @foreach($audioFiles as $audio)
                                                        <audio controls src="{{ $audio['url'] }}" title="Audio file {{ $audio['file'] }}" class="w-full max-w-md">
                                                            Your browser does not support the audio element.
                                                        </audio>
                                                    @endforeach
                                                </div>
                                            @endif

                                            @if(count($videoFiles) > 0)
                                                <div class="space-y-3 mt-3">
                                                    @foreach($videoFiles as $video)
                                                        <video controls width="480" preload="metadata" title="Video file {{ $video['file'] }}" class="rounded-lg">
                                                            <source src="{{ $video['url'] }}">
                                                            Sorry, your browser doesn't support embedded videos.
                                                        </video>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @elseif($displayField === 'Interview summary')
                                            @php
                                                $summary = is_array($record[$displayField]) ? ($record[$displayField][0] ?? '') : $record[$displayField];
                                                $cleanSummary = strip_tags($summary);
                                                $paragraphs = array_filter(array_map('trim', explode("\n\n", $cleanSummary)));
                                                $isLong = count($paragraphs) > 3 || mb_strlen($cleanSummary) > 600;
                                            @endphp
                                            <div>
                                                <div id="interview-summary" class="prose prose-sm max-w-none @if($isLong) max-h-36 overflow-hidden @endif"
                                                     @if($isLong) style="mask-image: linear-gradient(to bottom, black 60%, transparent 100%); -webkit-mask-image: linear-gradient(to bottom, black 60%, transparent 100%);" @endif>
                                                    @foreach($paragraphs as $paragraph)
                                                        <p>{!! nl2br(e($paragraph)) !!}</p>
                                                    @endforeach
                                                </div>
                                                @if($isLong)
                                                    <button type="button" id="summary-toggle"
                                                            onclick="var el = document.getElementById('interview-summary'); var btn = this; if (el.classList.contains('max-h-36')) { el.classList.remove('max-h-36', 'overflow-hidden'); el.style.maskImage = ''; el.style.webkitMaskImage = ''; btn.textContent = 'Read less'; } else { el.classList.add('max-h-36', 'overflow-hidden'); el.style.maskImage = 'linear-gradient(to bottom, black 60%, transparent 100%)'; el.style.webkitMaskImage = 'linear-gradient(to bottom, black 60%, transparent 100%)'; btn.textContent = 'Read more'; }"
                                                            class="mt-2 text-sm font-medium text-resp-teal-600 hover:text-resp-teal-700 hover:underline">
                                                        Read more
                                                    </button>
                                                @endif
                                            </div>
                                        @elseif(in_array($displayField, ['Access', 'Usage Statement', 'Biographical history', 'Related', 'Physical', 'Alternative Format', 'Physical Description', 'Processing Information']))
                                            @php
                                                $noteValues = is_array($record[$displayField]) ? $record[$displayField] : [$record[$displayField]];
                                            @endphp
                                            <div class="prose prose-sm max-w-none">
                                                @foreach($noteValues as $noteValue)
                                                    <p>{!! strip_tags(trim($noteValue), '<a><em><strong><br>') !!}</p>
                                                @endforeach
                                            </div>
                                        @elseif(is_array($record[$displayField]))
                                            {{ implode(', ', $record[$displayField]) }}
                                        @else
                                            {{ $record[$displayField] }}
                                        @endif
                                    </td>
                                </tr>

                                @if($displayField === 'Audio links and images' && count($transcripts) > 0)
                                    <tr>
                                        <th class="w-40 bg-gray-50 px-4 py-3 text-left text-sm font-medium text-gray-600 align-top">Transcript</th>
                                        <td class="px-4 py-3">
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($transcripts as $pdf)
                                                    <a href="{{ $pdf['url'] }}" target="_blank" rel="noopener"
                                                       class="inline-flex items-center gap-2 rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50"
                                                       title="Transcript: {{ $pdf['title'] }}">
                                                        <svg class="h-4 w-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5zM10 8a.75.75 0 01.75.75v1.5h1.5a.75.75 0 010 1.5h-1.5v1.5a.75.75 0 01-1.5 0v-1.5h-1.5a.75.75 0 010-1.5h1.5v-1.5A.75.75 0 0110 8z" clip-rule="evenodd"/></svg>
                                                        {{ $pdf['title'] }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endif
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Back button --}}
        <div class="mt-6 flex justify-end">
            <button onclick="history.go(-1);"
                    class="inline-flex items-center gap-2 rounded-md bg-resp-teal-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-resp-teal-700 focus:outline-none focus:ring-2 focus:ring-resp-teal-500 focus:ring-offset-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
                Back to Search Results
            </button>
        </div>
    </div>

    {{-- Related items sidebar --}}
    <div class="mt-8 lg:mt-0">
        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="bg-resp-slate-400 px-4 py-3">
                <h3 class="text-sm font-semibold tracking-wide text-white uppercase">Related Items</h3>
            </div>
            <ul class="divide-y divide-gray-100">
                @if(!empty($relatedItems) && count($relatedItems) > 0)
                    @foreach($relatedItems as $item)
                        @php
                            $relatedTitle = is_array($item['Title'] ?? null) ? ($item['Title'][0] ?? 'Untitled') : ($item['Title'] ?? 'Untitled');
                            $stripRelatedTitle = strip_tags($relatedTitle);
                            if (strpos($stripRelatedTitle, ',') !== false) {
                                $stripRelatedTitle = substr($stripRelatedTitle, 0, strpos($stripRelatedTitle, ','));
                            }

                            $relatedFullId = $item['Id'] ?? $item['id'] ?? '';
                            $relatedIdParts = explode('/', $relatedFullId);
                            $relatedNumericId = end($relatedIdParts);
                            $relatedTypes = $item['_raw']['types'] ?? [];
                            $relatedType = is_array($relatedTypes) ? ($relatedTypes[0] ?? 'archival_object') : 'archival_object';
                        @endphp
                        <li>
                            <a href="{{ url('/eerc/record/' . $relatedNumericId . '/' . $relatedType) }}"
                               class="block px-4 py-3 text-sm text-gray-700 transition-colors hover:bg-resp-teal-50 hover:text-resp-teal-700">
                                {{ $stripRelatedTitle }}
                                @if(isset($item['Component Unique Identifier']))
                                    <span class="mt-0.5 block text-xs text-gray-400">
                                        {{ is_array($item['Component Unique Identifier']) ? ($item['Component Unique Identifier'][0] ?? '') : $item['Component Unique Identifier'] }}
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endforeach
                @else
                    <li class="px-4 py-3 text-sm text-gray-500">No related items found.</li>
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection
