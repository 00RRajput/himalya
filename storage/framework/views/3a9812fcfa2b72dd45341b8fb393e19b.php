        <form action="<?php echo e(route('products.store')); ?>" method="POST" name="add_new_record">
            <?php echo csrf_field(); ?>

            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Add New Product</h4>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#varyingcontentModal" data-bs-whatever="Jennifer">Upload</button>
                </div>

                <div class="card-body pt-1">
                    <div class="live-preview">

                        <div class="row">

                            <!--end col-->
                            <div class="col-12">
                                <div class="mb-3 mt-0">
                                    <label for="customer-name" class="col-form-label">Select Project</label>
                                    <select class="form-control" required name="fld_p_id">
                                        <option value="">Selec Project</option>
                                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($project->fld_pid); ?>"> <?php echo e($project->fld_name); ?> </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="fld_name" class="form-control-label">Product Name<sup>*</sup></label>

                                    <div class="<?php $__errorArgs = ['fld_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>border border-danger rounded-3 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <input class="form-control" value="<?php echo e(old('fld_name')); ?>" type="text"
                                            placeholder="Enter product name" id="fld_name" name="fld_name" required>
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
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="fld_sku" class="form-control-label">SKU<sup>*</sup></label>

                                    <div class="<?php $__errorArgs = ['fld_sku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>border border-danger rounded-3 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <input class="form-control" value="<?php echo e(old('fld_sku')); ?>" type="text"
                                            placeholder="Enter  SKU" id="fld_sku" name="fld_sku" required>
                                        <?php $__errorArgs = ['fld_sku'];
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

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="fld_mrp" class="form-control-label">MRP<sup>*</sup></label>

                                    <div class="<?php $__errorArgs = ['fld_mrp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>border border-danger rounded-3 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <input class="form-control" value="<?php echo e(old('fld_mrp')); ?>" type="text"
                                            placeholder="Enter MRP" id="fld_mrp" name="fld_mrp" required>
                                        <?php $__errorArgs = ['fld_mrp'];
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
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="fld_cost_price" class="form-control-label">Cost
                                        price<sup>*</sup></label>

                                    <div class="<?php $__errorArgs = ['fld_cost_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>border border-danger rounded-3 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <input class="form-control" value="<?php echo e(old('fld_cost_price')); ?>" type="text"
                                            placeholder="Enter Cost" id="fld_cost_price" name="fld_cost_price" required>
                                        <?php $__errorArgs = ['fld_cost_price'];
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
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="fld_selling_price" class="form-control-label">Selling
                                        price<sup>*</sup></label>

                                    <div class="<?php $__errorArgs = ['fld_selling_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>border border-danger rounded-3 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <input class="form-control" value="<?php echo e(old('fld_selling_price')); ?>"
                                            type="text" placeholder="Enter  Selling" id="fld_selling_price"
                                            name="fld_selling_price" required>
                                        <?php $__errorArgs = ['fld_selling_price'];
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
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="fld_type" class="form-control-label">Type</label>
                                    <select class="form-control" name="fld_type" id="fld_type">
                                        <option value="">Select Sale Type</option>
                                        <option value="1">Retail</option>
                                        <option value="2">Order Booking</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="fld_display_order" class="form-control-label">Display order</label>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="fld_display_order"
                                            name="fld_display_order">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="fld_name" class="form-control-label">Status</label>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" checked="" value="1"
                                            name="status" />
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-12">

                                <div class="text-end">
                                    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-light">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>

                        <!--end row-->
                    </div>
                </div>
            </div>

        </form>
<?php /**PATH /Users/dr.mac/Downloads/himalaya/resources/views/product/create.blade.php ENDPATH**/ ?>