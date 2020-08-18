@extends('layouts.admin')
@section('content')
  <section class="content-header">
    <h1>
      {{trans('general_configuration.heading')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>

      <li class="active"> {{trans('general_configuration.plural')}}</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-warning">
          <div class="box-header">  
            <h3 class="box-title">{{trans('general_configuration.title')}}</h3>     
          </div>
          <div class="box-body">
            <form method="POST" action="{{route('general_configuration.update')}}" accept-charset="UTF-8">
              @csrf
              <div class="modal-body">
                <div class="form-group">
                  <label for="content" class="content-label">{{trans('general_configuration.free_training_sheet')}}</label>
                  <input class="form-control" placeholder="{{trans('general_configuration.free_training_sheet')}}" name="free_training_sheet" type="number"  value="{{$general_config['free_training_sheet']->value}}">
                  @error('free_training_sheet')
                    <div class="help-block">{{ $message }}</div>
                  @enderror
                </div> 
                <div class="form-group">
                  <label for="content" class="content-label">{{trans('general_configuration.product_posting_price')}}</label>
                  <input class="form-control" placeholder="{{trans('general_configuration.product_posting_price')}}" name="product_posting_price" type="number"  value="{{$general_config['product_posting_price']->value}}">
                  @error('product_posting_price')
                    <div class="help-block">{{ $message }}</div>
                  @enderror
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
           


