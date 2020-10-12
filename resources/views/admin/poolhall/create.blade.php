@extends('layouts.admin')
@section('content')
  <section class="content-header">
    <h1>
      {{trans('poolhall.add_new')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('pool_hall.index')}}">{{trans('poolhall.plural')}}</a></li>
      <li class="active">{{trans('poolhall.add_new')}}</li>
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
            <h3 class="box-title">{{ trans('poolhall.details') }}</h3>
            @can('poolhall-list')
              <a href="{{route('pool_hall.index')}}" class="btn btn-success pull-right">
                <i class="fa fa-arrow-left"></i>
                {{ trans('common.back') }}
              </a>
            @endcan
          </div>
          <form method="POST" id="poolhall" action="{{route('pool_hall.store')}}" accept-charset="UTF-8" enctype="multipart/form-data">
            @csrf
            <div class="box-body">
              <div class="row">
                <div class="col-lg-6">
					<ul class="nav nav-tabs" role="tablist">
                    @foreach(config('app.locales') as $lk=>$lv)
                      <li role="presentation" class="@if($lk=='en') active @endif">
                        <a href="#abc_{{$lk}}" aria-controls="" role="tab" data-toggle="tab" aria-expanded="true">
                          {{$lv['name']}}
                        </a>
                      </li>  
                    @endforeach
                  </ul>
					<div class="tab-content" style="margin-top: 10px;">
						@foreach(config('app.locales') as $lk=>$lv)
						  <div role="tabpanel" class="tab-pane @if($lk=='en') active @endif" id="abc_{{$lk}}">
								<div class="form-group">
									 <label for="title:{{$lk}}" class="content-label">{{trans('poolhall.title')}}</label>
									 <input type="text" class="form-control" name="title:{{$lk}}" placeholder="{{trans('poolhall.title')}}" value="">
								</div>
								<div class="form-group">
									<label for="description:{{$lk}}" class="content-label">{{trans('poolhall.description')}}</label>
									<textarea class="form-control" minlength="2" maxlength="255"  name="description:{{$lk}}"></textarea>
								</div>
								<div class="form-group">
										<label for="address:{{$lk}}" class="content-label">{{trans('poolhall.address')}}</label>
										<textarea class="form-control" minlength="2" maxlength="255"  name="address:{{$lk}}"></textarea>
								</div>
							</div>
						@endforeach
                    </div>  
					<div class="row">
						 <div class="col-lg-6">
							<div class="form-group">
							   <label for="latitude" class="content-label">{{trans('poolhall.latitude')}}</label>
							   <input type="text" class="form-control" name="latitude" placeholder="{{trans('poolhall.latitude')}}" value="">
							</div>
						 </div>
						 <div class="col-lg-6">
							<div class="form-group">
							  <label for="longitude" class="content-label">{{trans('poolhall.longitude')}}</label>
							  <input type="text" name="longitude" class="form-control"  placeholder="{{trans('poolhall.longitude')}}" value="">
							</div>
						 </div>
					</div>
					
				  <div class="form-group">
						 <label for="price" class="content-label">{{trans('poolhall.price')}}</label>
						  <input type="text" class="form-control" name="price" placeholder="{{trans('poolhall.price')}}" value="">
				  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="start_time" class="content-label">{{trans('poolhall.start_time')}}</label>
                           <input type="time" name="start_time" class="form-control" value="">
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="end_time" class="content-label">{{trans('poolhall.end_time')}}</label>
                          <input type="time" name="end_time" class="form-control" value="">
                        </div>
                     </div>
                  </div>
				 
                </div>
                <div class="col-lg-6">
					<div class="form-group">
                     <label for="country" class="content-label">{{trans('poolhall.country')}}</label>
					 <select name="country_id" class="form-control" >
						<option value="">{{trans('poolhall.select_country')}}</option>
                        @foreach($countries as $country)
                          <option value="{{$country->id}}">
                            {{$country->country_name}} 
                          </option>    
                        @endforeach
					  </select>
                     <p></p>
					</div>
					<div class="row">
						 <div class="col-lg-6">
							<div class="form-group">
							   <label for="email" class="content-label">{{trans('poolhall.email')}}</label>
							  
							   <input type="text" class="form-control" name="email" placeholder="{{trans('poolhall.email')}}" value="">
							</div>
						 </div>
						 <div class="col-lg-6">
							<div class="form-group">
							  <label for="createdBy" class="content-label">{{trans('poolhall.createdBy')}}</label>
							  <input type="hidden" name="created_by" value="{{auth()->user()->id}}">
							  <input type="text" class="form-control"  readOnly placeholder="{{trans('poolhall.createdBy')}}" value="{{auth()->user()->name}}">
							</div>
						 </div>
					</div>
					<div class="row">
						 <div class="col-lg-12">
							<div class="form-group">
							   <label for="phone_number" class="content-label">{{trans('poolhall.phonenumber')}}</label>
							   <div class="row">
									<div class="col-lg-4">
										<select name="country_code" class="form-control" >
											<option value="">{{trans('poolhall.select_dial_code')}}</option>
											@foreach($countries as $country)
											  <option value="{{$country->dial_code}}">
												{{$country->dial_code}} 
											  </option>    
											@endforeach
										  </select>
								   </div>
								   <div class="col-lg-8">
										<input type="text" class="form-control col-lg-6" name="phone_number" placeholder="{{trans('poolhall.phonenumber')}}" value="">
								   </div>
							   </div>
							  
							</div>
						 </div>
					</div>
					<div class="form-group">
						<label for="social_media_link" class="content-label">{{trans('poolhall.social_media_link')}}</label>
						<input type="text" class="form-control" name="social_media_link" placeholder="{{trans('poolhall.social_media_link')}}" value="">
					</div>
					<div class="row">
						 <div class="col-lg-6">
							<div class="form-group">
							  <label for="number_of_tables" class="content-label">{{trans('poolhall.number_of_tables')}}</label>
								<input type="number" class="form-control" name="number_of_tables" placeholder="{{trans('poolhall.number_of_tables')}}" value="">
							</div>
						 </div>
						 <div class="col-lg-6">
							<div class="form-group">
								<label for="types_of_tables" class="content-label">{{trans('poolhall.types_of_tables')}}</label>
								<input type="text" class="form-control" name="types_of_tables" placeholder="{{trans('poolhall.types_of_tables')}}" value="">
							</div>
						 </div>
					</div>
					<div class="form-group">
						<label for="name" class="content-label">{{trans('poolhall.poolhall_image')}}</label>
						<input type="file" class="form-control" name="pool_image" accept=".jpg, .png, .jpeg, .PNG, .JPEG, .JPG, .gif">
						{{-- @if($poolhall->getMedia('poolhall_images')->last() !== null)
						<img src="{{str_replace('http://localhost',url("/"),$poolhall->getMedia('poolhall_images')->last()->getUrl('thumb'))}}" style="width:100px; margin-top:10px">
						@else
						  {{trans('products.no_image')}}
						@endif --}}
					</div>
                </div>
              </div>
              
            </div>
            <div class="modal-footer">
              <button id="edit_btn" type="submit" class="btn btn-info btn-fill btn-wd">{{trans('common.submit')}}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
@endsection
