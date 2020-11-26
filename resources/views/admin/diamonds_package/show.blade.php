@extends('layouts.admin')
@section('content')
<section class="content-header">
   <h1>
      {{trans('diamonds_package.show')}}
   </h1>
   <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('pool_hall.index')}}">{{trans('diamonds_package.plural')}}</a></li>
      <li class="active">{{trans('diamonds_package.show')}}</li>
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
            <h3 class="box-title">{{ trans('diamonds_package.details') }}</h3>
            @can('diamonds_package-list')
            <a href="{{route('diamonds_package.index')}}" class="btn btn-success pull-right">
            <i class="fa fa-arrow-left"></i>
            {{ trans('common.back') }}
            </a>
            @endcan
         </div>
         <div class="box-body">
            <div class="row">
               <div class="col-lg-6">
					
				  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="package_name" class="content-label">{{trans('diamonds_package.package_name')}}</label>
                           <p>{{$diamonds_package->package_name}}</p>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="no_of_gems" class="content-label">{{trans('diamonds_package.no_of_gems')}}</label>
                          <p>{{$diamonds_package->no_of_gems}}</p>
                        </div>
                     </div>
                  </div>
				 
                  <div class="row">
                     <div class="col-lg-6">
						<div class="form-group">
						  <label for="status" class="content-label">{{trans('diamonds_package.status')}}</label>
						  <p>{{$diamonds_package->status}}</p>
						</div>
					 </div>
                     <div class="col-lg-6">
						<div class="form-group">
						  <label for="createdOn" class="content-label">{{trans('diamonds_package.createdOn')}}</label>
						  <p>{{$diamonds_package->created_at}}</p>
						</div>
					 </div>
                  </div>
                 
               </div>
               </div>
            </div>
            </form>
         </div>
      </div>
   </div>
</section>
@endsection
@section('js')

@endsection