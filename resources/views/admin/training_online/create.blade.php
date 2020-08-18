@extends('layouts.admin')
@section('content')
  <section class="content-header">
    <h1>
      {{trans('training_online.add_new')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('training_online.index')}}">{{trans('training_online.plural')}}</a></li>
      <li class="active">{{trans('training_online.add_new')}}</li>
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
            <h3 class="box-title">{{ trans('training_online.details') }}</h3>
            @can('training_online-list')
              <a href="{{route('training_online.index')}}" class="btn btn-success pull-right">
                <i class="fa fa-arrow-left"></i>
                {{ trans('common.back') }}
              </a>
            @endcan
          </div>
          <form method="POST" id="training_online" action="{{route('training_online.store')}}" accept-charset="UTF-8" enctype="multipart/form-data">
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
                          <label for="title:{{$lk}}" class="content-label">{{trans('training_online.title')}}</label>
                          <input class="form-control" minlength="2" maxlength="255" placeholder="{{trans('training_online.title')}}" name="title:{{$lk}}" type="text" value="{{old('title:'.$lk)}}">
                        </div>
                        <div class="form-group">
                          <label for="description:{{$lk}}" class="content-label">{{trans('training_online.description')}}</label>
                          <textarea class="form-control" minlength="2" maxlength="255"  name="description:{{$lk}}">{{old('description:'.$lk)}}</textarea>
                        </div>
                        <div class="form-group">
                          <label for="tutor_name:{{$lk}}" class="content-label">{{trans('training_online.tutor_name')}}</label>
                          <input class="form-control" minlength="2" maxlength="255" placeholder="{{trans('training_online.tutor_name')}}" name="tutor_name:{{$lk}}" type="text" value="{{old('tutor_name:'.$lk)}}">
                        </div>
                      </div>
                    @endforeach
                  </div>
                  <div class="form-group">
                    <label for="session_date" class="content-label">{{trans('training_online.session_date')}}</label>
                    <input type="date" name="session_date" class="form-control" value="{{old('session_date')}}">
                  </div>
                  <div class="form-group">
                    <label for="start_time" class="content-label">{{trans('training_online.start_time')}}</label>
                    <input type="time" name="start_time" class="form-control" value="{{old('start_time')}}">
                  </div>
                  <div class="form-group">
                    <label for="end_time" class="content-label">{{trans('training_online.end_time')}}</label>
                    <input type="time" name="end_time" class="form-control" value="{{old('end_time')}}">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="link" class="content-label">{{trans('training_online.link')}}</label>
                    <input type="url" name="link" class="form-control" value="{{old('link')}}">
                  </div>

                  <div class="form-group">
                    <label for="training_online_image" class="content-label">{{trans('training_online.image')}}</label>
                    <input type="file" class="form-control" name="training_online_image" accept=".jpg, .png, .jpeg, .PNG, .JPEG, .JPG, .gif">
                  </div>

                  <div class="form-group">  
                    <label for="name" class="content-label">{{trans('training_online.type')}}</label>
                    <select name="type" class="form-control" id="paid_free">
                      <option value="paid">{{trans('training_online.paid')}}</option>
                      <option value="free">{{trans('training_online.free')}}</option>
                    </select>
                  </div>

                  <div id="price_section">
                    <div class="form-group">
                      <label for="price" class="content-label">{{trans('training_online.price')}}</label>
                      <input type="number" class="form-control" name="price" placeholder="{{trans('training_online.price')}}" value="{{old('price')}}">
                    </div>
                    <div class="form-group">
                      <label for="currency" class="content-label">{{trans('training_online.currency')}}</label>
                      <select class="form-control" name="currency">
                        <option value="">{{trans('training_online.select_currency')}}</option>
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