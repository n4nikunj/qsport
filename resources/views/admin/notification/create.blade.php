@extends('layouts.admin')
@section('content')
  <section class="content-header">
    <h1>
      {{trans('notification.add_new')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('notification.index')}}">{{trans('notification.plural')}}</a></li>
      <li class="active">{{trans('notification.add_new')}}</li>
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
            <h3 class="box-title">{{ trans('notification.details') }}</h3>
            @can('level-list')
              <a href="{{route('notification.index')}}" class="btn btn-success pull-right">
                <i class="fa fa-arrow-left"></i>
                {{ trans('common.back') }}
              </a>
            @endcan
          </div>
          <form method="POST" id="notification" action="{{route('notification.store')}}" accept-charset="UTF-8" enctype="multipart/form-data">
            @csrf
            <div class="box-body">
				 <div class="row">
					<div class="col-md-6">
						<div class="form-group">
                           <label for="status" class="content-label">{{trans('notification.User')}}</label>
							<br>
							<label><input type="checkbox" id="all" name="" value="All" />  &nbsp;&nbsp;All User </label>
                        @foreach($users as $user)
						 <br>
							<label><input type="checkbox" class="user" name="users[]" value="{{$user->id}}" />  &nbsp;&nbsp;{{$user->name}} </label>
                        @endforeach
					  
                        </div>
					</div>
					<div class="col-md-6">		
						   <div class="form-group">
								  <label for="notification_title" class="content-label">{{trans('notification.title')}}</label>
								  <input class="form-control"  placeholder="{{trans('notification.title')}}" name="title" type="text" value="{{old('title')}}">
								  <strong class="help-block"></strong>
								</div>
							
						  <div class="form-group">
								  <label for="message" class="content-label">{{trans('notification.message')}}</label>
								  <textarea class="form-control" rows="9" name="message">{{old('message')}}</textarea>
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
  </section>
@endsection

@section('js')
<script>
	$('#all').on('change',function(){
		 if(this.checked) {
			$('.user').prop('checked', true);
		}else{
			$('.user').prop('checked', false);
		}
		
	});
</script>
@endsection