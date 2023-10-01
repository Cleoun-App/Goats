@if ($paginator->hasPages())
    <nav class="tabulator">
        <div class="tabulator-footer mt-3">
            <span class="tabulator-paginator">

                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <a class="tabulator-page disabled" href="javascript: void(0)" role="button"
                        aria-label="@lang('pagination.previous')" title="Prev Page" data-page="prev" disabled="true" disabled>
                        Prev
                    </a>
                @else
                    <a class="tabulator-page" type="button" role="button" aria-label="@lang('pagination.previous')"
                        title="Prev Page" data-page="prev" disabled="true" disabled
                        href="{{ $paginator->previousPageUrl() }}">
                        Prev
                    </a>
                @endif


                <span class="tabulator-pages">

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <button class="tabulator-page disabled" type="button"
                                role="button">{{ $element }}</button>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <button class="tabulator-page active" type="button" role="button"
                                        aria-label="Show Page 1" title="Show Page 1"
                                        data-page="{{ $page }}">{{ $page }}</button>
                                @else
                                    <a class="tabulator-page" href="{{ $url }}" role="button"
                                        aria-label="Show Page 2" title="Show Page 2"
                                        data-page="{{ $page }}">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                </span>


                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a class="tabulator-page" type="button" role="button" aria-label="@lang('pagination.next')"
                        title="Prev Page" data-page="prev" disabled="true" disabled
                        href="{{ $paginator->nextPageUrl() }}">
                        Next
                    </a>
                @else
                    <a class="tabulator-page disabled" href="javascript: void(0)" role="button"
                        aria-label="@lang('pagination.next')" title="Prev Page" data-page="prev" disabled="true" disabled>
                        Next
                    </a>
                @endif
            </span>

        </div>
    </nav>
@endif
