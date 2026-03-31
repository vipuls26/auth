<x-app-layout>

    <div class="flex overflow-hidden">

        <div class="flex-1 overflow-y-auto p-6 md:p-10">

            <header class="flex justify-between items-center mb-10">
                <h1 class="text-2xl font-bold">overview</h1>
                <button><a href="{{ route('blog.add') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">+ New Post</a></button>
            </header>

            <!-- card -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">


                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs border border-blue-200">
                    <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">

                        <i class="fa-regular fa-newspaper"></i>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600">
                            Total Posts
                        </p>
                        <p class="text-2xl font-semibold text-gray-700">
                            {{ $total_blogs }}
                        </p>
                    </div>
                </div>


                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs border border-green-200">
                    <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
                        <i class="fa-regular fa-circle-check"></i>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600">
                            Publish
                        </p>
                        <p class="text-2xl font-semibold text-gray-700">
                            {{ $approved_blog }}
                        </p>
                    </div>
                </div>


                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs border border-yellow-200">
                    <div class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full">
                        <i class="fa-regular fa-hourglass-half"></i>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600">
                            Pending
                        </p>
                        <p class="text-2xl font-semibold text-gray-700">
                            {{ $pending_blog }}
                        </p>
                    </div>
                </div>


                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs border border-indigo-200">
                    <div class="p-3 mr-4 text-indigo-500 bg-indigo-100 rounded-full">
                        <i class="fa-regular fa-comment"></i>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600">
                            Review
                        </p>
                        <p class="text-2xl font-semibold text-gray-700">
                            {{ $reviewd_blog }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="container-fluid mx-auto px-4 gap-6">

        <div class="flex flex-wrap justify-between md:flex-nowrap">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">My Blogs</h2>
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
                        <h4 class="text-xl font-semibold text-gray-900">
                            <a href="{{ url('/blog/'.$blog->id . '/detail') }}">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                {{ $blog->title }}
                            </a>
                        </h4>

                        <!-- category -->
                        <span class="inline-flex items-center mt-2 rounded-md bg-gray-700 px-2.5 py-0.5 text-xs font-medium text-white shadow-sm">
                            {{ $blog->category['name'] }}
                        </span>

                        <span class="inline-flex items-center mt-2 rounded-md bg-yellow-600 px-2.5 py-0.5 text-xs font-medium text-white shadow-sm">
                            {{ $blog->status }}
                        </span>




                        <!-- content -->
                        <p class="mt-2 text-sm text-gray-600 line-clamp-2">
                            {{ $blog->content }}
                        </p>
                    </div>

                </div>

                <!-- edit + delete -->
                <div class="mt-6 flex items-center justify-between gap-4 relative z-10">
                    <!-- edit -->
                    <a href="{{ route('blog.edit', $blog->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="glyphicon glyphicon-trash">Edit</i>
                    </a>


                    <!-- delete -->

                    <form action="{{ route('blog.delete', $blog->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="Delete bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            <i class="glyphicon glyphicon-trash">Delete</i>
                        </button>
                    </form>
                </div>

            </div>

            @endforeach

            @else
            <p>No blogs related</p>
            @endif

        </div>


        <!-- pagination -->
        <p class="mt-4"> {{ $blogs->appends(request()->query())->links() }} </p>


    </div>

</x-app-layout>


@if(Session::has('message'))
<x-toast.success></x-toast.success>
@endif

<!-- fontawesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- jquery cdn -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- sweet alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {

        // toast message
        setTimeout(() => {
            $('.Toast').fadeOut('fast');
        }, 2000);

        // sweet alert
        $('.Delete').on('click', function(event) {

            event.preventDefault();
            var form = $(this).closest("form");


            Swal.fire({
                title: 'Are you sure?',
                text: "This change are perment",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#eab308',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {

                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
