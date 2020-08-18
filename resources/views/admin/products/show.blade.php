@extends('layouts.admin')
@section('content')
  <section class="content-header">
    <h1>
      {{trans('products.show')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('products.index')}}">{{trans('products.plural')}}</a></li>
      <li class="active">{{trans('products.show')}}</li>
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
            <h3 class="box-title">{{ trans('products.details') }}</h3>
            @can('product-list')
              <a href="{{route('products.index')}}" class="btn btn-success pull-right">
                <i class="fa fa-arrow-left"></i>
                {{ trans('common.back') }}
              </a>
            @endcan
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="name" class="content-label">{{trans('products.name')}}</label>
                  <p>{{$product->name}}</p>
                </div>
                <div class="form-group">
                  <label for="name" class="content-label">{{trans('products.description')}}</label>
                  <p>{{$product->description}}</p>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="name" class="content-label">{{trans('products.image')}}</label>
                  <p>
                    @if($product->getMedia('products')->last() !== null)
                      <img src="{{str_replace('http://localhost',url('/'),$product->getMedia('products')->last()->getUrl('thumb'))}}" style="width:100px">
                    @else
                      {{trans('products.no_image')}}
                    @endif
                  </p>
                </div>
                <div class="form-group">
                  <label for="rate" class="content-label">{{trans('products.rate')}}</label>
                  {{$product->rate}} {{$product->currency}}
                </div>
                
                <div class="form-group">
                  <label for="name" class="content-label">{{trans('products.category')}}</label>
                  <p>{{@$product->category->name}}</p>
                </div>

                <div class="form-group">
                  <label for="name" class="content-label">{{trans('products.uploaded_on')}}</label>
                  <p>{{date('M-d-Y h:i A', strtotime($product->created_at))}}</p>
                  <p><b>{{trans('products.uploaded_by')}}</b> {{$product->user->name}}</p>
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

@endsection