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
   {{trans('country.heading')}} 
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>{{trans('common.home')}}</a></li>
    <li><a href="{{route('country.index')}}">{{trans('country.title')}}</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">{{trans('country.title')}}</h3>
          @can('country-create')
          <h3 class="box-title pull-right"><a href="{{route('country.create')}}" class="btn btn-success pull-right">{{ trans('country.add_new') }}</a></h3>
          @endcan
        </div>
        <div class="box-body">
          <table id="country" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>{{trans('common.id')}}</th>
                <th>{{trans('country.country_name')}}</th>
                <th>{{trans('country.dial_code')}}</th>
                <th>{{trans('country.currency')}}</th>
                <th>{{trans('country.currency_symbol')}}</th>
                <th>{{trans('country.country_status')}}</th>
                <th>{{trans('common.action')}}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($countrys as $country)
                <tr>
                  <td>{{$country->id}}</td>
                  <td>{{$country->country_name}}</td>
                  <td>{{$country->dial_code}}</td>
                  <td>{{$country->currency}}</td>
                  <td>{{$country->currency_symbol}}</td>
                  <td></td>
                  <td></td>
                </tr>
              @endforeach  
            </tbody>
            <tfoot>
              <tr>
                <th>{{trans('common.id')}}</th>
                <th>{{trans('country.country_name')}}</th>
                <th>{{trans('country.dial_code')}}</th>
                <th>{{trans('country.currency')}}</th>
                <th>{{trans('country.currency_symbol')}}</th>
                <th>{{trans('country.country_status')}}</th>
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
    $(document).on('change','.country_status',function(){
        var status = $(this).val();
        var id = $(this).attr('id');
        var delay = 500;
        var element = $(this);
        $.ajax({
            type:'post',
            url: "{{route('country_status')}}",
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
   $('#country').DataTable({
      processing: true,
      serverSide: true,
      serverMethod:'POST',
      processing: true,
      language: {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
      ajax: {
          url: "{{route('dt_country')}}",
          data: {"_token": "{{csrf_token()}}"},
      },
      columns: [
         { data: 'id' },
         { data: 'country_name' },
         { data: 'dial_code' },
         { data: 'currency' },
         { data: 'currency_symbol' },
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
                 return '<select class="country_status" id="'+row["id"]+'"><option value="active"'+type+'>Active</option><option value="inactive"'+data+'>Inactive</option></select><span class="loading" style="visibility: hidden;"><i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span></span>';
              } 
          },
          { 
            mRender : function(data, type, row) {
                  return '@can("country-edit")<form action="'+row["edit"]+'" method="get"><button class="btn" type="submit"><i class="fa fa-edit"></i></button></form>@endcan<form action="'+row["show"]+'" method="get"><button class="btn" type="submit"><i class="fa fa-eye"></i></button></form>@can("country-delete")<form action="'+row["delete"]+'" method="post"><button class="btn" type="submit" onclick=" return delete_alert()"><i class="fa fa-trash"></i></button>@method("delete")@csrf</form>@endcan';
              } 
          },
        ]
   });
});
</script>

@endsection