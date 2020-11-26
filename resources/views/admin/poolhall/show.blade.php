@extends('layouts.admin')
@section('content')
<section class="content-header">
   <h1>
      {{trans('poolhall.show')}}
   </h1>
   <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('pool_hall.index')}}">{{trans('poolhall.plural')}}</a></li>
      <li class="active">{{trans('poolhall.show')}}</li>
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
							 <p>{{ (isset($poolhall->translate($lk)->title))? $poolhall->translate($lk)->title :"" }}</p>
						  </div>
						  <div class="form-group">
							 <label for="description:{{$lk}}" class="content-label">{{trans('poolhall.description')}}</label>
							 <p>{{(isset($poolhall->translate($lk)->description))?$poolhall->translate($lk)->description:""}}</p>
						  </div>
						  <div class="form-group">
							 <label for="address:{{$lk}}" class="content-label">{{trans('poolhall.address')}}</label>
							 <p>{{(isset($poolhall->translate($lk)->address))?$poolhall->translate($lk)->address:""}}</p>
						  </div>
						</div>
                    @endforeach
                  </div>  
				  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="latitude" class="content-label">{{trans('poolhall.latitude')}}</label>
                           <p>{{$poolhall->latitude}}</p>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="longitude" class="content-label">{{trans('poolhall.longitude')}}</label>
                          <p>{{$poolhall->longitude}}</p>
                        </div>
                     </div>
                  </div>
				  <div class="form-group">
						 <label for="price" class="content-label">{{trans('poolhall.price')}}</label>
						  <p>{{$poolhall->price}}</p>
				  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="start_time" class="content-label">{{trans('poolhall.start_time')}}</label>
                           <p>{{date('g:i a',strtotime($poolhall->start_time))}}</p>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="end_time" class="content-label">{{trans('poolhall.end_time')}}</label>
                          <p>{{date('g:i a',strtotime($poolhall->end_time))}}</p>
                        </div>
                     </div>
                  </div>
                 
               </div>
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="country" class="content-label">{{trans('poolhall.country')}}</label>
                     <p>{{$poolhall->countries['country_name']}}</p>
                  </div>
				  <div class="row">
						 <div class="col-lg-6">
							<div class="form-group">
							    <label for="email" class="content-label">{{trans('poolhall.email')}}</label>
								<p>{{$poolhall->email}}</p>
							</div>
						 </div>
						 <div class="col-lg-6">
							<div class="form-group">
                           
							   <label for="phone_number" class="content-label">{{trans('poolhall.phonenumber')}}</label>
							   <div class="row">
								<div class="col-lg-3">
									<p>{{$poolhall->country_code}}</p>
									
							   </div>
							   <div class="col-lg-9">
									<p>{{$poolhall->phone_number}}</p>
							   </div></div>
							  
							</div>
						 </div>
					</div>
					<div class="row">
						 <div class="col-lg-6">
							<div class="form-group">
							  <label for="createdBy" class="content-label">{{trans('poolhall.createdBy')}}</label>
							  <p>{{$poolhall['users']->name}}</p>
							</div>
						 </div>
						 <div class="col-lg-6">
							<div class="form-group">
								<label for="status" class="content-label">{{trans('poolhall.status')}}</label>
								<p>{{$poolhall->status}}</p>
							</div>
						 </div>
					</div>
					<div class="form-group">
						<label for="social_media_link" class="content-label">{{trans('poolhall.social_media_link')}}</label>
						<p><a href="<?php echo $poolhall->social_media_link; ?>" target="_blank">{{$poolhall->social_media_link}}</a></p>
					</div>
					<div class="row">
						 <div class="col-lg-6">
							<div class="form-group">
							  <label for="number_of_tables" class="content-label">{{trans('poolhall.number_of_tables')}}</label>
								<p>{{$poolhall->number_of_tables}}</p>
							</div>
						 </div>
						 <div class="col-lg-6">
							<div class="form-group">
								<label for="types_of_tables" class="content-label">{{trans('poolhall.types_of_tables')}}</label>
								<p>{{$poolhall->types_of_tables}}</p>
							</div>
						 </div>
					</div>
					<div class="form-group">
						<label for="name" class="content-label">{{trans('poolhall.poolhall_image')}}</label>
						<p></p>
					</div>
                  
                  </div>
               </div>
            </div>
            </form>
         </div>
      </div>
   </div>
</section>
@endsection
@section('js')
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
@endsection