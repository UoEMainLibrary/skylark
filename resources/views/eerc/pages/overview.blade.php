@extends('layouts.eerc')

@section('title', 'Browse the Collections - EERC')

@push('styles')
<style>
    .plus-button {
        border: 2px solid lightgrey;
        background-color: #fff;
        font-size: 22px;
        height: 1.5em;
        width: 1.5em;
        border-radius: 999px;
        position: relative;
        cursor: pointer;
    }

    li.overview_list {
        list-style: none;
        margin: 0.5em;
    }

    .active_btn {
        font-weight: bold;
    }
</style>
@endpush

@push('scripts')
<script>
    function toggleButton(btn, elementId) {
        if(btn.innerText === '+') {
            btn.innerText = '-';
            $(btn).parent().addClass('active_btn');
        }
        else {
            btn.innerText = '+';
            $(btn).parent().removeClass('active_btn');
        }

        $(elementId).toggle();
    }
</script>
@endpush

@section('content')
<div class="col-md-9 col-sm-9 col-xs-12" style="margin-top: 20px;">
    <h1>Browse the Collections</h1>
    <p></p>

    @php
    /**
     * Extract the archival object ID from a record URI
     */
    function getArchivalObj($recordUri, $numberOfUnits = 1) {
        $units = explode('/', $recordUri);
        $lenUnits = count($units);
        $returnString = '';

        for ($i = $lenUnits - $numberOfUnits; $i < $lenUnits; $i++) {
            $returnString .= $units[$i];

            if($i != $lenUnits - 1) {
                $returnString .= '/';
            }
        }
        return $returnString;
    }

    /**
     * Clean title by removing everything after the first comma
     */
    function cleanTitle($title) {
        if(strpos($title, ',') !== false) {
            return substr($title, 0, strpos($title, ','));
        }

        return $title;
    }

    /**
     * Recursively render children of a branch
     */
    function getChildren($branch, $branchCount = 0, $subBranchCount = 0) {
        $output = '';
        if ($branch['has_children']) {
            if(is_int($subBranchCount)) {
                $output = '<ul id="ul_' . $branchCount . '_' . $subBranchCount . '" style="display: none;">';
            }
            else {
                $output = '<ul id="ul_' . $branchCount . '" style="display: none;">';
                $subBranchCount = 0;
            }

            foreach ($branch['children'] as $subBranch) {
                $subOutput = '';

                if ($subBranch['has_children']) {
                    $output .= '<li class="overview_list"><button class="plus-button" onclick="toggleButton(this, \'#ul_' . $branchCount . '_' . $subBranchCount . '\');">+</button>&nbsp;';
                    $subOutput = getChildren($subBranch, $branchCount, $subBranchCount);
                    $subBranchCount++;
                }
                else {
                    $output .= '<li class="overview_list" style="list-style: square;">';
                }

                $output .= '<a href="' . url('/eerc/record/' . getArchivalObj($subBranch['record_uri']) . '/archival_object') . '">';
                $title = cleanTitle($subBranch['title']);
                $output .= $title . ' <span style="font-size: smaller;">(';

                if(strpos($title, 'Interviews of') !== false) {
                    $output .= getArchivalObj($subBranch['component_id'], 2);
                }
                else {
                    $output .= getArchivalObj($subBranch['component_id']);
                }

                $output .=  ')</span></a></li>' . $subOutput;
                $branchCount++;
            }
            $output .= '</ul>';
        }

        return $output;
    }
    @endphp

    @if(isset($tree['children']) && !empty($tree['children']))
        @foreach($tree['children'] as $index => $branch)
            @if($index >= 0 && $index <= 4)
                <li class="overview_list" style="margin: 0.5em; font-size: 18px; font-weight: bold;">
                    <button class="plus-button" onclick="toggleButton(this, '#ul_{{ $index }}');">+</button>&nbsp;{{ cleanTitle($branch['title']) }}
                </li>
                {!! getChildren($branch, $index, null) !!}
            @endif
        @endforeach
    @else
        <p>No collections available at this time.</p>
    @endif
</div>

<div class="col-sidebar">
    <div class="col-md-3 col-sm-3 hidden-xs">
        <div class="sidebar-nav">
            @if(isset($subjectFacet) && !empty($subjectFacet['terms']))
            <ul class="list-group">
                <li class="list-group-item active">
                    <h4 href="{{ route('eerc.browse', ['facet' => 'Subject']) }}">
                        Subject
                    </h4>
                </li>
                
                @foreach($subjectFacet['terms'] as $term)
                <li class="list-group-item">
                    <span class="badge">{{ $term['count'] }}</span>
                    <a href='{{ url('/eerc/search/*:*/Subject:"' . str_replace(' ', '+', urldecode($term['name'])) . '"') }}'>{{ $term['display_name'] }}</a>
                </li>
                @endforeach
                
                @if(count($subjectFacet['terms']) >= 10)
                <li class="list-group-item"><a href="{{ route('eerc.browse', ['facet' => 'Subject']) }}">More ...</a></li>
                @endif
            </ul>
            @endif
            
            @if(isset($personFacet) && !empty($personFacet['terms']))
            <ul class="list-group">
                <li class="list-group-item active">
                    <h4 href="{{ route('eerc.browse', ['facet' => 'Person']) }}">
                        Person
                    </h4>
                </li>
                
                @foreach($personFacet['terms'] as $term)
                <li class="list-group-item">
                    <span class="badge">{{ $term['count'] }}</span>
                    <a href='{{ url('/eerc/search/*:*/Person:"' . str_replace(' ', '+', urldecode($term['name'])) . '"') }}'>{{ $term['display_name'] }}</a>
                </li>
                @endforeach
                
                @if(count($personFacet['terms']) >= 10)
                <li class="list-group-item"><a href="{{ route('eerc.browse', ['facet' => 'Person']) }}">More ...</a></li>
                @endif
            </ul>
            @endif
        </div>
    </div>
</div>
@endsection
