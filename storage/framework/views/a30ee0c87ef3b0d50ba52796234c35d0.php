<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('Van Retails Sales'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            <a href="/dashboard"> <?php echo app('translator')->get('Dashboards'); ?></a>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('titleHeading'); ?>
            <?php echo e($retailerName ?? 'VAN'); ?> RETAILS SALES (Total Orders: <?php echo e($records->total()); ?> , Order Value: ₹ <?php echo e($total_order_value); ?>)
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            VAN RETAILS SALES
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
                    <form action="<?php echo e(url('/van/retail-sales')); ?>" method="GET">
                        <div class="row g-3">
                            <!--end col-->
                            <div class="col">
                                <select id="project_id" name="project_id"
                                    class="form-control bg-light border-light flatpickr-input">
                                    <!-- <option value="">All Projects </option> -->
                                    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($project->fld_pid ==1 ): ?><option value="<?php echo e($project->fld_pid); ?>" selected>
                                            <?php echo e($project->fld_name); ?></option><?php endif; ?>
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
                                <select name="user_id" id="user_id"
                                    class="form-control bg-light border-light flatpickr-input">
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
                                    <?php if(in_array(Auth::user()->fld_role, [1, 3])): ?>
                                        <button type="submit" name="submit" value="export"
                                            class="col  mr-1 btn btn-success ">Export</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card">
                            <table class="table align-middle table-nowrap" id="">
                                <thead class="text-muted">
                                    <tr>

                                        <!-- <th class="text-uppercase">ID</th> -->
                                        <th class="text-uppercase">Shop Name</th>
                                        <th class="text-uppercase">Owner Name</th>
                                        <th class="text-uppercase">Order Total</th>
                                        <th class="text-uppercase">Location</th>
                                        <th class="text-uppercase">State</th>
                                        <th class="text-uppercase">Sale Slip</th>
                                        <th class="text-uppercase">Shop Photo</th>
                                        <th class="text-uppercase">Field User</th>
                                        <th class="text-uppercase">Order Date</th>
                                        <th class="text-uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all" id="">
                                    <?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            
                                            <td><?php echo e($record->shop_name); ?>

                                                <p class="text-muted mb-0"><?php echo e($record->shop_type); ?></p>
                                            </td>
                                            <td><?php echo e($record->owner_name); ?>

                                                <p class="text-muted mb-0"><?php echo e($record->mobile_no); ?></p>

                                            </td>
                                            <td><?php echo e($record->fld_total); ?></td>
                                            <td><?php echo $__env->make('components.locationTD', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></td>
                                            <td><?php echo e($record->fld_state); ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if($record->fld_bill_photo_file): ?>
                                                        <a class="image-popup"
                                                            href="<?php echo e(env('SERVER_BASE_URL')); ?><?php echo e($record->fld_bill_photo_path); ?>/<?php echo e($record->fld_bill_photo_file); ?>"
                                                            title="<?php echo e($record->fld_bill_photo_file); ?>">
                                                            <img class="gallery-img img-fluid mx-auto avatar-xs rounded me-2"
                                                                src="<?php echo e(env('SERVER_BASE_URL')); ?><?php echo e($record->fld_bill_photo_path); ?>/<?php echo e($record->fld_bill_photo_file); ?>"
                                                                alt="<?php echo e($record->fld_bill_photo_file); ?>">
                                                        </a>
                                                    <?php else: ?>
                                                        <i class="bx bx-image bx-md"></i>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if($record->fld_photo_file): ?>
                                                        <a class="image-popup"
                                                            href="<?php echo e(env('SERVER_BASE_URL')); ?><?php echo e($record->fld_photo_path); ?>/<?php echo e($record->fld_photo_file); ?>"
                                                            title="<?php echo e($record->fld_photo_file); ?>">
                                                            <img class="gallery-img img-fluid mx-auto avatar-xs rounded me-2"
                                                                src="<?php echo e(env('SERVER_BASE_URL')); ?><?php echo e($record->fld_photo_path); ?>/<?php echo e($record->fld_photo_file); ?>"
                                                                alt="<?php echo e($record->fld_photo_file); ?>">
                                                        </a>
                                                    <?php else: ?>
                                                        <i class="bx bx-image bx-md"></i>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td><?php echo e($record->fld_name); ?></td>
                                            <td> <?php echo e(date(env('DATE_FORMAT'), strtotime($record->fld_date))); ?></td>
                                            <td>
                                                <div class="d-flex gap-2">

                                                    <a class=""
                                                        href="<?php echo e(route('van.retailsales.details', $record->fld_rsid)); ?>">
                                                        <i class="ri-eye-line"></i></a>
                                                    <?php if(in_array(Auth::user()->fld_role, [1, 3])): ?>
                                                        <form onsubmit="return confirm('Do you really want to delete?');"
                                                            action="<?php echo e(route('van.retailsales.delete', $record->fld_rsid)); ?>"
                                                            method="POST">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="btn-submit  ri-delete-bin-line">
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="10">
                                                <div class="noresult">
                                                    <div class="text-center">
                                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                                            trigger="loop" colors="primary:#121331,secondary:#08a88a"
                                                            style="width:75px;height:75px">
                                                        </lord-icon>
                                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>

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
    <script src="<?php echo e(URL::asset('/build/js/app.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/build/js/jquery.min.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var request_state_id = "<?php echo e(request('state_id')); ?>"
            var request_district_id = "<?php echo e(request('district_id')); ?>"
            var request_user_id = "<?php echo e(request('user_id')); ?>"
            getLoads();
            async function getLoads() {
                await getState();

            }


            // Initialize form validation on the registration form.
            // It has the name attribute "registration"

            $("#project_id").change(function() {
                getState();
            });
            $("#state_id").change(function() {
                //getDistrict();
                getUsers();
            });

            async function getState() {
                let id = $('#project_id option:selected').val();
                if (id) {
                    (request_state_id) ?
                    $("#state_id").html('<option>loading....</option>'): '';
                    $.ajax({
                        url: `/get-project-wise-states/${id}`,
                        success: function(result) {
                            let html = "<option value='0'>All States </option>";
                            $.each(result, function(key, state) {
                                let selected = (state.fld_sid == request_state_id) ?
                                    'selected' : '';
                                html +=
                                    `<option value='${state.fld_sid}' ${selected}> ${state.fld_state}</option>`
                            });

                            $("#state_id").html(html);

                        }
                    });
                }
            }

            function getUsers() {
                let id = $('#state_id option:selected').val();
                if (id) {
                    (request_user_id) ? $("#user_id").html('<option>loading....</option>'): '';

                    $.ajax({
                        url: `/sales-report/retail-sale/get-state-wise-users/${id}`,
                        success: function(result) {
                            let html = "<option value='0'>All Field Users </option>";
                            $.each(result, function(key, user) {
                                let selected = (user.fld_uid == request_user_id) ?
                                    'selected' : '';
                                html +=
                                    `<option value='${user.fld_uid}' ${selected}> ${user.fld_name}</option>`
                            });

                            $("#user_id").html(html);

                        }
                    });


                }
            }

            // function getDistrict() {
            //     let id = $('#state_id option:selected').val();
            //     if (id) {
            //         (request_district_id) ? $("#district_id").html('<option>loading....</option>'): '';

            //         $.ajax({
            //             url: `/get-state-wise-district/${id}`,
            //             success: function(result) {
            //                 let html = "<option value='0'>All Districts </option>";
            //                 $.each(result, function(key, district) {
            //                     let selected = (district.fld_did == request_district_id) ?
            //                         'selected' : '';
            //                     html +=
            //                         `<option value='${district.fld_did}' ${selected}> ${district.fld_district}</option>`
            //                 });

            //                 $("#district_id").html(html);

            //             }
            //         });


            //     }
            // }

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/dr.mac/Downloads/himalaya/resources/views/retailsales.blade.php ENDPATH**/ ?>