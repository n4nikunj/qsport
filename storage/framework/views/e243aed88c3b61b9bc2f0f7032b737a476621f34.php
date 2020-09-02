<?php $__env->startSection('content'); ?>

<center><img src="<?php echo e(asset('/img/unauthorized.jpg')); ?>" height="200px" width="400px" style="margin-top: 150px;"></center>
<center><h2><?php echo e($message); ?></h2></center>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\qsport\resources\views/admin/permissions/unauthorized.blade.php ENDPATH**/ ?>