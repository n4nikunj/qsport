@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{asset('admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">

<style type="text/css">
  td form{
    display: inline; 
  }
</style>
@endsection  
@section('content')
  <section class="content-header">
    <h1>
      {{trans('training_sheets.heading')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>{{ trans('common.home') }}</a></li>
      <li><a href="{{route('training_sheets.index')}}"> {{trans('training_sheets.plural')}}</a></li>
    </ol>
  </section>

  <section class="content">
    @if ($message = Session::get('success'))
      <div class="alert alert-success">
          <p>{{ $message }}</p>
      </div>
    @endif
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">{{trans('training_sheets.titleh')}}</h3> 
            <h3 class="box-title pull-right"><a href="{{route('training_sheets.create')}}" class="btn btn-success pull-right"> {{trans('training_sheets.add_new')}}</a></h3>
          </div>
          <div class="box-body">
            <table id="training_sheets" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>{{trans('common.id')}}</th>
                  <th>{{trans('training_sheets.title')}}</th>
                  <!-- <th>{{trans('training_sheets.drill_instructions')}}</th> -->
                  <th>{{trans('training_sheets.type')}}</th>
                  <th>{{trans('training_sheets.formula')}}</th>
                  <th>{{trans('training_sheets.price')}}</th>
                  <th>{{trans('training_sheets.image')}}</th>
                  <th>{{trans('training_sheets.video')}}</th>
                  <th>{{trans('common.action')}}</th>
                </tr>
              </thead>
              <tbody> 

                @foreach($training_sheets as $ts)
                  <tr>
                    <td>{{$ts->id}}</td>
                    <td>{{$ts->title}}</td>
                    <!-- <td title="{{$ts->drill_instructions}}">{{substr($ts->drill_instructions,0,20)}}...</td> -->
                    <td>{{$ts->type}}</td>
                    <td>{{$ts->formula}}</td>
                    <td>{{$ts->price}} {{$ts->currency}}</td> 
                    <td>@if($ts->getMedia('training_sheet_images')->last() !== null)
                          <img src="{{str_replace('http://localhost',url("/"),$ts->getMedia('training_sheet_images')->last()->getUrl('thumb'))}}" style="width:50px">
                        @else
                        {{trans('training_sheets.no_image')}}
                        @endif
                    </td>
                    <td>@if($ts->getMedia('training_sheet_videos')->last() !== null)
                          <a href="{{route('training_sheets.show',$ts->id)}}"><i class="fa fa-video-camera"></i></a>
                        @else
                        {{trans('training_sheets.no_image')}}
                        @endif
                    </td>
                    <td>
                      <a class="btn" href="{{route('training_sheets.edit',$ts->id)}}">
                        <i class="fa fa-edit"></i>
                      </a>
                      <a class="btn" href="{{route('training_sheets.show',$ts->id)}}">
                        <i class="fa fa-eye"></i>
                      </a>
                      <form action="{{route('training_sheets.destroy',$ts->id)}}" method="post">
                        <button class="btn" type="submit" onclick=" return delete_alert()">
                          <i class="fa fa-trash"></i>
                        </button>
                        @method("delete")
                        @csrf
                      </form>
                    </td> 

                  </tr>
                @endforeach  
              </tbody>
              <tfoot>
               <tr>
                 <tr>
                  <th>{{trans('common.id')}}</th>
                  <th>{{trans('training_sheets.title')}}</th>
                  <!-- <th>{{trans('training_sheets.drill_instructions')}}</th> -->
                  <th>{{trans('training_sheets.type')}}</th>
                  <th>{{trans('training_sheets.formula')}}</th>
                  <th>{{trans('training_sheets.price')}}</th>
                  <th>{{trans('training_sheets.image')}}</th>
                  <th>{{trans('training_sheets.video')}}</th>
                  <th>{{trans('common.action')}}</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
@section('js')
<script type="text/javascript">
  $('#training_sheets').DataTable({
                'paging'      : true,
                'lengthChange': true,
                'searching'   : true,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : true
              })
  function delete_alert() {
      if(confirm("Are you sure want to delete this item?")){
        return true;
      }else{
        return false;
      }
  }
  $('.alert-success').delay(5000).fadeOut();
</script>
@endsection