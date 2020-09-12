<?php $__env->startSection('content'); ?>
  <section class="content-header">
    <h1>
      <?php echo e(trans('tutor.edit')); ?>

    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo e(route('home')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('common.home')); ?></a></li>
      <li><a href="<?php echo e(route('tutors.index')); ?>"><?php echo e(trans('tutor.plural')); ?></a></li>
      <li class="active"><?php echo e(trans('tutor.edit')); ?></li>
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
          <form method="POST" id="tutor" action="<?php echo e(route('tutors.update', $tutor->id)); ?>" accept-charset="UTF-8" enctype="multipart/form-data">
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
                          <label for="title:<?php echo e($lk); ?>" class="content-label"><?php echo e(trans('tutor.title')); ?></label>
                          <input class="form-control" minlength="2" maxlength="100" placeholder="<?php echo e(trans('tutor.title')); ?>" name="name:<?php echo e($lk); ?>" type="text" value="<?php echo e($tutor->translate($lk)->name); ?>">
                        </div>
                        <div class="form-group">
                          <label for="description:<?php echo e($lk); ?>" class="content-label"><?php echo e(trans('tutor.description')); ?></label>
                          <textarea class="form-control" minlength="2" maxlength="500"  name="description:<?php echo e($lk); ?>"><?php echo e($tutor->translate($lk)->description); ?></textarea>
                        </div>
                      </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>
				  <div class="form-group">
                           <label for="status" class="content-label"><?php echo e(trans('tutor.user')); ?></label>
                      <select name="user_id" class="form-control" >
						<option value=""><?php echo e(trans('tutor.select_user')); ?></option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($user->id); ?>" <?php if($tutor->user_id == $user->id): ?> selected <?php endif; ?> >
                            <?php echo e($user->name); ?> 
                          </option>    
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					  </select>
                        </div>
					 <div class="form-group">
			   <label for="phone_number" class="content-label"><?php echo e(trans('tutor.phoneno')); ?></label>
			   <div class="row">
				<div class="col-lg-3">
				<select name="country_code" class="form-control" >
					<option value=""><?php echo e(trans('tutor.select_dial_code')); ?></option>
					<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					  <option value="<?php echo e($country->dial_code); ?>" <?php if($tutor->country_code == $country->dial_code): ?> selected <?php endif; ?>>
						<?php echo e($country->dial_code); ?> 
					  </option>    
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				  </select>
			   </div>
			   <div class="col-lg-9">
			   <input type="text" class="form-control col-lg-6" name="phoneno" placeholder="<?php echo e(trans('tutor.phoneno')); ?>" value="<?php echo e($tutor->phoneno); ?>">
			   </div></div>
			  
			</div>		
			 <div class="form-group">
			   <label for="email" class="content-label"><?php echo e(trans('tutor.email')); ?></label>
			  
			   <input type="text" minlength="10" maxlength="500" class="form-control" name="email" placeholder="<?php echo e(trans('tutor.email')); ?>" value="<?php echo e($tutor->email); ?>">
			</div>	
				 <div class="form-group">
                    <label for="image" class="content-label"><?php echo e(trans('tutor.image')); ?></label>
					<div class="row">
						<div class="col-lg-3">
						<img src="<?php echo e(str_replace('http://localhost',url("/"),$tutor->getMedia('tutors')->last()->getUrl('thumb'))); ?>" width="100px"/>
						</div>
						<div class="col-lg-9">
						<input type="file" class="form-control col-lg-6" name="tutor_image" accept=".jpg, .png, .jpeg, .PNG, .JPEG, .JPG">
						</div>
					</div>
				  </div>
 
                </div>
                <div class="col-lg-6">
                  
                  <div class="form-group">
                    <label for="certificate" class="content-label"><?php echo e(trans('tutor.certificate')); ?></label>
						<div class="row">
						<div class="col-lg-3">
						<img src="<?php echo e(str_replace('http://localhost',url("/"),$tutor->getMedia('tutorscerty')->last()->getUrl('thumb'))); ?>" width="100px"/>
						</div>
						<div class="col-lg-9">
							<input type="file" class="form-control" name="tutor_certificate" accept=".jpg, .png, .jpeg, .PNG, .JPEG, .JPG">
						</div>
						</div>
                  </div>
					<div class="form-group">
                     <label for="country" class="content-label"><?php echo e(trans('tutor.country')); ?></label>
					 <select name="country_id" class="form-control" >
						<option value=""><?php echo e(trans('tutor.select_country')); ?></option>
                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($country->id); ?>" <?php if($tutor->country_id == $country->id): ?> selected <?php endif; ?>>
                            <?php echo e($country->country_name); ?> 
                          </option>    
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					  </select>
                     <p></p>
                  </div>
				   <div class="form-group">
                    <label for="address" class="content-label"><?php echo e(trans('tutor.address')); ?></label>
                    <textarea class="form-control" rows="2" name="address"><?php echo e($tutor->address); ?></textarea>
                  </div>
				   <div class="form-group">
					   <label for="address on map" class="content-label"><?php echo e(trans('tutor.addonmap')); ?></label>
					   <div class="row">
						<div class="col-lg-6">
							 <input type="text" class="form-control " name="lat" placeholder="<?php echo e(trans('tutor.lat')); ?>" value="<?php echo e($tutor->lat); ?>">
					   </div>
					   <div class="col-lg-6">
					   <input type="text" class="form-control col-lg-6" name="long" placeholder="<?php echo e(trans('tutor.long')); ?>" value="<?php echo e($tutor->long); ?>">
					   </div></div>
					</div>
					<div class="form-group">
					   <label for="social" class="content-label"><?php echo e(trans('tutor.social')); ?></label>
					   <div class="row">
							<div class="col-lg-4">
								 <input type="url" class="form-control " name="facebook" placeholder="<?php echo e(trans('tutor.facebook')); ?>" value="<?php echo e($tutor->facebook); ?>">
						   </div>
						   <div class="col-lg-4">
								 <input type="url" class="form-control " name="youtube" placeholder="<?php echo e(trans('tutor.youtube')); ?>" value="<?php echo e($tutor->youtube); ?>">
						   </div>
						   <div class="col-lg-4">
								 <input type="url" class="form-control " name="twitter" placeholder="<?php echo e(trans('tutor.twitter')); ?>" value="<?php echo e($tutor->twitter); ?>">
						   </div>
					   </div>
					</div>

                  <div id="price_section">
                    <div class="form-group">
                      <label for="rate" class="content-label"><?php echo e(trans('tutor.rate')); ?></label>
                      <input type="number" class="form-control" name="rate" placeholder="<?php echo e(trans('tutor.rate')); ?>" value="<?php echo e($tutor->rate); ?>">
                    </div>
                    <div class="form-group">
                      <label for="currency" class="content-label"><?php echo e(trans('tutor.currency')); ?></label>
                      <select class="form-control" name="currency">
                        <option value=""><?php echo e(trans('tutor.select_currency')); ?></option>
                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($currency->currency_code); ?>" <?php if($tutor->currency == $currency->currency_code): ?> selected <?php endif; ?>>
                            <?php echo e($currency->currency_code); ?> (<?php echo e($currency->currency_symbol); ?>)
                          </option>    
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                    </div>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\qsport\resources\views/admin/tutor/edit.blade.php ENDPATH**/ ?>