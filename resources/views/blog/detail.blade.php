<x-app-layout>


    <div class="relative mt-3 max-w-4xl mx-auto overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">



        @auth
        <a href="{{ url('/user/dashboard') }}"
            class="absolute top-4 left-4 z-20 flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white/90 backdrop-blur-sm rounded-lg border border-gray-200 hover:bg-white transition shadow-sm">
            Back
        </a>
        @endauth

        @guest
        <a href="{{ route('blog.all') }}"
            class="absolute top-4 left-4 z-20 flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white/90 backdrop-blur-sm rounded-lg border border-gray-200 hover:bg-white transition shadow-sm">
            Back
        </a>
        @endguest


        <div class="w-full h-[50vh]">
            <img
                src="{{ asset('storage/' . $blogDetail->image['image_path']) }}"
                alt="{{ $blogDetail->title }}"
                class="object-cover w-full h-full">
        </div>


        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <span class="px-3 py-1 text-xs font-semibold text-blue-600 uppercase bg-blue-100 rounded-full">
                    {{ $blogDetail->status }}
                </span>
                <span class="text-sm text-gray-500">
                    Created: {{ DateFormat($blogDetail->created_at) }}
                </span>
            </div>

            <h1 class="mb-4 text-3xl font-bold text-gray-900 leading-tight">
                {{ $blogDetail->title }}
            </h1>

            <p class="leading-relaxed text-gray-700">
                {{ $blogDetail->content }}
            </p>

        </div>
    </div>


</x-app-layout>
