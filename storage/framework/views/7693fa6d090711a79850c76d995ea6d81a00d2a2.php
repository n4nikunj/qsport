<?php $__env->startSection('content'); ?>
<section class="content-header">
   <h1>
      <?php echo e(trans('poolhall.show')); ?>

   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo e(route('home')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('common.home')); ?></a></li>
      <li><a href="<?php echo e(route('pool_hall.index')); ?>"><?php echo e(trans('poolhall.plural')); ?></a></li>
      <li class="active"><?php echo e(trans('poolhall.show')); ?></li>
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
            <h3 class="box-title"><?php echo e(trans('poolhall.details')); ?></h3>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('poolhall-list')): ?>
            <a href="<?php echo e(route('pool_hall.index')); ?>" class="btn btn-success pull-right">
            <i class="fa fa-arrow-left"></i>
            <?php echo e(trans('common.back')); ?>

            </a>
            <?php endif; ?>
         </div>
         <div class="box-body">
            <div class="row">
               <div class="col-lg-6">
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
							  <label for="title:<?php echo e($lk); ?>" class="content-label"><?php echo e(trans('poolhall.title')); ?></label>
							 <p><?php echo e($poolhall->translate($lk)->title); ?></p>
						  </div>
						  <div class="form-group">
							 <label for="description:<?php echo e($lk); ?>" class="content-label"><?php echo e(trans('poolhall.description')); ?></label>
							 <p><?php echo e($poolhall->translate($lk)->description); ?></p>
						  </div>
						  <div class="form-group">
							 <label for="address:<?php echo e($lk); ?>" class="content-label"><?php echo e(trans('poolhall.address')); ?></label>
							 <p><?php echo e($poolhall->translate($lk)->address); ?></p>
						  </div>
						</div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>  
				  
				  <div class="form-group">
						 <label for="price" class="content-label"><?php echo e(trans('poolhall.price')); ?></label>
						  <p><?php echo e($poolhall->price); ?></p>
				  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="start_time" class="content-label"><?php echo e(trans('poolhall.start_time')); ?></label>
                           <p><?php echo e($poolhall->start_time); ?></p>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="end_time" class="content-label"><?php echo e(trans('poolhall.end_time')); ?></label>
                          <p><?php echo e($poolhall->end_time); ?></p>
                        </div>
                     </div>
                  </div>
                 
               </div>
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="country" class="content-label"><?php echo e(trans('poolhall.country')); ?></label>
                     <p><?php echo e($poolhall->countries['country_name']); ?></p>
                  </div>
				  <div class="row">
						 <div class="col-lg-6">
							<div class="form-group">
							    <label for="email" class="content-label"><?php echo e(trans('poolhall.email')); ?></label>
								<p><?php echo e($poolhall->email); ?></p>
							</div>
						 </div>
						 <div class="col-lg-6">
							<div class="form-group">
                           
							   <label for="phone_number" class="content-label"><?php echo e(trans('poolhall.phonenumber')); ?></label>
							   <div class="row">
								<div class="col-lg-3">
									<p><?php echo e($poolhall->country_code); ?></p>
									
							   </div>
							   <div class="col-lg-9">
									<p><?php echo e($poolhall->phone_number); ?></p>
							   </div></div>
							  
							</div>
						 </div>
					</div>
					<div class="row">
						 <div class="col-lg-6">
							<div class="form-group">
							  <label for="createdBy" class="content-label"><?php echo e(trans('poolhall.createdBy')); ?></label>
							  <p><?php echo e($poolhall['users']->name); ?></p>
							</div>
						 </div>
						 <div class="col-lg-6">
							<div class="form-group">
								<label for="status" class="content-label"><?php echo e(trans('poolhall.status')); ?></label>
								<p><?php echo e($poolhall->status); ?></p>
							</div>
						 </div>
					</div>
					<div class="form-group">
						<label for="social_media_link" class="content-label"><?php echo e(trans('poolhall.social_media_link')); ?></label>
						<p><?php echo e($poolhall->social_media_link); ?></p>
					</div>
					<div class="row">
						 <div class="col-lg-6">
							<div class="form-group">
							  <label for="number_of_tables" class="content-label"><?php echo e(trans('poolhall.number_of_tables')); ?></label>
								<p><?php echo e($poolhall->number_of_tables); ?></p>
							</div>
						 </div>
						 <div class="col-lg-6">
							<div class="form-group">
								<label for="types_of_tables" class="content-label"><?php echo e(trans('poolhall.types_of_tables')); ?></label>
								<p><?php echo e($poolhall->types_of_tables); ?></p>
							</div>
						 </div>
					</div>
					<div class="form-group">
						<label for="name" class="content-label"><?php echo e(trans('poolhall.poolhall_image')); ?></label>
						<p></p>
					</div>
                  
                  </div>
               </div>
            </div>
            </form>
         </div>
      </div>
   </div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script>
   $('#paid_free').change(function(){
     var type = $(this).val();
     if(type == 'free'){
       $('#price_section').hide();
     }else{
       $('#price_section').show();
     }
   });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Nikunj\qsport\resources\views/admin/poolhall/show.blade.php ENDPATH**/ ?>