@extends('layouts.admin')
@section('content')
  <section class="content-header">
    <h1>
      {{trans('levels.add_new')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('levels.index')}}">{{trans('levels.plural')}}</a></li>
      <li class="active">{{trans('levels.add_new')}}</li>
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
            <h3 class="box-title">{{ trans('levels.details') }}</h3>
            @can('level-list')
              <a href="{{route('levels.index')}}" class="btn btn-success pull-right">
                <i class="fa fa-arrow-left"></i>
                {{ trans('common.back') }}
              </a>
            @endcan
          </div>
          <form method="POST" id="levels" action="{{route('levels.store')}}" accept-charset="UTF-8">
            @csrf
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
                          <label for="level_name:{{$lk}}" class="content-label">{{trans('levels.level_name')}}</label>
                          <input class="form-control" minlength="2" maxlength="255" placeholder="{{trans('levels.level_name')}}" name="level_name:{{$lk}}" type="text" value="{{old('level_name:'.$lk)}}">
                          <strong class="help-block"></strong>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="no_of_question" class="content-label">{{trans('levels.no_of_question')}}</label>
                    <input type="number" class="form-control" name="no_of_question" value="{{old('no_of_question')}}">
                  </div>
                  <div class="form-group">
                    <label for="plus_point_per_que" class="content-label">{{trans('levels.plus_point_per_que')}}</label>
                    <input type="number" class="form-control" name="plus_point_per_que" value="{{old('plus_point_per_que')}}">
                  </div>
                  <div class="form-group">
                    <label for="minus_point_per_que" class="content-label">{{trans('levels.minus_point_per_que')}}</label>
                    <input type="number" class="form-control" name="minus_point_per_que" value="{{old('minus_point_per_que')}}">
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

@endsection