<h2>@lang('Articles') in {{ $page->h1 }}</h2>
<ul>
    @foreach($articles as $article)
        <li><a href="{{ route('blog.show', [$article->primaryCategory, $article]) }}">{{ $article->navTitle }}</a></li>
    @endforeach
</ul>

<h2>@lang('Categories')</h2>
<ul>
    <li><a href="{{ route('blog.index') }}">@lang('All')</a></li>
    @foreach($categories as $category)
        <li><a href="{{ route('blog.list', [$category]) }}">{{ $category->navTitle }}</a></li>
    @endforeach
</ul>

<div>
    @repeaterblocks($page)
</div>
