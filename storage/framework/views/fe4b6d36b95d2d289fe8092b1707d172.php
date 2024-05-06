<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('Consumer Sales Details'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            <a href="/dashboard"> <?php echo app('translator')->get('Dashboards'); ?></a>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            <?php echo app('translator')->get('Mandi Consumer Sales Details'); ?>
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

                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card">
                            <table class="table align-middle table-nowrap" id="purchase-details">
                                <thead class="text-muted">
                                    <tr>
                                        <th class="text-uppercase">Product</th>
                                        <th class="text-uppercase">Price</th>
                                        <th class="text-uppercase">Quantity</th>
                                        <th class="text-uppercase">Total</th>
                                        <th class="text-uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all" id="table-tr">
                                    <?php $final_total=0;?>
                                    <?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="table-row" data-row-id=<?php echo e($record->fld_mcsiid); ?>>

                                            <td class="td">
                                                <span class="row_product_id" data-product-name="<?php echo e($record->fld_product); ?>"
                                                    data-product-id=<?php echo e($record->fld_pid); ?>>
                                                    <?php echo e($record->fld_product); ?>- <?php echo e($record->fld_selling_price); ?>

                                                    (MRP Rs.<?php echo e($record->fld_mrp); ?>)
                                                </span>
                                            </td>
                                            <td class="td">
                                                <input id="product_qty_<?php echo e($record->fld_mcsiid); ?>"
                                                    data-record-id="<?php echo e($record->fld_mcsiid); ?>"
                                                    value="<?php echo e($record->fld_price); ?>"
                                                    class="product_fld_price form-control" />
                                            </td>
                                            <td class="td">
                                                <input id="product_qty_<?php echo e($record->fld_mcsiid); ?>"
                                                    data-record-id="<?php echo e($record->fld_mcsiid); ?>"
                                                    value="<?php echo e($record->fld_qty); ?>" class="product_fld_qty form-control" />
                                            </td>
                                            <td class="td"><input readonly id="product_total_<?php echo e($record->fld_mcsiid); ?>"
                                                    value="<?php echo e($record->fld_total); ?>"
                                                    class="form-control each_product_total" />
                                            </td>
                                            <td>
                                                <?php if(in_array(Auth::user()->fld_role, [1, 3, 5])): ?>
                                                    <a class="bx bx-trash removeProduct" href="javascript:void(0)"
                                                        data-id="<?php echo e($record->fld_mcsiid); ?>"></a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php
                                            $final_total += $record->fld_total;
                                        ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr id="emptyRow">
                                            <td colspan="3">
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
                                    <?php if(in_array(Auth::user()->fld_role, [1, 3, 5])): ?>
                                        <tr id="add_new_product_row">
                                            <td class="td">
                                                <select name="product_id" id="add_product_id"
                                                    class="form-control add_new_product_ids bg-light border-light flatpickr-input">
                                                    <option value="">Select Product </option>
                                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option data-product-price="<?php echo e($product->fld_selling_price); ?>"
                                                            data-product-costPrice="<?php echo e($product->fld_cost_price); ?>"
                                                            data-product-id="<?php echo e($product->fld_pid); ?>" data-record-id="0"
                                                            data-product-mrp="<?php echo e($product->fld_mrp); ?>"
                                                            value="<?php echo e($product->fld_pid); ?>">
                                                            <?php echo e($product->fld_name); ?> Rs.<?php echo e($product->fld_selling_price); ?>

                                                            (MRP Rs.<?php echo e($product->fld_mrp); ?>)
                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </td>
                                            <td class="td">
                                                <input id="product_price_0" data-record-id="0" value=""
                                                    class="product_fld_price form-control" />
                                            </td>
                                            <td class="td">
                                                <input id="product_qty_0" data-record-id="0" value=""
                                                    class="product_fld_qty form-control" />
                                            </td>

                                            <td class="td"><input readonly id="product_total_0" value=""
                                                    class="form-control each_product_total" />
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" id="addNewItem"
                                                    class="btn btn-success  bx bx-plus-medical"></a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>

                            <table class="table align-middle table-nowrap">
                                <thead>
                                    <tr>
                                        <th># Note: This is the final invoice value.</th>
                                        <th>
                                            <label>Date</label>
                                            <input class="form-control" id="date" type="date" name="fld_date"
                                                value="<?php echo e($consumerSale->fld_date); ?>" />
                                        </th>
                                        <th>
                                            <label>Total</label>
                                            <input class="form-control" id="final_total" value="<?php echo e($final_total); ?>"
                                                readonly disabled value="" />
                                        </th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td>
                                            <input type="hidden" id="fld_csid" value="<?php echo e($consumerSale->fld_mcsid); ?>" />
                                            <input type="hidden" id="fld_mobile_id"
                                                value="<?php echo e($consumerSale->fld_mobile_id); ?>" />
                                            <?php if(in_array(Auth::user()->fld_role, [1, 3, 5])): ?>
                                                <a class="btn btn-success" id="updateItems"
                                                    href="javascript:void(0)">Update</a>
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
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

            $('#purchase-details').on('input', '.product_fld_price, .product_fld_qty', function() {
                var row = $(this).closest('tr');
                var quantity = row.find('.product_fld_qty').val();
                var price = row.find('.product_fld_price').val();
                var total = quantity * price;
                row.find('.each_product_total').val(total);
                calculateFinalTotal();
            });

            $(".product_fld_id").change(function(e) {
                let selected = $(this).find(':selected');
                let record_id = selected.attr('data-record-id');
                let product_mrp = parseInt(selected.attr('data-product-mrp'));
                let product_qty = parseInt($(`#product_qty_${record_id}`).val());

            })
            $("#add_product_id").change(function(e) {
                let selected = $(this).find(':selected');
                let record_id = selected.attr('data-product-id');
                let product_mrp = parseInt(selected.attr('data-product-mrp'));

                $("#product_price_0").val(product_mrp);
                $("#product_qty_0").val(1);
                $("#product_total_0").val(product_mrp);

            })

            function calculateFinalTotal() {
                var sum = 0;
                $('.each_product_total').each(function() {
                    var value = $(this).val();
                    // Convert value to number, if possible
                    var number = parseFloat(value);
                    // If number is valid, add it to the sum
                    if (!isNaN(number)) {
                        sum += number;
                    }
                });
                $("#final_total").val(sum);
            }

            $("#addNewItem").click(function() {
                addNewItem();
                calculateFinalTotal();
            });
            $(document).on('click', '.removeProduct', function() {
                let rowId = $(this).attr('data-id');
                var row = $(this).closest('tr');
                var dataId = row.attr('data-row-id');
                console.log(rowId, dataId)
                // Here you can put your condition
                if (dataId == rowId) {
                    row.remove(); // Remove the row
                }
                calculateFinalTotal();
            });

            const uid = function() {
                return Date.now().toString(36) + Math.random().toString(36).substr(2);
            }

            function addNewItem() {
                let productSelected = $("#add_product_id").find(':selected')
                let product_id = productSelected.val();

                if (product_id == 0) {
                    alert("Please select product");
                    return false;
                }


                let product_name = productSelected.text();
                let id = productSelected.attr('data-product-id');
                let selling_price = productSelected.attr('data-product-price');
                let mrp = productSelected.attr('data-product-mrp');
                let cost_price = productSelected.attr('data-product-costPrice');
                let price = $("#product_price_0").val();
                let qty = $("#product_qty_0").val();
                let idx = uid()
                let item = `
                        <tr class="table-row" data-row-id="${idx}">
                        <td class="td">
                            <span class="row_product_id" data-product-name="${product_name}" data-product-id="${id}">
                            ${product_name}-${selling_price} (MRP. ${mrp})
                            </span>
                        </td>
                        <td class="td">
                        <input id="product_qty_${id}"
                        data-record-id="${id}"
                        value="${price}"
                        class="product_fld_price form-control" />
                        </td>
                        <td class="td">
                        <input id="product_qty_${id}"
                        data-record-id="${id}" value="${qty}"
                        class="product_fld_qty form-control" />
                        </td>
                        <td class="td"><input readonly id="product_total_${id}"
                        value="${qty*price}"
                        class="form-control each_product_total" />
                        <td>
                        <a href="javascript:void(0)" class="bx bx-trash removeProduct" data-id="${idx}"></a>    
                        </td>
                        </td>
                        </tr>                
                `;
                $("#emptyRow").hide();
                $("#table-tr tr:last").before(item);

                $("#product_price_0").val(0);
                $("#product_qty_0").val(0);
                $("#product_total_0").val(0);
                $('#add_product_id').find('option:selected').remove();
            }

            $("#updateItems").click(function() {
                let jsonArray = [];
                showSuccessMessage('Please wait....');
                $('#purchase-details tbody tr.table-row').each(function() {
                    var productId = $(this).find('.row_product_id').attr('data-product-id');
                    var product_name = $(this).find('.row_product_id').attr('data-product-name');
                    var price = $(this).find('.product_fld_price').val();
                    var qty = $(this).find('.product_fld_qty').val();
                    var total = $(this).find('.each_product_total').val();
                    var item = {
                        "fld_mcsid": $("#fld_csid").val(),
                        "fld_mobile_id": $("#fld_mobile_id").val(),
                        "fld_pid": productId,
                        "fld_product": product_name,
                        "fld_price": price,
                        "fld_qty": qty,
                        "fld_total": total,
                        "fld_date": $("#date").val(),
                    };
                    jsonArray.push(item);
                });

                var additionalParams = {
                    "fld_mcsid": $("#fld_csid").val(),
                    "fld_date": $("#date").val(),
                    "fld_total": $("#final_total").val(),
                    'items': jsonArray
                };
                console.log(additionalParams);
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                console.log(csrfToken);
                $.ajax({
                    url: "<?php echo e(route('mandi.consumerSales.details.update')); ?>",
                    type: "POST",
                    data: JSON.stringify(additionalParams),
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in request headers
                    },
                    success: function(response) {
                        showSuccessMessage('Items successfully updated!');
                    },
                    error: function(xhr, status, error) {
                        showSuccessMessage(xhr.responseText);
                    }
                });
            })
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/dr.mac/Downloads/himalaya/resources/views/mandi/consumersaledetails.blade.php ENDPATH**/ ?>