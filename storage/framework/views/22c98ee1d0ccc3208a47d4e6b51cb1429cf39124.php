<?php $__env->startSection('content'); ?>
  <section class="content-header">
    <h1>
      <?php echo e(trans('categories.add_new')); ?>

    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo e(route('home')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('common.home')); ?></a></li>
      <li><a href="<?php echo e(route('categories.index')); ?>"><?php echo e(trans('categories.plural')); ?></a></li>
      <li class="active"><?php echo e(trans('categories.add_new')); ?></li>
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
            <h3 class="box-title"><?php echo e(trans('categories.details')); ?></h3>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-list')): ?>
              <a href="<?php echo e(route('categories.index')); ?>" class="btn btn-success pull-right">
                <i class="fa fa-arrow-left"></i>
                <?php echo e(trans('common.back')); ?>

              </a>
            <?php endif; ?>
          </div>
          <form method="POST" id="categories" action="<?php echo e(route('categories.store')); ?>" accept-charset="UTF-8">
            <?php echo csrf_field(); ?>
            <div class="box-body">
              <ul class="nav nav-tabs" role="tablist">
                <?php $__currentLoopData = config('app.locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lk=>$lv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li role="presentation" class="<?php if($lk=='en'): ?> active <?php endif; ?>">
                    <a href="#abc_<?php echo e($lk); ?>" aria-controls="" role="tab" data-toggle="tab" aria-expanded="true">
                      <?php echo e($lv['name']); ?>

                    </a>
                  </li>  
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
              <div class="tab-content" style="margin-top: 10px;">
                <?php $__currentLoopData = config('app.locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lk=>$lv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div role="tabpanel" class="tab-pane <?php if($lk=='en'): ?> active <?php endif; ?>" id="abc_<?php echo e($lk); ?>">
                    <div class="form-group">
                      <label for="name:<?php echo e($lk); ?>" class="content-label"><?php echo e(trans('categories.name')); ?></label>
                      <input class="form-control" minlength="2" maxlength="255" placeholder="<?php echo e(trans('categories.name')); ?>" name="name:<?php echo e($lk); ?>" type="text" value="<?php echo e(old('name:'.$lk)); ?>">
                      <strong class="help-block"></strong>
                    </div>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
              <div class="form-group">
                <label for="name" class="content-label"><?php echo e(trans('categories.parent')); ?></label>
                <select class="form-control" name="parent_id">
                  <option value=""><?php echo e(trans('categories.no_parent')); ?></option>
                  <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cat->id); ?>" <?php if(old('parent_id') == $cat->id): ?> selected <?php endif; ?>><?php echo e($cat->name); ?></option>    
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
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
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\qsport\resources\views/admin/categories/create.blade.php ENDPATH**/ ?>