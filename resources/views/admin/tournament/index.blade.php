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
      {{trans('tournament.heading')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>{{ trans('common.home') }}</a></li>
      <li><a href="{{route('tournaments.index')}}"> {{trans('tournament.plural')}}</a></li>
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
            <h3 class="box-title">{{trans('tournament.titleh')}}</h3> 
            <h3 class="box-title pull-right"><a href="{{route('tournaments.create')}}" class="btn btn-success pull-right"> {{trans('tournament.add_new')}}</a></h3>
          </div>
          <div class="box-body">
            <table id="tournament" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>{{trans('common.id')}}</th>
                  <th>{{trans('tournament.title')}}</th>
                  <!-- <th>{{trans('training_sheets.drill_instructions')}}</th> -->
                  <th>{{trans('tournament.venue')}}</th>
                  <th>{{trans('tournament.hotel_name')}}</th>
                  <th>{{trans('tournament.country')}}</th>
                  <th>{{trans('tournament.email')}}</th>
                  <th>{{trans('common.phonenumber')}}</th>
                  <th>{{trans('common.start_date')}}</th>
				  <th>{{trans('common.action')}}</th>
                </tr>
              </thead>
              <tbody> 

                @foreach($tournament as $to)
				
                  <tr>
                    <td>{{$to->id}}</td>
                    <td>{{$to->title}}</td>
                   
                    <td>{{$to->venue}}</td>
                    <td>{{$to->hotel_name}}</td>
                    <td>{{$to->countries['country_name']}} </td> 
                    <td>{{$to->email}} </td> 
                    <td>{{$to->country_code}} {{$to->phone_number}} </td> 
                    <td>{{$to->start_date}} </td> 
                    
                    <td>
                      <a class="btn" href="{{route('tournaments.edit',$to->id)}}">
                        <i class="fa fa-edit"></i>
                      </a>
                      <a class="btn" href="{{route('tournaments.show',$to->id)}}">
                        <i class="fa fa-eye"></i>
                      </a>
                      <form action="{{route('tournaments.destroy',$to->id)}}" method="post">
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
  $('#tournament').DataTable({
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