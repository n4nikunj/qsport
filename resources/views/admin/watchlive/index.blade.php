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
      {{trans('watchlive.heading')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>{{ trans('common.home') }}</a></li>
      <li><a href="{{route('tournaments.index')}}"> {{trans('watchlive.plural')}}</a></li>
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
            <h3 class="box-title">{{trans('watchlive.titleh')}}</h3> 
            <h3 class="box-title pull-right"><a href="{{route('watch_live.create')}}" class="btn btn-success pull-right"> {{trans('watchlive.add_new')}}</a></h3>
          </div>
         
          <div class="box-body">
            <table id="watchlive" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>{{trans('common.id')}}</th>
                  <th>{{trans('watchlive.match_name')}}</th>
                  <th>{{trans('watchlive.start_date')}}</th>
                  <th>{{trans('watchlive.end_date')}}</th>
                  <th>{{trans('watchlive.price')}}</th>
				  <th>{{trans('watchlive.currency')}}</th>
				  <th>{{trans('watchlive.status')}}</th>
				  <th>{{trans('common.action')}}</th>
                </tr>
              </thead>
              <tbody> 

              </tbody>
              <tfoot>
				<tr>
                  <th>{{trans('common.id')}}</th>
                  <th>{{trans('watchlive.match_name')}}</th>
                  <th>{{trans('watchlive.start_date')}}</th>
                  <th>{{trans('watchlive.end_date')}}</th>
                  <th>{{trans('watchlive.price')}}</th>
				  <th>{{trans('watchlive.currency')}}</th>
				  <th>{{trans('watchlive.status')}}</th>
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
            url: "{{route('watch_live_status')}}",
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
	  var statuslist=["Active","Inactive"];
   $('#watchlive').DataTable({
      processing: true,
      serverSide: true,
      serverMethod:'POST',      
	  language: {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
      ajax: {
          url: "{{route('ajax_watch_live')}}",
          data: {"_token": "{{csrf_token()}}"},
      },
	  
      columns: [
         { data: 'id' },
         { data: 'match_name' },
         { data: 'start_date' },
         { data: 'end_date' },
         { data: 'price' },
		 { data: 'currency' },
         { data: 'status',
           mRender : function(d,t,r){
				var $select = $("<select></select>", {
					"id": r["id"],
					"value": d,
					"class":"status"
				});
				$.each(statuslist, function(k,v){
					var $option = $("<option></option>", {
						"text": v,
						"value": v
					});
					if(d === v){
						$option.attr("selected", "selected")
					}
					$select.append($option);
				});
				
				return $select.prop("outerHTML")+'<span class="loading" style="visibility: hidden;"><i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span></span>';
			}
          },
          { 
            mRender : function(data, type, row) {
                  return '<form action="'+row["show"]+'" method="get"><button class="btn" type="submit"><i class="fa fa-eye"></i></button></form><form action="'+row["edit"]+'" method="get"><button class="btn" type="submit"><i class="fa fa-edit"></i></button></form><form action="'+row["delete"]+'" method="post"><button class="btn" type="submit" onclick=" return delete_alert()"><i class="fa fa-trash"></i></button>@method("delete")@csrf</form>';
              } 
          },
        ]
   });
  });
</script>
@endsection