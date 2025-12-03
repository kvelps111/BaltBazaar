@if ($paginator->hasPages())
    <div class="flex items-center justify-between">
        {{-- Left side: Items info --}}
        <div class="text-sm text-gray-600">
            <span class="font-semibold">Showing</span>
            <span class="font-semibold text-green-600">{{ $paginator->firstItem() }}</span>
            to
            <span class="font-semibold text-green-600">{{ $paginator->lastItem() }}</span>
            of
            <span class="font-semibold text-green-600">{{ $paginator->total() }}</span>
            items
        </div>

        {{-- Right side: Pagination controls --}}
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center gap-1">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <button disabled class="px-3 py-2 text-gray-400 bg-white border border-gray-300 rounded-lg cursor-not-allowed">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 text-green-600 bg-white border border-gray-300 rounded-lg hover:bg-green-50 hover:border-green-500 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-2 py-2 text-gray-500">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <button disabled class="px-3 py-2 text-white bg-green-500 border border-green-500 rounded-lg font-semibold cursor-default">
                                {{ $page }}
                            </button>
                        @else
                            <a href="{{ $url }}" class="px-3 py-2 text-green-600 bg-white border border-gray-300 rounded-lg hover:bg-green-50 hover:border-green-500 transition font-medium">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 text-green-600 bg-white border border-gray-300 rounded-lg hover:bg-green-50 hover:border-green-500 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            @else
                <button disabled class="px-3 py-2 text-gray-400 bg-white border border-gray-300 rounded-lg cursor-not-allowed">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            @endif
        </nav>
    </div>
@endif