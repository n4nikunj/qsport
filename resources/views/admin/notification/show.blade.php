@extends('layouts.admin')
@section('content')
  <section class="content-header">
    <h1>
      {{trans('notification.show')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('notification.index')}}">{{trans('notification.plural')}}</a></li>
      <li class="active">{{trans('notification.show')}}</li>
    </ol>
  </section>
  <section class="content">
    @if ($errors->any())
    <div class="alert alert-danger">
      <b>{{trans('common.whoops')}}</b>
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <div class="row">
      <div class="col-md-12">
        <div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title">{{ trans('notification.details') }}</h3>
            @can('level-list')
              <a href="{{route('notification.index')}}" class="btn btn-success pull-right">
                <i class="fa fa-arrow-left"></i>
                {{ trans('common.back') }}
              </a>
            @endcan
          </div>
            <div class="box-body">
				
				<div class="form-group">
                    <label for="sponsor_logo_image" class="content-label">{{trans('notification.title')}}</label>
                   <p>{{$notification->title}}</p>
                </div>		
               <div class="form-group">
                    <label for="notification_name" class="content-label">{{trans('notification.message')}}</label>
                    <p>{{$notification->message}}</p>
                </div>
                <div class="form-group">
                    <label for="notification_name" class="content-label">{{trans('notification.User')}}</label>
					@if($notification->userid == "All")
                    <p>Notification for all User</p>
					@else
						<?php 
							 $ids = explode(",",$notification->userid);
						?>
						@foreach($ids as $val)
							@if(isset($userdata[$val]))
							<p>{{$userdata[$val]}}</p>
							@endif
						 @endforeach
					@endif
                </div>
            
        </div>
      </div>
    </div>
  </section>
@endsection

@section('js')

@endsection