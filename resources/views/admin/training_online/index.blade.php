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
      {{trans('training_online.heading')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>{{ trans('common.home') }}</a></li>
      <li><a href="{{route('training_online.index')}}"> {{trans('training_online.plural')}}</a></li>
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
            <h3 class="box-title">{{trans('training_online.titleh')}}</h3> 
            <h3 class="box-title pull-right"><a href="{{route('training_online.create')}}" class="btn btn-success pull-right"> {{trans('training_online.add_new')}}</a></h3>
          </div>
          <div class="box-body">
            <table id="training_online" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>{{trans('common.id')}}</th>
                  <th>{{trans('training_online.title')}}</th>
                  <th>{{trans('training_online.tutor_name')}}</th>
                  <th>{{trans('training_online.type')}}</th>
                  <th>{{trans('training_online.price')}}</th>
                  <th>{{trans('training_online.session_date')}}</th>
                  <th>{{trans('training_online.start_time')}}</th>
                  <th>{{trans('training_online.end_time')}}</th>
                  <th>{{trans('training_online.image')}}</th>
                  <th>{{trans('common.action')}}</th>
                </tr>
              </thead>
              <tbody> 

                @foreach($training_online as $to)
                  <tr>
                    <td>{{$to->id}}</td>
                    <td>{{$to->title}}</td>
                    <td>{{$to->tutor_name}}</td>
                    <td>{{$to->type}}</td>
                    <td>{{$to->price}} {{$to->currency}}</td> 
                    <td>{{$to->session_date}}</td>
                    <td>{{$to->start_time}}</td>
                    <td>{{$to->end_time}}</td>
                    <td>@if($to->getMedia('training_online_images')->last() !== null)
                          <img src="{{str_replace('http://localhost',url("/"),$to->getMedia('training_online_images')->last()->getUrl('thumb'))}}" style="width:50px">
                        @else
                        {{trans('training_online.no_image')}}
                        @endif
                    </td>
                    <td>
                      <a class="btn" href="{{route('training_online.edit',$to->id)}}">
                        <i class="fa fa-edit"></i>
                      </a>
                      <a class="btn" href="{{route('training_online.show',$to->id)}}">
                        <i class="fa fa-eye"></i>
                      </a>
                      <form action="{{route('training_online.destroy',$to->id)}}" method="post">
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
                  <th>{{trans('training_online.title')}}</th>
                  <th>{{trans('training_online.tutor_name')}}</th>
                  <th>{{trans('training_online.type')}}</th>
                  <th>{{trans('training_online.price')}}</th>
                  <th>{{trans('training_online.session_date')}}</th>
                  <th>{{trans('training_online.start_time')}}</th>
                  <th>{{trans('training_online.end_time')}}</th>
                  <th>{{trans('training_online.image')}}</th>
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
  $('#training_online').DataTable({
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