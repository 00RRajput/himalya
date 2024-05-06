<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('Location'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            <a href="/dashboard"> <?php echo app('translator')->get('Dashboards'); ?></a>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('titleHeading'); ?>
            Location
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Location
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div id="invoiceList">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-1">
                                <div class="nav flex-column nav-pills text-center" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <a class="nav-link mb-2 <?php if(in_array(Route::currentRouteName(), ['district.edit', 'district.index'])): ?> active <?php endif; ?>"
                                        href="<?php echo e(route('district.index')); ?>" role="tab" aria-controls="v-pills-home"
                                        aria-selected="true">District</a>
                                    <a class="nav-link mb-2 <?php if(in_array(Route::currentRouteName(), ['tehsil.edit', 'tehsil.index'])): ?> active <?php endif; ?>"
                                        href="<?php echo e(route('tehsil.index')); ?>" role="tab" aria-controls="v-pills-profile"
                                        aria-selected="false" tabindex="-1">Tehsil</a>
                                    <a class="nav-link mb-2 <?php if(in_array(Route::currentRouteName(), ['village.edit', 'village.index'])): ?> active <?php endif; ?>"
                                        href="<?php echo e(route('village.index')); ?>" role="tab" aria-controls="v-pills-messages"
                                        aria-selected="false" tabindex="-1">Village</a>
                                </div>
                            </div><!-- end col -->
                            <div class="col-11">
                                <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                                    <div class="tab-pane fade <?php if(in_array(Route::currentRouteName(), ['district.edit', 'district.index'])): ?> active show <?php endif; ?>"
                                        id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                        <div class="d-flex mb-2">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/small/img-4.jpg" alt="" width="150"
                                                    class="rounded">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <?php if(in_array(Route::currentRouteName(), ['district.edit', 'district.index'])): ?>
                                                    <?php echo $__env->make('location.district.index', [
                                                        'states' => $states,
                                                        'records' => $records,
                                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade <?php if(in_array(Route::currentRouteName(), ['tehsil.edit', 'tehsil.index'])): ?> active show <?php endif; ?>"
                                        id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                        <div class="d-flex mb-2">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/small/img-5.jpg" alt="" width="150"
                                                    class="rounded">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <?php if(in_array(Route::currentRouteName(), ['tehsil.edit', 'tehsil.index'])): ?>
                                                    <?php echo $__env->make('location.tehsil.index', [
                                                        'states' => $states,
                                                        'records' => $records,
                                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade <?php if(in_array(Route::currentRouteName(), ['village.edit', 'village.index'])): ?> active show <?php endif; ?>"
                                        id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                        <div class="d-flex mb-2">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/small/img-6.jpg" alt="" width="150"
                                                    class="rounded">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <?php if(in_array(Route::currentRouteName(), ['village.edit', 'village.index'])): ?>
                                                    <?php echo $__env->make('location.village.index', [
                                                        'states' => $states,
                                                        'records' => $records,
                                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div><!--  end col -->
                        </div>
                        <!--end row-->
                    </div><!-- end card-body -->
                </div>
            </div>

        </div>
    </div>
    <!--end row-->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('/build/js/app.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/build/js/jquery.min.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u951376346/domains/nebulacrm.in/public_html/himalaya/resources/views/location/location.blade.php ENDPATH**/ ?>