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
      <?php echo e(trans('tournament.heading')); ?>

    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo e(route('home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('common.home')); ?></a></li>
      <li><a href="<?php echo e(route('tournaments.index')); ?>"> <?php echo e(trans('tournament.plural')); ?></a></li>
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
            <h3 class="box-title"><?php echo e(trans('tournament.titleh')); ?></h3> 
            <h3 class="box-title pull-right"><a href="<?php echo e(route('tournaments.create')); ?>" class="btn btn-success pull-right"> <?php echo e(trans('tournament.add_new')); ?></a></h3>
          </div>
          <div class="box-body">
            <table id="tournament" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th><?php echo e(trans('common.id')); ?></th>
                  <th><?php echo e(trans('tournament.title')); ?></th>
                  <!-- <th><?php echo e(trans('training_sheets.drill_instructions')); ?></th> -->
                  <th><?php echo e(trans('tournament.venue')); ?></th>
                  <th><?php echo e(trans('tournament.hotel_name')); ?></th>
                  <th><?php echo e(trans('tournament.country')); ?></th>
                  <th><?php echo e(trans('tournament.email')); ?></th>
                  <th><?php echo e(trans('common.phonenumber')); ?></th>
                  <th><?php echo e(trans('common.start_date')); ?></th>
				  <th><?php echo e(trans('common.action')); ?></th>
                </tr>
              </thead>
              <tbody> 

                <?php $__currentLoopData = $tournament; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $to): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				
                  <tr>
                    <td><?php echo e($to->id); ?></td>
                    <td><?php echo e($to->title); ?></td>
                   
                    <td><?php echo e($to->venue); ?></td>
                    <td><?php echo e($to->hotel_name); ?></td>
                    <td><?php echo e($to->countries['country_name']); ?> </td> 
                    <td><?php echo e($to->email); ?> </td> 
                    <td><?php echo e($to->country_code); ?> <?php echo e($to->phone_number); ?> </td> 
                    <td><?php echo e($to->start_date); ?> </td> 
                    
                    <td>
                      <a class="btn" href="<?php echo e(route('tournaments.edit',$to->id)); ?>">
                        <i class="fa fa-edit"></i>
                      </a>
                      <a class="btn" href="<?php echo e(route('tournaments.show',$to->id)); ?>">
                        <i class="fa fa-eye"></i>
                      </a>
                      <form action="<?php echo e(route('tournaments.destroy',$to->id)); ?>" method="post">
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
                 <tr>
                  <th><?php echo e(trans('common.id')); ?></th>
                  <th><?php echo e(trans('training_sheets.title')); ?></th>
                  <!-- <th><?php echo e(trans('training_sheets.drill_instructions')); ?></th> -->
                  <th><?php echo e(trans('training_sheets.type')); ?></th>
                  <th><?php echo e(trans('training_sheets.formula')); ?></th>
                  <th><?php echo e(trans('training_sheets.price')); ?></th>
                  <th><?php echo e(trans('training_sheets.image')); ?></th>
                  <th><?php echo e(trans('training_sheets.video')); ?></th>
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
  $('#tournament').DataTable({
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
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\qsport\resources\views/admin/tournament/index.blade.php ENDPATH**/ ?>