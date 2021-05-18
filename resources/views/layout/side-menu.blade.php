@extends('../layout/main')

@section('head')
    @yield('subhead')
@endsection

@section('content')
    @include('../layout/components/mobile-menu')
    <div class="flex">
        <!-- BEGIN: Side Menu -->
        <nav class="side-nav">
            <a href="{{ route('index') }}" class="intro-x flex items-center pl-5 pt-4">
                <img alt="" class="w-6" src="{{ asset('assets/logos/logo.png') }}">
                <span class="hidden xl:block text-white text-lg ml-3">
                    Mental<span class="font-medium"> Check</span>
                </span>
            </a>
            <div class="side-nav__devider my-6"></div>
            <ul>
                @foreach ($side_menu as $menuKey => $menu)
                    @if ($menu == 'devider')
                        <li class="side-nav__devider my-6"></li>
                    @else
                        <?php
                            $active = false;
                            if(isset($menu['extends'])){
                                foreach($menu['extends'] as $extendValue){
                                    if(Route::currentRouteName() == $extendValue) {
                                        $active = true;
                                        break;
                                    }
                                }
                            }
                            if($first_level_active_index == $menuKey){
                                $active = true;
                            }
                        ?>
                        <li>
                            <a href="{{ isset($menu['route_name']) ? route($menu['route_name'], $menu['params']) : 'javascript:;' }}" class="{{ $active ? 'side-menu side-menu--active' : 'side-menu' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="{{ $menu['icon'] }}"></i>
                                </div>
                                <div class="side-menu__title">
                                    {{ $menu['title'] }}
                                    @if (isset($menu['sub_menu']))
                                        <div class="side-menu__sub-icon">
                                            <i data-feather="chevron-down"></i>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            @if (isset($menu['sub_menu']))
                                <ul class="{{ $first_level_active_index == $menuKey ? 'side-menu__sub-open' : '' }}">
                                    @foreach ($menu['sub_menu'] as $subMenuKey => $subMenu)
                                        <?php
                                        $subActive = false;
                                        if(isset($subMenu['extends'])){
                                            foreach($subMenu['extends'] as $extendValue){
                                                if(Route::currentRouteName() == $extendValue) {
                                                    $subActive = true;
                                                    break;
                                                }
                                            }
                                        }
                                        if($second_level_active_index == $subMenuKey){
                                            $subActive = true;
                                        }
                                        ?>
                                        <li>
                                            <a href="{{ isset($subMenu['route_name']) ? route($subMenu['route_name'], $subMenu['params']) : 'javascript:;' }}" class="{{ $subActive ? 'side-menu side-menu--active' : 'side-menu' }}">
                                                <div class="side-menu__icon">
                                                    <i data-feather="activity"></i>
                                                </div>
                                                <div class="side-menu__title">
                                                    {{ $subMenu['title'] }}
                                                    @if (isset($subMenu['sub_menu']))
                                                        <div class="side-menu__sub-icon">
                                                            <i data-feather="chevron-down"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            </a>
                                            @if (isset($subMenu['sub_menu']))
                                                <ul class="{{ $second_level_active_index == $subMenuKey ? 'side-menu__sub-open' : '' }}">
                                                    @foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu)
                                                        <?php
                                                        $lastSubActive = false;
                                                        if(isset($lastSubMenu['extends'])){
                                                            foreach($lastSubMenu['extends'] as $extendValue){
                                                                if(Route::currentRouteName() == $extendValue) {
                                                                    $lastSubActive = true;
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                        if($third_level_active_index == $lastSubMenuKey){
                                                            $lastSubActive = true;
                                                        }
                                                        ?>
                                                        <li>
                                                            <a href="{{ isset($lastSubMenu['route_name']) ? route($lastSubMenu['route_name'], $lastSubMenu['params']) : 'javascript:;' }}" class="{{ $lastSubActive ? 'side-menu side-menu--active' : 'side-menu' }}">
                                                                <div class="side-menu__icon">
                                                                    <i data-feather="zap"></i>
                                                                </div>
                                                                <div class="side-menu__title">{{ $lastSubMenu['title'] }}</div>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>
        </nav>
        <!-- END: Side Menu -->
        <!-- BEGIN: Content -->
        <div class="content">
            @include('../layout/components/top-bar')
            @yield('subcontent')
        </div>
        <!-- END: Content -->
    </div>
@endsection
