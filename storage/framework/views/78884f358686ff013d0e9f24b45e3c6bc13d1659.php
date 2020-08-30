<?php $__env->startSection('content'); ?>
  <section class="content-header">
    <h1>
      <?php echo e(trans('products.edit')); ?>

    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo e(route('home')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('common.home')); ?></a></li>
      <li><a href="<?php echo e(route('products.index')); ?>"><?php echo e(trans('products.plural')); ?></a></li>
      <li class="active"><?php echo e(trans('products.edit')); ?></li>
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
          <form method="POST" id="products" action="<?php echo e(route('products.update', $product->id)); ?>" accept-charset="UTF-8" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input name="_method" type="hidden" value="PUT">
            <input type="hidden" name="user_id" value="<?php echo e(auth()->user()->id); ?>">
            <div class="box-body">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="name" class="content-label"><?php echo e(trans('products.name')); ?></label>
                    <input type="text" name="name" class="form-control" placeholder="<?php echo e(trans('products.name')); ?>" value="<?php echo e($product->name); ?>">
                  </div>
                  <div class="form-group">
                    <label for="name" class="content-label"><?php echo e(trans('products.description')); ?></label>
                    <textarea class="form-control" rows="9" name="description"><?php echo e($product->description); ?></textarea>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="name" class="content-label"><?php echo e(trans('products.image')); ?></label>
                    <input type="file" class="form-control" name="product_image" accept=".jpg, .png, .jpeg, .PNG, .JPEG, .JPG, .gif">
                    <?php if($product->getMedia('products')->last() !== null): ?>
                      <img src="<?php echo e(str_replace('http://localhost',url("/"),$product->getMedia('products')->last()->getUrl('thumb'))); ?>" style="width:100px">
                    <?php else: ?>
                      <?php echo e(trans('products.no_image')); ?>

                    <?php endif; ?>
                  </div>
                  <div class="form-group">
                    <label for="rate" class="content-label"><?php echo e(trans('products.rate')); ?></label>
                    <input type="number" class="form-control" name="rate" placeholder="<?php echo e(trans('products.rate')); ?>" value="<?php echo e($product->rate); ?>">
                  </div>
                  <div class="form-group">
                    <label for="currency" class="content-label"><?php echo e(trans('products.currency')); ?></label>
                    <select class="form-control" name="currency">
                      <option value=""><?php echo e(trans('products.select_currency')); ?></option>
                      <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($currency->currency_code); ?>" <?php if($currency->currency_code == $product->currency): ?> selected <?php endif; ?>>
                          <?php echo e($currency->currency_code); ?> (<?php echo e($currency->currency_symbol); ?>)
                        </option>    
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="name" class="content-label"><?php echo e(trans('products.category')); ?></label>
                    <select class="form-control" name="category_id">
                      <option value=""><?php echo e(trans('products.select_category')); ?></option>
                      <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->id); ?>" <?php if($cat->id == $product->category_id): ?> selected <?php endif; ?>><?php echo e($cat->name); ?></option>    
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </div>
                </div>
              </div>
              
            </div>
            <div class="modal-footer">
              <button id="edit_btn" type="submit" class="btn btn-info btn-fill btn-wd"><?php echo e(trans('common.submit')); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\qsport\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>