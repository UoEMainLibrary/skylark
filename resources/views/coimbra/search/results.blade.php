@extends('layouts.coimbra')

@section('title')
    @if($query !== '*' && $query !== '*:*')
        Search Results for "{{ urldecode($query) }}" - Coimbra Virtual Exhibition
    @else
        Search Results -Coimbra Virtual Exhibition
    @endif
@endsection

@section('content')
<div class="row" id="content">
    <div class="col-md-7 col-xs-12 gallery">
        <div class="col-xs-12 text-center visible-xs">
            <h5 class="text-muted">All <?php echo urldecode($searchbox_query) ?> records </h5>
        </div>
        <div id="gallery-container">
            <script>
                $(window).bind("load", function() {
                    initMap();
                });
            </script>
            @foreach($docs as $index => $doc)
                @php
                    $fieldMappings = config('skylight.field_mappings', []);
                    $titleField = str_replace('.', '', $fieldMappings['Title'] ?? 'dctitleen');
                    $coverImageName = str_replace('.', '', $fieldMappings['Image File Name'] ?? '');
                    $location = str_replace('.', '', $fieldMappings['Institutional Map Reference']?? '');
                    $title = isset($doc[$titleField][0]) ? $doc[$titleField][0] : "Untitled";
                    $imageServer = config('skylight.image_server');
                    $id_field = str_replace('.', '', $fieldMappings['ID'] ?? '');
                    $image = str_replace('.', '', $fieldMappings['Image URL'] ?? '');

                    if (isset($doc[$coverImageName][0]))
                    {
                        if (strpos($doc[$coverImageName][0], 'ttps') > 0)
                        {
                            $coverImageJSON = $doc[$coverImageName][0];
                            $coverImageURL = str_replace("/full/full", '/full/400,', $coverImageJSON);
                            $coverImageURLMap = str_replace("/full/full", '/full/50,', $coverImageJSON);
                        }
                        else
                        {
                            $coverImageJSON = $imageServer . "/iiif/2/" . $doc[$coverImageName][0];
                            $coverImageURL = $coverImageJSON . '/full/400,/0/default.jpg';
                            $coverImageURLMap = $coverImageJSON . '/full/50,/0/default.jpg';
                        }
                    }

                    else{
                        $coverImageJSON = $imageServer . "/iiif/2/missing.jpg";
                    }

                    $thumbnailLink = '<img class="img-responsive" src ="' . $coverImageURL . '" title="' . $title . '" />';


                @endphp
                @if(isset($doc[$location][0]))
                    <script>
                        $(window).on("load", function () {
                            addLocation(
                                @json($doc[$location][0]),
                                @json($title),
                                @json($doc['id']),
                                @json($coverImageURLMap)
                            );
                        });
                    </script>
                @endif

                <a href="{{ url('/coimbra/record/' . $doc['id']) }}" class="{{ $doc['id'] }} row record visible">
                    <!--                    Title-->
                    <h4 class="result-info record-title">
                        {{ $title }}
                    </h4>
                    <!--                    Thumbnail-->
                    {!! $thumbnailLink !!}
                </a>
            @endforeach
        </div>
    </div>
    <div class="col-md-5 hidden-sm hidden-xs sidebar">
    <div class="sidebar-nav">

        <ul class="list-group">
            <li class="list-group-item">
                <?php /*
                if(isset($searchbox_filters) && count($searchbox_filters) > 0)
                {
                    $filter_segments = explode("\"", urldecode($searchbox_filters[0]));
                    $case_segments = explode("|||", urldecode($filter_segments[1]));

                    echo " " . $case_segments[1] . " ";
                }
                else {
                    echo "All " . urldecode($searchbox_query) . " ";
                }
                */?>
                <!--records-->
                <a class="pull-right map-view">Map view</a>
            </li>
            <li class="list-group-item">
                <div id="map">
                </div>
            </li>
        </ul>
    </div>
</div>
@endsection
