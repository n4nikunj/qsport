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
      <?php echo e(trans('tutor.heading')); ?>

    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo e(route('home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('common.home')); ?></a></li>
      <li><a href="<?php echo e(route('tutors.index')); ?>"> <?php echo e(trans('tutor.plural')); ?></a></li>
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
            <h3 class="box-title"><?php echo e(trans('tutor.titleh')); ?></h3> 
			 <h3 class="box-title pull-right"><a href="<?php echo e(route('tutors.create')); ?>" class="btn btn-success pull-right"> <?php echo e(trans('tutor.add_new')); ?></a></h3>
          </div>
          <div class="box-body">
            <table id="tutor" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th><?php echo e(trans('common.id')); ?></th>
                  <th><?php echo e(trans('tutor.title')); ?></th>
                  <th><?php echo e(trans('tutor.image')); ?></th>
                  <th><?php echo e(trans('tutor.rate')); ?></th>
                  <th><?php echo e(trans('tutor.phoneno')); ?></th>
                  <th><?php echo e(trans('tutor.certificate')); ?></th>
                  <th><?php echo e(trans('tutor.ProfileStatus')); ?></th>
				  <th><?php echo e(trans('tutor.status')); ?></th>
				  <th><?php echo e(trans('common.action')); ?></th>
                </tr>
              </thead>
              <tbody> 

              </tbody>
              <tfoot>
               <tr>
                 <tr>
                    <th><?php echo e(trans('common.id')); ?></th>
                  <th><?php echo e(trans('tutor.title')); ?></th>
                  <th><?php echo e(trans('tutor.image')); ?></th>
                  <th><?php echo e(trans('tutor.rate')); ?></th>
                  <th><?php echo e(trans('tutor.phoneno')); ?></th>
                  <th><?php echo e(trans('tutor.certificate')); ?></th>
                  <th><?php echo e(trans('tutor.ProfileStatus')); ?></th>
				  <th><?php echo e(trans('tutor.status')); ?></th>
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
            url: "<?php echo e(route('tutor_status')); ?>",
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
	$(document).on('change','.profilestatus',function(){
        var profilestatus = $(this).val();
        var id = $(this).attr('id');
        var delay = 500;
        var element = $(this);
        $.ajax({
            type:'post',
            url: "<?php echo e(route('tutor_profile_status')); ?>",
            data: {
                    "profilestatus": profilestatus, 
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
	  
   $('#tutor').DataTable({
      processing: true,
      serverSide: true,
      serverMethod:'POST',      
	  language: {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
      ajax: {
          url: "<?php echo e(route('ajax_tutor')); ?>",
          data: {"_token": "<?php echo e(csrf_token()); ?>"},
      },
	  
      columns: [
         { data: 'id' },
         { data: 'name' },
         { data: 'image',
            mRender : function(data, type, row) {
               return '<img src="'+data+'" style="width:50px">';
            } 
		 },
         { data: 'rate' },
         { data: 'phoneno' },
         { data: 'certificate' ,
			mRender : function(data, type, row) {
               return '<img src="'+data+'" style="width:50px">';
            } 
		 },
         { data: 'profile_status', 
			 mRender : function(data, type, row) {
				
				 
				  if(data=='Approved'){   
					type="selected";
					data='';
				  }else{
					data='selected';
					type='';
				  }
				 return '<select class="profilestatus" id="'+row["id"]+'"><option value="Approved"'+type+'>Approved</option><option value="Rejected"'+data+'>Rejected</option></select><span class="loading" style="visibility: hidden;"><i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span></span>';
			  } 
		 },
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
                  return '<form action="'+row["show"]+'" method="get"><button class="btn" type="submit"><i class="fa fa-eye"></i></button></form>';
              } 
          },
        ]
   });
  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\qsport\resources\views/admin/tutor/index.blade.php ENDPATH**/ ?>