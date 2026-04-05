@extends('layouts.guardbook')

@section('title', $recordTitle . ' - ' . config('skylight.fullname'))

@section('content')
@php
    $fieldMappings = config('skylight.field_mappings', []);
    $filters = array_keys(config('skylight.filters', []));
    $schema = config('skylight.schema_links', []);

    $subject_field = str_replace('.', '', $fieldMappings['Subject'] ?? '');
    $bitstream_field = str_replace('.', '', $fieldMappings['Bitstream'] ?? '');
    $thumbnail_field = str_replace('.', '', $fieldMappings['Thumbnail'] ?? '');

    $link_bitstream = $link_bitstream ?? true;

    $orderedBitstreams = [];
    if ($bitstream_field !== '' && isset($record[$bitstream_field]) && is_array($record[$bitstream_field])) {
        foreach ($record[$bitstream_field] as $bitstream) {
            $segments = explode('##', $bitstream);
            $seq = $segments[4] ?? null;
            if ($seq !== null) {
                $orderedBitstreams[$seq] = $bitstream;
            }
        }
        ksort($orderedBitstreams);
    }

    $title_field = str_replace('.', '', $fieldMappings['Title'] ?? '');
@endphp

<div class="col-md-9 col-sm-9 col-xs-12">
    <div itemscope itemtype="http://schema.org/CreativeWork">
        <h1 class="itemtitle">{{ $recordTitle }}</h1>

        <table>
            <tbody>
            <tbody>
            @foreach($recordDisplay as $key)
                @php
                    $element = str_replace('.', '', $fieldMappings[$key] ?? '');
                @endphp

                @if($element !== '' && isset($record[$element]))
                    <tr>
                        <th>{{ $key }}&nbsp;</th>
                        <td>
                            @foreach($record[$element] as $index => $metadatavalue)
                                @if(in_array($key, $filters))
                                    @php
                                        $orig_filter = urlencode($metadatavalue);
                                        $lower_orig_filter = urlencode(strtolower($metadatavalue));
                                        $filterUrl = './search/*:*/' . $key . ':%22' . $lower_orig_filter . '+%7C%7C%7C+' . $orig_filter . '%22';
                                    @endphp

                                    @if(isset($schema[$key]))
                                        <span itemprop="{{ $schema[$key] }}">
                                            <a href="{{ $filterUrl }}">{{ $metadatavalue }}</a>
                                        </span>
                                    @else
                                        <a href="{{ $filterUrl }}" title="{{ $metadatavalue }}">{{ $metadatavalue }}</a>
                                    @endif
                                @else
                                    @if(isset($schema[$key]))
                                        <span itemprop="{{ $schema[$key] }}">{{ $metadatavalue }}</span>
                                    @else
                                        {{ $metadatavalue }}
                                    @endif
                                @endif

                                @if($index < count($record[$element]) - 1)
                                    ;
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>

    @if(isset($record[$bitstream_field]) && $link_bitstream)
        <div class="record_bitstreams">
            @foreach($orderedBitstreams as $bitstream)
                @php
                    $segments = explode('##', $bitstream);
                    $filename = $segments[1] ?? '';
                    $handle = $segments[3] ?? '';
                    $seq = $segments[4] ?? '';
                    $handleId = preg_replace('/^.*\//', '', $handle);

                    $isPdf = str_ends_with(strtolower($filename), '.pdf');
                @endphp

               @if($isPdf)

                {{--
                @php
                    $pdfViewerSrc = asset('collections/guardbook/addons/PDF_Viewer/pdf_reader.php');
                    $pdfAbsolute = url('/guardbook/' . ltrim(\App\Helpers\BitstreamHelper::getUri($bitstream), '/'));
                @endphp

                <br>
                <iframe
                    src="{{ $pdfViewerSrc }}?url={{ $pdfAbsolute }}"
                    title="PDF Viewer"
                    width="700"
                    height="900">
                </iframe>

               --}}


                @php
                    $proxyPdfUrl = url('/guardbook/record/' . $handleId . '/' . $seq . '/' . $filename);
                @endphp

                <iframe
                    src="{{ $proxyPdfUrl }}"
                    title="PDF Viewer"
                    width="700"
                    height="900">
                </iframe>


                <br>

                Click
                <a href="{{ $proxyPdfUrl }}" target="_blank" rel="noopener noreferrer">
                    {{ $filename }}<span class="visually-hidden"> (opens in a new tab)</span>
                </a>
                to download.
                @if(function_exists('getBitstreamSize'))
                    (<span class="bitstream_size">{{ getBitstreamSize($bitstream) }}</span>)
                @endif
                <br><br>
                @endif
            @endforeach
        </div>
    @endif

    <div class="clearfix"></div>

    <img
        src="{{ asset('collections/guardbook/images/CC-BY_icon.png') }}"
        alt="CC-BY attribution license"
        class="img-responsive"
    />

    <p>
        The PDFs are supplied under a Creative Commons CC-BY License: you may share and adapt for any purpose as long as attribution is given to the University of Edinburgh.
        Further information is available at
        <a href="http://creativecommons.org/licenses/by/4.0/" target="_blank" rel="noopener noreferrer">
            http://creativecommons.org/licenses/by/4.0/ (opens in a new tab)
        </a>
    </p>

    <div class="row">
        <button class="btn btn-info" onClick="history.go(-1);">
            <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Back to Search Results
        </button>
    </div>
</div>

@include('guardbook.record.partials.related-items', [
    'related_items' => $related_items ?? [],
    'title_field' => $title_field,
])
@endsection
