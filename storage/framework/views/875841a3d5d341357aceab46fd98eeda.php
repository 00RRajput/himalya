<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" data-layout="horizontal" data-topbar="light"
    data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default"
    data-theme-colors="default" data-sidebar-visibility="show" data-layout-style="default" data-bs-theme="light"
    data-layout-width="fluid" data-layout-position="fixed" data-body-image="none">
<script>
    window._wordtune_extension_installed = true;
</script>

<head>

    <head>
        <meta charset="utf-8" />
        <title><?php echo $__env->yieldContent('title'); ?> | <?php echo e(env('APP_NAME')); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo e(URL::asset('favicon.ico')); ?>">
        <?php echo $__env->make('layouts.head-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <style>
            .btn-submit {
                padding: 0px;
                background: transparent;
                border: 0px;
                color: blue;
            }

            .display-none {
                display: none;
            }

            .ui-sortable-handle {
                cursor: pointer;
            }
        </style>
    </head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?php echo $__env->make('layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <!-- end main content-->
        <div id="successMessage"
            style="display: none; position: fixed; bottom: -100px; left: 50%; transform: translateX(-50%); background-color: #4CAF50; color: white; padding: 15px; border-radius: 10px; z-index: 9999;">

        </div>
    </div>
    <!-- END layout-wrapper -->

    <?php echo $__env->make('layouts.customizer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- JAVASCRIPT -->
    <?php echo $__env->make('layouts.vendor-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html>
<?php /**PATH /Users/dr.mac/Downloads/himalaya/resources/views/layouts/master.blade.php ENDPATH**/ ?>