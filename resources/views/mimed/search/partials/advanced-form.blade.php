<form class="mimed-advanced-form" action="{{ route('mimed.advanced.post') }}" method="post">
    @csrf
    <p>Use quotation marks to match an exact phrase.</p>
    @foreach($searchFields as $label => $field)
        @php $fieldName = str_replace(' ', '_', $label); @endphp
        <label for="{{ $fieldName }}">{{ $label }}</label>
        <input type="text" name="{{ $fieldName }}" id="{{ $fieldName }}" value="{{ urldecode($savedSearch[$label] ?? '') }}">
    @endforeach
    <label for="operators">Default search operator</label>
    <select name="operator" id="operators">
        <option value="OR" @selected(($operator ?? 'OR') === 'OR')>OR (any terms may match)</option>
        <option value="AND" @selected(($operator ?? 'OR') === 'AND')>AND (all terms must match)</option>
    </select>
    <button class="mimed-button" type="submit" name="search" value="Search">Search</button>
</form>
