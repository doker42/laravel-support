<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">VIT_CHE</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 active disabled" aria-current="page" href="#">
                        <svg class="bi"><use xlink:href="#house-fill"/></svg>
                        {{__('Dashboard')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{route('target_list')}}">
                        <svg class="bi"><use xlink:href="#people"/></svg>
                        {{__('Targets')}}
                    </a>
                </li>
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link d-flex align-items-center gap-2" href="{{route('user_list')}}">--}}
{{--                        <svg class="bi"><use xlink:href="#people"/></svg>--}}
{{--                        {{__('Users')}}--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link d-flex align-items-center gap-2" href="{{route('admin_file_list')}}">--}}
{{--                        <svg class="bi"><use xlink:href="#files"/></svg>--}}
{{--                        {{__('Files')}}--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link d-flex align-items-center gap-2" href="{{route('admin_work_list')}}">--}}
{{--                        <svg class="bi"><use xlink:href="#works"/></svg>--}}
{{--                        {{__('Works')}}--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link d-flex align-items-center gap-2" href="{{route('admin_info_edit', ['id' => 1])}}">--}}
{{--                        <svg class="bi"><use xlink:href="#info"/></svg>--}}
{{--                        {{__('Info')}}--}}
{{--                    </a>--}}
{{--                </li>--}}
            </ul>

            <hr class="my-3">

            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                        <svg class="bi"><use xlink:href="#door-closed"/></svg>
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>