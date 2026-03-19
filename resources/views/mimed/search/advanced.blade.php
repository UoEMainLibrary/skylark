@extends('layouts.mimed')

@section('title', 'Advanced Search - MIMEd')

@section('content')
<div class="col-main">

<h1>Advanced Search</h1>

<div class="searchform" style="display:block">
    <p><strong>Hint: </strong> To match an exact phrase, try using quotation marks, eg. <em>"a search phrase"</em></p>
<form action="{{ url('/mimed/advanced/post') }}" method="post" accept-charset="utf-8">
@csrf
@foreach($searchFields as $label => $field)
@php $escapedLabel = str_replace(' ', '_', $label); @endphp
<p><label for="{{ $escapedLabel }}" style="width: 100px; float: left; display: block; text-align: right;">{{ $label }}</label><input type="text" name="{{ $escapedLabel }}" value="" id="{{ $escapedLabel }}" style="margin-left: 15px;"  /></p>
@endforeach
<p><label for="operators" style="width: 100px; float: left; display: block; text-align: right;">Default search operator</label><select name="operator" style="margin-left:15px;">
<option value="OR" selected="selected">OR (any terms may match)</option>
<option value="AND">AND (all terms must match)</option>
</select></p><p style="margin-left: 120px;"><em>Use <strong>AND</strong> for narrow searches and <strong>OR</strong> for broad searches</em></p><input type="submit" name="search" value="Search" style="margin-left: 120px" class="btn" /></form>
</div>

<script>
    $("#showform").click(function() {
        $(".searchform").show();
        $(this).hide();
        $(".message").hide();

        return false;
    });
</script>
</div>
<div class="col-sidebar">
</div>
@endsection
