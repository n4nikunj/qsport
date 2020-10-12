@extends('layouts.admin')
@section('content')
  <section class="content-header">
    <h1>
      {{trans('sponsors.edit')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('sponsors.index')}}">{{trans('sponsors.plural')}}</a></li>
      <li class="active">{{trans('sponsors.edit')}}</li>
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
          <form method="POST" id="sponsors" action="{{route('sponsors.update', $sponsors->id)}}" accept-charset="UTF-8" enctype="multipart/form-data">
            @csrf
            <input name="_method" type="hidden" value="PUT">
            <div class="box-body">
				<div class="form-group">
                           <label for="status" class="content-label">{{trans('sponsors.user')}}</label>
                      <select name="user_id" class="form-control" >
						<option value="">{{trans('sponsors.select_user')}}</option>
                        @foreach($users as $user)
                          <option value="{{$user->id}}" @if($sponsors->user_id == $user->id) selected @endif>
                            {{$user->name}} 
                          </option>    
                        @endforeach
					  </select>
                        </div>
				<div class="form-group">
                    <label for="sponsor_logo_image" class="content-label">{{trans('sponsors.logo')}}</label>
                    <input type="file" class="form-control" name="sponsor_logo" accept=".jpg, .png, .jpeg, .PNG, .JPEG, .JPG">
                  </div>		
               <div class="form-group">
                      <label for="sponsors_name" class="content-label">{{trans('sponsors.name')}}</label>
                      <input class="form-control"  placeholder="{{trans('sponsors.name')}}" name="name" type="text" value="{{$sponsors->name}}">
                      <strong class="help-block"></strong>
                    </div>
                
              <div class="form-group">
                      <label for="website" class="content-label">{{trans('sponsors.website')}}</label>
                      <input class="form-control"  placeholder="{{trans('sponsors.website')}}" name="website" type="text" value="{{$sponsors->website}}">
                      <strong class="help-block"></strong>
                    </div>
				
			<div class="form-group">
			    <label for="phone_number" class="content-label">{{trans('sponsors.phonenumber')}}</label>
			    <div class="row">
					<div class="col-lg-3">
						<select name="country_code" class="form-control" >
							<option value="">{{trans('sponsors.select_dial_code')}}</option>
							@foreach($countries as $country)
							  <option value="{{$country->dial_code}}" @if($sponsors->country_code == $country->dial_code) selected @endif>
								{{$country->dial_code}} 
							  </option>    
							@endforeach
						</select>
				   </div>
				   <div class="col-lg-9">
						<input type="text" class="form-control col-lg-6" name="phone_number" placeholder="{{trans('sponsors.phonenumber')}}" value="{{$sponsors->phone_number}}">
				   </div>
			   </div>
			</div>	
			<div class="form-group">
			   <label for="email" class="content-label">{{trans('sponsors.email')}}</label>
			  
			   <input type="text" class="form-control" name="email" placeholder="{{trans('sponsors.email')}}" value="{{$sponsors->email}}">
			</div>	
			<div class="form-group">
			   <label for="sponsors_category" class="content-label">{{trans('sponsors.sponsor_category')}}</label>
				<select name="sponsors_category" class="form-control">
					<option value="{{trans('sponsors.standard')}}" @if($sponsors->sponsors_category == trans('sponsors.standard')) selected @endif>{{trans('sponsors.standard')}}</option>
					<option value="{{trans('sponsors.premium')}}" @if($sponsors->sponsors_category == trans('sponsors.premium')) selected @endif>{{trans('sponsors.premium')}}</option>
				</select>
			  
			</div>				
			<div class="form-group">
				<label for="amountPaid" class="content-label">{{trans('sponsors.amount_paid')}}</label>
				<input type="text" class="form-control" name="amountPaid" placeholder="{{trans('sponsors.amount_paid')}}" value="{{$sponsors->amountPaid}}">
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

@section('js')

@endsection