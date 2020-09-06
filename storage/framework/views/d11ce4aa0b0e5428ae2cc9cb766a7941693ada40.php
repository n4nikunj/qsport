<?php $__env->startSection('content'); ?>
  <section class="content-header">
    <h1>
      <?php echo e(trans('sponsors.add_new')); ?>

    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo e(route('home')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('common.home')); ?></a></li>
      <li><a href="<?php echo e(route('sponsors.index')); ?>"><?php echo e(trans('sponsors.plural')); ?></a></li>
      <li class="active"><?php echo e(trans('sponsors.add_new')); ?></li>
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
            <h3 class="box-title"><?php echo e(trans('sponsors.details')); ?></h3>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('level-list')): ?>
              <a href="<?php echo e(route('sponsors.index')); ?>" class="btn btn-success pull-right">
                <i class="fa fa-arrow-left"></i>
                <?php echo e(trans('common.back')); ?>

              </a>
            <?php endif; ?>
          </div>
          <form method="POST" id="sponsors" action="<?php echo e(route('sponsors.store')); ?>" accept-charset="UTF-8" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="box-body">
				<div class="form-group">
                           <label for="status" class="content-label"><?php echo e(trans('sponsors.user')); ?></label>
                      <select name="user_id" class="form-control" >
						<option value=""><?php echo e(trans('sponsors.select_user')); ?></option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($user->id); ?>" >
                            <?php echo e($user->name); ?> 
                          </option>    
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					  </select>
                        </div>
				<div class="form-group">
                    <label for="sponsor_logo_image" class="content-label"><?php echo e(trans('sponsors.logo')); ?></label>
                    <input type="file" class="form-control" name="sponsor_logo" accept=".jpg, .png, .jpeg, .PNG, .JPEG, .JPG">
                  </div>		
               <div class="form-group">
                      <label for="sponsors_name" class="content-label"><?php echo e(trans('sponsors.name')); ?></label>
                      <input class="form-control"  placeholder="<?php echo e(trans('sponsors.name')); ?>" name="name" type="text" value="<?php echo e(old('name')); ?>">
                      <strong class="help-block"></strong>
                    </div>
                
              <div class="form-group">
                      <label for="website" class="content-label"><?php echo e(trans('sponsors.website')); ?></label>
                      <input class="form-control"  placeholder="<?php echo e(trans('sponsors.website')); ?>" name="website" type="text" value="<?php echo e(old('website')); ?>">
                      <strong class="help-block"></strong>
                    </div>
				 <div class="form-group">
			   <label for="phone_number" class="content-label"><?php echo e(trans('sponsors.phonenumber')); ?></label>
			   <div class="row">
				<div class="col-lg-3">
					<select name="country_code" class="form-control" >
						<option value=""><?php echo e(trans('sponsors.select_dial_code')); ?></option>
						<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						  <option value="<?php echo e($country->dial_code); ?>" >
							<?php echo e($country->dial_code); ?> 
						  </option>    
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					  </select>
			   </div>
			   <div class="col-lg-9">
			   <input type="text" class="form-control col-lg-6" name="phoneno" placeholder="<?php echo e(trans('sponsors.phonenumber')); ?>" value="<?php echo e(old('phoneno')); ?>">
			   </div></div>
			  
			</div>		
			 <div class="form-group">
			   <label for="email" class="content-label"><?php echo e(trans('sponsors.email')); ?></label>
			  
			   <input type="text" class="form-control" name="email" placeholder="<?php echo e(trans('sponsors.email')); ?>" value="<?php echo e(old('email')); ?>">
			</div>	
			<div class="form-group">
			   <label for="sponsors_category" class="content-label"><?php echo e(trans('sponsors.sponsor_category')); ?></label>
				<select name="sponsors_category" class="form-control">
				<option value="<?php echo e(trans('sponsors.standard')); ?>"><?php echo e(trans('sponsors.standard')); ?></option>
				<option value="<?php echo e(trans('sponsors.premium')); ?>"><?php echo e(trans('sponsors.premium')); ?></option>
				</select>
			  
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

<?php $__env->startSection('js'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\qsport\resources\views/admin/sponsor/create.blade.php ENDPATH**/ ?>