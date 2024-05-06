<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('Add New Route Plan'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            <a href="/dashboard"> <?php echo app('translator')->get('Dashboards'); ?></a>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            <?php echo app('translator')->get('Add New Route Plan'); ?>
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
                <form action="<?php echo e(route('branding.store.routePlans')); ?>" method="POST" name="add_new">
                    <?php echo csrf_field(); ?>
                    <div class="card-body">
                        <div class="live-preview">

                            <div class="row">
                                <div class="col-4 mb-3">
                                    <select id="fld_project_id" name="fld_project_id"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value="">All Projects</option>
                                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($project->fld_pid); ?>" <?php if(session('project_id') == $project->fld_pid || request('project_id') == $project->fld_pid): echo 'selected'; endif; ?>>
                                                <?php echo e($project->fld_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <!--end col-->
                                <div class="col-4 mb-3">
                                    <select id="state_id" name="state_id"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value="">All States</option>
                                         
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <select name="district_id" id="district_id"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value=""><?php echo app('translator')->get('All Districts'); ?> </option>
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <select name="town_id" id="town_id"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value=""><?php echo app('translator')->get('All Towns'); ?> </option>
                                        <?php $__currentLoopData = $towns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $town): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($town->fld_tid); ?>"><?php echo e($town->fld_town); ?> </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <select name="outlet_id" id="town_id"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value=""><?php echo app('translator')->get('All Outlets'); ?> </option>
                                        <?php $__currentLoopData = $outlets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $outlet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($outlet->fld_oid); ?>"><?php echo e($outlet->fld_outlet); ?> </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="col-4">
                                    <select name="user_id" id="user_id"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value=""><?php echo app('translator')->get('All Field Users'); ?> </option>
                                    </select>
                                </div>
                                

                            </div>
                            <!--end col-->
                            <div class="col-lg-12">

                                <div class="text-end">
                                    <a href="<?php echo e(route('report.routePlan')); ?>" class="btn btn-light">Cancel</a>
                                    <input class="form-control" type="hidden" readonly id="fld_tid" name="fld_tid"
                                        required>
                                    <input class="form-control" type="hidden" readonly id="fld_uid" name="fld_uid"
                                        required>
                                    <input class="form-control" type="hidden" readonly id="fld_username"
                                        name="fld_username" required>

                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>

                        <!--end row-->
                    </div>
                </form>
            </div>
        </div>
    </div>
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
            $("#fld_project_id").change(function() {
                getState();
                getUsers();
            });
            $("#state_id").change(function() {
                getDistrict();
            });
            $("#district_id").change(function() {
                getVillage();
            });
            $("#village_id").change(function() {
                let tname = $('#village_id option:selected').attr('data-tehsil-name');
                let tid = $('#village_id option:selected').attr('data-tehsil-id');
                $("#fld_tid").val(tid);
            });

            $("#user_id").change(function() {
                let username = $('#user_id option:selected').attr('data-username');
                let uid = $('#user_id option:selected').val();
                $("#fld_username").val(username);
                $("#fld_uid").val(uid);
            });

            async function getState() {
                let id = $('#fld_project_id option:selected').val();
                if (id) {
                    (request_state_id) ?
                    $("#state_id").html('<option>loading....</option>'): '';
                    $.ajax({
                        url: `/getState/${id}`,
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
                let id = $('#fld_project_id option:selected').val();
                if (id) {
                    (request_user_id) ? $("#user_id").html('<option>loading....</option>'): '';

                    $.ajax({
                        url: `/getUsers/${id}`,
                        success: function(result) {
                            let html = "<option value='0'>All Field Users </option>";
                            $.each(result, function(key, user) {
                                let selected = (user.fld_uid == request_user_id) ?
                                    'selected' : '';
                                html +=
                                    `<option data-username='${user.fld_username}' value='${user.fld_uid}' ${selected}> ${user.fld_username}</option>`
                            });

                            $("#user_id").html(html);

                        }
                    });


                }
            }

            function getDistrict() {
                let id = $('#state_id option:selected').val();
                if (id) {
                    (request_district_id) ? $("#district_id").html('<option>loading....</option>'): '';

                    $.ajax({
                        url: `/getDistrict/${id}`,
                        success: function(result) {
                            let html = "<option value='0'>All Districts </option>";
                            $.each(result, function(key, district) {
                                html +=
                                    `<option value='${district.fld_did}'> ${district.fld_district}</option>`
                            });

                            $("#district_id").html(html);

                        }
                    });


                }
            }

            function getVillage() {
                let id = $('#district_id option:selected').val();
                if (id) {
                    (request_district_id) ? $("#village_id").html('<option>loading....</option>'): '';

                    $.ajax({
                        url: `/geVillages/${id}`,
                        success: function(result) {
                            let html = "<option value='0'>All Villages </option>";
                            $.each(result, function(key, village) {
                                html +=
                                    `<option value='${village.fld_vid}' data-tehsil-name='${village.fld_tehsil}' data-tehsil-id='${village.fld_tehsil_id}'   > ${village.fld_village}</option>`
                            });

                            $("#village_id").html(html);

                        }
                    });


                }
            }

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/dr.mac/Downloads/himalaya/resources/views/branding/createRoutePlan.blade.php ENDPATH**/ ?>