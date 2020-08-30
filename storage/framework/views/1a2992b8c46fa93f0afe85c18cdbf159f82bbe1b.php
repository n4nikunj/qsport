<?php $__env->startSection('content'); ?>
  <section class="content-header">
    <h1>
      <?php echo e(trans('training_sheets.show')); ?>

    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo e(route('home')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('common.home')); ?></a></li>
      <li><a href="<?php echo e(route('training_sheets.index')); ?>"><?php echo e(trans('training_sheets.plural')); ?></a></li>
      <li class="active"><?php echo e(trans('training_sheets.show')); ?></li>
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
            <h3 class="box-title"><?php echo e(trans('training_sheets.details')); ?></h3>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('training_sheet-list')): ?>
              <a href="<?php echo e(route('training_sheets.index')); ?>" class="btn btn-success pull-right">
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
                          <label for="title:<?php echo e($lk); ?>" class="content-label"><?php echo e(trans('training_sheets.title')); ?></label>
                          <p><?php echo e($training_sheet->translate($lk)->title); ?></p>
                        </div>
                        <div class="form-group">
                          <label for="drill_instructions:<?php echo e($lk); ?>" class="content-label"><?php echo e(trans('training_sheets.drill_instructions')); ?></label>
                          <p><?php echo e($training_sheet->translate($lk)->drill_instructions); ?></p>
                        </div>
                      </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>
                  <div class="form-group">
                    <label for="formula" class="content-label"><?php echo e(trans('training_sheets.formula')); ?></label>
                    <p><?php echo e($training_sheet->formula); ?></p>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="name" class="content-label"><?php echo e(trans('training_sheets.image')); ?></label>
                    <p>
                      <?php if($training_sheet->getMedia('training_sheet_images')->last() !== null): ?>
                      <img src="<?php echo e(str_replace('http://localhost',url("/"),$training_sheet->getMedia('training_sheet_images')->last()->getUrl('thumb'))); ?>" style="width:100px; margin-top:10px">
                      <?php else: ?>
                        <?php echo e(trans('products.no_image')); ?>

                      <?php endif; ?>
                    </p>
                  </div>
                  <div class="form-group">
                    <label for="name" class="content-label"><?php echo e(trans('training_sheets.video')); ?></label>
                    <p>
                      <?php if($training_sheet->getMedia('training_sheet_videos')->last() !== null): ?>
                      <video id="banner" autoplay="true" loop="" controls="true"  width="320" height="240" style="margin-top: 10px">
                        <source src="<?php echo e(str_replace('http://localhost',url("/"),$training_sheet->getMedia('training_sheet_videos')->last()->getUrl())); ?>" type="video/mp4">
                      </video>
                      <?php else: ?>
                        <?php echo e(trans('products.no_video')); ?>

                      <?php endif; ?>
                    </p>
                  </div>

                  <div class="form-group">  
                    <label for="name" class="content-label"><?php echo e(trans('training_sheets.type')); ?></label>
                    <p><?php echo e($training_sheet->type); ?></p>
                  </div>

                  <div id="price_section" <?php if($training_sheet->type == 'free'): ?> style="display:none" <?php endif; ?>>
                    <div class="form-group">
                      <label for="price" class="content-label"><?php echo e(trans('training_sheets.price')); ?></label>
                      <p><?php echo e($training_sheet->price); ?> <?php echo e($training_sheet->currency); ?></p>
                    </div>
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
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\qsport\resources\views/admin/training_sheets/show.blade.php ENDPATH**/ ?>