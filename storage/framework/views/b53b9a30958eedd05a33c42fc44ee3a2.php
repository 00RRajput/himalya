<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('Product'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            <a href="/dashboard"> <?php echo app('translator')->get('Dashboards'); ?></a>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            <?php echo app('translator')->get('Product'); ?>
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-9">
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
                        <div class="table-responsive table-card">
                            <table class="table align-middle table-nowrap" id="">
                                <thead class="text-muted">
                                    <tr>

                                        <th class="text-uppercase">#</th>
                                        <th class="text-uppercase">Product Name</th>
                                        <th class="text-uppercase">SKU</th>
                                        <th class="text-uppercase">MRP</th>
                                        <th class="text-uppercase">Cost Price</th>
                                        <th class="text-uppercase">Selling Price</th>
                                        <th class="text-uppercase">Status</th>
                                        <th class="text-uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all" id="">
                                    <?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td>
                                                <?php echo e(($records->currentPage() - 1) * $records->perPage() + $loop->iteration); ?>

                                            </td>
                                            <td class="td"><?php echo e($record->fld_name); ?></td>
                                            <td class="td"> <?php echo e($record->fld_sku); ?></td>

                                            <td class="td"><?php echo e($record->fld_mrp); ?></td>
                                            <td class="td"><?php echo e($record->fld_cost_price); ?></td>
                                            <td class="td"><?php echo e($record->fld_selling_price); ?></td>
                                            <td class="td">

                                                <div class="form-check form-switch">
                                                    <input class="form-check-input status"
                                                        data-product-id=<?php echo e($record->fld_pid); ?> type="checkbox"
                                                        role="switch" id="flexSwitchCheckChecked"
                                                        <?php if($record->fld_status == 1): echo 'checked'; endif; ?> name="status" />
                                                </div>
                                            </td>
                                            <td class="d-flex gap-2">
                                                <a href="<?php echo e(route('products.edit', $record->fld_pid)); ?>"><i
                                                        class="ri-eye-line"></i></a>
                                                <form onsubmit="return confirm('Do you really want to delete?');"
                                                    action="<?php echo e(route('products.destroy', $record->fld_pid)); ?>"
                                                    method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn-submit  ri-delete-bin-line">
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="8">
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
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0">We've searched more than 150+ invoices We did not find any
                                        invoices for you search.</p>
                                </div>
                            </div>
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
        <div class="col-lg-3">

            <?php if(request()->route()->getName() === 'products.edit'): ?>
                <?php echo $__env->make('product.edit', ['product' => $product], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php else: ?>
                <?php echo $__env->make('product.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

        </div>
    </div>
    <!--end row-->
    <?php echo $__env->make('product.upload', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('/build/js/app.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/build/js/jquery.min.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $(".status").change(function(e) {
                let product_id = $(this).attr('data-product-id');
                let status = ($(this).is(':checked') === false) ? 0 : 1;
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                let additionalParam = {
                    status,
                    product_id
                };
                $.ajax({
                    url: "/master/product/update-status",
                    type: "POST",
                    data: JSON.stringify(additionalParam),
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in request headers
                    },
                    success: function(response) {
                        showSuccessMessage('Status has been updated');
                        // Handle success
                    },
                    error: function(xhr, status, error) {
                        showSuccessMessage(xhr.responseText);
                        // Handle error
                    }
                });

            })




        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u951376346/domains/nebulacrm.in/public_html/himalaya/resources/views/product/index.blade.php ENDPATH**/ ?>