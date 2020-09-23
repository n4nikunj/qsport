@extends('layouts.admin')
@section('content')
  <section class="content-header">
    <h1>
      {{trans('watchlive.edit')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('watch_live.index')}}">{{trans('watchlive.plural')}}</a></li>
      <li class="active">{{trans('watchlive.edit')}}</li>
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
            <h3 class="box-title">{{ trans('watchlive.details') }}</h3>
            @can('watchlive-list')
              <a href="{{route('watch_live.index')}}" class="btn btn-success pull-right">
                <i class="fa fa-arrow-left"></i>
                {{ trans('common.back') }}
              </a>
            @endcan
          </div>
		  <form method="POST" id="watchlive" action="{{route('watch_live.update', $watchlive->id)}}" accept-charset="UTF-8" enctype="multipart/form-data">
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
									 <label for="match_name:{{$lk}}" class="content-label">{{trans('watchlive.match_name')}}</label>
									 <input type="text" class="form-control" name="match_name:{{$lk}}" placeholder="{{trans('watchlive.match_name')}}" value="{{$watchlive->translate($lk)->match_name}}">
								</div>
							</div>
						@endforeach
                    </div>  
					
					
				  
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="start_date" class="content-label">{{trans('watchlive.start_date')}}</label>
                           <input type="date" name="start_date" class="form-control" value="{{$watchlive->start_date}}">
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="end_date" class="content-label">{{trans('watchlive.end_date')}}</label>
                          <input type="date" name="end_date" class="form-control" value="{{$watchlive->end_date}}">
                        </div>
                     </div>
                  </div>
				
                </div>
                <div class="col-lg-6">
					
					<div class="form-group">
						<label for="name" class="content-label">{{trans('watchlive.match_image')}}</label>
						<input type="file" class="form-control" name="match_image" accept=".jpg, .png, .jpeg, .PNG, .JPEG, .JPG, .gif">
						{{-- @if($watchlive->getMedia('watchlive_images')->last() !== null)
						<img src="{{str_replace('http://localhost',url("/"),$watchlive->getMedia('watchlive_images')->last()->getUrl('thumb'))}}" style="width:100px; margin-top:10px">
						@else
						  {{trans('products.no_image')}}
						@endif --}}
					</div>
					 <div class="row">
						 <div class="col-lg-6">
							<div class="form-group">
							  <label for="price" class="content-label">{{trans('watchlive.price')}}</label>
							  <input type="text" class="form-control"  name="price"  placeholder="{{trans('watchlive.price')}}" value="{{$watchlive->price}}">
							</div>
						 </div>
						 <div class="col-lg-6">
							<div class="form-group">
							  <label for="currency" class="content-label">{{trans('watchlive.currency')}}</label>
							  <input type="text" class="form-control" name="currency"  placeholder="{{trans('watchlive.currency')}}" value="{{$watchlive->currency}}">
							</div>
						 </div>
					</div>
					<div class="form-group">
						<label for="online_link" class="content-label">{{trans('watchlive.online_link')}}</label>
						<input type="text" class="form-control" name="online_link" placeholder="{{trans('watchlive.online_link')}}" value="{{$watchlive->online_link}}">
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
