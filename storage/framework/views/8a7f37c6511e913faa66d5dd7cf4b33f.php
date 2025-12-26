<?php
    $s = $getState() ?? [];
    $spent   = (float) ($s['spent'] ?? 0);
    $min     = (float) ($s['min'] ?? 0);
    $percent = (int)    ($s['percent'] ?? 0);
?>

<div class="w-56">
    
    <div class="text-xs text-gray-700 dark:text-gray-200 mb-1">
        <?php echo e(number_format($spent, 0)); ?>/<?php echo e(number_format($min, 0)); ?>

    </div>

    <div class="w-full h-2 rounded bg-gray-200 dark:bg-gray-700 overflow-hidden">
        <div
            class="h-2 bg-primary-500 dark:bg-primary-400"
            style="width: <?php echo e($percent); ?>%;"
            role="progressbar"
            aria-valuenow="<?php echo e($percent); ?>" aria-valuemin="0" aria-valuemax="100"
        ></div>
    </div>
</div>
<?php /**PATH /var/www/html/resources/views/filament/tables/columns/spend-progress.blade.php ENDPATH**/ ?>