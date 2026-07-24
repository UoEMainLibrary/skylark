@extends('layouts.iog')

@section('title', $recordTitle.' - '.config('skylight.fullname'))

@section('content')
@php
    $filters = array_keys(config('skylight.filters', []));
    $schema = config('skylight.schema_links', []);
    $subjectField = str_replace('.', '', $fieldMappings['Subject'] ?? '');
    $linkField = str_replace('.', '', $fieldMappings['Link'] ?? '');
    $bitstreamFieldName = str_replace('.', '', $fieldMappings['Bitstream'] ?? '');
@endphp

<h1 class="itemtitle">{{ $recordTitle }}</h1>

<div class="tags">
    @if($subjectField !== '' && isset($record[$subjectField]) && ! empty($record[$subjectField]))
        @php
            $subjects = is_array($record[$subjectField]) ? $record[$subjectField] : [$record[$subjectField]];
        @endphp
        @foreach($subjects as $subject)
            @php
                $origFilter = urlencode($subject);
                $lowerFilter = urlencode(strtolower($subject));
            @endphp
            <a href="{{ $collectionUrl('search/*:*/Subject:%22'.$lowerFilter.'+%7C%7C%7C+'.$origFilter.'%22') }}">{{ str_replace('|', "\u{00A0}", $subject) }}</a>
        @endforeach
    @endif
</div>

<div class="content" itemscope itemtype="http://schema.org/CreativeWork">
    <table>
        <tbody>
        @foreach($recordDisplay as $key)
            @php
                $element = str_replace('.', '', $fieldMappings[$key] ?? '');
            @endphp
            @if($element !== '' && isset($record[$element]) && ! empty($record[$element]))
                <tr>
                    <th>{{ $key }}</th>
                    <td>
                        @php
                            $values = is_array($record[$element]) ? $record[$element] : [$record[$element]];
                        @endphp
                        @foreach($values as $idx => $metadataValue)
                            @php
                                $metadataValue = str_replace('|', "\u{00A0}", $metadataValue);
                                $schemaAttr = $schema[$key] ?? null;
                            @endphp
                            @if(in_array($key, $filters, true))
                                @php
                                    $origFilter = urlencode($metadataValue);
                                    $lowerFilter = urlencode(strtolower($metadataValue));
                                @endphp
                                @if($schemaAttr)
                                    <span itemprop="{{ $schemaAttr }}"><a href="{{ $collectionUrl('search/*:*/'.$key.':%22'.$lowerFilter.'+%7C%7C%7C+'.$origFilter.'%22') }}" title="{{ $metadataValue }}">{{ $metadataValue }}</a></span>
                                @else
                                    <a href="{{ $collectionUrl('search/*:*/'.$key.':%22'.$lowerFilter.'+%7C%7C%7C+'.$origFilter.'%22') }}" title="{{ $metadataValue }}">{{ $metadataValue }}</a>
                                @endif
                            @else
                                @if($schemaAttr)
                                    <span itemprop="{{ $schemaAttr }}">{{ $metadataValue }}</span>
                                @else
                                    {{ $metadataValue }}
                                @endif
                            @endif
                            @if($idx < count($values) - 1){{ '; ' }}@endif
                        @endforeach
                    </td>
                </tr>
            @endif
        @endforeach

        @if($linkField !== '' && isset($record[$linkField]) && ! empty($record[$linkField]))
            @php
                $linkValues = is_array($record[$linkField]) ? $record[$linkField] : [$record[$linkField]];
            @endphp
            @foreach($linkValues as $uri)
                @if(str_contains(strtolower((string) $uri), 'hdl.handle.net'))
                    @continue
                @endif
                <tr>
                    <th>Link</th>
                    <td>
                        @if(str_contains(strtolower((string) $uri), 'images.is.ed.ac.uk'))
                            <a href="{{ $uri }}" title="Link to High resolution version of image" target="_blank" rel="noopener noreferrer">High resolution version of photo<span class="visually-hidden"> (opens in a new tab)</span></a>
                        @else
                            <a href="{{ $uri }}" title="Link to {{ $uri }}" target="_blank" rel="noopener noreferrer">{{ $uri }}<span class="visually-hidden"> (opens in a new tab)</span></a>
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>

@if(! empty($bitstreams['pdf']))
    <div class="record_bitstreams">
        @foreach($bitstreams['pdf'] as $pdf)
            @php
                $pdfViewerSrc = asset('collections/iog/addons/PDF_Viewer/pdf_reader.php');
                $pdfAbsolute = $collectionUrl(ltrim($pdf['uri'], '/'));
            @endphp
            <br>
            <iframe src="{{ $pdfViewerSrc }}?url={{ urlencode($pdfAbsolute) }}" title="PDF Viewer" width="700" height="900"></iframe>
            <br>
            Click <a href="{{ $collectionUrl(ltrim($pdf['uri'], '/')) }}" target="_blank" rel="noopener noreferrer">{{ $pdf['filename'] }}<span class="visually-hidden"> (opens in a new tab)</span></a> to download.
            @if(! empty($pdf['size']))
                (<span class="bitstream_size">{{ $pdf['size'] }}</span>)
            @endif
            <br><br>
        @endforeach
    </div>
@endif

<input type="button" value="Back to Search Results" class="backbtn" onClick="history.go(-1);">
@endsection

@section('sidebar')
    <h4>Related Items</h4>
    <ul class="related">
        @if(! empty($relatedItems) && count($relatedItems) > 0)
            @php
                $titleFieldName = str_replace('.', '', $fieldMappings['Title'] ?? '');
                $authorFieldName = str_replace('.', '', $fieldMappings['Author'] ?? '');
            @endphp
            @foreach($relatedItems as $rIndex => $relDoc)
                @php
                    $relTitle = $relDoc[$titleFieldName][0] ?? 'Untitled';
                    $relId = $relDoc['id'] ?? '';
                    if (is_array($relId)) {
                        $relId = $relId[0] ?? '';
                    }
                @endphp
                <li @class(['first' => $rIndex === 0, 'last' => $rIndex === count($relatedItems) - 1])>
                    <a class="related-record" href="{{ $collectionUrl('record/'.$relId) }}" title="{{ $relTitle }}">{{ $relTitle }}</a>

                    <div class="tags">
                        @if($authorFieldName !== '' && isset($relDoc[$authorFieldName]) && ! empty($relDoc[$authorFieldName]))
                            @php
                                $relAuthors = is_array($relDoc[$authorFieldName]) ? $relDoc[$authorFieldName] : [$relDoc[$authorFieldName]];
                            @endphp
                            @foreach($relAuthors as $author)
                                {!! $loop->first ? '' : ' ' !!}
                                @php
                                    $origFilter = urlencode($author);
                                    $lowerFilter = urlencode(strtolower($author));
                                @endphp
                                <a href="{{ $collectionUrl('search/*:*/Author:%22'.$lowerFilter.'+%7C%7C%7C+'.$origFilter.'%22') }}">{{ $author }}</a>
                            @endforeach
                        @endif
                    </div>
                </li>
            @endforeach
        @else
            <li>None.</li>
        @endif
    </ul>
@endsection
