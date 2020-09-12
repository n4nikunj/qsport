<?php $__env->startSection('content'); ?>
<section class="content-header">
  <h1>
    <?php echo e(trans('permission.add_new')); ?>

    <!-- <small>advanced tables</small> -->
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> ><?php echo e(trans('common.home')); ?></a></li>
    <li><a href="#"><?php echo e(trans('permission.plural')); ?></a></li>
    <li class="active"><?php echo e(ucfirst(basename(Request::url()))); ?></li>
  </ol>
</section>
<section class="content">
    <?php if(count($errors) > 0): ?>
        <div class="alert alert-danger">
            <strong><?php echo e(trans('permission.whoops!')); ?></strong> <?php echo e(trans('permission.some_problems_with_input')); ?><br><br>
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
                    <h3 class="box-title"><?php echo e(trans('permission.details')); ?></h3>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission-list')): ?>
                        <ul class="pull-right">
                            <a href="<?php echo e(route('permissions.index')); ?>" class="btn btn-success">
                                <i class="fa fa-arrow-left"></i>
                                <?php echo e(trans('common.back')); ?>

                            </a>
                        </ul>
                    <?php endif; ?>
                </div>
                <div class="box-body">
                    <?php echo Form::open(array('route' => 'permissions.store','method'=>'POST')); ?>

                        <?php echo csrf_field(); ?>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="usr"><?php echo e(trans('permission.name')); ?></label>
                                        <?php echo Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')); ?>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="usr"><?php echo e(trans('permission.select_role')); ?></label>
                                        <?php echo Form::select('role_id[]', $roles, @$selectedRole, ['class' => 'form-control m-bot15','multiple']); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="btn_add_tml" type="submit" class="btn btn-info btn-fill btn-wd"><?php echo e(trans('common.submit')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Nikunj\qsport\resources\views/admin/permissions/create.blade.php ENDPATH**/ ?>