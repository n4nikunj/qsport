@extends('layouts.admin')
@section('content')
<section class="content-header">
  <h1>
    {{trans('permission.add_new')}}
    <!-- <small>advanced tables</small> -->
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> >{{ trans('common.home') }}</a></li>
    <li><a href="#">{{trans('permission.plural')}}</a></li>
    <li class="active">{{ucfirst(basename(Request::url()))}}</li>
  </ol>
</section>
<section class="content">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>{{trans('permission.whoops!')}}</strong> {{trans('permission.some_problems_with_input')}}<br><br>
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
                    <h3 class="box-title">{{ trans('permission.details') }}</h3>
                    @can('permission-list')
                        <ul class="pull-right">
                            <a href="{{route('permissions.index')}}" class="btn btn-success">
                                <i class="fa fa-arrow-left"></i>
                                {{ trans('common.back') }}
                            </a>
                        </ul>
                    @endcan
                </div>
                <div class="box-body">
                    {!! Form::open(array('route' => 'permissions.store','method'=>'POST')) !!}
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="usr">{{trans('permission.name')}}</label>
                                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="usr">{{trans('permission.select_role')}}</label>
                                        {!! Form::select('role_id[]', $roles, @$selectedRole, ['class' => 'form-control m-bot15','multiple']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="btn_add_tml" type="submit" class="btn btn-info btn-fill btn-wd">{{ trans('common.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection