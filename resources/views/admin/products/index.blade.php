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
      {{trans('products.heading')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>{{ trans('common.home') }}</a></li>
      <li><a href="{{route('products.index')}}"> {{trans('products.plural')}}</a></li>
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
            <h3 class="box-title">{{trans('products.title')}}</h3> 
            <!-- <h3 class="box-title pull-right"><a href="{{route('products.create')}}" class="btn btn-success pull-right"> {{trans('products.add_new')}}</a></h3> -->
          </div>
          <div class="box-body">
            <table id="product" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>{{trans('common.id')}}</th>
                  <th>{{trans('products.name')}}</th>
                  <th>{{trans('products.description')}}</th>
                  <th>{{trans('products.rate')}}</th>
                  <th>{{trans('products.category')}}</th>
                  <th>{{trans('products.image')}}</th>
                  <th>{{trans('products.uploaded_on')}}</th>
                  <th>{{trans('products.uploaded_by')}}</th>
                  <th>{{trans('common.action')}}</th>
                </tr>
              </thead>
              <tbody> 

                @foreach($products as $product)
                  <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->name}}</td>
                    <td title="{{$product->description}}">{{substr($product->description,0,20)}}...</td>
                    <td>{{$product->rate}} {{$product->currency}}</td>
                    <td>{{@$product->category->name}}</td>
                    <td>@if($product->getMedia('products')->last() !== null)
                          <img src="{{str_replace('http://localhost',url("/"),$product->getMedia('products')->last()->getUrl('thumb'))}}" style="width:50px">
                        @else
                        {{trans('products.no_image')}}
                        @endif
                    </td>
                    <td>{{date('M-d-Y h:i A', strtotime($product->created_at))}}</td>
                    <td>{{@$product->user->name}}</td>
                    <td>
                      <!-- <a class="btn" href="{{route('products.edit',$product->id)}}">
                        <i class="fa fa-edit"></i>
                      </a> -->
                      <a class="btn" href="{{route('products.show',$product->id)}}">
                        <i class="fa fa-eye"></i>
                      </a>
                      <form action="{{route('products.destroy',$product->id)}}" method="post">
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
                 <th>{{trans('products.name')}}</th>
                 <th>{{trans('products.description')}}</th>
                 <th>{{trans('products.rate')}}</th>
                 <th>{{trans('products.category')}}</th>
                 <th>{{trans('products.image')}}</th>
                 <th>{{trans('products.uploaded_on')}}</th>
                 <th>{{trans('products.uploaded_by')}}</th>
                 <th>{{trans('common.action')}}</th>
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