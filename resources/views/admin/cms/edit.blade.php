@extends('layouts.admin')
@section('content')
<!-- 
<style type="text/css">
  .box-header {
    margin-right: 8px;
    margin-left: 6px;
    margin-top: 7px; 
  } 
</style> -->

  <section class="content-header">
    <h1>
      {{trans('cms.update')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>{{ trans('common.home') }}</a></li>
      <li><a href="{{route('cms.index')}}">{{trans('cms.singular')}}</a></li>
      <li class="active">{{trans('cms.update')}}</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-warning">
           <div class="box-header with-border">
                <h3 class="box-title">{{ trans('cms.details') }}</h3>
                @can('cms-list')
                <ul class="pull-right">
                    <a href="{{route('cms.index')}}" class="btn btn-success">
                        <i class="fa fa-arrow-left"></i>
                        {{ trans('common.back') }}
                    </a>
                </ul>
                @endcan
            </div>
          <div class="box-body">
            <form method="POST" id="cmsForm" action="{{route('cms.update', $cms->id)}}" accept-charset="UTF-8">
              <input name="_method" type="hidden" value="PUT">
              @csrf
                <div class="tab-content" style="margin-top: 10px;">
                  <input type='text' name="locale" value="{{@$_GET['locale']}}" hidden> 
                  @foreach(config('app.locales') as $lk=>$lv)
                    @if($lk==@$_GET['locale'])
                    <div role="tabpanel" class="tab-pane @if($lk==@$_GET['locale']) active @endif" id="abc_{{$lk}}">
                      <div class="form-group">
                        <label for="content:{{$lk}}" class="content-label">{{trans('cms.content')}}</label>
                        <textarea class="form-control" id="summary-ckeditor"placeholder="{{trans('cms.content')}}" name="content:{{$lk}}" type="text" value="">
                          {{$cms->translate($lk)->content}}
                        </textarea>
                        @if ($errors->has('content:'.$lk)) <p style="color:red;">{{ $errors->first('content:'.$lk) }}</p> @endif
                        <strong class="help-block"></strong>
                      </div>

                      <div class="form-group">
                        <label for="page_name:{{$lk}}" class="content-label">{{trans('cms.page_name')}}</label>
                        <input class="form-control" minlength="2" maxlength="255" placeholder="{{trans('cms.page_name')}}" name="page_name:{{$lk}}" type="text" value="{{$cms->translate($lk)->page_name}}">
                        @if ($errors->has('page_name:'.$lk)) <p style="color:red;">   {{ $errors->first('page_name:'.$lk) }}</p> 
                        @endif
                        <strong class="help-block"></strong>
                      </div>
                    </div>
                    @endif
                  @endforeach

                    <div class="form-group">
                        <label for="slug" class="content-label">{{trans('cms.slug')}}</label>
                        <input class="form-control" minlength="2" maxlength="255" placeholder="{{trans('cms.slug')}}" name="slug" type="text" value="{{$cms->slug}}">
                          @if ($errors->has('slug')) <p style="color:red;">{{ $errors->first('slug') }}</p> @endif
                      <strong class="help-block"></strong>
                    </div>
                      
                    <div class="form-group">
                      <label for="display_order:{{$lk}}" class="content-label">{{trans('cms.display_order')}}</label>
                      <input class="form-control" maxlength="255" placeholder="{{trans('cms.display_order')}}" name="display_order" type="number" value="{{$cms->display_order}}">
                       @if ($errors->has('display_order')) <p style="color:red;">   {{ $errors->first('display_order') }}</p> 
                       @endif
                      <strong class="help-block"></strong>
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
    </div>
  </section>
@endsection

@section('js')
 <script src="{{asset('resources/js/ck_editor.js')}}"></script>

<script>
    CKEDITOR.replaceAll();
    CKEDITOR.config.allowedContent = true;
</script>

@endsection


