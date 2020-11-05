@extends('layouts.admin')
@section('content')
<section class="content-header">
   <h1>
      {{trans('gems.show')}}
   </h1>
   <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('pool_hall.index')}}">{{trans('gems.plural')}}</a></li>
      <li class="active">{{trans('gems.show')}}</li>
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
            <h3 class="box-title">{{ trans('gems.details') }}</h3>
            @can('gems-list')
            <a href="{{route('gems.index')}}" class="btn btn-success pull-right">
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
                           <label for="number_of_gems" class="content-label">{{trans('gems.number_of_gems')}}</label>
                           <p>{{$gems->number_of_gems}}</p>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="getting_from" class="content-label">{{trans('gems.getting_from')}}</label>
                          <p>{{$gems->getting_from}}</p>
                        </div>
                     </div>
                  </div>
				 
                  <div class="row">
                     <div class="col-lg-6">
						<div class="form-group">
						  <label for="createdBy" class="content-label">{{trans('gems.createdBy')}}</label>
						  <p>{{$gems['users']->name}}</p>
						</div>
					 </div>
                     <div class="col-lg-6">
						<div class="form-group">
						  <label for="createdOn" class="content-label">{{trans('gems.createdOn')}}</label>
						  <p>{{$gems->created_at}}</p>
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