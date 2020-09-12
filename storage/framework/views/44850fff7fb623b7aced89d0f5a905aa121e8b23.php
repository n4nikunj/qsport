<?php $__env->startSection('content'); ?>
<section class="content-header">
   <h1>
      <?php echo e(trans('tutor.show')); ?>

   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo e(route('home')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('common.home')); ?></a></li>
      <li><a href="<?php echo e(route('tutors.index')); ?>"><?php echo e(trans('tutor.plural')); ?></a></li>
      <li class="active"><?php echo e(trans('tutor.show')); ?></li>
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
            <h3 class="box-title"><?php echo e(trans('tutor.details')); ?></h3>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tutor-list')): ?>
            <a href="<?php echo e(route('tutors.index')); ?>" class="btn btn-success pull-right">
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
							  <label for="title:<?php echo e($lk); ?>" class="content-label"><?php echo e(trans('tutor.title')); ?></label>
							 <p><?php echo e($tutor->translate($lk)->name); ?></p>
						  </div>
						  <div class="form-group">
							 <label for="description:<?php echo e($lk); ?>" class="content-label"><?php echo e(trans('tutor.description')); ?></label>
							 <p><?php echo e($tutor->translate($lk)->description); ?></p>
						  </div>
						</div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>  
				 
                  <div class="form-group">
                     <label for="title" class="content-label"><?php echo e(trans('tutor.user')); ?></label>
                     <p><?php echo e($tutor->user['name']); ?></p>
                  </div>
                 
                        <div class="form-group">
                           <label for="country_code" class="content-label"><?php echo e(trans('tutor.phoneno')); ?></label>
                           <p><?php echo e($tutor->country_code); ?> <?php echo e($tutor->phoneno); ?></p>
                        </div>
                    
                        <div class="form-group">
                           <label for="email" class="content-label"><?php echo e(trans('tutor.email')); ?></label>
                           <p><?php echo e($tutor->email); ?></p>
                        </div>
                 
                        <div class="form-group">
                           <label for="image" class="content-label"><?php echo e(trans('tutor.image')); ?></label>
                           <p><img src="<?php echo e(str_replace('http://localhost',url("/"),$tutor->getMedia('tutors')->last()->getUrl('thumb'))); ?>" width="200px"/></p>
                        </div>
               </div>
               <div class="col-lg-6">
				 <div class="form-group">
                           <label for="certificate" class="content-label"><?php echo e(trans('tutor.certificate')); ?></label>
                           <p><img src="<?php echo e(str_replace('http://localhost',url("/"),$tutor->getMedia('tutorscerty')->last()->getUrl('thumb'))); ?>" width="200px"/></p>
                        </div>
                  <div class="form-group">
                     <label for="country" class="content-label"><?php echo e(trans('tutor.country')); ?></label>
                     <p><?php echo e($tutor->countries['country_name']); ?></p>
                  </div>
                  <div class="form-group">
                     <label for="address" class="content-label"><?php echo e(trans('tutor.address')); ?></label>
                     <p><?php echo e($tutor->address); ?></p>
                  </div>
                  <div class="form-group">
                     <label for="addonmap" class="content-label"><?php echo e(trans('tutor.addonmap')); ?></label>
                     <p><?php echo e($tutor->lat); ?></p>
                  </div>
                 
                        <div class="form-group">
                           <label for="social" class="content-label"><?php echo e(trans('tutor.social')); ?></label>
                           <p><?php echo e($tutor->facebook); ?></p>
                           <p><?php echo e($tutor->youtube); ?></p>
                           <p><?php echo e($tutor->twitter); ?></p>
                        </div>
                     
                     
                       
                           <div class="form-group">
                              <label for="rate" class="content-label"><?php echo e(trans('tutor.rate')); ?></label>
                              <p><?php echo e($tutor->currency); ?> <?php echo e($tutor->rate); ?></p>
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
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\qsport\resources\views/admin/tutor/show.blade.php ENDPATH**/ ?>