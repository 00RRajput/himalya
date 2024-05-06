        <form action="<?php echo e(route('district.store')); ?>" method="POST" name="add_new_record">
            <?php echo csrf_field(); ?>

            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Add New District</h4>
                </div>

                <div class="card-body">
                    <div class="live-preview">

                        <div class="row">

                            <!--end col-->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="fld_state_id" class="form-control-label">State<sup>*</sup></label>

                                    <select id="fld_state_id" name="fld_state_id"
                                        class="form-control bg-light border-light flatpickr-input">
                                        <option value="">All States</option>
                                        <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($state->fld_sid); ?>" <?php if(old('fld_state_id') == $state->fld_sid): echo 'selected'; endif; ?>>
                                                <?php echo e($state->fld_state); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="fld_district" class="form-control-label">District<sup>*</sup></label>

                                    <div class="<?php $__errorArgs = ['fld_district'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>border border-danger rounded-3 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <input class="form-control" value="<?php echo e(old('fld_district')); ?>" type="text"
                                            placeholder="Enter  name" id="fld_district" name="fld_district" required>
                                        <?php $__errorArgs = ['fld_district'];
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


                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="fld_name" class="form-control-label">Status</label>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" value="1" name="fld_status" />
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-12">

                                <div class="text-end">
                                    <a href="<?php echo e(route('clients.index')); ?>" class="btn btn-light">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>

                        <!--end row-->
                    </div>
                </div>
            </div>

        </form>
<?php /**PATH /Users/dr.mac/Downloads/himalaya/resources/views/location/district/create.blade.php ENDPATH**/ ?>