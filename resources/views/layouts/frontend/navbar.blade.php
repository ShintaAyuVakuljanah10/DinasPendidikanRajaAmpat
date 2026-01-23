<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl d-flex align-items-center">

        <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
            <img src="{{ asset('assets/skydash/images/logorajaampat.ico') }}" alt="">
            <h5 class="sitename">Disdik Raja Ampat</h5>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                @foreach ($pages as $page)
        
                    {{-- MENU TANPA SUBMENU --}}
                    @if ($page->children->isEmpty())
                        <li>
                            <a href="{{ url($page->slug) }}"
                               class="{{ request()->is($page->slug) ? 'active' : '' }}">
                                {{ $page->title }}
                            </a>
                        </li>
        
                    {{-- MENU DENGAN SUBMENU --}}
                    @else
                        @php
                            $isActiveParent = request()->is($page->slug.'/*');
                        @endphp
        
                        <li class="dropdown {{ $isActiveParent ? 'active' : '' }}">
                            <a href="#">
                                <span class="{{ $isActiveParent ? 'active' : '' }}">
                                    {{ $page->title }}
                                </span>
                                <i class="bi bi-chevron-down toggle-dropdown"></i>
                            </a>
        
                            <ul>
                                @foreach ($page->children as $child)
                                    <li>
                                        <a href="{{ url($child->slug) }}"
                                           class="{{ request()->is($child->slug) ? 'active' : '' }}">
                                            {{ $child->title }}
                                        </a>
                                    </li>
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
