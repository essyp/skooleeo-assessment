@if ($paginator->hasPages())
<div class="pagination mt-50">
    {{--  <ul>  --}}
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            {{-- <li class="disabled page-item"><a class="page-link">Previous</a></li> --}}
        @else
            <a class="prev" href="{{ $paginator->previousPageUrl() }}"><span aria-hidden="true" class="fa fa-angle-left"></span></a>
        @endif
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled page-item"><span>{{ $element }}</span></li>
            @endif
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="" class="active" >{{ $page }}<span class="sr-only">(current)</span></a>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="next" href="{{ $paginator->nextPageUrl() }}"><span aria-hidden="true" class="fa fa-angle-right"></span></a>
        @else
            {{-- <li class="disabled page-item"><a class="page-link">Next</a></li> --}}
        @endif
    {{--  </ul>  --}}
</div>
@endif
