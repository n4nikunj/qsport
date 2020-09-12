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
      {{trans('sponsors.heading')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>{{ trans('common.home') }}</a></li>
      <li><a href="{{route('sponsors.index')}}"> {{trans('sponsors.plural')}}</a></li>
    </ol>
  </section>
  <section class="content">
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
    @endif
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">{{trans('sponsors.title')}}</h3> 
            <h3 class="box-title pull-right"><a href="{{route('sponsors.create')}}" class="btn btn-success pull-right"> {{trans('sponsors.add_new')}}</a></h3>
          </div>
          <div class="box-body">
            <table id="sponsors" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>{{trans('common.id')}}</th>
                  <th>{{trans('sponsors.logo')}}</th>
                  <th>{{trans('sponsors.name')}}</th>
                  <th>{{trans('sponsors.website')}}</th>
                  <th>{{trans('sponsors.sponsor_category')}}</th>
                  <th>{{trans('common.status')}}</th>
                  <th>{{trans('common.action')}}</th>
                </tr>
              </thead>
              <tbody> 
              </tbody>
              <tfoot>
                <tr>
                 <th>{{trans('common.id')}}</th>
                  <th>{{trans('sponsors.logo')}}</th>
                  <th>{{trans('sponsors.name')}}</th>
                  <th>{{trans('sponsors.website')}}</th>
                  <th>{{trans('sponsors.sponsor_category')}}</th>
                  <th>{{trans('common.status')}}</th>
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
            url: "{{route('sponsors_status')}}",
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
  </script>

  <script type="text/javascript">
  $(document).ready(function(){
	
   $('#sponsors').DataTable({
      processing: true,
      serverSide: true,
      serverMethod:'POST',
      processing: true,
      language: {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
      ajax: {
          url: "{{route('ajax_sponsor')}}",
          data: {"_token": "{{csrf_token()}}"},
      },
      columns: [
         { data: 'id' },
         { data: 'logo' ,
            mRender : function(data, type, row) {
               return '<a href="'+row['website']+'"><img src="'+data+'" style="width:50px"></a>';
            }
		},
         { data: 'name' },
         { data: 'website' },
         { data: 'sponsors_category' },
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
                  return '<form action="'+row["show"]+'" method="get"><button class="btn" type="submit"><i class="fa fa-eye"></i></button></form><form action="'+row["delete"]+'" method="post"><button class="btn" type="submit" onclick=" return delete_alert()"><i class="fa fa-trash"></i></button>@method("delete")@csrf</form>';
              } 
          },
        ],
	'columnDefs': [ {
        'targets': [1,6], /* column index */
        'orderable': false, /* true or false */
		}]
   });
  });
</script>

@endsection