<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('Activity Photos'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            <a href="/dashboard"> <?php echo app('translator')->get('Dashboards'); ?></a>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            <?php echo app('translator')->get('Mela Activity Photos'); ?>
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
                <div class="card-body bg-soft-light border border-dashed border-start-0 border-end-0">
                    <form action="<?php echo e(url('/mandi/activity-photos')); ?>" method="GET">
                        <div class="row g-3">
                            <!--end col-->
                            <div class="col">
                                <select id="project_id" name="project_id"
                                    class="form-control bg-light border-light flatpickr-input">
                                    <option value="">Select Project </option>
                                    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($project->fld_pid); ?>" <?php if(session('project_id') == $project->fld_pid || request('project_id') == $project->fld_pid): echo 'selected'; endif; ?>>
                                            <?php echo e($project->fld_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col">
                                <select id="state_id" name="state_id"
                                    class="form-control bg-light border-light flatpickr-input">
                                    <option value="">All States</option>
                                    <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($state->fld_sid); ?>" <?php if(request('state_id') == $state->fld_sid): echo 'selected'; endif; ?>>
                                            <?php echo e($state->fld_state); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col">
                                <select name="district_id" id="district_id"
                                    class="form-control bg-light border-light flatpickr-input">
                                    <option value=""><?php echo app('translator')->get('All Districts'); ?> </option>
                                    <?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($district->fld_did); ?>" <?php if(request('district_id') == $district->fld_did): echo 'selected'; endif; ?>>
                                            <?php echo e($district->fld_district); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col">
                                <select name="user_id" class="form-control bg-light border-light flatpickr-input">
                                    <option value=""><?php echo app('translator')->get('All Field Users'); ?> </option>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($user->fld_uid); ?>" <?php if(request('user_id') == $user->fld_uid): echo 'selected'; endif; ?>>
                                            <?php echo e($user->fld_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <!--end col-->
                            <div class="col">
                                <input name="start_date" type="date"
                                    class="form-control bg-light border-light flatpickr-input" id="start_date"
                                    placeholder="<?php echo app('translator')->get('start date'); ?>" value="<?php echo e(request('start_date')); ?>">
                            </div>
                            <div class="col">
                                <input name="end_date" type="date"
                                    class="form-control bg-light border-light flatpickr-input" id="end_date"
                                    placeholder="<?php echo app('translator')->get('End date'); ?>" value="<?php echo e(request('end_date')); ?>">
                            </div>
                            <div class="col">
                                <div class="d-flex gap-2">
                                    <button type="submit" name="submit" name="go"
                                        class="col  mr-1 btn btn-primary">Search</button>
                                    <button type="submit" name="submit" value="reset"
                                        class="col  mr-1 btn btn-secondary ">Reset</button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body">
                    <div>
                        <div class="row mt-1" id="seller-list">
                            <?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="col-lg-2">
                                    <a class="image-popup m-0 p-0"
                                        href="<?php echo e(env('SERVER_BASE_URL')); ?><?php echo e($record->fld_path); ?>/<?php echo e($record->fld_image); ?>"
                                        title="">
                                        <img class="gallery-img img-fluid mx-auto"
                                            src="<?php echo e(env('SERVER_BASE_URL')); ?><?php echo e($record->fld_path); ?>/<?php echo e($record->fld_image); ?>"
                                            alt="">
                                        <div class="gallery-overlay">
                                            <h5 class="overlay-caption"><?php echo e($record->photo_type); ?></h5>
                                        </div>
                                    </a>
                                    <p class="text-muted m-0 p-0">
                                        <?php echo e(date(env('DATE_FORMAT'), strtotime($record->fld_created_at))); ?>

                                        <a href="http://maps.google.com/?q=<?php echo e($record->fld_lat); ?>,<?php echo e($record->fld_long); ?>"
                                            target="_blank" class="ri-map-pin-fill"></a>

                                    </p>
                                    <p class="m-0 p-0 text-muted"><?php echo e($record->user_name); ?> |
                                        <?php echo e($record->user->state->fld_state ?? 'NA'); ?></p>
                                    <p class="text-muted"><?php echo e($record->project_name ?? ''); ?></p>

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
                                <?php echo e($records->appends(request()->except('page'))->links()); ?>

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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/dr.mac/Downloads/himalaya/resources/views/mela/activityPhoto.blade.php ENDPATH**/ ?>