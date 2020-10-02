<?php
$routename = Route::currentRouteName();
?>
<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
     <!--  <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo e(asset('admin/dist/img/user2-160x160.jpg')); ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo e(Auth::user()->name); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div> -->
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header"><?php echo e(trans('admin.main_navigation')); ?></li>
        <!-- <li class="active treeview menu-open"> -->
        <li class="<?php if($routename == 'home'): ?> active <?php endif; ?>">
          <a href="<?php echo e(route('home')); ?>">
            <i class="fa fa-dashboard"></i> <span><?php echo e(trans('admin.dashboard')); ?></span>
            <span class="pull-right-container">
              <!-- <i class="fa fa-angle-left pull-right"></i> -->
            </span>
          </a>
        </li>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer-list')): ?>
        <li class="<?php echo e((request()->is('admin/customers*')) ? 'active' : ''); ?>">
          <a href="<?php echo e(route('customers.index')); ?>">
            <i class="fa fa-user-circle"></i> <span>Customers</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission-list')): ?>
        <li class="<?php echo e((request()->is('admin/permissions*')) ? 'active' : ''); ?>">
          <a href="<?php echo e(route('permissions.index')); ?>">
            <i class="fa fa-tags"></i> <span>Manage Permissions</span>
          </a>
        </li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-list')): ?>
        <li class="<?php echo e((request()->is('admin/roles*')) ? 'active' : ''); ?>">
          <a href="<?php echo e(route('roles.index')); ?>">
            <i class="fa fa-briefcase"></i> <span>Manage Roles</span>
          </a>
        </li>
        <?php endif; ?>        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-list')): ?>     
        <li class="treeview <?php echo e((request()->is('admin/products*') || request()->is('admin/categories*')) ? 'active menu-open' : ''); ?>">
          <a href="#">
            <i class="fa fa-cubes"></i> <span><?php echo e(trans('admin.products')); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="<?php echo e((request()->is('admin/products')) ? 'display: block;' : ''); ?>">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-list')): ?>
            <li class="<?php echo e((request()->is('admin/categories*')) ? 'active' : ''); ?>">
              <a href="<?php echo e(route('categories.index')); ?>">
                <i class="fa fa-arrow-right"></i>
                <?php echo e(trans('categories.plural')); ?>

              </a>
            </li>
            <?php endif; ?>
            <li class="<?php echo e((request()->is('admin/products*')) ? 'active' : ''); ?>">
              <a href="<?php echo e(route('products.index')); ?>">
                <i class="fa fa-arrow-right"></i>
                <?php echo e(trans('products.plural')); ?>

              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('training_sheet-list')): ?>
        <li class="treeview <?php echo e((request()->is('admin/training*')) ? 'active menu-open' : ''); ?>">
          <a href="#">
            <i class="fa fa-mortar-board"></i> <span><?php echo e(trans('admin.training')); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="<?php echo e((request()->is('admin/training*')) ? 'display: block;' : ''); ?>">
            <li class="<?php echo e((request()->is('admin/training_sheets*')) ? 'active' : ''); ?>">
              <a href="<?php echo e(route('training_sheets.index')); ?>">
                <i class="fa fa-arrow-right"></i>
                <?php echo e(trans('admin.training_sheets')); ?>

              </a>
            </li>
            <li class="<?php echo e((request()->is('admin/training_online*')) ? 'active' : ''); ?>">
              <a href="<?php echo e(route('training_online.index')); ?>">
                <i class="fa fa-arrow-right"></i>
                <?php echo e(trans('admin.training_online')); ?>

              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>    
       
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('game-list')): ?>
        <li class="treeview <?php echo e((request()->is('admin/games*')) ? 'active menu-open' : ''); ?>">
          <a href="#">
            <i class="fa fa-gamepad"></i> <span><?php echo e(trans('admin.games')); ?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="<?php echo e((request()->is('admin/games')) ? 'display: block;' : ''); ?>">
            <li class="<?php echo e((request()->is('admin/games')) ? 'active' : ''); ?>">
              <a href="<?php echo e(route('games.index')); ?>">
                  <i class="fa fa-arrow-right"></i>
                  <?php echo e(trans('admin.list_game')); ?>

              </a>
            </li>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('game-create')): ?>
            <li class="<?php echo e((request()->is('admin/games/create')) ? 'active' : ''); ?>">
              <a href="<?php echo e(route('games.create')); ?>">
                  <i class="fa fa-arrow-right"></i>
                  <?php echo e(trans('admin.add_game')); ?>

              </a>
            </li>
            <?php endif; ?>
          </ul>
        </li>
        <?php endif; ?>
        <!-- country_list -->
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('country-list')): ?>
        <li class="<?php echo e((request()->is('admin/country')) ? 'active' : ''); ?>">
          <a href="<?php echo e(route('country.index')); ?>">
            <i class="fa fa fa-map"></i> <span><?php echo e(trans('admin.countries')); ?></span>
          </a>
        </li>
        <?php endif; ?>
		<!-- Pool Hall List -->
		<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pool_hall-list')): ?>
        <li class="<?php echo e((request()->is('admin/pool_hall')) ? 'active' : ''); ?>">
          <a href="<?php echo e(route('pool_hall.index')); ?>">
            <i class="fa fa fa-map"></i> <span><?php echo e(trans('admin.poolhall')); ?></span>
          </a>
        </li>
        <?php endif; ?>
		<!-- Watch Live List -->
		<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('watch_live-list')): ?>
        <li class="<?php echo e((request()->is('admin/watch_live')) ? 'active' : ''); ?>">
          <a href="<?php echo e(route('watch_live.index')); ?>">
            <i class="fa fa fa-map"></i> <span><?php echo e(trans('admin.watchlive')); ?></span>
          </a>
        </li>
        <?php endif; ?>  
        <!-- enquiry -->
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('enquiry-list')): ?>
        <li class="<?php echo e((request()->is('admin/enquiry')) ? 'active' : ''); ?>">
          <a href="<?php echo e(route('enquiry.index')); ?>">
            <i class="fa fa-envelope"></i> <span><?php echo e(trans('admin.enquiry')); ?></span>
            <span class="pull-right-container">
              <!-- <i class="fa fa-angle-left pull-right"></i> -->
            </span>
          </a>
        </li>
        <?php endif; ?>
		 <!-- tutor_list -->
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tutor-list')): ?>
        <li class="<?php echo e((request()->is('admin/tutors')) ? 'active' : ''); ?>">
          <a href="<?php echo e(route('tutors.index')); ?>">
            <i class="fa fa fa-map"></i> <span><?php echo e(trans('admin.tutor')); ?></span>
          </a>
        </li>
        <?php endif; ?>  
		 <!-- tournament_list -->
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tournament-list')): ?>
        <li class="<?php echo e((request()->is('admin/tournaments')) ? 'active' : ''); ?>">
          <a href="<?php echo e(route('tournaments.index')); ?>">
            <i class="fa fa fa-map"></i> <span><?php echo e(trans('admin.tournament')); ?></span>
          </a>
        </li>
        <?php endif; ?>  
		 <!-- sponsors_list -->
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sponsors-list')): ?>
        <li class="<?php echo e((request()->is('admin/sponsors')) ? 'active' : ''); ?>">
          <a href="<?php echo e(route('sponsors.index')); ?>">
            <i class="fa fa fa-map"></i> <span><?php echo e(trans('admin.sponsors')); ?></span>
          </a>
        </li>
        <?php endif; ?>
		
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('quiz-list')): ?>
        <li class="treeview <?php echo e((request()->is('admin/quiz*') || request()->is('admin/levels*')) ? 'active menu-open' : ''); ?>">
          <a href="#">
            <i class="fa fa-question-circle"></i> <span><?php echo e(trans('admin.quiz')); ?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="<?php echo e((request()->is('admin/quiz*')) ? 'display: block;' : ''); ?>">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('level-list')): ?>
            <li class="<?php echo e((request()->is('admin/levels*')) ? 'active' : ''); ?>">
              <a href="<?php echo e(route('levels.create')); ?>">
                  <i class="fa fa-arrow-right"></i>
                  <?php echo e(trans('admin.levels')); ?>

              </a>
            </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('quiz-list')): ?>
            <li class="<?php echo e((request()->is('admin/quiz*')) ? 'active' : ''); ?>">
              <a href="<?php echo e(route('quiz.index')); ?>">
                  <i class="fa fa-arrow-right"></i>
                  <?php echo e(trans('admin.quiz_questions')); ?>

              </a>
            </li>
            <?php endif; ?>
          </ul>
        </li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cms-list')): ?>
        <li class="<?php echo e((request()->is('admin/cms') || request()->is('admin/cms/create') || request()->is('admin/cms/*')) ? 'active' : ''); ?>">
          <a href="<?php echo e(route('cms.index')); ?>">
            <i class="fa fa-file-text"></i> <span>Cms</span>
          </a>
        </li> 
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting-list')): ?>
        <li class="treeview <?php echo e((request()->is('admin/settings*')) ? 'active menu-open' : ''); ?>">
          <a href="#">
            <i class="fa fa fa-cog"></i> <span><?php echo e(trans('admin.settings')); ?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="<?php echo e((request()->is('admin/settings')) ? 'display: block;' : ''); ?>">
            <li class="<?php echo e((request()->is('admin/settings')) ? 'active' : ''); ?>">
              <a href="<?php echo e(route('settings.index')); ?>">
                  <i class="fa fa-arrow-right"></i>
                  <?php echo e(trans('admin.site_settings')); ?>

              </a>
            </li>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('general_config-list')): ?>
            <li class="<?php echo e((request()->is('admin/settings/general')) ? 'active' : ''); ?>">
              <a href="<?php echo e(route('general_config.index')); ?>">
                  <i class="fa fa-arrow-right"></i>
                  <?php echo e(trans('admin.general_configuration')); ?>

              </a>
            </li>       
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gems_config-list')): ?>
            <li class="<?php echo e((request()->is('admin/settings/gems')) ? 'active' : ''); ?>">
              <a href="<?php echo e(route('gems_config.index')); ?>">
                  <i class="fa fa-arrow-right"></i>
                  <!-- <i class="fa fa-diamond"></i> -->
                  <?php echo e(trans('admin.gems_configuration')); ?>

              </a>
            </li>
            <?php endif; ?>
          </ul>
        </li>
        <?php endif; ?>  
      </ul>
    </section>
  </aside><?php /**PATH C:\xampp\htdocs\qsport\resources\views/admin/elements/sidebar.blade.php ENDPATH**/ ?>