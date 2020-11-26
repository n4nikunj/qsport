@extends('layouts.admin')
@section('content')
<section class="content-header">
   <h1>
      {{trans('tutor.show')}}
   </h1>
   <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('tutors.index')}}">{{trans('tutor.plural')}}</a></li>
      <li class="active">{{trans('tutor.show')}}</li>
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
							 <p>{{(isset($tutor->translate($lk)->name))?$tutor->translate($lk)->name:""}}</p>
						  </div>
						  <div class="form-group">
							 <label for="description:{{$lk}}" class="content-label">{{trans('tutor.description')}}</label>
							 <p>{{ (isset($tutor->translate($lk)->description))?$tutor->translate($lk)->description:""}}</p>
						  </div>
						</div>
                    @endforeach
                  </div>  
				 
                  <div class="form-group">
                     <label for="title" class="content-label">{{trans('tutor.user')}}</label>
                     <p>{{$tutor->user['name']}}</p>
                  </div>
                 
                        <div class="form-group">
                           <label for="country_code" class="content-label">{{trans('tutor.phoneno')}}</label>
                           <p>{{$tutor->country_code}} {{$tutor->phoneno}}</p>
                        </div>
                    
                        <div class="form-group">
                           <label for="email" class="content-label">{{trans('tutor.email')}}</label>
                           <p>{{$tutor->email}}</p>
                        </div>
                 
                        <div class="form-group">
                           <label for="image" class="content-label">{{trans('tutor.image')}}</label>
                           <p><img src="{{str_replace('http://localhost',url("/"),$tutor->getMedia('tutors')->last()->getUrl('thumb'))}}" width="200px"/></p>
                        </div>
               </div>
               <div class="col-lg-6">
				 <div class="form-group">
                           <label for="certificate" class="content-label">{{trans('tutor.certificate')}}</label>
                           <p><img src="{{str_replace('http://localhost',url("/"),$tutor->getMedia('tutorscerty')->last()->getUrl('thumb'))}}" width="200px"/></p>
                        </div>
                  <div class="form-group">
                     <label for="country" class="content-label">{{trans('tutor.country')}}</label>
                     <p>{{$tutor->countries['country_name']}}</p>
                  </div>
                  <div class="form-group">
                     <label for="address" class="content-label">{{trans('tutor.address')}}</label>
                     <p>{{$tutor->address}}</p>
                  </div>
                  <div class="form-group">
                     <label for="addonmap" class="content-label">{{trans('tutor.addonmap')}}</label>
                     <p>{{$tutor->lat}}</p>
                  </div>
                 
                        <div class="form-group">
                           <label for="social" class="content-label">{{trans('tutor.social')}}</label>
                           <p>{{$tutor->facebook}}</p>
                           <p>{{$tutor->youtube}}</p>
                           <p>{{$tutor->twitter}}</p>
                        </div>
                     
                     
                       
                           <div class="form-group">
                              <label for="rate" class="content-label">{{trans('tutor.rate')}}</label>
                              <p>{{$tutor->currency}} {{$tutor->rate}}</p>
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