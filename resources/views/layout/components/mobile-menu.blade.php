<!-- BEGIN: Mobile Menu -->
<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="" class="flex mr-auto">
            <img alt="Rubick Tailwind HTML Admin Template" class="w-6" src="{{ asset('dist/images/logo.svg') }}">
        </a>
        <a href="javascript:;" id="mobile-menu-toggler">
            <i data-feather="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i>
        </a>
    </div>
    <ul class="border-t border-theme-29 py-5 hidden">
        @foreach ($side_menu as $menuKey => $menu)
            @if ($menu == 'devider')
                <li class="menu__devider my-6"></li>
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
                    <a href="{{ isset($menu['route_name']) ? route($menu['route_name'], $menu['params']) : 'javascript:;' }}" class="{{ $active ? 'menu menu--active' : 'menu' }}">
                        <div class="menu__icon">
                            <i data-feather="{{ $menu['icon'] }}"></i>
                        </div>
                        <div class="menu__title">
                            {{ $menu['title'] }}
                            @if (isset($menu['sub_menu']))
                                <i data-feather="chevron-down" class="menu__sub-icon"></i>
                            @endif
                        </div>
                    </a>
                    @if (isset($menu['sub_menu']))
                        <ul class="{{ $first_level_active_index == $menuKey ? 'menu__sub-open' : '' }}">
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
                                    <a href="{{ isset($subMenu['layout']) ? route('page', ['layout' => $subMenu['layout'], 'theme' => $theme, 'pageName' => $subMenu['page_name']]) : 'javascript:;' }}" class="{{ $subActive ? 'menu menu--active' : 'menu' }}">
                                        <div class="menu__icon">
                                            <i data-feather="activity"></i>
                                        </div>
                                        <div class="menu__title">
                                            {{ $subMenu['title'] }}
                                            @if (isset($subMenu['sub_menu']))
                                                <i data-feather="chevron-down" class="menu__sub-icon"></i>
                                            @endif
                                        </div>
                                    </a>
                                    @if (isset($subMenu['sub_menu']))
                                        <ul class="{{ $second_level_active_index == $subMenuKey ? 'menu__sub-open' : '' }}">
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
                                                    <a href="{{ isset($lastSubMenu['route_name']) ? route($lastSubMenu['route_name'], $lastSubMenu['params']) : 'javascript:;' }}" class="{{ $lastSubActive ? 'menu menu--active' : 'menu' }}">
                                                        <div class="menu__icon">
                                                            <i data-feather="zap"></i>
                                                        </div>
                                                        <div class="menu__title">{{ $lastSubMenu['title'] }}</div>
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
</div>
<!-- END: Mobile Menu -->
