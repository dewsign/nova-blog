@isset($author->profileUrl)
    <a href="{{ $author->profileUrl }}">
@endisset

        <h4>{{ $author->name }}</h4>

@isset($author->profileUrl)
    </a>
@endisset
