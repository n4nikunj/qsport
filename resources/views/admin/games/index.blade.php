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
      {{trans('games.heading')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>{{ trans('common.home') }}</a></li>
      <li><a href="{{route('games.index')}}"> {{trans('games.plural')}}</a></li>
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
            <h3 class="box-title">{{trans('games.title')}}</h3> 
            <h3 class="box-title pull-right"><a href="{{route('games.create')}}" class="btn btn-success pull-right"> {{trans('games.add_new')}}</a></h3>
          </div>
          <div class="box-body">
            <table id="games" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>{{trans('common.id')}}</th>
                  <th>{{trans('games.name')}}</th>
                  <th>{{trans('games.icon')}}</th>
                  <th>{{trans('common.status')}}</th>
                  <th>{{trans('common.action')}}</th>
                </tr>
              </thead>
              <tbody> 
              </tbody>
              <tfoot>
                <tr>
                  <th>{{trans('common.id')}}</th>
                  <th>{{trans('games.name')}}</th>
                  <th>{{trans('games.icon')}}</th>
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
            url: "{{route('game_status')}}",
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
   $('#games').DataTable({
      processing: true,
      serverSide: true,
      serverMethod:'POST',
      processing: true,
      language: {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
      ajax: {
          url: "{{route('ajax_game')}}",
          data: {"_token": "{{csrf_token()}}"},
      },
      columns: [
         { data: 'id' },
         { data: 'game_name' },
         { data: 'icon',
            mRender : function(data, type, row) {
              return row['icon'];
            }
         },
         { data: 'status',
            mRender : function(data, type, row) {
                  var status=data;
                  if(status=='active'){   
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
                  return '<form action="'+row["edit"]+'" method="get"><button class="btn" type="submit"><i class="fa fa-edit"></i></button></form><form action="'+row["delete"]+'" method="post"><button class="btn" type="submit" onclick=" return delete_alert()"><i class="fa fa-trash"></i></button>@method("delete")@csrf</form>';
              } 
          },
        ]
   });
  });
</script>

@endsection