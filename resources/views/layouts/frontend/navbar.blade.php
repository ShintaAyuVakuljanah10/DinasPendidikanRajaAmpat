<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl d-flex align-items-center">

        <a href="{{ url('/') }}" class="logo">
            <img src="{{ $appSetting?->logo
                ? asset('storage/' . $appSetting->logo)
                : asset('assets/skydash/images/default-logo.png') }}"
                alt="Logo Aplikasi">

            <span class="sitename">
                {{ $appSetting->nama_aplikasi ?? 'Nama Aplikasi' }}
            </span>
        </a>



        <nav id="navmenu" class="navmenu">
            <ul>
                @foreach ($pages as $page)

                @if ($page->children->isEmpty())
                        <li>
                            <a
                                href="{{ $page->slug === 'kategori'
                                    ? (request()->is('/') ? '#kategori' : url('/').'#kategori')
                                    : url($page->slug) }}"
                                class="{{ request()->is($page->slug) ? 'active' : '' }}"
                            >
                                {{ $page->title }}
                            </a>


                        </li>
        

                {{-- MENU DENGAN SUBMENU --}}
                @else
                @php
                $isActiveParent = $page->children->contains(function ($child) {
                return request()->is($child->slug);
                });
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
                            <a href="{{ url($child->slug) }}" class="{{ request()->is($child->slug) ? 'active' : '' }}">
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
