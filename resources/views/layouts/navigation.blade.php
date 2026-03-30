<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div>
        <div class="flex justify-between h-16">
            <div class="flex">

                <!-- Navigation Links -->


                @php
                $user = Auth::user();

                $roleName = $user && $user->roles->isNotEmpty() ? $user->roles->first()->name : 'user';
                @endphp
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    @auth
                    <x-nav-link :href="url('/' . $roleName . '/dashboard')" :active="request()->is($roleName . '/dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @else

                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">

                        <h3 class="text-end leading-none mb-1 font-semibold p-3">Welcome, {{ Auth::user()?->name ?? 'Guest' }}</h3>

                        <div class="relative w-12 h-12 rounded-full overflow-hidden">
                            <img src="{{ asset('storage/' . (Auth::user()->image?->image_path ?? 'profile/69c5227eb1a26.png')) }}" alt="profile"
                                class="absolute top-0 left-0 w-full h-full object-cover">
                        </div>

                    </button>
                    @endauth

                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">

                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">

                            <h3 class="text-end leading-none mb-1 font-semibold p-3">Welcome, {{ Auth::user()?->name ?? 'Guest' }}</h3>

                            <div class="relative w-12 h-12 rounded-full overflow-hidden">
                                <img src="{{ asset('storage/' . (Auth::user()->image?->image_path ?? 'profile/69c5227eb1a26.png')) }}" alt="profile"
                                    class="absolute top-0 left-0 w-full h-full object-cover">
                            </div>

                        </button>

                    </x-slot>



                    <x-slot name="content">
                        @auth
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        @if(Auth::user())
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                        @endif

                        @endauth
                    </x-slot>
                </x-dropdown>
                @else
                <div>
                    <a href="{{ route('login') }}" class="ml-auto px-3 py-2 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">Sign in</a>

                    <a href="{{ route('register') }}" class="ml-auto px-3 py-2 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">Sign up</a>

                </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">

            <x-nav-link :href="url('/' . $roleName . '/dashboard')" :active="request()->is($roleName . '/dashboard')">
                {{ __('Dashboard') }}
            </x-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()?->name ?? 'Guest' }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
