@extends('layouts.admin')
@section('content')
  <section class="content-header">
    <h1>
      {{trans('products.add_new')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('products.index')}}">{{trans('products.plural')}}</a></li>
      <li class="active">{{trans('products.add_new')}}</li>
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
          <form method="POST" id="products" action="{{route('products.store')}}" accept-charset="UTF-8" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
            <div class="box-body">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="name" class="content-label">{{trans('products.name')}}</label>
                    <input type="text" name="name" class="form-control" placeholder="{{trans('products.name')}}" value="{{old('name')}}">
                  </div>
                  <div class="form-group">
                    <label for="name" class="content-label">{{trans('products.description')}}</label>
                    <textarea class="form-control" rows="9" name="description">{{old('description')}}</textarea>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="name" class="content-label">{{trans('products.image')}}</label>
                    <input type="file" class="form-control" name="product_image" accept=".jpg, .png, .jpeg, .PNG, .JPEG, .JPG, .gif">
                  </div>
                  <div class="form-group">
                    <label for="rate" class="content-label">{{trans('products.rate')}}</label>
                    <input type="number" class="form-control" name="rate" placeholder="{{trans('products.rate')}}" value="{{old('rate')}}">
                  </div>
                  <div class="form-group">
                    <label for="currency" class="content-label">{{trans('products.currency')}}</label>
                    <select class="form-control" name="currency">
                      <option value="">{{trans('products.select_currency')}}</option>
                      @foreach($countries as $currency)
                        <option value="{{$currency->currency_code}}" @if(old('currency') == $currency->currency_code) selected @endif>
                          {{$currency->currency_code}} ({{$currency->currency_symbol}})
                        </option>    
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="name" class="content-label">{{trans('products.category')}}</label>
                    <select class="form-control" name="category_id">
                      <option value="">{{trans('products.select_category')}}</option>
                      @foreach($categories as $cat)
                        <option value="{{$cat->id}}" @if(old('category_id') == $cat->id) selected @endif>{{$cat->name}}</option>    
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

@endsection