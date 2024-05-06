<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('images/logo_c.png') }}" alt="sidebarLogo" height="27">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('images/logo_c.png') }}" alt="sidebarLogo" height="21">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('images/logo_w.png') }}" alt="sidebarLogo" height="27">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('images/logo_w.png') }}" alt="sidebarLogo" height="21">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div class="dropdown sidebar-user m-1 rounded">
        <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center gap-2">

                <span class="text-start">
                    <span class="d-block fw-medium sidebar-user-name-text">{{ Auth::user()->name }}</span>
                    <span class="d-block fs-14 sidebar-user-name-sub-text"><i
                            class="ri ri-circle-fill fs-10 text-success align-baseline"></i> <span
                            class="align-middle">Online</span></span>
                </span>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <h6 class="dropdown-header">Welcome {{ Auth::user()->name }}!</h6>
            <a class="dropdown-item" href="pages-profile"><i
                    class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Profile</span></a>
            <a class="dropdown-item" href="apps-chat"><i
                    class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Messages</span></a>
            <a class="dropdown-item" href="apps-tasks-kanban"><i
                    class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Taskboard</span></a>
            <a class="dropdown-item" href="pages-faqs"><i
                    class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Help</span></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="pages-profile"><i
                    class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance :
                    <b>$5971.67</b></span></a>
            <a class="dropdown-item" href="pages-profile-settings"><span
                    class="badge bg-success-subtle text-success mt-1 float-end">New</span><i
                    class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Settings</span></a>
            <a class="dropdown-item" href="auth-lockscreen-basic"><i
                    class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Lock
                    screen</span></a>

            <a class="dropdown-item " href="javascript:void();"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                    class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                    key="t-logout">@lang('translation.logout')</span></a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.menu')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/" role="button" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span>@lang('Dashboard')</span>
                    </a>

                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/attendance" role="button" aria-controls="sidebarDashboards">
                        <i class="bx bx-time"></i> <span>@lang('Attendance')</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span>@lang('Van Activity')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{ route('van.retailsales') }}"
                                    class="nav-link">@lang('Retail Sales ')</a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('van.consumersales') }}"
                                    class="nav-link">@lang('Consumer Sales ')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('van.activityphotos') }}"
                                    class="nav-link">@lang('Activity Photos')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('van.retailers') }}"
                                    class="nav-link">@lang('Retailers')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('van.consumer') }}" class="nav-link">@lang('Consumers')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('van.purchase') }}"
                                    class="nav-link">@lang('Purchase')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('van.stockists') }}" class="nav-link"></i>@lang('Stockists')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('van.routePlan') }}" class="nav-link"></i>@lang('Route Plans')</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span>@lang('Mandi Activity')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{ route('mandi.retailsales') }}"
                                    class="nav-link">@lang('Retail Sales ')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mandi.consumersales') }}"
                                    class="nav-link">@lang('Consumer Sales ')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mandi.activityphotos') }}"
                                    class="nav-link">@lang('Activity Photos')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mandi.retailers') }}"
                                    class="nav-link">@lang('Retailers')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mandi.consumer') }}" class="nav-link">@lang('Consumers')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mandi.purchase') }}"
                                    class="nav-link">@lang('Purchase')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mandi.stockists') }}" class="nav-link"></i>@lang('Stockists')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mandi.routePlan') }}" class="nav-link"></i>@lang('Route Plans')</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span>@lang('Mela Activity')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('mela.consumer') }}" class="nav-link">@lang('Consumers')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mela.consumersales') }}"
                                    class="nav-link">@lang('Consumer Sales ')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mela.activityphotos') }}"
                                    class="nav-link">@lang('Activity Photos')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mela.purchase') }}"
                                    class="nav-link">@lang('Purchase')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mela.stockists') }}" class="nav-link"></i>@lang('Stockists')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mela.routePlan') }}" class="nav-link"></i>@lang('Route Plans')</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span>@lang('Branding Activity')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{ route('branding.reccepending') }}"
                                    class="nav-link">@lang('Recce Pending ')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('branding.recceapproved') }}"
                                    class="nav-link">@lang('Approved Recce')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('branding.reccerejected') }}"
                                    class="nav-link">@lang('Rejected Recce')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('branding.installationcompleted') }}"
                                    class="nav-link">@lang('Installation Completed')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('branding.installationapproved') }}" class="nav-link">@lang('Approved Installations')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('branding.installationrejected') }}" class="nav-link"></i>@lang('Rejected Installations')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('branding.outlets') }}" class="nav-link"></i>@lang('Outlets')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('branding.routePlan') }}" class="nav-link"></i>@lang('Route Plans')</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span>@lang('Sales Reports')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href=""
                                    class="nav-link">@lang('Retail Sales ')</a>
                            </li>

                            <li class="nav-item">
                                <a href=""
                                    class="nav-link">@lang('Consumer Sales ')</a>
                            </li>
                        </ul>
                    </div>
                </li> -->
                @if (in_array(Auth::user()->fld_role, [1, 3]))
                    <!-- <li class="nav-item">
                        <a class="nav-link menu-link" href="" role="button"
                            aria-controls="sidebarDashboards">
                            <i class="bx bxs-store"></i> <span>@lang('Retailers')</span>
                        </a>
                    </li> -->
                @endif
                <!-- <li class="nav-item">
                    <a class="nav-link menu-link" href="" role="button"
                        aria-controls="sidebarDashboards">
                        <i class="bx bx-receipt"></i> <span>@lang('Purchase')</span>
                    </a>
                </li> -->
                <!-- <li class="nav-item">
                    <a class="nav-link menu-link" href="" role="button"
                        aria-controls="sidebarDashboards">
                        <i class="bx bx-photo-album"></i> <span>@lang('Activity Photos')</span>
                    </a>
                </li> -->
                @if (in_array(Auth::user()->fld_role, [1, 3]))
                    <!-- <li class="nav-item">
                        <a href="{{ route('report.routePlan') }}" class="nav-link"> <i
                                class="bx bxs-bus"></i>@lang('Route Plans')</a>
                    </li> -->
                @endif

                <li class="nav-item " style="display: none">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span>@lang('Reports')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">

                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{ route('report.dayWiseSalesSummary') }}"
                                    class="nav-link">@lang('Day Wise Sales Summary')</a>
                            </li>
                           --}}
                        </ul>
                    </div>
                </li>
                @if (in_array(Auth::user()->fld_role, [1]))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarApps">
                            <i class="bx bx-grid"></i> <span>@lang('Masters')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarApps">
                            <ul class="nav nav-sm flex-column">
                                <!-- <li class="nav-item">
                                    <a href="{{ route('consumer.index') }}" class="nav-link">@lang('Consumers')</a>
                                </li> -->
                                <!-- <li class="nav-item">
                                    <a href="{{ route('stockists') }}" class="nav-link"></i>@lang('Stockists')</a>
                                </li> -->
                                <li class="nav-item">
                                    <a href="{{ route('products.index') }}" class="nav-link">@lang('Products')</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('projects.index') }}" class="nav-link">@lang('Projects')</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('master.routePlans') }}"
                                        class="nav-link">@lang('Route Plan')</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('phototypes.index') }}" class="nav-link">@lang('Photo Types')</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('clients.index') }}" class="nav-link">@lang('Clients')</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link">@lang('Users')</a>
                                </li>

                            </ul>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
