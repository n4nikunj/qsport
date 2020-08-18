@extends('layouts.admin')
@section('content')
  <section class="content-header">
    <h1>
      {{trans('quiz.edit')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('quiz.index')}}">{{trans('quiz.plural')}}</a></li>
      <li class="active">{{trans('quiz.edit')}}</li>
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
            <h3 class="box-title">{{ trans('quiz.details') }}</h3>
            @can('quiz-list')
              <a href="{{route('quiz.index')}}" class="btn btn-success pull-right">
                <i class="fa fa-arrow-left"></i>
                {{ trans('common.back') }}
              </a>
            @endcan
          </div>
          <form method="POST" id="levels" action="{{route('quiz.update', $quiz->id)}}" accept-charset="UTF-8">
            @csrf
            <input name="_method" type="hidden" value="PUT">
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
                          <label for="question:{{$lk}}" class="content-label">{{trans('quiz.question')}}</label>
                          <input class="form-control" minlength="2" maxlength="255" placeholder="{{trans('quiz.question')}}" name="question:{{$lk}}" type="text" value="{{$quiz->translate($lk)->question}}">
                        </div>
                        <div class="form-group">
                          <label for="option1:{{$lk}}" class="content-label">{{trans('quiz.option1')}}</label>
                          <input class="form-control" minlength="2" maxlength="255" placeholder="{{trans('quiz.option1')}}" name="option1:{{$lk}}" type="text" value="{{$quiz->translate($lk)->option1}}">
                        </div>
                        <div class="form-group">
                          <label for="option2:{{$lk}}" class="content-label">{{trans('quiz.option2')}}</label>
                          <input class="form-control" minlength="2" maxlength="255" placeholder="{{trans('quiz.option2')}}" name="option2:{{$lk}}" type="text" value="{{$quiz->translate($lk)->option2}}">
                        </div>
                        <div class="form-group">
                          <label for="option3:{{$lk}}" class="content-label">{{trans('quiz.option3')}}</label>
                          <input class="form-control" minlength="2" maxlength="255" placeholder="{{trans('quiz.option3')}}" name="option3:{{$lk}}" type="text" value="{{$quiz->translate($lk)->option3}}">
                        </div>
                        <div class="form-group">
                          <label for="option4:{{$lk}}" class="content-label">{{trans('quiz.option4')}}</label>
                          <input class="form-control" minlength="2" maxlength="255" placeholder="{{trans('quiz.option4')}}" name="option4:{{$lk}}" type="text" value="{{$quiz->translate($lk)->option4}}">
                        </div>

                      </div>
                    @endforeach
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">  
                    <label for="correct_answer" class="content-label">{{trans('quiz.correct_answer')}}</label>
                    <select name="correct_answer" class="form-control" id="paid_free">
                      <option value="1" @if($quiz->correct_answer == 1) selected @endif>{{trans('quiz.option1')}}</option>
                      <option value="2" @if($quiz->correct_answer == 2) selected @endif>{{trans('quiz.option2')}}</option>
                      <option value="3" @if($quiz->correct_answer == 3) selected @endif>{{trans('quiz.option3')}}</option>
                      <option value="4" @if($quiz->correct_answer == 4) selected @endif>{{trans('quiz.option4')}}</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="level_id" class="content-label">{{trans('quiz.level')}}</label>
                    <select class="form-control" name="level_id">
                      <option value="">{{trans('quiz.select_level')}}</option>
                      @foreach($levels as $lvl)
                        <option value="{{$lvl->id}}" @if($quiz->level_id == $lvl->id) selected @endif>
                          {{$lvl->level_name}}
                        </option>    
                      @endforeach
                    </select>
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
    }else{
      $('#price_section').show();
    }
  });
</script>
@endsection