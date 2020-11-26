@extends('layouts.admin')
@section('content')
  <section class="content-header">
    <h1>
      {{trans('tutor.edit')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('tutors.index')}}">{{trans('tutor.plural')}}</a></li>
      <li class="active">{{trans('tutor.edit')}}</li>
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
            <h3 class="box-title">{{ trans('tutor.details') }}</h3>
            @can('tutor-list')
              <a href="{{route('tutors.index')}}" class="btn btn-success pull-right">
                <i class="fa fa-arrow-left"></i>
                {{ trans('common.back') }}
              </a>
            @endcan
          </div>
          <form method="POST" id="tutor" action="{{route('tutors.update', $tutor->id)}}" accept-charset="UTF-8" enctype="multipart/form-data">
            @csrf
            <input name="_method" type="hidden" value="PUT">
           
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
                          <label for="title:{{$lk}}" class="content-label">{{trans('tutor.title')}}</label>
                          <input class="form-control" minlength="2" maxlength="100" placeholder="{{trans('tutor.title')}}" name="name:{{$lk}}" type="text" value="{{isset($tutor->translate($lk)->name)?$tutor->translate($lk)->name:""}}">
                        </div>
                        <div class="form-group">
                          <label for="description:{{$lk}}" class="content-label">{{trans('tutor.description')}}</label>
                          <textarea class="form-control" minlength="2" maxlength="500"  name="description:{{$lk}}">{{isset($tutor->translate($lk)->description)?$tutor->translate($lk)->description:""}}</textarea>
                        </div>
                      </div>
                    @endforeach
                  </div>
				  <div class="form-group">
                           <label for="status" class="content-label">{{trans('tutor.user')}}</label>
                      <select name="user_id" class="form-control" >
						<option value="">{{trans('tutor.select_user')}}</option>
                        @foreach($users as $user)
                          <option value="{{$user->id}}" @if($tutor->user_id == $user->id) selected @endif >
                            {{$user->name}} 
                          </option>    
                        @endforeach
					  </select>
                        </div>
					 <div class="form-group">
			   <label for="phone_number" class="content-label">{{trans('tutor.phoneno')}}</label>
			   <div class="row">
				<div class="col-lg-3">
				<select name="country_code" class="form-control" >
					<option value="">{{trans('tutor.select_dial_code')}}</option>
					@foreach($countries as $country)
					  <option value="{{$country->dial_code}}" @if($tutor->country_code == $country->dial_code) selected @endif>
						{{$country->dial_code}} 
					  </option>    
					@endforeach
				  </select>
			   </div>
			   <div class="col-lg-9">
			   <input type="text" class="form-control col-lg-6" name="phoneno" placeholder="{{trans('tutor.phoneno')}}" value="{{$tutor->phoneno}}">
			   </div></div>
			  
			</div>		
			 <div class="form-group">
			   <label for="email" class="content-label">{{trans('tutor.email')}}</label>
			  
			   <input type="text" minlength="10" maxlength="500" class="form-control" name="email" placeholder="{{trans('tutor.email')}}" value="{{$tutor->email}}">
			</div>	
				 <div class="form-group">
                    <label for="image" class="content-label">{{trans('tutor.image')}}</label>
					<div class="row">
						<div class="col-lg-3">
						<img src="{{str_replace('http://localhost',url("/"),$tutor->getMedia('tutors')->last()->getUrl('thumb'))}}" width="100px"/>
						</div>
						<div class="col-lg-9">
						<input type="file" class="form-control col-lg-6" name="tutor_image" accept=".jpg, .png, .jpeg, .PNG, .JPEG, .JPG">
						</div>
					</div>
				  </div>
 
                </div>
                <div class="col-lg-6">
                  
                  <div class="form-group">
                    <label for="certificate" class="content-label">{{trans('tutor.certificate')}}</label>
						<div class="row">
						<div class="col-lg-3">
						<img src="{{str_replace('http://localhost',url("/"),$tutor->getMedia('tutorscerty')->last()->getUrl('thumb'))}}" width="100px"/>
						</div>
						<div class="col-lg-9">
							<input type="file" class="form-control" name="tutor_certificate" accept=".jpg, .png, .jpeg, .PNG, .JPEG, .JPG">
						</div>
						</div>
                  </div>
					<div class="form-group">
                     <label for="country" class="content-label">{{trans('tutor.country')}}</label>
					 <select name="country_id" class="form-control" >
						<option value="">{{trans('tutor.select_country')}}</option>
                        @foreach($countries as $country)
                          <option value="{{$country->id}}" @if($tutor->country_id == $country->id) selected @endif>
                            {{$country->country_name}} 
                          </option>    
                        @endforeach
					  </select>
                     <p></p>
                  </div>
				   <div class="form-group">
                    <label for="address" class="content-label">{{trans('tutor.address')}}</label>
                    <textarea class="form-control" rows="2" name="address">{{$tutor->address}}</textarea>
                  </div>
				   <div class="form-group">
					   <label for="address on map" class="content-label">{{trans('tutor.addonmap')}}</label>
					   <div class="row">
						<div class="col-lg-6">
							 <input type="text" class="form-control " name="lat" placeholder="{{trans('tutor.lat')}}" value="{{$tutor->lat}}">
					   </div>
					   <div class="col-lg-6">
					   <input type="text" class="form-control col-lg-6" name="long" placeholder="{{trans('tutor.long')}}" value="{{$tutor->long}}">
					   </div></div>
					</div>
					<div class="form-group">
					   <label for="social" class="content-label">{{trans('tutor.social')}}</label>
					   <div class="row">
							<div class="col-lg-4">
								 <input type="url" class="form-control " name="facebook" placeholder="{{trans('tutor.facebook')}}" value="{{$tutor->facebook}}">
						   </div>
						   <div class="col-lg-4">
								 <input type="url" class="form-control " name="youtube" placeholder="{{trans('tutor.youtube')}}" value="{{$tutor->youtube}}">
						   </div>
						   <div class="col-lg-4">
								 <input type="url" class="form-control " name="twitter" placeholder="{{trans('tutor.twitter')}}" value="{{$tutor->twitter}}">
						   </div>
					   </div>
					</div>

                  <div id="price_section">
                    <div class="form-group">
                      <label for="rate" class="content-label">{{trans('tutor.rate')}}</label>
                      <input type="number" class="form-control" name="rate" placeholder="{{trans('tutor.rate')}}" value="{{$tutor->rate}}">
                    </div>
                    <div class="form-group">
                      <label for="currency" class="content-label">{{trans('tutor.currency')}}</label>
                      <select class="form-control" name="currency">
                        <option value="">{{trans('tutor.select_currency')}}</option>
                        @foreach($countries as $currency)
                          <option value="{{$currency->currency_code}}" @if($tutor->currency == $currency->currency_code) selected @endif>
                            {{$currency->currency_code}} ({{$currency->currency_symbol}})
                          </option>    
                        @endforeach
                      </select>
                    </div>
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
