<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')); ?>">

<style type="text/css">
  td form{
    display: inline; 
  }
</style>
<?php $__env->stopSection(); ?>  
<?php $__env->startSection('content'); ?>
  <section class="content-header">
    <h1>
      <?php echo e(trans('categories.heading')); ?>

    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo e(route('home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('common.home')); ?></a></li>
      <li><a href="<?php echo e(route('categories.index')); ?>"> <?php echo e(trans('categories.plural')); ?></a></li>
    </ol>
  </section>

  <section class="content">
    <?php if($message = Session::get('success')): ?>
      <div class="alert alert-success">
          <p><?php echo e($message); ?></p>
      </div>
    <?php endif; ?>
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"><?php echo e(trans('categories.title')); ?></h3> 
            <h3 class="box-title pull-right"><a href="<?php echo e(route('categories.create')); ?>" class="btn btn-success pull-right"> <?php echo e(trans('categories.add_new')); ?></a></h3>
          </div>
          <div class="box-body">
            <table id="categories" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th><?php echo e(trans('common.id')); ?></th>
                  <th><?php echo e(trans('categories.name')); ?></th>
                  <th><?php echo e(trans('common.action')); ?></th>
                </tr>
              </thead>
              <tbody> 

                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                    <td><?php echo e($cat->id); ?></td>
                    <td><?php echo e($cat->name); ?></td>
                    <td>
                      <a class="btn" href="<?php echo e(route('categories.edit',$cat->id)); ?>">
                        <i class="fa fa-edit"></i>
                      </a>
                      <a class="btn" href="<?php echo e(route('categories.show',$cat->id)); ?>">
                        <i class="fa fa-eye"></i>
                      </a>
                      <form action="<?php echo e(route('categories.destroy',$cat->id)); ?>" method="post">
                        <button class="btn" type="submit" onclick=" return delete_alert()">
                          <i class="fa fa-trash"></i>
                        </button>
                        <?php echo method_field("delete"); ?>
                        <?php echo csrf_field(); ?>
                      </form>
                    </td> 
                  </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
              </tbody>
              <tfoot>
                <tr>
                  <th><?php echo e(trans('common.id')); ?></th>
                  <th><?php echo e(trans('categories.name')); ?></th>
                  <th><?php echo e(trans('common.action')); ?></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script type="text/javascript">
  $('#categories').DataTable({
                'paging'      : true,
                'lengthChange': true,
                'searching'   : true,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : true
              })
  function delete_alert() {
      if(confirm("Are you sure want to delete this item?")){
        return true;
      }else{
        return false;
      }
  }
  $('.alert-success').delay(5000).fadeOut();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\qsport\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>