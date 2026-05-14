<!-- Topbar Start -->
<div class="topbar-custom" style="z-index: 1;">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                <li>
                    <button type="button" class="button-toggle-menu nav-link">
                        <iconify-icon icon="solar:hamburger-menu-linear" class="fs-22 align-middle text-dark">
                        </iconify-icon>
                    </button>
                </li>
                {{-- <li class="d-none d-lg-block">
                    <form class="app-search d-none d-md-block me-auto">
                        <div class="position-relative topbar-search">
                            <iconify-icon icon="solar:minimalistic-magnifer-line-duotone"
                                class="fs-18 align-middle text-dark position-absolute text-dark top-50 translate-middle-y ms-2">
                            </iconify-icon>
                            <input type="text" class="form-control shadow-none" placeholder="Search for somethings" />
                        </div>
                    </form>
                </li> --}}
            </ul>

            <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center gap-2">
               

                <!-- User Dropdown -->
                <li class="dropdown notification-list topbar-dropdown">
                    <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="#" role="button"
                        aria-haspopup="false" aria-expanded="false">
                        <img src={{ asset( "assets/images/users/avatar/avatar-07.svg") }} alt="user-image" class="img-fluid " />
                    </a>
                    <div class="dropdown-menu dropdown-menu-end profile-dropdown">
                        <!-- item-->
                        <div class="dropdown-header noti-title border-bottom border-dashed d-flex align-items-center">
                            <img src={{ asset("assets/images/users/avatar/avatar-07.svg") }}  alt="user-image"
                                class="avatar avatar-xs rounded-circle me-2" />
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>

                        <!-- item-->
                        <a href="pages-profile.html" class="dropdown-item notify-item border-bottom border-dashed">
                            <iconify-icon icon="solar:user-bold-duotone" class="fs-18 align-middle"
                                id="selected-language-image"></iconify-icon>
                            <span>My Account</span>
                        </a>

                        <!-- item-->
                        <a href="page-profile.html" class="dropdown-item notify-item border-bottom border-dashed">
                            <iconify-icon icon="solar:settings-bold-duotone" class="fs-18 align-middle"
                                id="selected-language-image"></iconify-icon>
                            <span>Setting</span>
                        </a>

                        <!-- item-->
                        <a href="auth-lock-screen.html" class="dropdown-item notify-item border-bottom border-dashed">
                            <iconify-icon icon="solar:shield-keyhole-bold-duotone" class="fs-18 align-middle"
                                id="selected-language-image"></iconify-icon>
                            <span>Lock Screen</span>
                        </a>

                        <!-- item-->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit"
                                class="dropdown-item notify-item border-0 bg-transparent w-100 text-start">
                                <iconify-icon icon="solar:logout-2-bold-duotone" class="fs-18 align-middle">
                                </iconify-icon>

                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>
<!-- end Topbar -->