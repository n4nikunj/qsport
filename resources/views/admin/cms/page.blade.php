@extends('layouts.blank')

@section('css')
<style>
	 .box-header{
		text-align: center;
	}
	</style>
@endsection

@section('content')
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-warning">
           <div class="box-header with-border">
                <h3 class="box-title">{{ $cms[0]->page_name }}</h3>
               
            </div>
          <div class="box-body">
             
                {!! $cms[0]->content !!}
              </div>
                
          </div>
        </div>
      </div>
  </section>

@endsection

