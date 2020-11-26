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
      {{trans('diamonds_package.heading')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>{{ trans('common.home') }}</a></li>
      <li><a href="{{route('tournaments.index')}}"> {{trans('diamonds_package.plural')}}</a></li>
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
            <h3 class="box-title">{{trans('diamonds_package.titleh')}}</h3> 
          </div>
         
          <div class="box-body">
            <table id="diamonds_package" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>{{trans('common.id')}}</th>
                  <th>{{trans('diamonds_package.package_name')}}</th>
                  <th>{{trans('diamonds_package.no_of_gems')}}</th>
                  <th>{{trans('diamonds_package.status')}}</th>
				  <th>{{trans('diamonds_package.createdOn')}}</th>
				  <th>{{trans('common.action')}}</th>
                </tr>
              </thead>
              <tbody> 

              </tbody>
              <tfoot>
				<tr>
                  <th>{{trans('common.id')}}</th>
                   <th>{{trans('diamonds_package.package_name')}}</th>
                  <th>{{trans('diamonds_package.no_of_gems')}}</th>
                  <th>{{trans('diamonds_package.status')}}</th>
				  <th>{{trans('diamonds_package.createdOn')}}</th>
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
    // $(document).on('change','.status',function(){
        // var status = $(this).val();
        // var id = $(this).attr('id');
        // var delay = 500;
        // var element = $(this);
        // $.ajax({
            // type:'post',
            // url: "{{route('pool_hall_status')}}",
            // data: {
                    // "status": status, 
                    // "id" : id,  
                    // "_token": "{{ csrf_token() }}"
                  // },
            // beforeSend: function () {
                // element.next('.loading').css('visibility', 'visible');
            // },
            // success: function (data) {
              // setTimeout(function() {
                    // element.next('.loading').css('visibility', 'hidden');
                // }, delay);
              // toastr.success(data.success);
            // },
            // error: function () {
              // toastr.error(data.error);
            // }
        // })
    // })
  </script>
 <script type="text/javascript">
  $(document).ready(function(){
	  
   $('#diamonds_package').DataTable({
      processing: true,
      serverSide: true,
      serverMethod:'POST',      
	  language: {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
      ajax: {
          url: "{{route('ajax_diamonds_package')}}",
          data: {"_token": "{{csrf_token()}}"},
      },
	  columnDefs: [
			{ orderable: false, targets: -1 }
		],
      columns: [
         { data: 'id' },
         { data: 'package_name' },
         { data: 'no_of_gems' },
         { data: 'status' },
		 { data: 'created_at' },
        
          { 
            mRender : function(data, type, row) {
                  return '<form action="'+row["show"]+'" method="get"><button class="btn" type="submit"><i class="fa fa-eye"></i></button></form>';
              } 
          },
        ]
   });
  });
</script>
@endsection