<x-guest-layout>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                placeholder="password" />

            <i class="fas fa-eye-slash" id="togglePassword"></i>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <div class="flex justify-between">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif
            </div>
        </div>

        <div class="flex justify-center mt-4">

            <x-primary-button class="ms-3 gggggggg">
                {{ __('Log in') }}
            </x-primary-button>

        </div>

        <hr class="border-gray-400 border-1 my-4">

        <div class="flex justify-center mt-2">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md" href="{{ route('register') }}">
                Don't have account?
            </a>
        </div>

    </form>
</x-guest-layout>

@if(Session::has('message'))
<x-toast.success></x-toast.success>
@endif

<!-- fontawesome -->
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"></script>

<!-- jquery cdn -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
<script>
    $(document).ready(function() {
        $('#registerUser').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8
                }
            },

            messages: {
                email: {
                    required: "email is required",
                    email: "valid email address"
                },
                password: {
                    required: "password is required",
                    minlength: "atleast 8 character"
                }

            },
            submitHandler: function(form) {
                form.submit();
            }
        });


        // toast message
        setTimeout(() => {
            $('.Toast').fadeOut('fast');
        }, 2000);

        // password hide/show
        $('#togglePassword').on('click', function() {
            const passwordField = $('#password');
            const type = passwordField.attr('type') === 'password' ? 'text' : 'password';

            passwordField.attr('type', type);

            $(this).text(type === 'password' ? 'Show' : 'Hide');
        });
    });
</script>
