<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <style>
        /* Modern Navigation Styles */
        .nav-container {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .logo-text {
            font-size: 1.75rem;
            font-weight: 700;
            color: #2ecc71;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .logo-text:hover {
            color: #27ae60;
            transform: scale(1.05);
        }

        .nav-link {
            position: relative;
            font-weight: 600;
            color: #1a1a1a;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .nav-link:hover {
            color: #2ecc71;
            background: rgba(46, 204, 113, 0.1);
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: #2ecc71;
            background: rgba(46, 204, 113, 0.15);
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 1rem;
            right: 1rem;
            height: 3px;
            background: #2ecc71;
            border-radius: 2px;
        }

        .user-dropdown {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            color: #1a1a1a;
            transition: all 0.3s ease;
            cursor: pointer;
            background: rgba(46, 204, 113, 0.05);
        }

        .user-dropdown:hover {
            background: rgba(46, 204, 113, 0.15);
            color: #2ecc71;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.875rem;
        }

        .hamburger-btn {
            padding: 0.5rem;
            border-radius: 8px;
            color: #1a1a1a;
            transition: all 0.3s ease;
        }

        .hamburger-btn:hover {
            background: rgba(46, 204, 113, 0.1);
            color: #2ecc71;
        }

        .mobile-nav-link {
            display: block;
            padding: 0.75rem 1rem;
            font-weight: 600;
            color: #1a1a1a;
            border-radius: 8px;
            margin: 0.25rem 0.5rem;
            transition: all 0.3s ease;
        }

        .mobile-nav-link:hover {
            background: rgba(46, 204, 113, 0.1);
            color: #2ecc71;
            transform: translateX(5px);
        }

        .mobile-nav-link.active {
            background: rgba(46, 204, 113, 0.15);
            color: #2ecc71;
            border-left: 3px solid #2ecc71;
        }

        .mobile-menu {
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .logo-text {
                font-size: 1.5rem;
            }
            
            .logo-text::before {
                font-size: 1.25rem;
            }
        }
    </style>

    <div class="px-4 sm:px-6 lg:px-8 nav-container">
        <div class="flex justify-between h-16">

            <!-- Left: Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}" class="logo-text">
                    BaltBazaar
                </a>
            </div>

            <!-- Center: Links -->
            <div class="hidden sm:flex sm:space-x-2 sm:ml-10 items-center">
                <a href="{{ route('dashboard') }}" 
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    {{ __('Mājas') }}
                </a>

                <a href="{{ route('listings.index') }}" 
                   class="nav-link {{ request()->routeIs('listings.index') ? 'active' : '' }}">
                    {{ __('Sludinājumi') }}
                </a>

                <a href="{{ route('listings.create') }}" 
                   class="nav-link {{ request()->routeIs('listings.create') ? 'active' : '' }}">
                    {{ __('Pievienot sludinājumu') }}
                </a>

                <a href="{{ route('listings.my') }}" 
                   class="nav-link {{ request()->routeIs('listings.my') ? 'active' : '' }}">
                    {{ __('Mani sludinājumi') }}
                </a>
            </div>

            <!-- Right: User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="user-dropdown">
                            <div class="user-avatar">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div>{{ Auth::user()->name }}</div>
                            <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
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
                <button @click="open = ! open" class="hamburger-btn">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-100 mobile-menu">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" 
               class="mobile-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                {{ __('Home') }}
            </a>
            <a href="{{ route('listings.index') }}" 
               class="mobile-nav-link {{ request()->routeIs('listings.index') ? 'active' : '' }}">
                {{ __('Sludinājumi') }}
            </a>
            <a href="{{ route('listings.create') }}" 
               class="mobile-nav-link {{ request()->routeIs('listings.create') ? 'active' : '' }}">
                {{ __('Pievienot sludinājumu') }}
            </a>
            <a href="{{ route('listings.my') }}" 
               class="mobile-nav-link {{ request()->routeIs('listings.my') ? 'active' : '' }}">
                {{ __('Mani sludinājumi') }}
            </a>
        </div>

        <!-- Mobile User Section -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex items-center gap-3 mb-3">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-bold text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-1">
                <a href="{{ route('profile.edit') }}" class="mobile-nav-link">
                    {{ __('Profile') }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="mobile-nav-link w-full text-left">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>