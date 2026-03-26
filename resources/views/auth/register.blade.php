<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" id="registerUser">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
            <span class="text-red-500">
                <label id="name-error" class="error" for="name"></label>
            </span>

        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <span class="text-red-500">
                <label id="email-error" class="error" for="email"></label>
            </span>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                placeholder="password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <span class="text-red-500">
                <label id="password-error" class="error" for="password"></label>
            </span>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                placeholder="confirm password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            <span class="text-red-500">
                <label id="password_confirmation-error" class="error" for="password_confirmation"></label>
            </span>
        </div>

        <!-- role -->


        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />

            @if($roles && $roles->isNotEmpty())
            <div class="inline-flex items-center">
                @foreach($roles as $role)
                <x-radio name="role" value=" {{ $role['name'] }}" label=" {{ $role['name'] }}" :checked="old('role') == ' {{ $role['name'] }}'" checked />
                @endforeach
            </div>

            @else
            add role first

            @endif

            <div class="text-red-500">
                <label id="role-error" class="error" for="role"></label>
            </div>

        </div>

        <div class="flex justify-center mt-4">

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>

        <div class="flex justify-center mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

        </div>
    </form>


</x-guest-layout>

@if(Session::has('message'))
<x-toast.success></x-toast.success>
@endif

<!-- jquery cdn -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
<script>
    $(document).ready(function() {
        $('#registerUser').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2,
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "{{ url('/checkEmail') }}",
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            email: function() {
                                return $("#email").val();
                            }
                        }
                    }
                },
                password: {
                    required: true,
                    minlength: 8
                },
                password_confirmation: {
                    required: true,
                    equalTo: '#password',
                    minlength: 8
                },
                role: {
                    required: true
                }
            },

            messages: {
                name: {
                    required: "name is required",
                    minlength: "atleast 2 character"
                },
                email: {
                    required: "email is required",
                    email: "valid email address",
                    remote: "this email is exist"
                },
                password: {
                    required: "password is required",
                    minlength: "atleast 8 character"
                },
                password_confirmation: {
                    required: "confirm password is required",
                    equalTo: "must match to password",
                    minlength: "atleast 8 character"
                },
                role: {
                    required: "role is required"
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
    });
</script>
