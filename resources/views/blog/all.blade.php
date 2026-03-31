<x-app-layout>

    <div class="mx-auto sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">

        <!-- title + search -->
        <div class="flex flex-wrap justify-between md:flex-nowrap">

            <div class="m-2">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">All Blogs</h2>
            </div>

            <div class="flex">
                <form action="{{ route('blog.all') }}" method="post">
                    @csrf

                    @if(request()->filled('category'))
                    @foreach(request('category') as $categoryId)
                    <input type="hidden" name="category[]" value="{{ $categoryId }}">
                    @endforeach
                    @endif
                    <x-text-input id="title" class="" type="search" name="search" value="{{ request()->input('search') }}"></x-text-input>
                    <button class="bg-cyan-500 hover:bg-cyan-700 text-white py-2 px-4 rounded-full">search</button>
                </form>
            </div>

        </div>

        <!-- category -->
        <div class="p-4 m-2 bg-white rounded-lg shadow-sm border border-gray-100">

            <form action="{{ route('blog.all') }}" method="get" class="space-y-4">

                <div class="flex">

                    <div class="flex items-center flex-wrap me-4 gap-2 md:gap-4">
                        @foreach($category as $cat)

                        <div class="flex items-center">
                            <input
                                id="cat-{{ $cat->id }}"
                                type="checkbox"
                                name="category[]"
                                value="{{ $cat->id }}"
                                class="sr-only peer"
                                @checked(in_array($cat->id, (array) request('category')))>

                            <label for="cat-{{ $cat->id }}" class="flex items-center space-x-2 p-2 rounded-md border border-gray-200 peer-checked:bg-indigo-100 peer-checked:border-indigo-600 peer-checked:text-indigo-900 cursor-pointer text-sm md:text-base">
                                {{ $cat->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <div class="gap-4">
                        <button type="submit" class="justify-end mb-4 px-3 py-2 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            Filter
                        </button>

                        <a href="{{ route('blog.all') }}" class="ml-auto px-3 py-2 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">Clear</a>

                    </div>

                </div>

            </form>

        </div>



        <!-- blog display -->
        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">

            @if(!empty($blogs) && $blogs->count() > 0)

            @foreach($blogs as $blog)

            <div class="group relative flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white">

                <div class="aspect-video w-full overflow-hidden bg-gray-200 sm:aspect-square">
                    <img src="{{ $blog->image ? asset('storage/' . $blog->image->image_path) : asset('images/default-placeholder.png') }}"
                        alt="{{ $blog->title }}"
                        class="h-full w-full object-cover object-center group-hover:opacity-75 transition-opacity" />
                </div>

                <div class="flex flex-1 flex-col justify-between p-4">
                    <div>
                        <!-- title -->
                        <h3 class="text-xl font-semibold text-gray-900">
                            <a href="{{ url('/blog/'.$blog->id . '/detail') }}">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                {{ $blog->title }}
                            </a>
                        </h3>

                        <!-- category -->
                        <span class="inline-flex items-center mt-2 rounded-md bg-gray-700 px-2.5 py-0.5 text-xs font-medium text-white shadow-sm">
                            {{ $blog->category['name'] }}
                        </span>

                        <!-- content -->
                        <p class="mt-2 text-sm text-gray-600 line-clamp-2">
                            {{ $blog->content }}
                        </p>
                    </div>

                    <!-- author name -->
                    <div class="mt-6 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-2">
                            <img class="h-8 w-8 rounded-full bg-gray-200"
                                src="{{ $blog->user?->image ? asset('storage/' . $blog->user->image->image_path) : asset('images/default-avatar.png') }}"
                                alt="{{ $blog->user?->name ?? 'Unknown' }}">
                            <p class="text-sm font-medium text-gray-900">
                                {{ $blog->user?->name ?? 'unknown' }}
                            </p>
                        </div>
                        <p class="text-sm text-gray-500">
                            {{ DateFormat($blog->updated_at) }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach

            @else
            <p>No blogs related</p>
            @endif

        </div>

        <p class="mt-4"> {{ $blogs->appends(request()->query())->links() }} </p>

    </div>

</x-app-layout>
