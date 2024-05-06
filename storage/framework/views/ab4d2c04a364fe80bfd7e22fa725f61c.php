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
                <form action="<?php echo e(route('mandi.store.routePlans')); ?>" method="POST" name="add_new">
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
                                        <?php $__errorArgs = ['fld_project_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <p class="text-danger text-xs mt-2"><?php echo e($message); ?></p>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </select>
                                </div>
                                <!--end col-->
                                <div class="col-4 mb-3">
                                    <select id="state_id" name="state_id"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value="">All States</option>
                                        <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($state->fld_sid); ?>" <?php if(request('state_id') == $state->fld_sid): echo 'selected'; endif; ?>>
                                                        <?php echo e($state->fld_state); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                                <?php $__errorArgs = ['state_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <p class="text-danger text-xs mt-2"><?php echo e($message); ?></p>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <select name="district_id" id="district_id"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value=""><?php echo app('translator')->get('All Districts'); ?> </option>
                                        <?php $__currentLoopData = $destrict; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($d->fld_did); ?>" <?php if(request('state_id') == $d->fld_did): echo 'selected'; endif; ?>>
                                                        <?php echo e($d->fld_district); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                                <?php $__errorArgs = ['district_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <p class="text-danger text-xs mt-2"><?php echo e($message); ?></p>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <select id="fld_tid" name="fld_tid"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value="">All Towns</option>
                                        <?php $__currentLoopData = $towns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $town): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($town->fld_tid); ?>" <?php if(request('state_id') == $town->fld_tid): echo 'selected'; endif; ?>>
                                                        <?php echo e($town->fld_town); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                                <?php $__errorArgs = ['fld_tid'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <p class="text-danger text-xs mt-2"><?php echo e($message); ?></p>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <select id="mandi_id" name="mandi_id"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value="">All Mandis</option>
                                        <?php $__currentLoopData = $mandis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mandi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($mandi->fld_mid); ?>" <?php if(request('state_id') == $mandi->fld_mid): echo 'selected'; endif; ?>>
                                                        <?php echo e($mandi->fld_mandi); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                                <?php $__errorArgs = ['mandi_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <p class="text-danger text-xs mt-2"><?php echo e($message); ?></p>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <select name="wholesaler_id" id="wholesaler_id"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value=""><?php echo app('translator')->get('All Wholesalers'); ?> </option>
                                        <?php $__currentLoopData = $wholesalers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($w->fld_wsid); ?>" <?php if(request('state_id') == $w->fld_wsid): echo 'selected'; endif; ?>>
                                                        <?php echo e($w->fld_wholesaler); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                                <?php $__errorArgs = ['wholesaler_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <p class="text-danger text-xs mt-2"><?php echo e($message); ?></p>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </select>
                                </div>

                                <div class="col-4">
                                    <select name="user_id" id="user_id"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value=""><?php echo app('translator')->get('All Field Users'); ?> </option>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($u->fld_uid); ?>" <?php if(request('state_id') == $u->fld_uid): echo 'selected'; endif; ?>>
                                                        <?php echo e($u->fld_name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                                <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <p class="text-danger text-xs mt-2"><?php echo e($message); ?></p>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <div class="<?php $__errorArgs = ['fld_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>border border-danger rounded-3 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <input class="form-control" value="<?php echo e(old('fld_date')); ?>" type="date"
                                                placeholder="Enter user name" id="fld_date" name="fld_date" required>
                                            <?php $__errorArgs = ['fld_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <p class="text-danger text-xs mt-2"><?php echo e($message); ?></p>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--end col-->
                            <div class="col-lg-12">

                                <div class="text-end">
                                    <!-- <a href="<?php echo e(route('report.routePlan')); ?>" class="btn btn-light">Cancel</a>
                                    <input class="form-control" type="hidden" readonly id="fld_tid" name="fld_tid"
                                        required>
                                    <input class="form-control" type="hidden" readonly id="fld_uid" name="fld_uid"
                                        required>
                                    <input class="form-control" type="hidden" readonly id="fld_username"
                                        name="fld_username" required> -->

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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/dr.mac/Downloads/himalaya/resources/views/mandi/createRoutePlan.blade.php ENDPATH**/ ?>