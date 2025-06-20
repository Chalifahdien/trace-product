<ul class="navbar-nav pt-lg-3 px-2 dropdown-menu">
    <a class="nav-link mb-1 {{ Request::is('/') ? 'aktif' : '' }}" href="/">
        <!-- Download SVG icon from http://tabler.io/icons/icon/home -->
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
        </svg>
        <!-- </span> -->
        <span class="nav-link-title ms-2">
            Home
        </span>
    </a>
    @if (auth()->user()->role == 'admin')
        <a class="nav-link mb-1 {{ Request::is('users') ? 'aktif' : '' }}" href="/users">
            <!-- Download SVG icon from http://tabler.io/icons/icon/home -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
            </svg>
            <!-- </span> -->
            <span class="nav-link-title ms-2">
                Users
            </span>
        </a>
    @endif
    @if (auth()->user()->role == 'produsen')
        <a class="nav-link mb-1 {{ Request::is('product*') ? 'aktif' : '' }}" href="/product">
            <!-- Download SVG icon from http://tabler.io/icons/icon/home -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-package">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
                <path d="M12 12l8 -4.5" />
                <path d="M12 12l0 9" />
                <path d="M12 12l-8 -4.5" />
                <path d="M16 5.25l-8 4.5" />
            </svg>
            <!-- </span> -->
            <span class="nav-link-title ms-2">
                Product
            </span>
        </a>
    @endif
    @if (auth()->user()->role == 'distributor')
        <a class="nav-link mb-1 {{ Request::is('distribution*') ? 'aktif' : '' }}" href="/distribution">
            <!-- Download SVG icon from http://tabler.io/icons/icon/home -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-truck">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                <path d="M5 17h-2v-11a1 1 0 0 1 1 -1h9v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
            </svg>
            <!-- </span> -->
            <span class="nav-link-title ms-2">
                Distribution
            </span>
        </a>
    @endif
    {{-- @if (auth()->user()->role != 'konsumen')
        <a class="nav-link mb-1 {{ Request::is('history*') ? 'aktif' : '' }}" href="/history">
            <!-- Download SVG icon from http://tabler.io/icons/icon/home -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-history">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 8l0 4l2 2" />
                <path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5" />
            </svg>
            <!-- </span> -->
            <span class="nav-link-title ms-2">
                History
            </span>
        </a>
    @endif --}}
    @if (auth()->user()->role == 'admin')
        <a class="nav-link mb-1 {{ Request::is('blockchain*') ? 'aktif' : '' }}" href="/blockchain">
            <!-- Download SVG icon from http://tabler.io/icons/icon/home -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-currency-ethereum">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M6 12l6 -9l6 9l-6 9z" />
                <path d="M6 12l6 -3l6 3l-6 2z" />
            </svg>
            <!-- </span> -->
            <span class="nav-link-title ms-2">
                Blockchain
            </span>
        </a>
    @endif
</ul>
