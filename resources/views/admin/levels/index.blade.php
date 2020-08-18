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
      {{trans('levels.heading')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>{{ trans('common.home') }}</a></li>
      <li><a href="{{route('levels.index')}}"> {{trans('levels.plural')}}</a></li>
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
            <h3 class="box-title">{{trans('levels.title')}}</h3> 
            <h3 class="box-title pull-right"><a href="{{route('levels.create')}}" class="btn btn-success pull-right"> {{trans('levels.add_new')}}</a></h3>
          </div>
          <div class="box-body">
            <table id="levels" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>{{trans('common.id')}}</th>
                  <th>{{trans('levels.level_name')}}</th>
                  <th>{{trans('levels.no_of_question')}}</th>
                  <th>{{trans('levels.plus_point_per_que')}}</th>
                  <th>{{trans('levels.minus_point_per_que')}}</th>
                  <th>{{trans('common.action')}}</th>
                </tr>
              </thead>
              <tbody> 

                @foreach($levels as $lvl)
                  <tr>
                    <td>{{$lvl->id}}</td>
                    <td>{{$lvl->level_name}}</td>
                    <td>{{$lvl->no_of_question}}</td>
                    <td>{{$lvl->plus_point_per_que}}</td>
                    <td>{{$lvl->minus_point_per_que}}</td>
                    <td>
                      <a class="btn" href="{{route('levels.edit',$lvl->id)}}">
                        <i class="fa fa-edit"></i>
                      </a>
                      <a class="btn" href="{{route('levels.show',$lvl->id)}}">
                        <i class="fa fa-eye"></i>
                      </a>
                      <form action="{{route('levels.destroy',$lvl->id)}}" method="post">
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
                  <th>{{trans('common.id')}}</th>
                  <th>{{trans('levels.level_name')}}</th>
                  <th>{{trans('levels.no_of_question')}}</th>
                  <th>{{trans('levels.plus_point_per_que')}}</th>
                  <th>{{trans('levels.minus_point_per_que')}}</th>
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
  $('#levels').DataTable({
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