@extends('layouts.admin')
@section('content')
  <section class="content-header">
    <h1>
      {{trans('categories.edit')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('categories.index')}}">{{trans('categories.plural')}}</a></li>
      <li class="active">{{trans('categories.edit')}}</li>
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
            <h3 class="box-title">{{ trans('categories.details') }}</h3>
            @can('category-list')
              <a href="{{route('categories.index')}}" class="btn btn-success pull-right">
                <i class="fa fa-arrow-left"></i>
                {{ trans('common.back') }}
              </a>
            @endcan
          </div>
          <form method="POST" id="categories" action="{{route('categories.update', $category->id)}}" accept-charset="UTF-8">
            @csrf
            <input name="_method" type="hidden" value="PUT">
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
                      <label for="name:{{$lk}}" class="content-label">{{trans('categories.name')}}</label>
                      <input class="form-control" minlength="2" maxlength="255" placeholder="{{trans('categories.name')}}" name="name:{{$lk}}" type="text" value="{{$category->translate($lk)->name}}">
                      <strong class="help-block"></strong>
                    </div>
                  </div>
                @endforeach
                  
              </div>
              <div class="form-group">
                <label for="name" class="content-label">{{trans('categories.parent')}}</label>
                <select class="form-control" name="parent_id">
                  <option value="">{{trans('categories.no_parent')}}</option>
                  @foreach($categories as $cat)
                    <option value="{{$cat->id}}" @if($cat->parent_id == $category->id) selected @endif>{{$cat->name}}</option>    
                  @endforeach
                </select>
                @if ($errors->has('name')) <p style="color:red;">{{ $errors->first('name') }}</p> @endif
                <strong class="help-block"></strong>
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