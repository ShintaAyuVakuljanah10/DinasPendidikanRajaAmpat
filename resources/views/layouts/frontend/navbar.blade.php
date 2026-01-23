<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl d-flex align-items-center">

        <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
            <img src="{{ asset('assets/skydash/images/logorajaampat.ico') }}" alt="">
            <h5 class="sitename">Disdik Raja Ampat</h5>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                @foreach ($pages as $page)
                    @if ($page->children->isEmpty())
                        <li><a href="{{ url($page->slug) }}">{{ $page->title }}</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#">
                                <span>{{ $page->title }}</span>
                                <i class="bi bi-chevron-down toggle-dropdown"></i>
                            </a>
                            <ul>
                                @foreach ($page->children as $child)
                                    <li><a href="{{ url($child->slug) }}">{{ $child->title }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>

            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

    </div>
</header>
