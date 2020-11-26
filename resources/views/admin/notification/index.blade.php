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
      {{trans('notification.heading')}}sde35sww
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>{{ trans('common.home') }}</a></li>
      <li><a href="{{route('notification.index')}}"> {{trans('notification.plural')}}</a></li>
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
            <h3 class="box-title">{{trans('notification.titleh')}}</h3> 
			<h3 class="box-title pull-right"><a href="{{route('notification.create')}}" class="btn btn-success pull-right"> {{trans('notification.add_new')}}</a></h3>
          </div>
          <div class="box-body">
            <table id="notification" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>{{trans('common.id')}}</th>
                  <th>{{trans('notification.title')}}</th>
                  <th>{{trans('notification.message')}}</th>
				  <th>{{trans('common.action')}}</th>
                </tr>
              </thead>
              <tbody> 

              </tbody>
              <tfoot>
               <tr>
                 <tr>
                    <th>{{trans('common.id')}}</th>
                  <th>{{trans('notification.title')}}</th>
                  <th>{{trans('notification.message')}}</th>
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
  $(document).ready(function(){
	
   $('#notification').DataTable({
      processing: true,
      serverSide: true,
      serverMethod:'POST',
      processing: true,
      language: {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
      ajax: {
          url: "{{route('ajax_notification')}}",
          data: {"_token": "{{csrf_token()}}"},
      },
      columns: [
         { data: 'id' },
         { data: 'title' },
         { data: 'message' },
          { 
            mRender : function(data, type, row) {
                  return '<form action="'+row["show"]+'" method="get"><button class="btn" type="submit"><i class="fa fa-eye"></i></button></form><form action="'+row["edit"]+'" method="get"><button class="btn" type="submit"><i class="fa fa-edit"></i></button></form><form action="'+row["delete"]+'" method="post"><button class="btn" type="submit" onclick=" return delete_alert()"><i class="fa fa-trash"></i></button>@method("delete")@csrf</form>';
              } 
          },
        ],
	'columnDefs': [ {
        'targets': [1,1], /* column index */
        'orderable': false, /* true or false */
		}]
   });
  });
</script>
@endsection