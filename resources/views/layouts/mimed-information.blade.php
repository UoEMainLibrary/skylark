@extends('layouts.mimed-catalogue')

@section('content')
<div class="mimed-record-heading">
    <div class="mimed-wrap">
        <a class="mimed-back" href="{{ route('mimed.home') }}">← Musical Instrument Collection</a>
        <h1>@yield('page-heading')</h1>
    </div>
</div>
<div class="mimed-wrap mimed-information-layout">
    <article class="mimed-information">@yield('information')</article>
    <aside class="mimed-information-sidebar">
        <nav aria-label="Collection information">
            <h2>Collection information</h2>
            @foreach([
                'about' => 'About the collection',
                'iiif' => 'IIIF images',
                'feedback' => 'Feedback',
                'licensing' => 'Licensing & copyright',
                'takedown' => 'Takedown policy',
            ] as $pageName => $label)
                <a href="{{ route('mimed.'.$pageName) }}" @if(request()->routeIs('mimed.'.$pageName)) aria-current="page" @endif>{{ $label }}</a>
            @endforeach
        </nav>
        <a href="{{ route('mimed.search.index', ['query' => '*:*']) }}">Browse the catalogue →</a>
    </aside>
</div>
@endsection
