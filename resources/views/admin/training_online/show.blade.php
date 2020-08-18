@extends('layouts.admin')
@section('content')
  <section class="content-header">
    <h1>
      {{trans('training_online.show')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('training_online.index')}}">{{trans('training_online.plural')}}</a></li>
      <li class="active">{{trans('training_online.show')}}</li>
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
            <h3 class="box-title">{{ trans('training_online.details') }}</h3>
            @can('training_online-list')
              <a href="{{route('training_online.index')}}" class="btn btn-success pull-right">
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
                          <label for="title:{{$lk}}" class="content-label">{{trans('training_online.title')}}</label>
                          <p>{{$training_online->translate($lk)->title}}</p>
                        </div>
                        <div class="form-group">
                          <label for="description:{{$lk}}" class="content-label">{{trans('training_online.description')}}</label>
                          <p>{{$training_online->translate($lk)->description}}</p>
                        </div>
                        <div class="form-group">
                          <label for="tutor_name:{{$lk}}" class="content-label">{{trans('training_online.tutor_name')}}</label>
                          <p>{{$training_online->translate($lk)->tutor_name}}</p>
                        </div>
                      </div>
                    @endforeach
                  </div>
                  <div class="form-group">
                    <label for="session_date" class="content-label">{{trans('training_online.session_date')}}</label>
                    <p>{{$training_online->session_date}}</p>
                  </div>
                  <div class="form-group">
                    <label for="start_time" class="content-label">{{trans('training_online.start_time')}}</label>
                    <p>{{$training_online->start_time}}</p>
                  </div>
                  <div class="form-group">
                    <label for="end_time" class="content-label">{{trans('training_online.end_time')}}</label>
                    <p>{{$training_online->end_time}}</p>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="link" class="content-label">{{trans('training_online.link')}}</label>
                    <p>
                      <a href="{{$training_online->link}}">{{$training_online->link}}</a>
                    </p>
                  </div>

                  <div class="form-group">
                    <label for="training_online_image" class="content-label">{{trans('training_online.image')}}</label>
                    <p>
                      @if($training_online->getMedia('training_online_images')->last() !== null)
                      <img src="{{str_replace('http://localhost',url("/"),$training_online->getMedia('training_online_images')->last()->getUrl('thumb'))}}" style="width:100px; margin-top:10px">
                      @else
                        {{trans('training_online.no_image')}}
                      @endif
                    </p>
                  </div>

                  <div class="form-group">  
                    <label for="name" class="content-label">{{trans('training_online.type')}}</label>
                    <p>{{$training_online->type}}</p>
                  </div>

                  <div id="price_section" @if($training_online->type == 'free') style="display:none" @endif>
                    <div class="form-group">
                      <label for="price" class="content-label">{{trans('training_online.price')}}</label>
                      <p>{{$training_online->price}} {{$training_online->currency}}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
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