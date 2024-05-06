        <form action="<?php echo e(route('projects.store')); ?>" method="POST" name="add_new_record">
            <?php echo csrf_field(); ?>

            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Add New Project</h4>
                </div>

                <div class="card-body">
                    <div class="live-preview">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="fld_type" class="form-control-label">Project Type<sup>*</sup></label>
                                    <select class="form-control" name="fld_sale_type" required>
                                        <option value="">Select Project Type</option>
                                        <option value="1">Van</option>
                                        <option value="2">Mandi</option>
                                        <option value="3">Mela</option>
                                        <option value="4">Branding</option>
                                    </select>

                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="fld_name" class="form-control-label">Project Name<sup>*</sup></label>

                                    <div class="<?php $__errorArgs = ['fld_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>border border-danger rounded-3 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <input class="form-control" value="<?php echo e(old('fld_name')); ?>" type="text"
                                            placeholder="Enter  name" id="fld_name" name="fld_name" required>
                                        <?php $__errorArgs = ['fld_name'];
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
                            <input type="hidden" value="1" name="fld_sale_type">
                            <!-- <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="fld_name" class="form-control-label">Sale Type</label>
                                    <select class="form-control" name="fld_sale_type">
                                        <option value="">Select Sale Type</option>
                                        <option value="1">Retail</option>
                                        <option value="2">Order Booking</option>
                                    </select>

                                </div>
                            </div> -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="fld_start_date" class="form-control-label">Start
                                        Date<sup>*</sup></label>

                                    <div class="<?php $__errorArgs = ['fld_start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>border border-danger rounded-3 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <input class="form-control" value="<?php echo e(old('fld_start_date')); ?>" type="date"
                                            id="fld_start_date" name="fld_start_date" required>
                                        <?php $__errorArgs = ['fld_start_date'];
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
                            <!-- <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="fld_consumer_sales" class="form-control-label">Consumer Sales</label>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="fld_consumer_sales"
                                            name="fld_consumer_sales">
                                    </div>
                                </div>
                            </div> -->
                            <!-- <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="fld_activity_photos" class="form-control-label">Activity Photos</label>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="fld_activity_photos"
                                            name="fld_activity_photos">
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="fld_name" class="form-control-label">Status</label>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" checked="" value="1" name="status" />
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-12">

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>

                        <!--end row-->
                    </div>
                </div>
            </div>

        </form>
<?php /**PATH /Users/dr.mac/Downloads/himalaya/resources/views/project/create.blade.php ENDPATH**/ ?>