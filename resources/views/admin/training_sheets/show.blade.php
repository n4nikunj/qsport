@extends('layouts.admin')
@section('content')
  <section class="content-header">
    <h1>
      {{trans('training_sheets.show')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('training_sheets.index')}}">{{trans('training_sheets.plural')}}</a></li>
      <li class="active">{{trans('training_sheets.show')}}</li>
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
            <h3 class="box-title">{{ trans('training_sheets.details') }}</h3>
            @can('training_sheet-list')
              <a href="{{route('training_sheets.index')}}" class="btn btn-success pull-right">
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
                          <label for="title:{{$lk}}" class="content-label">{{trans('training_sheets.title')}}</label>
                          <p>{{$training_sheet->translate($lk)->title}}</p>
                        </div>
                        <div class="form-group">
                          <label for="drill_instructions:{{$lk}}" class="content-label">{{trans('training_sheets.drill_instructions')}}</label>
                          <p>{{$training_sheet->translate($lk)->drill_instructions}}</p>
                        </div>
                      </div>
                    @endforeach
                  </div>
                  <div class="form-group">
                    <label for="formula" class="content-label">{{trans('training_sheets.formula')}}</label>
                    <p>{{$training_sheet->formula}}</p>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="name" class="content-label">{{trans('training_sheets.image')}}</label>
                    <p>
                      @if($training_sheet->getMedia('training_sheet_images')->last() !== null)
                      <img src="{{str_replace('http://localhost',url("/"),$training_sheet->getMedia('training_sheet_images')->last()->getUrl('thumb'))}}" style="width:100px; margin-top:10px">
                      @else
                        {{trans('products.no_image')}}
                      @endif
                    </p>
                  </div>
                  <div class="form-group">
                    <label for="name" class="content-label">{{trans('training_sheets.video')}}</label>
                    <p>
                      @if($training_sheet->getMedia('training_sheet_videos')->last() !== null)
                      <video id="banner" autoplay="true" loop="" controls="true"  width="320" height="240" style="margin-top: 10px">
                        <source src="{{str_replace('http://localhost',url("/"),$training_sheet->getMedia('training_sheet_videos')->last()->getUrl())}}" type="video/mp4">
                      </video>
                      @else
                        {{trans('products.no_video')}}
                      @endif
                    </p>
                  </div>

                  <div class="form-group">  
                    <label for="name" class="content-label">{{trans('training_sheets.type')}}</label>
                    <p>{{$training_sheet->type}}</p>
                  </div>

                  <div id="price_section" @if($training_sheet->type == 'free') style="display:none" @endif>
                    <div class="form-group">
                      <label for="price" class="content-label">{{trans('training_sheets.price')}}</label>
                      <p>{{$training_sheet->price}} {{$training_sheet->currency}}</p>
                    </div>
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