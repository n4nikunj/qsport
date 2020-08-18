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
      {{trans('quiz.heading')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>{{ trans('common.home') }}</a></li>
      <li><a href="{{route('quiz.index')}}"> {{trans('quiz.plural')}}</a></li>
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
            <h3 class="box-title">{{trans('quiz.title')}}</h3> 
            <h3 class="box-title pull-right"><a href="{{route('quiz.create')}}" class="btn btn-success pull-right"> {{trans('quiz.add_new')}}</a></h3>
          </div>
          <div class="box-body">
            <table id="quiz" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>{{trans('common.id')}}</th>
                  <th>{{trans('quiz.question')}}</th>
                  <th>{{trans('quiz.option1')}}</th>
                  <th>{{trans('quiz.option2')}}</th>
                  <th>{{trans('quiz.option3')}}</th>
                  <th>{{trans('quiz.option4')}}</th>
                  <th>{{trans('quiz.correct_answer')}}</th>
                  <th>{{trans('quiz.level')}}</th>
                  <th>{{trans('common.action')}}</th>
                </tr>
              </thead>
              <tbody> 

                @foreach($quiz as $qz)
                  <tr>
                    <td>{{$qz->id}}</td>
                    <td>{{$qz->question}}</td>
                    <td>{{$qz->option1}}</td>
                    <td>{{$qz->option2}}</td>
                    <td>{{$qz->option3}}</td>
                    <td>{{$qz->option4}}</td>
                    <td>{{trans('quiz.option')}} {{$qz->correct_answer}}</td>
                    <td>{{@$qz->level->level_name}}</td>
                    <td>
                      <a class="btn" href="{{route('quiz.edit',$qz->id)}}">
                        <i class="fa fa-edit"></i>
                      </a>
                      <a class="btn" href="{{route('quiz.show',$qz->id)}}">
                        <i class="fa fa-eye"></i>
                      </a>
                      <form action="{{route('quiz.destroy',$qz->id)}}" method="post">
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
                  <th>{{trans('quiz.question')}}</th>
                  <th>{{trans('quiz.option1')}}</th>
                  <th>{{trans('quiz.option2')}}</th>
                  <th>{{trans('quiz.option3')}}</th>
                  <th>{{trans('quiz.option4')}}</th>
                  <th>{{trans('quiz.correct_answer')}}</th>
                  <th>{{trans('quiz.level')}}</th>
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
  $('#product').DataTable({
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