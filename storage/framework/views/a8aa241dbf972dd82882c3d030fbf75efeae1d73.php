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
   <?php echo e(trans('country.heading')); ?> 
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo e(route('home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('common.home')); ?></a></li>
    <li><a href="<?php echo e(route('country.index')); ?>"><?php echo e(trans('country.title')); ?></a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?php echo e(trans('country.title')); ?></h3>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('country-create')): ?>
          <h3 class="box-title pull-right"><a href="<?php echo e(route('country.create')); ?>" class="btn btn-success pull-right"><?php echo e(trans('country.add_new')); ?></a></h3>
          <?php endif; ?>
        </div>
        <div class="box-body">
          <table id="country" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th><?php echo e(trans('common.id')); ?></th>
                <th><?php echo e(trans('country.country_name')); ?></th>
                <th><?php echo e(trans('country.dial_code')); ?></th>
                <th><?php echo e(trans('country.currency')); ?></th>
                <th><?php echo e(trans('country.currency_symbol')); ?></th>
                <th><?php echo e(trans('country.country_status')); ?></th>
                <th><?php echo e(trans('common.action')); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php $__currentLoopData = $countrys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td><?php echo e($country->id); ?></td>
                  <td><?php echo e($country->country_name); ?></td>
                  <td><?php echo e($country->dial_code); ?></td>
                  <td><?php echo e($country->currency); ?></td>
                  <td><?php echo e($country->currency_symbol); ?></td>
                  <td></td>
                  <td></td>
                </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
            </tbody>
            <tfoot>
              <tr>
                <th><?php echo e(trans('common.id')); ?></th>
                <th><?php echo e(trans('country.country_name')); ?></th>
                <th><?php echo e(trans('country.dial_code')); ?></th>
                <th><?php echo e(trans('country.currency')); ?></th>
                <th><?php echo e(trans('country.currency_symbol')); ?></th>
                <th><?php echo e(trans('country.country_status')); ?></th>
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
    $(document).on('change','.country_status',function(){
        var status = $(this).val();
        var id = $(this).attr('id');
        var delay = 500;
        var element = $(this);
        $.ajax({
            type:'post',
            url: "<?php echo e(route('country_status')); ?>",
            data: {
                    "status": status, 
                    "id" : id,  
                    "_token": "<?php echo e(csrf_token()); ?>"
                  },
            beforeSend: function () {
                element.next('.loading').css('visibility', 'visible');
            },
            success: function (data) {
              setTimeout(function() {
                    element.next('.loading').css('visibility', 'hidden');
                }, delay);
              toastr.success(data.success);
            },
            error: function () {
              toastr.error(data.error);
            }
        })
    })
  </script>
<script type="text/javascript">
 $(document).ready(function(){
   $('#country').DataTable({
      processing: true,
      serverSide: true,
      serverMethod:'POST',
      processing: true,
      language: {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
      ajax: {
          url: "<?php echo e(route('dt_country')); ?>",
          data: {"_token": "<?php echo e(csrf_token()); ?>"},
      },
      columns: [
         { data: 'id' },
         { data: 'country_name' },
         { data: 'dial_code' },
         { data: 'currency' },
         { data: 'currency_symbol' },
         { data: 'status',
            mRender : function(data, type, row) {
                  var status=data;
                  if(status=='active'){
                    type="selected";
                    data='';
                  }else{
                    data='selected';
                    type='';
                  }
                 return '<select class="country_status" id="'+row["id"]+'"><option value="active"'+type+'>Active</option><option value="inactive"'+data+'>Inactive</option></select><span class="loading" style="visibility: hidden;"><i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span></span>';
              } 
          },
          { 
            mRender : function(data, type, row) {
                  return '<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("country-edit")): ?><form action="'+row["edit"]+'" method="get"><button class="btn" type="submit"><i class="fa fa-edit"></i></button></form><?php endif; ?><form action="'+row["show"]+'" method="get"><button class="btn" type="submit"><i class="fa fa-eye"></i></button></form><?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("country-delete")): ?><form action="'+row["delete"]+'" method="post"><button class="btn" type="submit" onclick=" return delete_alert()"><i class="fa fa-trash"></i></button><?php echo method_field("delete"); ?><?php echo csrf_field(); ?></form><?php endif; ?>';
              } 
          },
        ]
   });
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\qsport\resources\views/admin/country/index.blade.php ENDPATH**/ ?>