@extends('layouts.eerc')

@section('title', $record['Title'] ?? 'Record - Regional Ethnology of Scotland Project')

@section('content')
<div class="col-md-9 col-sm-9 col-xs-12">
    <div class="row">
        <h1 class="itemtitle">
            @php
                $titleValue = is_array($record['Title'] ?? null) ? ($record['Title'][0] ?? 'Untitled') : ($record['Title'] ?? 'Untitled');
                $stripTitle = strip_tags($titleValue);
                // Only show title up to first comma
                echo strpos($stripTitle, ',') !== false ? substr($stripTitle, 0, strpos($stripTitle, ',')) : $stripTitle;
            @endphp
        </h1>
    </div>

    <div class="row full-metadata">
        <table class="table">
            <tbody>
                @php
                    $interviewer = '';
                    $transcripts = [];
                @endphp
                
                @foreach($recordDisplay as $displayField)
                    @if(isset($record[$displayField]) && !empty($record[$displayField]))
                        @php
                            $shouldDisplay = true;
                            
                            // Store interviewer for comparison
                            if($displayField === 'Interviewer') {
                                $interviewer = is_array($record[$displayField]) ? ($record[$displayField][0] ?? '') : $record[$displayField];
                            }
                            
                            // Skip Notable persons if they match the interviewer
                            if($displayField === 'Notable persons / organisations') {
                                $notableValue = is_array($record[$displayField]) ? ($record[$displayField][0] ?? '') : $record[$displayField];
                                if(trim($notableValue) === trim($interviewer)) {
                                    $shouldDisplay = false;
                                }
                            }
                        @endphp
                        
                        @if($shouldDisplay)
                            <tr>
                                <th class="table-header">{{ $displayField }}</th>
                                <td>
                                    @if($displayField === 'Subject' && in_array($displayField, $filters))
                                        @php
                                            $subjects = is_array($record[$displayField]) ? $record[$displayField] : [$record[$displayField]];
                                        @endphp
                                        @foreach($subjects as $index => $subject)
                                            @php
                                                $encodedSubject = urlencode($subject);
                                            @endphp
                                            <a href="{{ url('/eerc/search/*:*/Subject:%22' . urlencode($encodedSubject) . '%22') }}" title="Search for items with the subject: {{ $subject }}">{{ $subject }}</a>{{ $index < count($subjects) - 1 ? ', ' : '' }}
                                        @endforeach
                                    @elseif($displayField === 'Extent')
                                        @php
                                            $extents = is_array($record[$displayField]) ? $record[$displayField] : [$record[$displayField]];
                                            $extentParts = [];
                                            foreach($extents as $extent) {
                                                if(is_array($extent) && isset($extent['number'], $extent['extent_type'])) {
                                                    $extentParts[] = $extent['number'] . ' ' . $extent['extent_type'];
                                                }
                                            }
                                            echo implode(', ', $extentParts);
                                        @endphp
                                    @elseif($displayField === 'Dates')
                                        @php
                                            $dates = is_array($record[$displayField]) ? $record[$displayField] : [$record[$displayField]];
                                            foreach($dates as $date) {
                                                if(is_array($date)) {
                                                    if(isset($date['label']) && $date['label'] === 'coverage' && isset($date['expression'])) {
                                                        echo $date['label'] . ': ' . $date['expression'] . '<br/>';
                                                    } elseif(isset($date['label'], $date['begin'])) {
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
                                            
                                            foreach($digitalObjectIds as $digitalObjectId) {
                                                try {
                                                    $solrBase = config('skylight.solr_base');
                                                    $solrCore = config('skylight.solr_core');
                                                    $url = "{$solrBase}{$solrCore}/select";
                                                    
                                                    $response = Http::timeout(5)->get($url, [
                                                        'q' => 'id:"' . $digitalObjectId . '"',
                                                        'wt' => 'json',
                                                        'indent' => 'true'
                                                    ]);
                                                    
                                                    if($response->successful()) {
                                                        $jsonData = $response->json();
                                                        $jsonField = $jsonData['response']['docs'][0]['json'] ?? null;
                                                        
                                                        if($jsonField) {
                                                            $jsonArray = is_array($jsonField) ? $jsonField : [$jsonField];
                                                            foreach($jsonArray as $digitalObj) {
                                                                $digitalObj = is_string($digitalObj) ? json_decode($digitalObj, true) : $digitalObj;
                                                                
                                                if(isset($digitalObj['file_versions'][0])) {
                                                    $doFile = $digitalObj['title'] ?? '';
                                                    $doUrl = \App\Helpers\BitstreamHelper::rewriteBitstreamUrl($digitalObj['file_versions'][0]['file_uri'] ?? '');
                                                                    
                                                                    if(str_ends_with(strtolower($doFile), '.mp3') || str_ends_with(strtolower($doFile), '.wav')) {
                                                                        $audioFiles[] = ['url' => $doUrl, 'file' => $doFile];
                                                                    } elseif(str_ends_with(strtolower($doFile), '.jpg') || str_ends_with(strtolower($doFile), '.jpeg')) {
                                                                        $doTitleShort = substr($doFile, 0, strrpos($doFile, '.'));
                                                                        $photos[] = ['url' => $doUrl, 'title' => $doTitleShort];
                                                                    } elseif(str_ends_with(strtolower($doFile), '.pdf')) {
                                                                        $doTitleShort = substr($doFile, 0, strrpos($doFile, '.'));
                                                                        $transcripts[] = ['url' => $doUrl, 'title' => $doTitleShort];
                                                                    } elseif(str_ends_with(strtolower($doFile), '.mp4') || str_ends_with(strtolower($doFile), '.mov') || str_ends_with(strtolower($doFile), '.m4v')) {
                                                                        $videoFiles[] = ['url' => $doUrl, 'file' => $doFile];
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                } catch(\Exception $e) {
                                                    // Log but don't break the page
                                                }
                                            }
                                        @endphp
                                        
                                        @if(count($photos) > 0)
                                            <div>
                                                @foreach($photos as $photo)
                                                    <a href="{{ $photo['url'] }}" title="Photograph {{ $photo['title'] }}">
                                                        <img src="{{ $photo['url'] }}" alt="Photograph {{ $photo['title'] }}" class="photos" style="width: 300px; padding: 8px;">
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                        
                                        @if(count($audioFiles) > 0)
                                            <div style="float: left;">
                                                @foreach($audioFiles as $audio)
                                                    <audio controls src="{{ $audio['url'] }}" title="Embedded audio file {{ $audio['file'] }}">
                                                        Your browser does not support the <code>audio</code> element.
                                                    </audio>
                                                @endforeach
                                            </div>
                                        @endif
                                        
                                        @if(count($videoFiles) > 0)
                                            @foreach($videoFiles as $video)
                                                <video controls width="480" preload="metadata" title="Embedded video file {{ $video['file'] }}">
                                                    <source src="{{ $video['url'] }}">
                                                    Sorry, your browser doesn't support embedded videos.
                                                </video>
                                            @endforeach
                                        @endif
                                    @elseif($displayField === 'Interview summary')
                                        <div id="intsum">
                                            @php
                                                $summary = is_array($record[$displayField]) ? ($record[$displayField][0] ?? '') : $record[$displayField];
                                                // Split by double newlines and wrap each paragraph in <p> tags
                                                $paragraphs = explode("\n\n", $summary);
                                                foreach($paragraphs as $paragraph) {
                                                    echo '<p>' . nl2br(e(trim($paragraph))) . '</p>';
                                                }
                                            @endphp
                                        </div>
                                        <script>
                                            $("#intsum").readmore({
                                                collapsedHeight: 50,
                                                moreLink: '<div style="margin: 0;"><p style="margin: 0;">...</p><a href="#" class="moreless" title="Click to expand the interview summary box">read more</a></div>',
                                                lessLink: '<div style="margin: 0;"><a href="#" title="Click to shrink the interview summary box" class="moreless">read less</a></div>'
                                            });
                                        </script>
                                    @elseif(is_array($record[$displayField]))
                                        {{ implode(', ', $record[$displayField]) }}
                                    @else
                                        {{ $record[$displayField] }}
                                    @endif
                                </td>
                            </tr>
                            
                            @if($displayField === 'Audio links and images' && count($transcripts) > 0)
                                <tr>
                                    <th class="table-header">Transcript</th>
                                    <td>
                                        @foreach($transcripts as $pdf)
                                            <a href="{{ $pdf['url'] }}" title="Transcript of interview {{ $pdf['title'] }} in PDF format" target="_blank" onclick="return warnNewTab()"><img src="{{ asset('collections/eerc/images/file-pdf-icon.png') }}" alt="Transcript of interview {{ $pdf['title'] }} in PDF format"></a>
                                        @endforeach
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row" style="float: right;">
        <button class="btn btn-info" onClick="history.go(-1);">
            <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Back to Search Results
        </button>
    </div>
</div>

<!-- Related Items Sidebar -->
<div class="col-md-3 col-sm-3 hidden-xs">
    <div class="sidebar-nav related-items">
        <ul class="list-group">
            <li class="list-group-item active">Related Items</li>
            
            @if(!empty($relatedItems) && count($relatedItems) > 0)
                @foreach($relatedItems as $item)
                    @php
                        $relatedTitle = is_array($item['Title'] ?? null) ? ($item['Title'][0] ?? 'Untitled') : ($item['Title'] ?? 'Untitled');
                        $stripRelatedTitle = strip_tags($relatedTitle);
                        if(strpos($stripRelatedTitle, ',') !== false) {
                            $stripRelatedTitle = substr($stripRelatedTitle, 0, strpos($stripRelatedTitle, ','));
                        }
                        
                        // Extract numeric ID and type for related item
                        $relatedFullId = $item['Id'] ?? $item['id'] ?? '';
                        $relatedIdParts = explode('/', $relatedFullId);
                        $relatedNumericId = end($relatedIdParts);
                        $relatedTypes = $item['_raw']['types'] ?? [];
                        $relatedType = is_array($relatedTypes) ? ($relatedTypes[0] ?? 'archival_object') : 'archival_object';
                    @endphp
                    <li class="list-group-item">
                        <a class="related-record" title="Link to related item: {{ $stripRelatedTitle }}" href="{{ url('/eerc/record/' . $relatedNumericId . '/' . $relatedType) }}">
                            {{ $stripRelatedTitle }}
                        </a>
                        @if(isset($item['Component Unique Identifier']))
                            <div class="component_id">
                                {{ is_array($item['Component Unique Identifier']) ? ($item['Component Unique Identifier'][0] ?? '') : $item['Component Unique Identifier'] }}
                            </div>
                        @endif
                    </li>
                @endforeach
            @else
                <li class="list-group-item">None.</li>
            @endif
        </ul>
    </div>
</div>

<script>
    function warnNewTab() {
        return true;
    }
</script>
@endsection
