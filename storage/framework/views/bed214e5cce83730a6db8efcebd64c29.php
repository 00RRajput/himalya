<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('Activity Photos'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            <a href="/dashboard"> <?php echo app('translator')->get('Dashboards'); ?></a>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            <?php if($request->type == 'recce'): ?>
            <?php echo app('translator')->get('Recce Photos'); ?>
            <?php endif; ?>
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="invoiceList">
                <?php if(session('success')): ?>
                    <div class="m-3  alert bg-success alert-dismissible  show" id="alert-success" role="alert">
                        <span class="alert-text text-white">
                            <?php echo e(session('success')); ?></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">

                        </button>
                    </div>
                <?php endif; ?>
                
                <div class="card-body">
                    <div>
                        <div class="row mt-1" id="seller-list">
                            <div class="col-lg-3">
                                <?php if($images[0]->fld_photo_path_recce): ?>
                                            <a class="image-popup m-0 p-0"
                                                href="<?php echo e(env('SERVER_BASE_URL')); ?><?php echo e($images[0]->fld_photo_path_recce); ?>/<?php echo e($images[0]->fld_photo_file_recce); ?>"
                                                title="">
                                                <img class="gallery-img img-fluid mx-auto"
                                                    src="<?php echo e(env('SERVER_BASE_URL')); ?><?php echo e($images[0]->fld_photo_path_recce); ?>/<?php echo e($images[0]->fld_photo_file_recce); ?>"
                                                    alt="">
                                                <div class="gallery-overlay">
                                                    
                                                </div>
                                            </a>
                                            <?php endif; ?>
                                           

                            </div>
                            <div class="col-lg-9">
                                <div class="row mt-1" id="seller-list">
                                    <?php $__empty_1 = true; $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div class="col-lg-2">
                                            <a class="image-popup m-0 p-0"
                                                href="<?php echo e(env('SERVER_BASE_URL')); ?><?php echo e($image->fld_path); ?>/<?php echo e($image->fld_image); ?>"
                                                title="">
                                                <img class="gallery-img img-fluid mx-auto"
                                                    src="<?php echo e(env('SERVER_BASE_URL')); ?><?php echo e($image->fld_path); ?>/<?php echo e($image->fld_image); ?>"
                                                    alt="">
                                                <div class="gallery-overlay">
                                                    <h5 class="overlay-caption"><?php echo e($image->photo_type ?? ''); ?></h5>
                                                </div>
                                            </a>
                                            <p class="text-muted m-0 p-0">
                                                <?php echo e(date(env('DATE_FORMAT'), strtotime($image->fld_created_at))); ?>

                                                <a href="http://maps.google.com/?q=<?php echo e($image->fld_lat); ?>,<?php echo e($image->fld_long); ?>"
                                                    target="_blank" class="ri-map-pin-fill"></a>

                                            </p>
                                            <p class="m-0 p-0 text-muted"><?php echo e($image->user_name); ?> |
                                                <?php echo e($image->fld_state ?? 'NA'); ?></p>
                                            <p class="text-muted"><?php echo e($image->project_name ?? ''); ?></p>

                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <div class="noresult">
                                            <div class="text-center">
                                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                    colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                                </lord-icon>
                                                <h5 class="mt-2">Sorry! No Result Found</h5>

                                            </div>
                                        </div>
                                    <?php endif; ?>

                                </div>




                                <div class="d-flex justify-content-end mt-3">
                                    <div class="pagination-wrap hstack gap-2" style="display: flex;">
                                        <?php echo e($images->appends(request()->except('page'))->links()); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade flip" id="deleteOrder" tabindex="-1" aria-labelledby="deleteOrderLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px">
                                    </lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4>You are about to delete a user ?</h4>
                                        <p class="text-muted fs-15 mb-4">Deleting your user will remove all of your
                                            information from our database.</p>
                                        <div class="hstack gap-2 justify-content-center remove">
                                            <button class="btn btn-link link-success fw-medium text-decoration-none"
                                                id="deleteRecord-close" data-bs-dismiss="modal"><i
                                                    class="ri-close-line me-1 align-middle"></i> Close</button>
                                            <a href="" class="btn btn-danger" id="delete-record">Yes, Delete
                                                It</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end modal -->
                </div>
            </div>

        </div>
    </div>
    <!--end row-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('/assets/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".delete_user").click(function(e) {
                let id = $(this).attr('data-id');
                let url = `users/destroy/${id}`;
                $("#delete-record").attr('href', url)
            })
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/dr.mac/Downloads/himalaya/resources/views/branding/activityPhoto.blade.php ENDPATH**/ ?>