<?php $__env->startSection('content'); ?>
  <section class="content-header">
    <h1>
      <?php echo e(trans('products.show')); ?>

    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo e(route('home')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('common.home')); ?></a></li>
      <li><a href="<?php echo e(route('products.index')); ?>"><?php echo e(trans('products.plural')); ?></a></li>
      <li class="active"><?php echo e(trans('products.show')); ?></li>
    </ol>
  </section>
  <section class="content">
    <?php if($errors->any()): ?>
    <div class="alert alert-danger">
      <b><?php echo e(trans('common.whoops')); ?></b>
      <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
    <?php endif; ?>
    <div class="row">
      <div class="col-md-12">
        <div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title"><?php echo e(trans('products.details')); ?></h3>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-list')): ?>
              <a href="<?php echo e(route('products.index')); ?>" class="btn btn-success pull-right">
                <i class="fa fa-arrow-left"></i>
                <?php echo e(trans('common.back')); ?>

              </a>
            <?php endif; ?>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="name" class="content-label"><?php echo e(trans('products.name')); ?></label>
                  <p><?php echo e($product->name); ?></p>
                </div>
                <div class="form-group">
                  <label for="name" class="content-label"><?php echo e(trans('products.description')); ?></label>
                  <p><?php echo e($product->description); ?></p>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="name" class="content-label"><?php echo e(trans('products.image')); ?></label>
                  <p>
                    <?php if($product->getMedia('products')->last() !== null): ?>
                      <img src="<?php echo e(str_replace('http://localhost',url('/'),$product->getMedia('products')->last()->getUrl('thumb'))); ?>" style="width:100px">
                    <?php else: ?>
                      <?php echo e(trans('products.no_image')); ?>

                    <?php endif; ?>
                  </p>
                </div>
                <div class="form-group">
                  <label for="rate" class="content-label"><?php echo e(trans('products.rate')); ?></label>
                  <?php echo e($product->rate); ?> <?php echo e($product->currency); ?>

                </div>
                
                <div class="form-group">
                  <label for="name" class="content-label"><?php echo e(trans('products.category')); ?></label>
                  <p><?php echo e(@$product->category->name); ?></p>
                </div>

                <div class="form-group">
                  <label for="name" class="content-label"><?php echo e(trans('products.uploaded_on')); ?></label>
                  <p><?php echo e(date('M-d-Y h:i A', strtotime($product->created_at))); ?></p>
                  <p><b><?php echo e(trans('products.uploaded_by')); ?></b> <?php echo e($product->user->name); ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\qsport\resources\views/admin/products/show.blade.php ENDPATH**/ ?>