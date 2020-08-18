@extends('layouts.admin')
@section('content')
  <section class="content-header">
    <h1>
      {{trans('quiz.show')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('quiz.index')}}">{{trans('quiz.plural')}}</a></li>
      <li class="active">{{trans('quiz.show')}}</li>
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
                          <p>{{$quiz->translate($lk)->question}}</p>
                        </div>
                        <div class="form-group">
                          <label for="option1:{{$lk}}" class="content-label">{{trans('quiz.option1')}}</label>
                          <p>{{$quiz->translate($lk)->option1}}</p>
                        </div>
                        <div class="form-group">
                          <label for="option2:{{$lk}}" class="content-label">{{trans('quiz.option2')}}</label>
                          <p>{{$quiz->translate($lk)->option2}}</p>
                        </div>
                        <div class="form-group">
                          <label for="option3:{{$lk}}" class="content-label">{{trans('quiz.option3')}}</label>
                          <p>{{$quiz->translate($lk)->option3}}</p>
                        </div>
                        <div class="form-group">
                          <label for="option4:{{$lk}}" class="content-label">{{trans('quiz.option4')}}</label>
                          <p>{{$quiz->translate($lk)->option4}}</p>
                        </div>

                      </div>
                    @endforeach
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">  
                    <label for="correct_answer" class="content-label">{{trans('quiz.correct_answer')}}</label>
                    <p>{{trans('quiz.option')}} {{$quiz->correct_answer}}</p>
                  </div>
                  <div class="form-group">
                    <label for="level_id" class="content-label">{{trans('quiz.level')}}</label>
                    <p>{{$quiz->level->level_name}}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button id="show_btn" type="submit" class="btn btn-info btn-fill btn-wd">{{trans('common.submit')}}</button>
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