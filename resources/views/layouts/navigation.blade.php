<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Left: Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold text-[#2ecc71] hover:text-[#27ae60]">
                    BaltBazaar
                </a>
            </div>

            <!-- Center: Links -->
            <div class="hidden sm:flex sm:space-x-8 sm:ml-10">
                <x-nav-link 
                    :href="route('dashboard')"  
                    :active="request()->routeIs('dashboard')"
                    class="!text-gray-800 !bg-white hover:!text-[#2ecc71]"
                >
                    {{ __('Home') }}
                </x-nav-link>

                <x-nav-link 
                    :href="route('listings.index')" 
                    :active="request()->routeIs('listings.index')"
                    class="!text-gray-800 !bg-white hover:!text-[#2ecc71]"
                >
                    {{ __('Sludinājumi') }}
                </x-nav-link>

                <x-nav-link 
                    :href="route('listings.create')" 
                    :active="request()->routeIs('listings.create')"
                    class="!text-gray-800 !bg-white hover:!text-[#2ecc71]"
                >
                    {{ __('Pievienot sludinājumu') }}
                </x-nav-link>

                <x-nav-link 
                    :href="route('listings.my')" 
                    :active="request()->routeIs('listings.my')"
                    class="!text-gray-800 !bg-white hover:!text-[#2ecc71]"
                >
                    {{ __('Mani sludinājumi') }}
                </x-nav-link>
            </div>

            <!-- Right: User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 hover:text-[#2ecc71] focus:outline-none transition">
                            <div>{{ Auth::user()->name }}</div>
                            <svg class="ml-1 h-4 w-4 fill-current text-gray-500" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-[#2ecc71] hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('listings.index')" :active="request()->routeIs('listings.index')">
                {{ __('Sludinājumi') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('listings.create')" :active="request()->routeIs('listings.create')">
                {{ __('Pievienot sludinājumu') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('listings.my')" :active="request()->routeIs('listings.my')">
                {{ __('Mani sludinājumi') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
