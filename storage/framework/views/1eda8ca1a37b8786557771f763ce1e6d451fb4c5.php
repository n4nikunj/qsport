<?php $__env->startSection('content'); ?>
  <section class="content-header">
    <h1>
      <?php echo e(trans('poolhall.edit')); ?>

    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo e(route('home')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('common.home')); ?></a></li>
      <li><a href="<?php echo e(route('pool_hall.index')); ?>"><?php echo e(trans('poolhall.plural')); ?></a></li>
      <li class="active"><?php echo e(trans('poolhall.edit')); ?></li>
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
          <form method="POST" id="poolhall" action="<?php echo e(route('pool_hall.update', $poolhall->id)); ?>" accept-charset="UTF-8" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input name="_method" type="hidden" value="PUT">
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
								 <input type="text" class="form-control" name="title:<?php echo e($lk); ?>" placeholder="<?php echo e(trans('poolhall.title')); ?>" value="<?php echo e($poolhall->translate($lk)->title); ?>">
							</div>
							 <div class="form-group">
							 <label for="description:<?php echo e($lk); ?>" class="content-label"><?php echo e(trans('poolhall.description')); ?></label>
							 <textarea class="form-control" minlength="2" maxlength="255"  name="description:<?php echo e($lk); ?>"><?php echo e($poolhall->translate($lk)->description); ?></textarea>
							
						  </div>
						</div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>  
					 <div class="form-group">
                     <label for="createdBy" class="content-label"><?php echo e(trans('poolhall.createdBy')); ?></label>
                   <input type="text" class="form-control" name="created_by" placeholder="<?php echo e(trans('poolhall.createdBy')); ?>" value="">
                  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="start_time" class="content-label"><?php echo e(trans('poolhall.start_time')); ?></label>
                           <input type="time" name="start_time" class="form-control" value="<?php echo e($poolhall->start_time); ?>">
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="end_time" class="content-label"><?php echo e(trans('poolhall.end_time')); ?></label>
                          <input type="time" name="end_time" class="form-control" value="<?php echo e($poolhall->end_time); ?>">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="status" class="content-label"><?php echo e(trans('poolhall.status')); ?></label>
                      <select name="status" class="form-control" >
                      <option value="<?php echo e(trans('poolhall.active')); ?>"><?php echo e(trans('poolhall.active')); ?></option>
                      <option value="<?php echo e(trans('poolhall.active')); ?>"><?php echo e(trans('poolhall.inactive')); ?></option>
                    </select>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="social_media_link" class="content-label"><?php echo e(trans('poolhall.social_media_link')); ?></label>
							<input type="text" class="form-control" name="social_media_link" placeholder="<?php echo e(trans('poolhall.social_media_link')); ?>" value="<?php echo e($poolhall->social_media_link); ?>">
                        </div>
                     </div>
                  </div>
				  <div class="form-group">
                     <label for="number_of_tables" class="content-label"><?php echo e(trans('poolhall.number_of_tables')); ?></label>
					 <input type="number" class="form-control" name="number_of_tables" placeholder="<?php echo e(trans('poolhall.number_of_tables')); ?>" value="<?php echo e($poolhall->number_of_tables); ?>">
					
                  </div>
                 
                </div>
                <div class="col-lg-6">
					<div class="form-group">
                     <label for="country" class="content-label"><?php echo e(trans('poolhall.country')); ?></label>
					 <select name="country_id" class="form-control" >
						<option value=""><?php echo e(trans('poolhall.select_country')); ?></option>
                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($country->id); ?>" <?php if($poolhall->country_id == $country->id): ?> selected <?php endif; ?>>
                            <?php echo e($country->country_name); ?> 
                          </option>    
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					  </select>
                     <p></p>
                  </div>
                  <div class="form-group">
                     <label for="price" class="content-label"><?php echo e(trans('poolhall.price')); ?></label>
					  <input type="text" class="form-control" name="price" placeholder="<?php echo e(trans('poolhall.price')); ?>" value="<?php echo e($poolhall->price); ?>">
					  
                  </div>
                  
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="email" class="content-label"><?php echo e(trans('poolhall.email')); ?></label>
                          
						   <input type="text" class="form-control" name="email" placeholder="<?php echo e(trans('poolhall.email')); ?>" value="<?php echo e($poolhall->email); ?>">
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="phone_number" class="content-label"><?php echo e(trans('poolhall.phonenumber')); ?></label>
						   <div class="row">
							<div class="col-lg-3">
						   </div>
						   <div class="col-lg-9">
						   <input type="text" class="form-control col-lg-6" name="phone_number" placeholder="<?php echo e(trans('poolhall.phonenumber')); ?>" value="<?php echo e($poolhall->phone_number); ?>">
						   </div></div>
                          
                        </div>
                     </div>
					</div> 
                  <div class="form-group">
                    <label for="name" class="content-label"><?php echo e(trans('poolhall.poolhall_image')); ?></label>
                    <input type="file" class="form-control" name="poolhall_image" accept=".jpg, .png, .jpeg, .PNG, .JPEG, .JPG, .gif">
                    
                  </div>
                  
                </div>
              </div>
              
            </div>
            <div class="modal-footer">
              <button id="edit_btn" type="submit" class="btn btn-info btn-fill btn-wd"><?php echo e(trans('common.submit')); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Nikunj\qsport\resources\views/admin/poolhall/edit.blade.php ENDPATH**/ ?>