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

          </div>
          <div class="box-body">
            <table id="tournament" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th><?php echo e(trans('common.id')); ?></th>
                  <th><?php echo e(trans('tournament.title')); ?></th>
                  <th><?php echo e(trans('tournament.venue')); ?></th>
                  <th><?php echo e(trans('tournament.hotel_name')); ?></th>
                  <th><?php echo e(trans('tournament.country')); ?></th>
                  <th><?php echo e(trans('tournament.email')); ?></th>
                  <th><?php echo e(trans('tournament.phonenumber')); ?></th>
                  <th><?php echo e(trans('tournament.start_date')); ?></th>
				  <th><?php echo e(trans('tournament.status')); ?></th>
				  <th><?php echo e(trans('common.action')); ?></th>
                </tr>
              </thead>
              <tbody> 

              </tbody>
              <tfoot>
               <tr>
                 <tr>
                   <th><?php echo e(trans('common.id')); ?></th>
                  <th><?php echo e(trans('tournament.title')); ?></th>
                  <!-- <th><?php echo e(trans('training_sheets.drill_instructions')); ?></th> -->
                  <th><?php echo e(trans('tournament.venue')); ?></th>
                  <th><?php echo e(trans('tournament.hotel_name')); ?></th>
                  <th><?php echo e(trans('tournament.country')); ?></th>
                  <th><?php echo e(trans('tournament.email')); ?></th>
                  <th><?php echo e(trans('tournament.phonenumber')); ?></th>
                  <th><?php echo e(trans('tournament.start_date')); ?></th>
				  <th><?php echo e(trans('tournament.status')); ?></th>
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
            url: "<?php echo e(route('tournaments_status')); ?>",
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
	  var statuslist=["Announced","Running","Elapsed","Cancelled"];
   $('#tournament').DataTable({
      processing: true,
      serverSide: true,
      serverMethod:'POST',      
	  language: {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
      ajax: {
          url: "<?php echo e(route('ajax_tournament')); ?>",
          data: {"_token": "<?php echo e(csrf_token()); ?>"},
      },
	  
      columns: [
         { data: 'id' },
         { data: 'title' },
         { data: 'venue' },
         { data: 'hotel_name' },
         { data: 'country_id' },
         { data: 'email' },
         { data: 'phone_number' },
         { data: 'start_date' },
         { data: 'status',
           mRender : function(d,t,r){
				var $select = $("<select></select>", {
					"id": r["id"],
					"value": d,
					"class":"status"
				});
				$.each(statuslist, function(k,v){
					var $option = $("<option></option>", {
						"text": v,
						"value": v
					});
					if(d === v){
						$option.attr("selected", "selected")
					}
					$select.append($option);
				});
				
				return $select.prop("outerHTML")+'<span class="loading" style="visibility: hidden;"><i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span></span>';
			}
          },
          { 
            mRender : function(data, type, row) {
                  return '<form action="'+row["show"]+'" method="get"><button class="btn" type="submit"><i class="fa fa-eye"></i></button></form><form action="'+row["edit"]+'" method="get"><button class="btn" type="submit"><i class="fa fa-edit"></i></button></form><form action="'+row["delete"]+'" method="post"><button class="btn" type="submit" onclick=" return delete_alert()"><i class="fa fa-trash"></i></button><?php echo method_field("delete"); ?><?php echo csrf_field(); ?></form>';
              } 
          },
        ]
   });
  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\qsport\resources\views/admin/tournament/index.blade.php ENDPATH**/ ?>