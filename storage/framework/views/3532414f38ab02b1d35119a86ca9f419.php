        <form action="<?php echo e(route('clients.store')); ?>" method="POST" name="add_new_client">
            <?php echo csrf_field(); ?>

            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Add New Client</h4>
                </div>

                <div class="card-body">
                    <div class="live-preview">

                        <div class="row">

                            <!--end col-->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fld_name" class="form-control-label">Client Name<sup>*</sup></label>

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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fld_name" class="form-control-label">Status</label>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" checked="" value="1" name="status">
                                        <label class="form-check-label" for="flexSwitchCheckChecked">Checked to
                                            active</label>
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
<?php /**PATH /home/u951376346/domains/nebulacrm.in/public_html/himalaya/resources/views/client/create.blade.php ENDPATH**/ ?>