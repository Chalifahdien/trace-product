<!-- Navbar -->
<header class="navbar navbar-expand-md d-none d-lg-flex d-print-none sticky-top">
    <div class="container-fluid">
        @include('components.brand')
        <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item me-3" id="navbar-menu">
                <form action="./" method="get" autocomplete="off" novalidate="">
                    <div class="input-icon">
                        <span class="input-icon-addon">
                            <!-- Download SVG icon from http://tabler.io/icons/icon/search -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-1">
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                        </span>
                        <input type="text" value="" class="form-control" placeholder="Search…"
                            aria-label="Search in website">
                    </div>
                </form>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    <div class="avatar text-white" style="background-color: black">
                        {{ Str::substr(auth()->user()->name, 0, 1) }}
                    </div>
                </a>
                @include('components.dropdown-user')
            </div>
        </div>
    </div>
</header>
