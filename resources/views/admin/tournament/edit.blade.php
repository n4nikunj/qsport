@extends('layouts.admin')
@section('content')
  <section class="content-header">
    <h1>
      {{trans('tournament.edit')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('tournaments.index')}}">{{trans('tournament.plural')}}</a></li>
      <li class="active">{{trans('tournament.edit')}}</li>
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
          <form method="POST" id="tournament" action="{{route('tournaments.update', $tournament->id)}}" accept-charset="UTF-8" enctype="multipart/form-data">
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
								 <label for="title:{{$lk}}" class="content-label">{{trans('tournament.title')}}</label>
								 <input type="text" class="form-control" name="title:{{$lk}}" placeholder="{{trans('tournament.title')}}" value="{{isset($tournament->translate($lk)->title)?$tournament->translate($lk)->title:""}}">
							</div>
							 <div class="form-group">
							 <label for="description:{{$lk}}" class="content-label">{{trans('tournament.description')}}</label>
							 <textarea class="form-control" minlength="2" maxlength="255"  name="description:{{$lk}}">{{isset($tournament->translate($lk)->description)?$tournament->translate($lk)->description:""}}</textarea>
							
						  </div>
						</div>
                    @endforeach
                  </div>  
					 <div class="form-group">
                     <label for="createdBy" class="content-label">{{trans('tournament.createdBy')}}</label>
                   <input type="text" class="form-control" name="created_by" placeholder="{{trans('tournament.createdBy')}}" value="{{$tournament->created_by}}">
                  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="start_date" class="content-label">{{trans('tournament.start_date')}}</label>
                           <input type="date" name="start_date" class="form-control" value="{{$tournament->start_date}}">
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="end_date" class="content-label">{{trans('tournament.end_date')}}</label>
                          <input type="date" name="end_date" class="form-control" value="{{$tournament->end_date}}">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="status" class="content-label">{{trans('tournament.status')}}</label>
                      <select name="status" class="form-control" >
                      <option value="{{trans('tournament.announced')}}">{{trans('tournament.announced')}}</option>
                      <option value="{{trans('tournament.running')}}">{{trans('tournament.running')}}</option>
                      <option value="{{trans('tournament.elapsed')}}">{{trans('tournament.elapsed')}}</option>
                      <option value="{{trans('tournament.cancelled')}}">{{trans('tournament.cancelled')}}</option>
                     
                    </select>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="maximum_Player" class="content-label">{{trans('tournament.maximum_Player')}}</label>
							<input type="number" class="form-control" name="maximum_Player" placeholder="{{trans('tournament.maximum_Player')}}" value="{{$tournament->maximum_Player}}">
                        </div>
                     </div>
                  </div>
				  <div class="form-group">
                     <label for="watch_live" class="content-label">{{trans('tournament.watch_live')}}</label>
					 <select name="watch_live" class="form-control" >
					  <option value="Yes">Yes</option>
					  <option value="No">No</option>
					 </select>
                  </div>
                 
                </div>
                <div class="col-lg-6">
					<div class="form-group">
                     <label for="country" class="content-label">{{trans('tournament.country')}}</label>
					 <select name="country_id" class="form-control" >
						<option value="">{{trans('tournament.select_country')}}</option>
                        @foreach($countries as $country)
                          <option value="{{$country->id}}" @if($tournament->country_id == $country->id) selected @endif>
                            {{$country->country_name}} 
                          </option>    
                        @endforeach
					  </select>
                     <p></p>
                  </div>
                  <div class="form-group">
                     <label for="venue" class="content-label">{{trans('tournament.venue')}}</label>
					  <input type="text" class="form-control" name="venue" placeholder="{{trans('tournament.venue')}}" value="{{$tournament->venue}}">
                  </div>
                  <div class="form-group">
                     <label for="hotel_name" class="content-label">{{trans('tournament.hotel_name')}}</label>
					  <input type="text" class="form-control" name="hotel_name" placeholder="{{trans('tournament.hotel_name')}}" value="{{$tournament->hotel_name}}">
                  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="email" class="content-label">{{trans('tournament.email')}}</label>
                          
						   <input type="text" class="form-control" name="email" placeholder="{{trans('tournament.email')}}" value="{{$tournament->email}}">
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="phone_number" class="content-label">{{trans('tournament.phonenumber')}}</label>
						   <div class="row">
							<div class="col-lg-3">
								<select name="country_code" class="form-control" >
									<option value="">{{trans('tournament.select_dial_code')}}</option>
									@foreach($countries as $country)
									  <option value="{{$country->dial_code}}" @if($tournament->country_code == $country->dial_code) selected @endif>
										{{$country->dial_code}} 
									  </option>    
									@endforeach
								  </select>
						   </div>
						   <div class="col-lg-9">
						   <input type="text" class="form-control col-lg-6" name="phone_number" placeholder="{{trans('tournament.phonenumber')}}" value="{{$tournament->phone_number}}">
						   </div></div>
                          
                        </div>
                     </div>
					</div> 
					<div class="form-group">
                      <label for="currency" class="content-label">{{trans('tournament.currency')}}</label>
                      <select class="form-control" name="currency">
                        <option value="">{{trans('tournament.select_currency')}}</option>
                        @foreach($countries as $currency)
                          <option value="{{$currency->currency_code}}" @if($tournament->currency == $currency->currency_code) selected @endif>
                            {{$currency->currency_code}} ({{$currency->currency_symbol}})
                          </option>    
                        @endforeach
                      </select>
                    </div>
					<div class="row">
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="entry_fee" class="content-label">{{trans('tournament.entry_fee')}}</label>
							   <input type="text" class="form-control col-lg-6" name="entry_fee" placeholder="{{trans('tournament.entry_fee')}}" value="{{$tournament->entry_fee}}">
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="priceMoney" class="content-label">{{trans('tournament.priceMoney')}}</label>
                              
							   <input type="text" class="form-control col-lg-6" name="priceMoney" placeholder="{{trans('tournament.priceMoney')}}" value="{{$tournament->priceMoney}}">
                           </div>
                        </div>
                     </div>
					
                  <div class="form-group">
                    <label for="name" class="content-label">{{trans('tournament.tournament_banner')}}</label>
                    <input type="file" class="form-control" name="tournament_image" accept=".jpg, .png, .jpeg, .PNG, .JPEG, .JPG, .gif">
                    {{-- @if($tournament->getMedia('tournament_images')->last() !== null)
                    <img src="{{str_replace('http://localhost',url("/"),$tournament->getMedia('tournament_images')->last()->getUrl('thumb'))}}" style="width:100px; margin-top:10px">
                    @else
                      {{trans('products.no_image')}}
                    @endif --}}
                  </div>
                  <div class="form-group">
                        <label for="Amount Paid" class="content-label">{{trans('tournament.amount_paid')}}</label>
						<input type="text" class="form-control col-lg-6" name="amountPaid" placeholder="{{trans('tournament.amount_paid')}}" value="{{$tournament->amountPaid}}">
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
