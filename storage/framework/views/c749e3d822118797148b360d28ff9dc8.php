<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('images/logo_c.png')); ?>" alt="sidebarLogo" height="27">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('images/logo_c.png')); ?>" alt="sidebarLogo" height="21">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('images/logo_w.png')); ?>" alt="sidebarLogo" height="27">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('images/logo_w.png')); ?>" alt="sidebarLogo" height="21">
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
                    <span class="d-block fw-medium sidebar-user-name-text"><?php echo e(Auth::user()->name); ?></span>
                    <span class="d-block fs-14 sidebar-user-name-sub-text"><i
                            class="ri ri-circle-fill fs-10 text-success align-baseline"></i> <span
                            class="align-middle">Online</span></span>
                </span>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <h6 class="dropdown-header">Welcome <?php echo e(Auth::user()->name); ?>!</h6>
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
                    key="t-logout"><?php echo app('translator')->get('translation.logout'); ?></span></a>
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                <?php echo csrf_field(); ?>
            </form>
        </div>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span><?php echo app('translator')->get('translation.menu'); ?></span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/" role="button" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span><?php echo app('translator')->get('Dashboard'); ?></span>
                    </a>

                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/attendance" role="button" aria-controls="sidebarDashboards">
                        <i class="bx bx-time"></i> <span><?php echo app('translator')->get('Attendance'); ?></span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span><?php echo app('translator')->get('Sales Reports'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="<?php echo e(route('salesreport.retailsales')); ?>"
                                    class="nav-link"><?php echo app('translator')->get('Retail Sales '); ?></a>
                            </li>

                            <li class="nav-item">
                                <a href="<?php echo e(route('salesreport.consumersales')); ?>"
                                    class="nav-link"><?php echo app('translator')->get('Consumer Sales '); ?></a>
                            </li>
                        </ul>
                    </div>
                </li>
                <?php if(in_array(Auth::user()->fld_role, [1, 3])): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="<?php echo e(route('retailers')); ?>" role="button"
                            aria-controls="sidebarDashboards">
                            <i class="bx bxs-store"></i> <span><?php echo app('translator')->get('Retailers'); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?php echo e(route('purchasedetails')); ?>" role="button"
                        aria-controls="sidebarDashboards">
                        <i class="bx bx-receipt"></i> <span><?php echo app('translator')->get('Purchase'); ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?php echo e(route('activityphotos')); ?>" role="button"
                        aria-controls="sidebarDashboards">
                        <i class="bx bx-photo-album"></i> <span><?php echo app('translator')->get('Activity Photos'); ?></span>
                    </a>
                </li>
                <?php if(in_array(Auth::user()->fld_role, [1, 3])): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('report.routePlan')); ?>" class="nav-link"> <i
                                class="bx bxs-bus"></i><?php echo app('translator')->get('Route Plans'); ?></a>
                    </li>
                <?php endif; ?>

                <li class="nav-item " style="display: none">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span><?php echo app('translator')->get('Reports'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">

                            </li>
                            
                        </ul>
                    </div>
                </li>
                <?php if(in_array(Auth::user()->fld_role, [1])): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarApps">
                            <i class="bx bx-grid"></i> <span><?php echo app('translator')->get('Masters'); ?></span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarApps">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a href="<?php echo e(route('clients.index')); ?>" class="nav-link"><?php echo app('translator')->get('Clients'); ?></a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?php echo e(route('projects.index')); ?>" class="nav-link"><?php echo app('translator')->get('Projects'); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('master.routePlans')); ?>"
                                        class="nav-link"><?php echo app('translator')->get('Route Plan'); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('stockists')); ?>" class="nav-link"></i><?php echo app('translator')->get('Stockists'); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('phototypes.index')); ?>" class="nav-link"><?php echo app('translator')->get('Photo Types'); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('products.index')); ?>" class="nav-link"><?php echo app('translator')->get('Products'); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('users.index')); ?>" class="nav-link"><?php echo app('translator')->get('Users'); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('district.index')); ?>" class="nav-link"><?php echo app('translator')->get('Location'); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('consumer.index')); ?>" class="nav-link"><?php echo app('translator')->get('Consumers'); ?></a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
<?php /**PATH C:\xampp\htdocs\himalaya\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>