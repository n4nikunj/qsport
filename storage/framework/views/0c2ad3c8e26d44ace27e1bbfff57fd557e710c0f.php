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
      <?php echo e(trans('sponsors.heading')); ?>

    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo e(route('home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('common.home')); ?></a></li>
      <li><a href="<?php echo e(route('sponsors.index')); ?>"> <?php echo e(trans('sponsors.plural')); ?></a></li>
    </ol>
  </section>
  <section class="content">
    <?php if(count($errors) > 0): ?>
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"><?php echo e(trans('sponsors.title')); ?></h3> 
            <h3 class="box-title pull-right"><a href="<?php echo e(route('sponsors.create')); ?>" class="btn btn-success pull-right"> <?php echo e(trans('sponsors.add_new')); ?></a></h3>
          </div>
          <div class="box-body">
            <table id="sponsors" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th><?php echo e(trans('common.id')); ?></th>
                  <th><?php echo e(trans('sponsors.logo')); ?></th>
                  <th><?php echo e(trans('sponsors.name')); ?></th>
                  <th><?php echo e(trans('sponsors.website')); ?></th>
                  <th><?php echo e(trans('sponsors.sponsor_category')); ?></th>
                  <th><?php echo e(trans('common.status')); ?></th>
                  <th><?php echo e(trans('common.action')); ?></th>
                </tr>
              </thead>
              <tbody> 
              </tbody>
              <tfoot>
                <tr>
                 <th><?php echo e(trans('common.id')); ?></th>
                  <th><?php echo e(trans('sponsors.logo')); ?></th>
                  <th><?php echo e(trans('sponsors.name')); ?></th>
                  <th><?php echo e(trans('sponsors.website')); ?></th>
                  <th><?php echo e(trans('sponsors.sponsor_category')); ?></th>
                  <th><?php echo e(trans('common.status')); ?></th>
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
    $(document).on('change','.status',function(){
        var status = $(this).val();
        var id = $(this).attr('id');
        var delay = 500;
        var element = $(this);
        $.ajax({
            type:'post',
            url: "<?php echo e(route('sponsors_status')); ?>",
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
	
   $('#sponsors').DataTable({
      processing: true,
      serverSide: true,
      serverMethod:'POST',
      processing: true,
      language: {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
      ajax: {
          url: "<?php echo e(route('ajax_sponsor')); ?>",
          data: {"_token": "<?php echo e(csrf_token()); ?>"},
      },
      columns: [
         { data: 'id' },
         { data: 'logo' ,
            mRender : function(data, type, row) {
               return '<a href="'+row['website']+'"><img src="'+data+'" style="width:50px"></a>';
            }
		},
         { data: 'name' },
         { data: 'website' },
         { data: 'sponsors_category' },
         { data: 'status',
            mRender : function(data, type, row) {
				
                  var status=data;
                  if(status=='Active'){   
                    type="selected";
                    data='';
                  }else{
                    data='selected';
                    type='';
                  }
                 return '<select class="status" id="'+row["id"]+'"><option value="active"'+type+'>Active</option><option value="inactive"'+data+'>Inactive</option></select><span class="loading" style="visibility: hidden;"><i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span></span>';
              } 
          },
          { 
            mRender : function(data, type, row) {
                  return '<form action="'+row["show"]+'" method="get"><button class="btn" type="submit"><i class="fa fa-eye"></i></button></form><form action="'+row["delete"]+'" method="post"><button class="btn" type="submit" onclick=" return delete_alert()"><i class="fa fa-trash"></i></button><?php echo method_field("delete"); ?><?php echo csrf_field(); ?></form>';
              } 
          },
        ],
	'columnDefs': [ {
        'targets': [1,6], /* column index */
        'orderable': false, /* true or false */
		}]
   });
  });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\qsport\resources\views/admin/sponsor/index.blade.php ENDPATH**/ ?>