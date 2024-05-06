<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('Retailers'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            <a href="/dashboard"> <?php echo app('translator')->get('Dashboards'); ?></a>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            <?php echo app('translator')->get('Retailers'); ?>
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
                    <form action="<?php echo e(url('retailers')); ?>" method="GET">
                        <div class="row g-3">
                            <!--end col-->
                            <div class="col">
                                <select name="project_id" id="project_id"
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
                                <select name="user_id" id="user_id"
                                    class="form-control bg-light border-light flatpickr-input">
                                    <option value=""><?php echo app('translator')->get('All Field Users'); ?> </option>
                                    
                                </select>
                            </div>
                            <!--end col-->
                            
                            <div class="col">
                                <div class="d-flex gap-2">
                                    <button type="submit" name="submit" value="add"
                                        class="col  mr-1 btn btn-primary">Search</button>
                                    <a class="btn btn-secondary col ml-1"
                                        href="<?php echo e(url('sales-report/retail-sales')); ?>">Reset</a>
                                    <?php if(in_array(Auth::user()->fld_role, [1, 3])): ?>
                                        <button type="submit" name="submit" value="export"
                                            class="col  mr-1 btn btn-success">Export</button>
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

                                        <th class="text-uppercase">ID</th>
                                        <th class="text-uppercase">Shop Name</th>
                                        <th class="text-uppercase">Owner Name</th>
                                        <th class="text-uppercase">Location</th>
                                        <th class="text-uppercase">State</th>
                                        <th class="text-uppercase">Shop Photo</th>
                                        <th class="text-uppercase">Field User</th>
                                        <th class="text-uppercase">Date</th>
                                        <th class="text-uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all" id="">
                                    <?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e(($records->currentPage() - 1) * $records->perPage() + $loop->iteration); ?>

                                            </td>
                                            <td class="td"><?php echo e($record->fld_store_name); ?>

                                                <p class="text-muted mb-0"><?php echo e($record->shop_type); ?></p>
                                            </td>
                                            <td class="td text-capitlize"><?php echo e($record->fld_owner_name); ?>

                                                <p class="text-muted mb-0"><?php echo e($record->fld_number); ?></p>
                                            </td>
                                            <td><?php echo $__env->make('components.locationTD', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></td>
                                            <td><?php echo e($record->fld_state); ?></td>
                                            <td class="td">
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
                                            </td>
                                            <td class="td"><?php echo e($record->username); ?></td>
                                            <td>
                                                <?php echo e(date(env('DATE_FORMAT'), strtotime($record->fld_created_at))); ?>

                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <?php if($record->retail_sale_count_sum_fld_total): ?>
                                                        <a href="<?php echo e(route('salesreport.retailsales', ['rid' => $record->fld_rid])); ?>"
                                                            data-id="25000351"><i class="ri-eye-fill text-muted"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <a href="<?php echo e(route('salesreport.retailsales.addnew', ['rid' => $record->fld_rid])); ?>"
                                                        data-id="25000351"><i class="ri-add-box-fill text-muted"></i>
                                                    </a>
                                                    <?php if(in_array(Auth::user()->fld_role, [1, 3])): ?>
                                                        <form onsubmit="return confirm('Do you really want to delete?');"
                                                            action="<?php echo e(route('retailer.delete', $record->fld_rid)); ?>"
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
                                            <td colspan="9">
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
            var request_uid = "<?php echo e(request('user_id')); ?>"
            getLoads();
            async function getLoads() {
                await getState();
                await getUsers();

            }


            // Initialize form validation on the registration form.
            // It has the name attribute "registration"

            $("#project_id").change(function() {
                getState();
                getUsers();
            });
            $("#state_id").change(function() {
                getDistrict();
            });

            async function getState() {
                let id = $('#project_id option:selected').val();
                if (id > 0) {
                    (request_state_id > 0) ?
                    $("#state_id").html('<option>loading....</option>'): '';
                    $.ajax({
                        url: `/retailers/get-project-wise-states/${id}`,
                        success: function(result) {
                            let html = "<option value='0'>All States </option>";
                            $.each(result, function(key, state) {
                                let selected = (state.fld_sid == request_state_id) ?
                                    'selected' : '';
                                html +=
                                    `<option value='${state.fld_sid}' ${selected}> ${state.fld_state}</option>`
                            });

                            $("#state_id").html(html);
                            getDistrict();
                        }
                    });
                }
            }


            function getDistrict() {
                let id = $('#state_id option:selected').val();
                if (id > 0) {
                    (request_district_id > 0) ? $("#district_id").html('<option>loading....</option>'): '';

                    $.ajax({
                        url: `/retailers/get-state-wise-district/${id}`,
                        success: function(result) {
                            let html = "<option value='0'>All Districts </option>";
                            $.each(result, function(key, district) {
                                let selected = (district.fld_did == request_district_id) ?
                                    'selected' : '';
                                html +=
                                    `<option value='${district.fld_did}' ${selected}> ${district.fld_district}</option>`
                            });

                            $("#district_id").html(html);

                        }
                    });


                }
            }

            function getUsers() {
                let id = $('#project_id option:selected').val();
                if (id > 0) {
                    (request_district_id > 0) ? $("#user_id").html('<option>loading....</option>'): '';

                    $.ajax({
                        url: `/retailers/get-project-wise-users/${id}`,
                        success: function(result) {
                            let html = "<option value='0'>All Field Users</option>";
                            $.each(result, function(key, user) {
                                let selected = (user.fld_uid == request_uid) ?
                                    'selected' : '';
                                html +=
                                    `<option value='${user.fld_uid}' ${selected}> ${user.fld_name}</option>`
                            });

                            $("#user_id").html(html);

                        }
                    });


                }
            }


        });

        function ViewInvoice(order) {
            console.log(order);
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u951376346/domains/nebulacrm.in/public_html/himalaya/resources/views/retailers.blade.php ENDPATH**/ ?>