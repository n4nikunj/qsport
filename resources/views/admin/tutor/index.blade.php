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
      {{trans('tutor.heading')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>{{ trans('common.home') }}</a></li>
      <li><a href="{{route('tutors.index')}}"> {{trans('tutor.plural')}}</a></li>
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
            <h3 class="box-title">{{trans('tutor.titleh')}}</h3> 
			 <h3 class="box-title pull-right"><a href="{{route('tutors.create')}}" class="btn btn-success pull-right"> {{trans('tutor.add_new')}}</a></h3>
          </div>
          <div class="box-body">
            <table id="tutor" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>{{trans('common.id')}}</th>
                  <th>{{trans('tutor.title')}}</th>
                  <th>{{trans('tutor.image')}}</th>
                  <th>{{trans('tutor.rate')}}</th>
                  <th>{{trans('tutor.phoneno')}}</th>
                  <th>{{trans('tutor.certificate')}}</th>
                  <th>{{trans('tutor.ProfileStatus')}}</th>
				  <th>{{trans('tutor.status')}}</th>
				  <th>{{trans('common.action')}}</th>
                </tr>
              </thead>
              <tbody> 

              </tbody>
              <tfoot>
               <tr>
                 <tr>
                    <th>{{trans('common.id')}}</th>
                  <th>{{trans('tutor.title')}}</th>
                  <th>{{trans('tutor.image')}}</th>
                  <th>{{trans('tutor.rate')}}</th>
                  <th>{{trans('tutor.phoneno')}}</th>
                  <th>{{trans('tutor.certificate')}}</th>
                  <th>{{trans('tutor.ProfileStatus')}}</th>
				  <th>{{trans('tutor.status')}}</th>
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
    $(document).on('change','.status',function(){
        var status = $(this).val();
        var id = $(this).attr('id');
        var delay = 500;
        var element = $(this);
        $.ajax({
            type:'post',
            url: "{{route('tutor_status')}}",
            data: {
                    "status": status, 
                    "id" : id,  
                    "_token": "{{ csrf_token() }}"
                  },
            beforeSend: function () {
                element.next('.loading').css('visibility', 'visible');
            },
            success: function (data) {
              setTimeout(function() {
                    element.next('.loading').css('visibility', 'hidden');
                }, delay);
              toastr.success(data.success);
            },
            error: function () {
              toastr.error(data.error);
            }
        })
    })
	$(document).on('change','.profilestatus',function(){
        var profilestatus = $(this).val();
        var id = $(this).attr('id');
        var delay = 500;
        var element = $(this);
        $.ajax({
            type:'post',
            url: "{{route('tutor_profile_status')}}",
            data: {
                    "profilestatus": profilestatus, 
                    "id" : id,  
                    "_token": "{{ csrf_token() }}"
                  },
            beforeSend: function () {
                element.next('.loading').css('visibility', 'visible');
            },
            success: function (data) {
              setTimeout(function() {
                    element.next('.loading').css('visibility', 'hidden');
                }, delay);
              toastr.success(data.success);
            },
            error: function () {
              toastr.error(data.error);
            }
        })
    })
  </script>
 <script type="text/javascript">
  $(document).ready(function(){
	  
   $('#tutor').DataTable({
      processing: true,
      serverSide: true,
      serverMethod:'POST',      
	  language: {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
      ajax: {
          url: "{{route('ajax_tutor')}}",
          data: {"_token": "{{csrf_token()}}"},
      },
	  
      columns: [
         { data: 'id' },
         { data: 'name' },
         { data: 'image',
            mRender : function(data, type, row) {
               return '<img src="'+data+'" style="width:50px">';
            } 
		 },
         { data: 'rate' },
         { data: 'phoneno' },
         { data: 'certificate' ,
			mRender : function(data, type, row) {
               return '<img src="'+data+'" style="width:50px">';
            } 
		 },
         { data: 'profile_status', 
			 mRender : function(data, type, row) {
				
				 
				  if(data=='Approved'){   
					type="selected";
					data='';
				  }else{
					data='selected';
					type='';
				  }
				 return '<select class="profilestatus" id="'+row["id"]+'"><option value="Approved"'+type+'>Approved</option><option value="Rejected"'+data+'>Rejected</option></select><span class="loading" style="visibility: hidden;"><i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span></span>';
			  } 
		 },
         { data: 'status',
           mRender : function(data, type, row) {
				
                  var status=data;
                  if(status=='Active'){   
                    type="selected";
                    data='';
                  }else{
                    data='selected';
                    type='';
                  }
                 return '<select class="status" id="'+row["id"]+'"><option value="active"'+type+'>Active</option><option value="inactive"'+data+'>Inactive</option></select><span class="loading" style="visibility: hidden;"><i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span></span>';
              } 
          },
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