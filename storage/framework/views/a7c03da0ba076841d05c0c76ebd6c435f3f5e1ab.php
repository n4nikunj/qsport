<?php $__env->startSection('content'); ?>
  <section class="content-header">
    <h1>
      <?php echo e(trans('tournament.edit')); ?>

    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo e(route('home')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('common.home')); ?></a></li>
      <li><a href="<?php echo e(route('tournaments.index')); ?>"><?php echo e(trans('tournament.plural')); ?></a></li>
      <li class="active"><?php echo e(trans('tournament.edit')); ?></li>
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
          <form method="POST" id="tournament" action="<?php echo e(route('tournaments.update', $tournament->id)); ?>" accept-charset="UTF-8" enctype="multipart/form-data">
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
								 <label for="title:<?php echo e($lk); ?>" class="content-label"><?php echo e(trans('tournament.title')); ?></label>
								 <input type="text" class="form-control" name="title:<?php echo e($lk); ?>" placeholder="<?php echo e(trans('tournament.title')); ?>" value="<?php echo e($tournament->translate($lk)->title); ?>">
							</div>
							 <div class="form-group">
							 <label for="description:<?php echo e($lk); ?>" class="content-label"><?php echo e(trans('tournament.description')); ?></label>
							 <textarea class="form-control" minlength="2" maxlength="255"  name="description:<?php echo e($lk); ?>"><?php echo e($tournament->translate($lk)->description); ?></textarea>
							
						  </div>
						</div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>  
					 <div class="form-group">
                     <label for="createdBy" class="content-label"><?php echo e(trans('tournament.createdBy')); ?></label>
                   <input type="text" class="form-control" name="created_by" placeholder="<?php echo e(trans('tournament.createdBy')); ?>" value="<?php echo e($tournament->created_by); ?>">
                  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="start_date" class="content-label"><?php echo e(trans('tournament.start_date')); ?></label>
                           <input type="date" name="start_date" class="form-control" value="<?php echo e($tournament->start_date); ?>">
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="end_date" class="content-label"><?php echo e(trans('tournament.end_date')); ?></label>
                          <input type="date" name="end_date" class="form-control" value="<?php echo e($tournament->end_date); ?>">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="status" class="content-label"><?php echo e(trans('tournament.status')); ?></label>
                      <select name="status" class="form-control" >
                      <option value="<?php echo e(trans('tournament.announced')); ?>"><?php echo e(trans('tournament.announced')); ?></option>
                      <option value="<?php echo e(trans('tournament.running')); ?>"><?php echo e(trans('tournament.running')); ?></option>
                      <option value="<?php echo e(trans('tournament.elapsed')); ?>"><?php echo e(trans('tournament.elapsed')); ?></option>
                      <option value="<?php echo e(trans('tournament.cancelled')); ?>"><?php echo e(trans('tournament.cancelled')); ?></option>
                     
                    </select>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="maximum_Player" class="content-label"><?php echo e(trans('tournament.maximum_Player')); ?></label>
							<input type="number" class="form-control" name="maximum_Player" placeholder="<?php echo e(trans('tournament.maximum_Player')); ?>" value="<?php echo e($tournament->maximum_Player); ?>">
                        </div>
                     </div>
                  </div>
				  <div class="form-group">
                     <label for="watch_live" class="content-label"><?php echo e(trans('tournament.watch_live')); ?></label>
					 <select name="watch_live" class="form-control" >
					  <option value="Yes">Yes</option>
					  <option value="No">No</option>
					 </select>
                  </div>
                 
                </div>
                <div class="col-lg-6">
					<div class="form-group">
                     <label for="country" class="content-label"><?php echo e(trans('tournament.country')); ?></label>
					 <select name="country_id" class="form-control" >
						<option value=""><?php echo e(trans('tournament.select_country')); ?></option>
                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($country->id); ?>" <?php if($tournament->country_id == $country->id): ?> selected <?php endif; ?>>
                            <?php echo e($country->country_name); ?> 
                          </option>    
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					  </select>
                     <p></p>
                  </div>
                  <div class="form-group">
                     <label for="venue" class="content-label"><?php echo e(trans('tournament.venue')); ?></label>
					  <input type="text" class="form-control" name="venue" placeholder="<?php echo e(trans('tournament.venue')); ?>" value="<?php echo e($tournament->venue); ?>">
                  </div>
                  <div class="form-group">
                     <label for="hotel_name" class="content-label"><?php echo e(trans('tournament.hotel_name')); ?></label>
					  <input type="text" class="form-control" name="hotel_name" placeholder="<?php echo e(trans('tournament.hotel_name')); ?>" value="<?php echo e($tournament->hotel_name); ?>">
                  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="email" class="content-label"><?php echo e(trans('tournament.email')); ?></label>
                          
						   <input type="text" class="form-control" name="email" placeholder="<?php echo e(trans('tournament.email')); ?>" value="<?php echo e($tournament->email); ?>">
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="phone_number" class="content-label"><?php echo e(trans('tournament.phonenumber')); ?></label>
						   <div class="row">
							<div class="col-lg-3">
								<select name="country_code" class="form-control" >
									<option value=""><?php echo e(trans('tournament.select_dial_code')); ?></option>
									<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									  <option value="<?php echo e($country->dial_code); ?>" <?php if($tournament->country_code == $country->dial_code): ?> selected <?php endif; ?>>
										<?php echo e($country->dial_code); ?> 
									  </option>    
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								  </select>
						   </div>
						   <div class="col-lg-9">
						   <input type="text" class="form-control col-lg-6" name="phone_number" placeholder="<?php echo e(trans('tournament.phonenumber')); ?>" value="<?php echo e($tournament->phone_number); ?>">
						   </div></div>
                          
                        </div>
                     </div>
					</div> 
					<div class="form-group">
                      <label for="currency" class="content-label"><?php echo e(trans('tournament.currency')); ?></label>
                      <select class="form-control" name="currency">
                        <option value=""><?php echo e(trans('tournament.select_currency')); ?></option>
                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($currency->currency_code); ?>" <?php if($tournament->currency == $currency->currency_code): ?> selected <?php endif; ?>>
                            <?php echo e($currency->currency_code); ?> (<?php echo e($currency->currency_symbol); ?>)
                          </option>    
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                    </div>
					<div class="row">
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="entry_fee" class="content-label"><?php echo e(trans('tournament.entry_fee')); ?></label>
							   <input type="text" class="form-control col-lg-6" name="entry_fee" placeholder="<?php echo e(trans('tournament.entry_fee')); ?>" value="<?php echo e($tournament->entry_fee); ?>">
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="priceMoney" class="content-label"><?php echo e(trans('tournament.priceMoney')); ?></label>
                              
							   <input type="text" class="form-control col-lg-6" name="priceMoney" placeholder="<?php echo e(trans('tournament.priceMoney')); ?>" value="<?php echo e($tournament->priceMoney); ?>">
                           </div>
                        </div>
                     </div>
					
                  <div class="form-group">
                    <label for="name" class="content-label"><?php echo e(trans('tournament.tournament_banner')); ?></label>
                    <input type="file" class="form-control" name="tournament_image" accept=".jpg, .png, .jpeg, .PNG, .JPEG, .JPG, .gif">
                    
                  </div>
                  <div class="form-group">
                        <label for="Amount Paid" class="content-label"><?php echo e(trans('tournament.amount_paid')); ?></label>
						<input type="text" class="form-control col-lg-6" name="amountPaid" placeholder="<?php echo e(trans('tournament.amount_paid')); ?>" value="<?php echo e($tournament->amountPaid); ?>">
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Nikunj\qsport\resources\views/admin/tournament/edit.blade.php ENDPATH**/ ?>