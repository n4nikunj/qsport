@extends('layouts.admin')
@section('content')
  <section class="content-header">
    <h1>
      {{trans('setting.heading')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>

      <li class="active"> {{trans('setting.heading')}}</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-warning">
          <div class="box-header">  
            <h3 class="box-title">{{trans('setting.title')}}</h3>     
          </div>
          <form method="POST" action="{{route('settings.update')}}" accept-charset="UTF-8">
            @csrf
            <div class="box-body">
                  @foreach($settings_data as $k=>$v)
                    <div class="form-group">
                      <label for="content" class="content-label">{{trans('setting.'.strtolower($k))}}</label>
                      <input class="form-control" minlength="2" maxlength="255" placeholder="{{trans('setting.'.strtolower($k))}}" name="{{$k}}" type="text" value="{{$v}}">
                      @error(strtolower($k))
                        <div class="help-block">{{ $message }}</div>
                      @enderror
                    </div>
                  @endforeach  
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
           


