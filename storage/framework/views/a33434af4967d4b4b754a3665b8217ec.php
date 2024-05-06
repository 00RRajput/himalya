<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('Projects'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            <a href="/dashboard"> <?php echo app('translator')->get('Dashboards'); ?></a>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            <?php echo app('translator')->get('Projects'); ?>
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
                                        <th class="text-uppercase">Project Name</th>
                                        <th class="text-uppercase">Consumer Sales</th>
                                        <th class="text-uppercase">Activity Photos</th>
                                        <th class="text-uppercase">Project Type</th>
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
                                            <td class="td"><?php echo e($record->fld_name); ?>

                                                <p class="text-muted mb-0">
                                                    <?php echo e(date(env('DATE_FORMAT'), strtotime($record->fld_start_date))); ?></p>
                                            </td>

                                            <td class="td"> <?php echo e($record->fld_consumer_sales ? 'Yes' : 'No'); ?>

                                            </td>

                                            <td class="td"><?php echo e($record->fld_activity_photos ? 'Yes' : 'No'); ?>

                                            </td>

                                            <td class="td"><?php echo e($record->sale_type); ?></td>

                                            <td class="td <?php echo e($record->fld_status ? 'text-green' : 'bg-red'); ?>">
                                                <?php echo e($record->fld_status ? 'Active' : 'Deactive'); ?></td>


                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a class=" btn-sm"
                                                        href="<?php echo e(route('projects.edit', $record->fld_pid)); ?>"><i
                                                            class="ri-edit-line"></i></a>
                                                    <?php if(!count($record->routePlans)): ?>
                                                        <form onsubmit="return confirm('Do you really want to delete?');"
                                                            action="<?php echo e(route('projects.destroy', $record->fld_pid)); ?>"
                                                            method="POST">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="btn-submit  ri-delete-bin-line">
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                    <a class="ri-file-list-3-line" data-toggle="tooltip"
                                                        data-placement="top" title="Custom Fields"
                                                        href="<?php echo e(route('custom-fields.index', ['pid' => $record->fld_pid])); ?>"></a>
                                                    <a class="ri-calendar-check-fill" data-toggle="tooltip"
                                                        data-placement="top" title="Summary Question"
                                                        href="<?php echo e(route('summaries.index', ['pid' => $record->fld_pid])); ?>"></a>

                                                </div>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="7">
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
        <div class="col-lg-3">
            <?php if(request()->route()->getName() === 'projects.edit'): ?>
                <?php echo $__env->make('project.edit', ['project' => $project], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php else: ?>
                <?php echo $__env->make('project.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

        </div>
    </div>
    <!--end row-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('/build/js/jquery.min.js')); ?>"></script>

    <script type="text/javascript">
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/dr.mac/Downloads/himalaya/resources/views/project/index.blade.php ENDPATH**/ ?>