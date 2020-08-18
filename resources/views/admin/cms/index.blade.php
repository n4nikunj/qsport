@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{asset('admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
<style type="text/css">
  td form{
    display: inline; 

  }
</style>

<style type="text/css">
.info-box {
    padding-top: 10px;
    padding-bottom: 10px;
  }
</style>


@endsection  
@section('content')
  <section class="content-header">
    <h1>
     {{ trans('cms.heading') }} 
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>
      <li><a href="{{route('cms.index')}}">{{ trans('cms.singular') }}</a></li>
    </ol>
  </section>
  
  <section class="content" >
       <div class="row">
      <div class="col-xs-12">
            @can('cms-create')
            <h3 class="box-title pull-right"><a href="{{route('cms.create')}}" class="btn btn-success pull-right">{{ trans('cms.add_new') }}</a></h3>
            @endcan
      </div>
    </div>
    <div class="row" >
      <center>     
         @foreach($cms as $cm)
          @foreach($cm->translation as $trans)
      <a href ="{{route('cms.edit',$cm->id)}}?locale={{$trans->locale}}">
      <div class="col-md-3 col-sm-8 col-xs-12" >
        <div class="info-box">
           <span class="info-box-text">Manage</span> 
            <span class="info-box-text">{{$trans->page_name}}</span>          
            <span class="info-box-number">{{$trans->locale}}</span> 
        </div>
      </div>
    </a>
     
      @endforeach
      @endforeach
     </center> 
    </div>    
  </section>

@endsection
@section('js')
<script>
    function delete_alert() {
      if(confirm("Are you sure want to delete this item?")){
        return true;
      }else{
        return false;
      }
    }
</script>
@endsection