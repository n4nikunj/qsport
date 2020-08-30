@extends('layouts.admin')
@section('content')
<section class="content-header">
   <h1>
      {{trans('tournament.show')}}
   </h1>
   <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('tournaments.index')}}">{{trans('tournament.plural')}}</a></li>
      <li class="active">{{trans('tournament.show')}}</li>
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
            <h3 class="box-title">{{ trans('tournament.details') }}</h3>
            @can('tournament-list')
            <a href="{{route('tournaments.index')}}" class="btn btn-success pull-right">
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
							  <label for="title:{{$lk}}" class="content-label">{{trans('tournament.title')}}</label>
							 <p>{{$tournament->translate($lk)->title}}</p>
						  </div>
						  <div class="form-group">
							 <label for="description:{{$lk}}" class="content-label">{{trans('tournament.description')}}</label>
							 <p>{{$tournament->translate($lk)->description}}</p>
						  </div>
						</div>
                    @endforeach
                  </div>  
				  
                  <div class="form-group">
                     <label for="title" class="content-label">{{trans('tournament.createdBy')}}</label>
                     <p>{{$tournament->createdBy}}</p>
                  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="start_date" class="content-label">{{trans('tournament.start_date')}}</label>
                           <p>{{$tournament->start_date}}</p>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="end_date" class="content-label">{{trans('tournament.end_date')}}</label>
                           <p>{{$tournament->end_date}}</p>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="status" class="content-label">{{trans('tournament.status')}}</label>
                           <p>{{$tournament->status}}</p>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="maximum_Player" class="content-label">{{trans('tournament.maximum_Player')}}</label>
                           <p>{{$tournament->maximum_Player}}</p>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="watch_live" class="content-label">{{trans('tournament.watch_live')}}</label>
                     <p>{{$tournament->watch_live}}</p>
                  </div>
                  
               </div>
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="country" class="content-label">{{trans('tournament.country')}}</label>
                     <p>{{$tournament->countries['country_name']}}</p>
                  </div>
                  <div class="form-group">
                     <label for="venue" class="content-label">{{trans('tournament.venue')}}</label>
                     <p>{{$tournament->venue}}</p>
                  </div>
                  <div class="form-group">
                     <label for="hotel_name" class="content-label">{{trans('tournament.hotel_name')}}</label>
                     <p>{{$tournament->hotel_name}}</p>
                  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="email" class="content-label">{{trans('tournament.email')}}</label>
                           <p>{{$tournament->email}}</p>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="phone_number" class="content-label">{{trans('tournament.phonenumber')}}</label>
                           <p>{{$tournament->country_code}} {{$tournament->phone_number}}</p>
                        </div>
                     </div>
					</div> 
                     <div class="row">
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="entry_fee" class="content-label">{{trans('tournament.entry_fee')}}</label>
                              <p>{{$tournament->entry_fee}}</p>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="priceMoney" class="content-label">{{trans('tournament.priceMoney')}}</label>
                              <p>{{$tournament->priceMoney}}</p>
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="tournament_banner" class="content-label">{{trans('tournament.tournament_banner')}}</label>
                        <p></p>
                     </div>
                     <div class="form-group">
                        <label for="Amount Paid" class="content-label">{{trans('tournament.amount_paid')}}</label>
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