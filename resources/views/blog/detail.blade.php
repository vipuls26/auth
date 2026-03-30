<x-app-layout>


    <div class="relative mt-3 max-w-4xl mx-auto overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">


        <a href="{{ url()->previous() }}"
            class="absolute top-4 left-4 z-20 flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white/90 backdrop-blur-sm rounded-lg border border-gray-200 hover:bg-white transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back
        </a>


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
                    Created: {{ \Carbon\Carbon::parse($blogDetail->created_at)->format('M d, Y') }}
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
