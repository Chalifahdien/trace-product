<!-- Sidebar -->
<aside class="navbar navbar-vertical navbar-transparent navbar-expand-lg z-1">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        @include('components.brand')
        <div class="navbar-nav flex-row d-lg-none">
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
        <div class="collapse navbar-collapse" id="sidebar-menu">
            @include('components.sidebar-menu')
        </div>
    </div>
</aside>
