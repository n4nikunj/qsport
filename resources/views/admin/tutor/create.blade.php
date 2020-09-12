@extends('layouts.admin')
@section('content')
  <section class="content-header">
    <h1>
      {{trans('tutors.add_new')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('tutors.index')}}">{{trans('tutors.plural')}}</a></li>
      <li class="active">{{trans('tutors.add_new')}}</li>
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
    @if ($message = Session::get('error'))
          <div class="alert alert-danger">
              <p>{{ $message }}</p>
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
          <form method="POST" id="tutors" action="{{route('tutors.store')}}" accept-charset="UTF-8" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
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
                          <input class="form-control" minlength="2" maxlength="100" placeholder="{{trans('tutor.title')}}" name="name:{{$lk}}" type="text" value="{{old('title:'.$lk)}}">
                        </div>
                        <div class="form-group">
                          <label for="description:{{$lk}}" class="content-label">{{trans('tutor.description')}}</label>
                          <textarea class="form-control" minlength="2" maxlength="500"  name="description:{{$lk}}">{{old('description:'.$lk)}}</textarea>
                        </div>
                      </div>
                    @endforeach
                  </div>
				  <div class="form-group">
                           <label for="status" class="content-label">{{trans('tutor.user')}}</label>
                      <select name="user_id" class="form-control" >
						<option value="">{{trans('tutor.select_user')}}</option>
                        @foreach($users as $user)
                          <option value="{{$user->id}}" @if(old('user_id') == $user->id) selected @endif >
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
					  <option value="{{$country->dial_code}}" >
						{{$country->dial_code}} 
					  </option>    
					@endforeach
				  </select>
			   </div>
			   <div class="col-lg-9">
			   <input type="text" class="form-control col-lg-6" name="phoneno" placeholder="{{trans('tutor.phoneno')}}" value="{{old('phoneno')}}">
			   </div></div>
			  
			</div>		
			 <div class="form-group">
			   <label for="email" class="content-label">{{trans('tutor.email')}}</label>
			  
			   <input type="text" minlength="10" maxlength="500" class="form-control" name="email" placeholder="{{trans('tutor.email')}}" value="{{old('email')}}">
			</div>	
				 <div class="form-group">
                    <label for="image" class="content-label">{{trans('tutor.image')}}</label>
                    <input type="file" class="form-control" name="tutor_image" accept=".jpg, .png, .jpeg, .PNG, .JPEG, .JPG">
                  </div>
 
                </div>
                <div class="col-lg-6">
                  
                  <div class="form-group">
                    <label for="certificate" class="content-label">{{trans('tutor.certificate')}}</label>
                    <input type="file" class="form-control" name="tutor_certificate" accept=".jpg, .png, .jpeg, .PNG, .JPEG, .JPG">
                  </div>
					<div class="form-group">
                     <label for="country" class="content-label">{{trans('tutor.country')}}</label>
					 <select name="country_id" class="form-control" >
						<option value="">{{trans('tutor.select_country')}}</option>
                        @foreach($countries as $country)
                          <option value="{{$country->id}}" @if(old('country_id') == $country->id) selected @endif>
                            {{$country->country_name}} 
                          </option>    
                        @endforeach
					  </select>
                     <p></p>
                  </div>
				   <div class="form-group">
                    <label for="address" class="content-label">{{trans('tutor.address')}}</label>
                    <textarea class="form-control" rows="2" name="address">{{old('address')}}</textarea>
                  </div>
				   <div class="form-group">
					   <label for="address on map" class="content-label">{{trans('tutor.addonmap')}}</label>
					   <div class="row">
						<div class="col-lg-6">
							 <input type="text" class="form-control " name="lat" placeholder="{{trans('tutor.lat')}}" value="{{old('lat')}}">
					   </div>
					   <div class="col-lg-6">
					   <input type="text" class="form-control col-lg-6" name="long" placeholder="{{trans('tutor.long')}}" value="{{old('long')}}">
					   </div></div>
					</div>
					<div class="form-group">
					   <label for="social" class="content-label">{{trans('tutor.social')}}</label>
					   <div class="row">
							<div class="col-lg-4">
								 <input type="url" class="form-control " name="facebook" placeholder="{{trans('tutor.facebook')}}" value="{{old('facebook')}}">
						   </div>
						   <div class="col-lg-4">
								 <input type="url" class="form-control " name="youtube" placeholder="{{trans('tutor.youtube')}}" value="{{old('youtube')}}">
						   </div>
						   <div class="col-lg-4">
								 <input type="url" class="form-control " name="twitter" placeholder="{{trans('tutor.twitter')}}" value="{{old('twitter')}}">
						   </div>
					   </div>
					</div>

                  <div id="price_section">
                    <div class="form-group">
                      <label for="rate" class="content-label">{{trans('tutor.rate')}}</label>
                      <input type="number" class="form-control" name="rate" placeholder="{{trans('tutor.rate')}}" value="{{old('rate')}}">
                    </div>
                    <div class="form-group">
                      <label for="currency" class="content-label">{{trans('tutor.currency')}}</label>
                      <select class="form-control" name="currency">
                        <option value="">{{trans('tutor.select_currency')}}</option>
                        @foreach($countries as $currency)
                          <option value="{{$currency->currency_code}}" @if(old('currency') == $currency->currency_code) selected @endif>
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

@section('js')
<script>
  $('#paid_free').change(function(){
    var type = $(this).val();
    if(type == 'free'){
      $('#price_section').hide();
      $( "input[name='price']").val('');
      $( "select[name='currency']").val('');
    }else{
      $('#price_section').show();
    }
  });
</script>
@endsection