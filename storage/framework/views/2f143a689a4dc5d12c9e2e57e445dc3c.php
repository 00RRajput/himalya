<script src="<?php echo e(URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/simplebar/simplebar.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/node-waves/waves.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/feather-icons/feather.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/pages/plugins/lord-icon-2.1.0.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/plugins.js')); ?>"></script>
<!-- glightbox js -->
<script src="/build/libs/glightbox/js/glightbox.min.js"></script>

<script src="/build/js/pages/gallery.init.js"></script>
<script>
    function showSuccessMessage(message) {
        $("#successMessage").text(message).css("bottom", "-100px").fadeIn();
        $("#successMessage").animate({
            bottom: "20px"
        }, 500);
        setTimeout(function() {
            $("#successMessage").fadeOut();
        }, 5000);
    }
</script>
<?php echo $__env->yieldContent('script'); ?>
<?php echo $__env->yieldContent('script-bottom'); ?>
<?php /**PATH /home/u951376346/domains/nebulacrm.in/public_html/himalaya/resources/views/layouts/vendor-scripts.blade.php ENDPATH**/ ?>