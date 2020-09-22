@extends('layouts.admin')
@section('content')
  <section class="content-header">
    <h1>
      {{trans('sponsors.show')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('sponsors.index')}}">{{trans('sponsors.plural')}}</a></li>
      <li class="active">{{trans('sponsors.show')}}</li>
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
            <h3 class="box-title">{{ trans('sponsors.details') }}</h3>
            @can('level-list')
              <a href="{{route('sponsors.index')}}" class="btn btn-success pull-right">
                <i class="fa fa-arrow-left"></i>
                {{ trans('common.back') }}
              </a>
            @endcan
          </div>
            <div class="box-body">
				<div class="form-group">
					<label for="status" class="content-label">{{trans('sponsors.user')}}</label>
					@foreach($users as $user)
					 
					  @if($sponsors->user_id == $user->id)
						<p>{{$user->name}} </p>
					  @endif
					@endforeach
                </div>
				<div class="form-group">
                    <label for="sponsor_logo_image" class="content-label">{{trans('sponsors.logo')}}</label>
                    <p></p>
                  </div>		
               <div class="form-group">
                    <label for="sponsors_name" class="content-label">{{trans('sponsors.name')}}</label>
                    <p>{{$sponsors->name}}</p>
                </div>
                <div class="form-group">
                    <label for="sponsors_name" class="content-label">{{trans('sponsors.phonenumber')}}</label>
                    <p>{{$sponsors->phoneno}}</p>
                </div>
				<div class="form-group">
                    <label for="website" class="content-label">{{trans('sponsors.website')}}</label>
                    <p>{{$sponsors->website}}</p>
                </div>
				
			 <div class="form-group">
			   <label for="email" class="content-label">{{trans('sponsors.email')}}</label>
			   <p>{{$sponsors->email}}</p>
			</div>	
			<div class="form-group">
			   <label for="sponsors_category" class="content-label">{{trans('sponsors.sponsor_category')}}</label>
			   <p>{{$sponsors->sponsors_category}}</p>
			</div>				
			
            
        </div>
      </div>
    </div>
  </section>
@endsection

@section('js')

@endsection