<header class="main-header">

    <!-- Logo -->
    <a href="<?php echo e(route('home')); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><?php echo config('adminlte.small_logo'); ?></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><?php echo config('adminlte.logo'); ?></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <?php $__currentLoopData = config('app.locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(config('app.locale') == $key): ?>
    <li class="dropdown user user-menu active">
    <?php else: ?>
    <li class="dropdown user user-menu">
    <?php endif; ?>
        <a href="<?php echo e(route('locale',$key)); ?>">
            <!-- <img src="<?php echo e(asset($item['flag'])); ?>"> --> <?php echo e($item["native"]); ?>

        </a>
    </li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo e(asset('admin/dist/img/user2-160x160.jpg')); ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo e(Auth::user()->name); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo e(asset('admin/dist/img/user2-160x160.jpg')); ?>" class="img-circle" alt="User Image">
                <p>
                  <?php echo e(Auth::user()->name); ?>

                  <small>Member since Nov. 2012</small>
                </p>
              </li>
             
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                  
                </div>
                <div class="pull-right">
                    <a href="#" class="btn btn-default btn-flat" href="<?php echo e(route('logout')); ?>"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                             Sign out
                    </a>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                    </form>
                </div>
              </li>
            </ul>
          </li>
          
        </ul>
      </div>

    </nav>
</header><?php /**PATH D:\Nikunj\qsport\resources\views/admin/elements/header.blade.php ENDPATH**/ ?>