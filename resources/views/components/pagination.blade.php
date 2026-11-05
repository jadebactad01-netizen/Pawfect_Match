
@props(['paginator'])

@if ($paginator->hasPages())

    <div class="mt-8 flex justify-center">

        <nav aria-label="Pagination"
             class="inline-flex max-w-full overflow-x-auto rounded-xl border border-gray-300 bg-white shadow-sm">

            {{-- PREVIOUS --}}
            @if ($paginator->onFirstPage())
                <span class="whitespace-nowrap border-r border-gray-300 px-4 py-2 text-sm text-gray-400">
                    ‹ Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="whitespace-nowrap border-r border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                    ‹ Previous
                </a>
            @endif

            {{-- FIRST PAGE --}}
            @if ($paginator->currentPage() > 3)
                <a href="{{ $paginator->url(1) }}"
                   class="border-r border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                    1
                </a>
            @endif

            {{-- LEFT DOTS --}}
            @if ($paginator->currentPage() > 4)
                <span class="border-r border-gray-300 px-3 py-2 text-sm text-gray-400">
                    ...
                </span>
            @endif

            {{-- PAGE NUMBERS --}}
            @for ($page = max(1, $paginator->currentPage() - 2); $page <= min($paginator->lastPage(), $paginator->currentPage() + 2); $page++)

                @if ($page == $paginator->currentPage())
                    <span aria-current="page"
                          class="border-r border-gray-300 bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-900">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $paginator->url($page) }}"
                       class="border-r border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                        {{ $page }}
                    </a>
                @endif

            @endfor

            {{-- RIGHT DOTS --}}
            @if ($paginator->currentPage() < $paginator->lastPage() - 3)
                <span class="border-r border-gray-300 px-3 py-2 text-sm text-gray-400">
                    ...
                </span>
            @endif

            {{-- LAST PAGE --}}
            @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                <a href="{{ $paginator->url($paginator->lastPage()) }}"
                   class="border-r border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                    {{ $paginator->lastPage() }}
                </a>
            @endif

            {{-- NEXT --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="whitespace-nowrap px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                    Next ›
                </a>
            @else
                <span class="whitespace-nowrap px-4 py-2 text-sm text-gray-400">
                    Next ›
                </span>
            @endif

        </nav>

    </div>

@endif
