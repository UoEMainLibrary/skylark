@extends('stcecilias.museum.layout')
@section('content')
<section class="sch-page-heading"><p class="sch-eyebrow">Experience St Cecilia’s</p><h1>{{ $page->title }}</h1><p class="sch-lead">{{ $page->intro }}</p></section>
<section class="sch-events-section" aria-label="Upcoming events">
    @if($page->body)<div class="sch-rich">{!! \Filament\Forms\Components\RichEditor\RichContentRenderer::make($page->body)->toHtml() !!}</div>@endif
    @include('stcecilias.museum.event-cards')
    <div class="sch-pagination">{{ $events->links() }}</div>
</section>
@endsection
