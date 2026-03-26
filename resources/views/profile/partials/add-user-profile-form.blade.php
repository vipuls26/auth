<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile photo') }}

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('only .jpeg .png .jpg format are allow') }}
            </p>
        </h2>
    </header>


    <form action="{{ route('upload') }}" method="post" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method ('put')
        <x-input-label for="profilePhoto" :value="__('Profile picture')" />

        <div class="col-span-full">

            <label for="profilePhoto" class="block text-sm font-medium text-gray-700">Profile Photo</label>
            <div class="mt-2 flex items-center gap-4">


                <div class="relative w-12 h-12 rounded-full overflow-hidden">
                    <img src="{{ asset('storage/' . (Auth::user()->image?->image_path ?? 'profile/1774006004.jpg')) }}"
                        alt="profile"
                        class="absolute top-0 left-0 w-full h-full object-cover">
                </div>


                <x-text-input id="profilePhoto" name="profilePhoto" type="file"
                    class="block w-full text-sm text-gray-500
                             file:mr-4 file:py-2 file:px-4
                             file:rounded-full file:border-0
                             file:text-sm file:font-semibold
                             file:bg-blue-50 file:text-blue-700
                             hover:file:bg-blue-100"
                    accept="image/*" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('profilePhoto')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>

    </form>


</section>
