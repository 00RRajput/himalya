<?php echo $__env->yieldContent('css'); ?>
<!-- Layout config Js -->
<script src="<?php echo e(URL::asset('build/js/layout.js')); ?>"></script>
<!-- Bootstrap Css -->
<link href="<?php echo e(URL::asset('build/css/bootstrap.min.css')); ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="<?php echo e(URL::asset('build/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="<?php echo e(URL::asset('build/css/app.min.css')); ?>" id="app-style" rel="stylesheet" type="text/css" />
<!-- custom Css-->
<link rel="stylesheet" href="/build/libs/glightbox/css/glightbox.min.css">
<link href="<?php echo e(URL::asset('build/css/custom.min.css')); ?>" id="app-style" rel="stylesheet" type="text/css" />


<style>
    [data-layout=horizontal] .navbar-menu .navbar-nav .nav-link {
        padding: 0.31rem 1rem;
    }

    form sup {
        color: red
    }

    .error {
        color: red
    }

    .text-red {
        color: red
    }

    .one-bg {
        background-image: url("images/bg_login.jpg");
        background-position: center;
        background-size: cover;
    }

    .bg-overlay {
        opacity: .2 !important;
    }
</style>
<?php /**PATH C:\xampp\htdocs\himalaya\resources\views/layouts/head-css.blade.php ENDPATH**/ ?>