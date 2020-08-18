@extends('layouts.admin')
@section('content')
<section class="content-header">
  <h1>
    {{$country->country_name}}
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>{{trans('common.home')}}</a></li>
    <li><a href="{{route('country.index')}}">{{trans('country.plural')}}</a></li>
    <li class="active">{{trans('common.show')}}</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
          <div class="tab-content active">
              <div class="tab-pane active" id="settings">
                <table class="table">
                  <tbody>
                      <tr>
                        <th>{{trans('country.country_name')}}</th>
                        <td>{{$country->country_name}}</td>
                    </tr>
                      <tr>
                        <th>{{trans('country.country_code')}}</th>
                        <td>{{$country->country_code}} </td>
                      </tr>
                      <tr>
                        <th>{{trans('country.phone_dial_code')}}</th>
                        <td>{{$country->dial_code}} </td>
                      </tr>
                      <tr>
                        <th>{{trans('country.currency')}}</th>
                        <td>{{$country->currency}} </td>
                      </tr>
                      <tr>
                        <th>{{trans('country.currency_code')}}</th>
                        <td>{{$country->currency_code}} </td>
                      </tr>
                      <tr>
                        <th>{{trans('country.currency_symbol')}}</th>
                        <td>{{$country->currency_symbol}} </td>
                      </tr>
                      <tr>
                        <th>{{trans('country.country_status')}}</th>
                        <td>{{$country->status}} </td>
                      </tr>
                  </tbody>
              </table>
              </div>
          </div>
        </div>
    </div>
</section>
@endsection
