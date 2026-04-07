<x-app-layout>

    @if (empty($allBlogs) || $allBlogs->count() === 0)
        <div class="flex flex-col items-center justify-center py-20">
            <p class="text-gray-500 text-lg font-medium">No blogs to restore</p>
            <a href="{{ route('user.dashboard') }}">
                Back to dashboard
            </a>
        </div>
    @else
        <form action="{{ route('blog.restoreBlog') }}" method="POST">
            @csrf

            {{-- restore button --}}
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Restore Blogs</h2>

                <button type="submit"
                    class="Restore px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition">
                    Restore Selected
                </button>
            </div>

            {{-- blog --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                @foreach ($allBlogs as $allBlog)
                    <label class="relative group">

                        {{-- input field --}}
                        <input type="checkbox" name="blog_ids[]" value="{{ $allBlog->id }}"
                            class="absolute top-3 left-3 z-10 h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                        {{-- card --}}
                        <div
                            class="flex flex-col h-full overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm group-hover:shadow-md transition">

                            {{-- image --}}
                            <div class="aspect-video first:bg-gray-200">
                                <img src="{{ $allBlog->image ? asset('storage/' . $allBlog->image->image_path) : asset('images/default-placeholder.png') }}"
                                    alt="{{ $allBlog->title }}" class="h-full w-full object-cover" />
                            </div>

                            {{-- content --}}
                            <div class="flex flex-col justify-between flex-1 p-4">

                                <div>
                                    {{-- title --}}
                                    <h3 class="text-lg font-semibold text-gray-900 line-clamp-1">
                                        {{ $allBlog->title }}
                                    </h3>

                                    {{-- category --}}
                                    <span class="inline-block mt-2 bg-gray-800 text-white text-xs px-2 py-1 rounded">
                                        {{ $allBlog->category['name'] }}
                                    </span>

                                    {{-- description --}}
                                    <p class="mt-2 text-sm text-gray-600 line-clamp-2">
                                        {{ $allBlog->content }}
                                    </p>
                                </div>


                                <div class="mt-4 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <img class="h-8 w-8 rounded-full"
                                            src="{{ $allBlog->user?->image ? asset('storage/' . $allBlog->user->image->image_path) : asset('storage/default-avatar.png') }}"
                                            alt="">
                                        <span class="text-sm text-gray-800">
                                            {{ $allBlog->user?->name ?? 'Unknown' }}
                                        </span>
                                    </div>

                                    <span class="text-xs text-gray-500">
                                        {{ DateFormat($allBlog->updated_at) }}
                                    </span>
                                </div>

                            </div>
                        </div>

                    </label>
                @endforeach

            </div>

        </form>
    @endif
</x-app-layout>


<!-- fontawesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- jquery cdn -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- sweet alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // restore blog
        $('.Restore').on('click', function(event) {
            event.preventDefault();

            var form = $(this).closest('form');

            Swal.fire({
                title: 'Restore all trash blogs?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1bc4ae',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, restore it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Restored!', 'Your blogs are being restored.', 'success');

                    setTimeout(() => {

                        form[0].submit();
                    }, 1000);
                }
            });
        });
    });
</script>
