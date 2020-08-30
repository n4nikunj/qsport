<?php $__env->startSection('content'); ?>
<section class="content-header">
   <h1>
      <?php echo e(trans('tournament.show')); ?>

   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo e(route('home')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('common.home')); ?></a></li>
      <li><a href="<?php echo e(route('tournaments.index')); ?>"><?php echo e(trans('tournament.plural')); ?></a></li>
      <li class="active"><?php echo e(trans('tournament.show')); ?></li>
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
            <h3 class="box-title"><?php echo e(trans('tournament.details')); ?></h3>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tournament-list')): ?>
            <a href="<?php echo e(route('tournaments.index')); ?>" class="btn btn-success pull-right">
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
							  <label for="title:<?php echo e($lk); ?>" class="content-label"><?php echo e(trans('tournament.title')); ?></label>
							 <p><?php echo e($tournament->translate($lk)->title); ?></p>
						  </div>
						  <div class="form-group">
							 <label for="description:<?php echo e($lk); ?>" class="content-label"><?php echo e(trans('tournament.description')); ?></label>
							 <p><?php echo e($tournament->translate($lk)->description); ?></p>
						  </div>
						</div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>  
				  
                  <div class="form-group">
                     <label for="title" class="content-label"><?php echo e(trans('tournament.createdBy')); ?></label>
                     <p><?php echo e($tournament->createdBy); ?></p>
                  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="start_date" class="content-label"><?php echo e(trans('tournament.start_date')); ?></label>
                           <p><?php echo e($tournament->start_date); ?></p>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="end_date" class="content-label"><?php echo e(trans('tournament.end_date')); ?></label>
                           <p><?php echo e($tournament->end_date); ?></p>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="status" class="content-label"><?php echo e(trans('tournament.status')); ?></label>
                           <p><?php echo e($tournament->status); ?></p>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="maximum_Player" class="content-label"><?php echo e(trans('tournament.maximum_Player')); ?></label>
                           <p><?php echo e($tournament->maximum_Player); ?></p>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="watch_live" class="content-label"><?php echo e(trans('tournament.watch_live')); ?></label>
                     <p><?php echo e($tournament->watch_live); ?></p>
                  </div>
                  
               </div>
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="country" class="content-label"><?php echo e(trans('tournament.country')); ?></label>
                     <p><?php echo e($tournament->countries['country_name']); ?></p>
                  </div>
                  <div class="form-group">
                     <label for="venue" class="content-label"><?php echo e(trans('tournament.venue')); ?></label>
                     <p><?php echo e($tournament->venue); ?></p>
                  </div>
                  <div class="form-group">
                     <label for="hotel_name" class="content-label"><?php echo e(trans('tournament.hotel_name')); ?></label>
                     <p><?php echo e($tournament->hotel_name); ?></p>
                  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="email" class="content-label"><?php echo e(trans('tournament.email')); ?></label>
                           <p><?php echo e($tournament->email); ?></p>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="phone_number" class="content-label"><?php echo e(trans('tournament.phonenumber')); ?></label>
                           <p><?php echo e($tournament->country_code); ?> <?php echo e($tournament->phone_number); ?></p>
                        </div>
                     </div>
					</div> 
                     <div class="row">
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="entry_fee" class="content-label"><?php echo e(trans('tournament.entry_fee')); ?></label>
                              <p><?php echo e($tournament->entry_fee); ?></p>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="priceMoney" class="content-label"><?php echo e(trans('tournament.priceMoney')); ?></label>
                              <p><?php echo e($tournament->priceMoney); ?></p>
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="tournament_banner" class="content-label"><?php echo e(trans('tournament.tournament_banner')); ?></label>
                        <p></p>
                     </div>
                     <div class="form-group">
                        <label for="Amount Paid" class="content-label"><?php echo e(trans('tournament.amount_paid')); ?></label>
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
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\qsport\resources\views/admin/tournament/show.blade.php ENDPATH**/ ?>