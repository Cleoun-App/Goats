<div>

    <nav class="side-nav" style="transition: none;">
        <a href="" class="intro-x flex items-center pl-5 pt-4 mt-3">
            <img alt="Tinker Tailwind HTML Admin Template" class="w-6" src="/assets/core/images/logo.svg">
            <span class="hidden xl:block text-white text-lg ml-3"> <span class="font-medium">DYV</span>e
            </span>
        </a>
        <div class="side-nav__devider my-6"></div>
        <ul style="transition: none;">
            @foreach ($menu as $_menu)
                @if (array_key_exists('menu', $_menu))
                    <li>
                        <a href="javascript: void(0)" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="{{ $_menu['icon'] }}"></i> </div>
                            <div class="side-menu__title">
                                {{ $_menu['name'] }}
                                <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul class="">
                            @foreach ($_menu['menu'] as $item)
                                <li>
                                    <a href="{{ $item['route'] }}" class="side-menu">
                                        <div class="side-menu__icon"> <i data-feather="{{ $item['icon'] }}"></i> </div>
                                        <div class="side-menu__title"> {{ $item['name'] }} </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @elseif ($_menu['name'] == 'break')
                    <li class="side-nav__devider my-6"></li>
                @else
                    <li>
                        <a href="{{ $_menu['route'] }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="{{ $_menu['icon'] }}"></i> </div>
                            <div class="side-menu__title">
                                {{ $_menu['name'] }} </div>
                        </a>
                    </li>
                @endif
            @endforeach
    
        </ul>
    </nav>    

</div>