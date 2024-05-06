<span class="text-capitalize">
        <?php if(isset($record->fld_village) ): ?>
        <?php echo e($record->fld_village); ?>

        <?php elseif(isset($record->fld_town)): ?>
        <?php echo e($record->fld_town); ?>

        <?php endif; ?>
</span>
<p class="text-muted mb-0"><a href="http://maps.google.com/?q=<?php echo e($record->fld_lat); ?>,<?php echo e($record->fld_long); ?>"
        target="_blank" class="ri-map-pin-fill"></a> <?php echo e($record->fld_district ?? ''); ?></p>
<?php /**PATH /Users/dr.mac/Downloads/himalaya/resources/views/components/locationTD.blade.php ENDPATH**/ ?>