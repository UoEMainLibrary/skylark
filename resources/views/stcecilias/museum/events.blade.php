@extends('stcecilias.museum.layout')
@section('content')
<section class="sch-page-heading"><p class="sch-eyebrow">Experience St Cecilia’s</p><h1>{{ $page->title }}</h1><p class="sch-lead">{{ $page->intro }}</p></section>
<section class="sch-events-section" aria-label="{{ $page->title }}">
    @if($page->body)<div class="sch-rich">{!! \Filament\Forms\Components\RichEditor\RichContentRenderer::make($page->body)->toHtml() !!}</div>@endif
    <p><a href="{{ ($archive ?? false) ? route('stcecilias.museum.events') : route('stcecilias.museum.archive') }}">{{ ($archive ?? false) ? 'Upcoming events' : 'Past events' }} →</a></p>
    @if(($archive ?? false) && ! ($detail ?? false) && $hasIcomArchive)
        <p><a href="{{ route('stcecilias.museum.page', ['slug' => 'archive/icom-music-2026']) }}">ICOM MUSIC Annual Meeting 2026 →</a></p>
    @endif
    @include('stcecilias.museum.event-cards')
    @unless($detail ?? false)<div class="sch-pagination">{{ $events->links() }}</div>@endunless
</section>
@endsection
