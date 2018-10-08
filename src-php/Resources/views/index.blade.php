<h2>@lang('Articles')</h2>
<ul>
    @foreach($articles as $article)
        <li><a href="{{ route('blog.show', [$article->primaryCategory, $article]) }}">{{ $article->navTitle }}</a></li>
    @endforeach
</ul>

<h2>@lang('Categories')</h2>
<ul>
    @foreach($categories as $category)
        <li><a href="{{ route('blog.list', [$category]) }}">{{ $category->navTitle }}</a></li>
    @endforeach
</ul>
