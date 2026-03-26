<x-app-layout>
    <form action="{{ route('blog.store') }}" method="POST" class="max-w-xl mx-auto p-4 space-y-4 border rounded shadow" id="blogFormId" enctype="multipart/form-data"   >
        @csrf

        <!-- title -->
        <div>
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" placeholder="Post Title" />

            <div class="text-red-500">
                <x-input-error :messages="$errors->get('title')" class="error mt-2" id="title-error" for="title" />
                <label id="title-error" class="error" for="title"></label>
            </div>

        </div>

        <!-- image upload -->
        <div>
            <x-input-label for="image" :value="__('Image')" />
            <x-text-input id="image" name="image" type="file" class="mt-1 block w-full" :value="old('image')" accept="image/*" />

            <div class="text-red-500">
                <x-input-error :messages="$errors->get('image')" class="error mt-2" id="image-error" for="image" />
                <label id="image-error" class="error" for="image"></label>
            </div>
        </div>

        <!-- category -->
        <div>
            <x-input-label for="category" :value="__('Category')" />
            <select class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 w-full mt-1 p-2 border rounded" name="category">

                @if($category && $category->isNotEmpty())
                @foreach($category as $category)
                <option value="{{ $category['name'] }}  "> {{ $category['name'] }}</option>
                @endforeach
                @endif
            </select>
        </div>

        <!-- content -->
        <div>
            <x-input-label for="content" :value="__('Content')" />
            <x-textarea-input name="content" id="content">{{ old('content') }}</x-textarea-input>

            <div class="text-red-500">
                <x-input-error :messages="$errors->get('content')" class="error mt-2" id="content-error" for="content" />
                <label id="content-error" class="error" for="content"></label>
            </div>
        </div>


        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Submit</button>
    </form>

</x-app-layout>


<!-- jquery cdn -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

<script>
    $(document).ready(function() {
        $('#blogFormId').validate({
            rules: {
                title: {
                    required: true,
                    minlength: 3,

                },
                image : {
                    required : true,
                    extension: true,
                },
                category: {
                    required: true,
                },
                content: {
                    required: true,
                    minlength: 5
                }
            },
            messages: {
                title: {
                    required: "title is required",
                    minlength: "atleast 3 character required",
                },
                image : {
                    required: "image is required",
                    extension: "Only PNG , JPEG , JPG, GIF File Allowed"
                },
                category: {
                    required: 'category is required',
                },
                content: {
                    required: "content is required",
                    minlength: "atleast 5 character required"
                }
            }
        });
    });
</script>
