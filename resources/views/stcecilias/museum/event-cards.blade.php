<div @class(['grid gap-x-8 gap-y-14 md:grid-cols-2 lg:grid-cols-3' => ! ($detail ?? false), 'sch-article' => $detail ?? false])>
@forelse($events as $event)
<article class="sch-event">
    @if($event->imageUrl())<img class="sch-event-image" src="{{ $event->imageUrl() }}" alt="{{ $event->image_alt }}" loading="lazy" width="1024" height="576">@else<div class="sch-event-art" aria-hidden="true"><span>St Cecilia’s Hall</span><strong>{{ $event->category ?: 'Event' }}</strong></div>@endif
    <div class="sch-event-meta"><span>{{ $event->category ?: 'Event' }}</span><span>{{ $event->price }}</span></div>
    @unless($detail ?? false)<h2><a href="{{ route('stcecilias.museum.event', ['slug' => $event->slug]) }}">{{ $event->title }}</a></h2>@endunless
    <p class="sch-event-date"><time datetime="{{ $event->starts_at->toIso8601String() }}">{{ $event->starts_at->timezone('Europe/London')->format('d F Y · H:i') }}</time>@if($event->ends_at) – <time datetime="{{ $event->ends_at->toIso8601String() }}">{{ $event->ends_at->timezone('Europe/London')->format($event->ends_at->isSameDay($event->starts_at) ? 'H:i' : 'd F Y · H:i') }}</time>@endif</p>
    <p>{{ $event->intro }}</p>
    @if($event->body)<details @if($detail ?? false) open @endif><summary>Event information</summary><div class="sch-rich">{!! \Filament\Forms\Components\RichEditor\RichContentRenderer::make($event->body)->toHtml() !!}</div></details>@endif
    <p class="sch-event-venue">{{ $event->venue }}</p>
    @if($event->booking_url && ! ($archive ?? false))<a class="sch-event-link" href="{{ $event->booking_url }}">Booking &amp; tickets <span aria-hidden="true">↗</span><span class="sr-only"> for {{ $event->title }}</span></a>@endif
</article>
@empty
<p class="sch-empty">{{ ($archive ?? false) ? 'There are no past events listed.' : 'There are no upcoming events listed at the moment. Please check back soon.' }}</p>
@endforelse
</div>
