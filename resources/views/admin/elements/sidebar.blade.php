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
          <img src="{{ asset('admin/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div> -->
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">{{trans('admin.main_navigation')}}</li>
        <!-- <li class="active treeview menu-open"> -->
        <li class="@if($routename == 'home') active @endif">
          <a href="{{route('home')}}">
            <i class="fa fa-dashboard"></i> <span>{{trans('admin.dashboard')}}</span>
            <span class="pull-right-container">
              <!-- <i class="fa fa-angle-left pull-right"></i> -->
            </span>
          </a>
        </li>
        @can('customer-list')
        <li class="{{ (request()->is('admin/customers*')) ? 'active' : '' }}">
          <a href="{{route('customers.index')}}">
            <i class="fa fa-user-circle"></i> <span>Customers</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        @endcan
        @can('permission-list')
        <li class="{{ (request()->is('admin/permissions*')) ? 'active' : '' }}">
          <a href="{{ route('permissions.index') }}">
            <i class="fa fa-tags"></i> <span>Manage Permissions</span>
          </a>
        </li>
        @endcan
        @can('role-list')
        <li class="{{ (request()->is('admin/roles*')) ? 'active' : '' }}">
          <a href="{{ route('roles.index') }}">
            <i class="fa fa-briefcase"></i> <span>Manage Roles</span>
          </a>
        </li>
        @endcan        
        @can('product-list')     
        <li class="treeview {{ (request()->is('admin/products*') || request()->is('admin/categories*')) ? 'active menu-open' : '' }}">
          <a href="#">
            <i class="fa fa-cubes"></i> <span>{{trans('admin.products')}}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="{{ (request()->is('admin/products')) ? 'display: block;' : '' }}">
            @can('category-list')
            <li class="{{ (request()->is('admin/categories*')) ? 'active' : '' }}">
              <a href="{{route('categories.index')}}">
                <i class="fa fa-arrow-right"></i>
                {{trans('categories.plural')}}
              </a>
            </li>
            @endcan
            <li class="{{ (request()->is('admin/products*')) ? 'active' : '' }}">
              <a href="{{route('products.index')}}">
                <i class="fa fa-arrow-right"></i>
                {{trans('products.plural')}}
              </a>
            </li>
          </ul>
        </li>
        @endcan
        @can('training_sheet-list')
        <li class="treeview {{ (request()->is('admin/training*')) ? 'active menu-open' : '' }}">
          <a href="#">
            <i class="fa fa-mortar-board"></i> <span>{{trans('admin.training')}}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="{{ (request()->is('admin/training*')) ? 'display: block;' : '' }}">
            <li class="{{ (request()->is('admin/training_sheets*')) ? 'active' : '' }}">
              <a href="{{route('training_sheets.index')}}">
                <i class="fa fa-arrow-right"></i>
                {{trans('admin.training_sheets')}}
              </a>
            </li>
            <li class="{{ (request()->is('admin/training_online*')) ? 'active' : '' }}">
              <a href="{{route('training_online.index')}}">
                <i class="fa fa-arrow-right"></i>
                {{trans('admin.training_online')}}
              </a>
            </li>
          </ul>
        </li>
        @endcan    
       
        @can('game-list')
        <li class="treeview {{ (request()->is('admin/games*')) ? 'active menu-open' : '' }}">
          <a href="#">
            <i class="fa fa-gamepad"></i> <span>{{trans('admin.games')}}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="{{ (request()->is('admin/games')) ? 'display: block;' : '' }}">
            <li class="{{ (request()->is('admin/games')) ? 'active' : '' }}">
              <a href="{{route('games.index')}}">
                  <i class="fa fa-arrow-right"></i>
                  {{trans('admin.list_game')}}
              </a>
            </li>
            @can('game-create')
            <li class="{{ (request()->is('admin/games/create')) ? 'active' : '' }}">
              <a href="{{route('games.create')}}">
                  <i class="fa fa-arrow-right"></i>
                  {{trans('admin.add_game')}}
              </a>
            </li>
            @endcan
          </ul>
        </li>
        @endcan
        <!-- country_list -->
        @can('country-list')
        <li class="{{ (request()->is('admin/country')) ? 'active' : '' }}">
          <a href="{{route('country.index')}}">
            <i class="fa fa fa-map"></i> <span>{{trans('admin.countries')}}</span>
          </a>
        </li>
        @endcan
		<!-- Pool Hall List -->
		@can('pool_hall-list')
        <li class="{{ (request()->is('admin/pool_hall')) ? 'active' : '' }}">
          <a href="{{route('pool_hall.index')}}">
            <i class="fa fa fa-map"></i> <span>{{trans('admin.poolhall')}}</span>
          </a>
        </li>
        @endcan  
        <!-- enquiry -->
        @can('enquiry-list')
        <li class="{{ (request()->is('admin/enquiry')) ? 'active' : '' }}">
          <a href="{{route('enquiry.index')}}">
            <i class="fa fa-envelope"></i> <span>{{trans('admin.enquiry')}}</span>
            <span class="pull-right-container">
              <!-- <i class="fa fa-angle-left pull-right"></i> -->
            </span>
          </a>
        </li>
        @endcan
		 <!-- tutor_list -->
        @can('tutor-list')
        <li class="{{ (request()->is('admin/tutors')) ? 'active' : '' }}">
          <a href="{{route('tutors.index')}}">
            <i class="fa fa fa-map"></i> <span>{{trans('admin.tutor')}}</span>
          </a>
        </li>
        @endcan  
		 <!-- tournament_list -->
        @can('tournament-list')
        <li class="{{ (request()->is('admin/tournaments')) ? 'active' : '' }}">
          <a href="{{route('tournaments.index')}}">
            <i class="fa fa fa-map"></i> <span>{{trans('admin.tournament')}}</span>
          </a>
        </li>
        @endcan  
		 <!-- sponsors_list -->
        @can('sponsors-list')
        <li class="{{ (request()->is('admin/sponsors')) ? 'active' : '' }}">
          <a href="{{route('sponsors.index')}}">
            <i class="fa fa fa-map"></i> <span>{{trans('admin.sponsors')}}</span>
          </a>
        </li>
        @endcan  
        @can('quiz-list')
        <li class="treeview {{ (request()->is('admin/quiz*') || request()->is('admin/levels*')) ? 'active menu-open' : '' }}">
          <a href="#">
            <i class="fa fa-question-circle"></i> <span>{{trans('admin.quiz')}}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="{{ (request()->is('admin/quiz*')) ? 'display: block;' : '' }}">
            @can('level-list')
            <li class="{{ (request()->is('admin/levels*')) ? 'active' : '' }}">
              <a href="{{route('levels.create')}}">
                  <i class="fa fa-arrow-right"></i>
                  {{trans('admin.levels')}}
              </a>
            </li>
            @endcan
            @can('quiz-list')
            <li class="{{ (request()->is('admin/quiz*')) ? 'active' : '' }}">
              <a href="{{route('quiz.index')}}">
                  <i class="fa fa-arrow-right"></i>
                  {{trans('admin.quiz_questions')}}
              </a>
            </li>
            @endcan
          </ul>
        </li>
        @endcan
        @can('cms-list')
        <li class="{{ (request()->is('admin/cms') || request()->is('admin/cms/create') || request()->is('admin/cms/*')) ? 'active' : '' }}">
          <a href="{{route('cms.index')}}">
            <i class="fa fa-file-text"></i> <span>Cms</span>
          </a>
        </li> 
        @endcan
        @can('setting-list')
        <li class="treeview {{ (request()->is('admin/settings*')) ? 'active menu-open' : '' }}">
          <a href="#">
            <i class="fa fa fa-cog"></i> <span>{{trans('admin.settings')}}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="{{ (request()->is('admin/settings')) ? 'display: block;' : '' }}">
            <li class="{{ (request()->is('admin/settings')) ? 'active' : '' }}">
              <a href="{{route('settings.index')}}">
                  <i class="fa fa-arrow-right"></i>
                  {{trans('admin.site_settings')}}
              </a>
            </li>
            @can('general_config-list')
            <li class="{{ (request()->is('admin/settings/general')) ? 'active' : '' }}">
              <a href="{{route('general_config.index')}}">
                  <i class="fa fa-arrow-right"></i>
                  {{trans('admin.general_configuration')}}
              </a>
            </li>       
            @endcan
            @can('gems_config-list')
            <li class="{{ (request()->is('admin/settings/gems')) ? 'active' : '' }}">
              <a href="{{route('gems_config.index')}}">
                  <i class="fa fa-arrow-right"></i>
                  <!-- <i class="fa fa-diamond"></i> -->
                  {{trans('admin.gems_configuration')}}
              </a>
            </li>
            @endcan
          </ul>
        </li>
        @endcan  
      </ul>
    </section>
  </aside>