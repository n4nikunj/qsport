@extends('layouts.admin')
@section('content')
  <section class="content-header">
    <h1>
      {{trans('games.edit')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('games.index')}}">{{trans('games.plural')}}</a></li>
      <li class="active">{{trans('games.edit')}}</li>
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
            <h3 class="box-title">{{ trans('games.details') }}</h3>
            @can('level-list')
              <a href="{{route('games.index')}}" class="btn btn-success pull-right">
                <i class="fa fa-arrow-left"></i>
                {{ trans('common.back') }}
              </a>
            @endcan
          </div>
          <form method="POST" id="games" action="{{route('games.update', $game)}}" accept-charset="UTF-8" enctype="multipart/form-data">
            <input name="_method" type="hidden" value="PUT">
            @csrf
            <div class="box-body">
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
                      <label for="game_name:{{$lk}}" class="content-label">{{trans('games.name')}}</label>
                      <input class="form-control" minlength="2" maxlength="255" placeholder="{{trans('games.name')}}" name="game_name:{{$lk}}" type="text" value="{{$game->translate($lk)->game_name}}">
                      <strong class="help-block"></strong>
                    </div>
                  </div>
                @endforeach
              </div>
               <div class="form-group">
                    <label for="name" class="content-label">{{trans('games.icon')}}</label>
                    <input type="file" class="form-control" name="game_icon" accept=".jpg, .png, .jpeg, .PNG, .JPEG, .JPG, .gif">
                    @if($game->getMedia('games')->last() !== null)
                      <img src="{{str_replace('http://localhost',url("/"),$game->getMedia('games')->last()->getUrl('thumb'))}}" style="width:100px">
                    @else
                      {{trans('games.no_image')}}
                    @endif
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