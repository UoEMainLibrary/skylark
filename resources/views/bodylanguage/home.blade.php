@extends('layouts.bodylanguage')

@section('title', 'Body Language')

@section('content')
<div class="record">
    <div id="collection-search" class="index-search">
        <form action="{{ $collectionUrl('redirect') }}" method="post">
            @csrf
            <fieldset class="search">
                <input type="text" name="q" value="{{ isset($searchbox_query) ? urldecode($searchbox_query) : '' }}" id="q" />
                <input type="submit" name="submit_search" class="btn" value="Search" id="submit_search" />
            </fieldset>
        </form>
    </div>

    <div class="content byEditor">
        <p>
            Body Language: movement, dance and physical education in Scotland, 1890&ndash;1990 preserved, conserved, catalogued,
            made accessible and virtually united three archive collections held by the University of Edinburgh and Culture Perth and Kinross: Museums.
            The archive collections include the archives of Dunfermline College of Physical Education, and Scottish Gymnastics (University of Edinburgh),
            and the archives of Margaret Morris Movement International (Culture Perth and Kinross: Museums).
        </p>

        <div>
            <div title="Suzanne Lenglen and Margaret Morris demonstrating a tennis exercise, c.1937. Margaret Morris Collection, Fergusson Gallery, Perth" id="dancer-image"></div>
            <div title="Dancer Jack Skinner and cricketer Donald Bradman. Illustrations from the prospectus of the Basic Physical Training Association, 1938. Margaret Morris Collection, Fergusson Gallery, Perth" id="cricket-image"></div>
        </div>

        <div class="clearfix"></div>
        <div class="big-divider"></div>
    </div>

    <div class="clearfix"></div>
</div>
@endsection
