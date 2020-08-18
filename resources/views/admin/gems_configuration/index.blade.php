@extends('layouts.admin')
@section('content')
  <section class="content-header">
    <h1>
      {{trans('gems_configuration.heading')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('common.home') }}</a></li>

      <li class="active"> {{trans('gems_configuration.plural')}}</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-warning">
          <div class="box-header">  
            <h3 class="box-title">{{trans('gems_configuration.title')}}</h3>     
          </div>
          <div class="box-body">
            <form method="POST" action="{{route('gems_config.update')}}" accept-charset="UTF-8">
              @csrf
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="game" class="content-label">
                        {{trans('gems_configuration.available_games')}}
                      </label>
                      <select class="form-control game" name="game">
                        <option value="">{{trans('gems_configuration.select_game')}}</option>
                        @foreach($games as $game)
                          <option value="{{$game->id}}">
                            {{$game->game_name}}
                          </option>    
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <input type="hidden" name="game_id">
                <div class="row gems_config_row" style="display: none">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="game" class="content-label">
                        {{trans('gems_configuration.allow_games')}}
                      </label>
                      {!! Form::select('allow_gems_payment',['no' => 'No', 'yes' => 'Yes'] ,[], ['class' => 'form-control allow_gems']) !!}
                    </div>
                  </div>
                  <div class="col-md-6 no_of_gems" style="display: none">
                    <div class="form-group">
                      <label for="game" class="content-label">
                        {{trans('gems_configuration.no_of_gems')}}
                      </label>
                      {!!Form::number('no_of_gems',null,['class' => 'form-control'])!!}
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button id="edit_btn" type="submit" class="btn btn-info btn-fill btn-wd">
                  {{trans('common.submit')}}
                </button>
              </div>
            </form>
            @if(isset($configs) && count($configs) > 0)
            <div class="box box-primary">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th></th>
                      <th>{{trans('gems_configuration.game_name')}}</th>
                      <th>{{trans('gems_configuration.is_allow')}}</th>
                      <th>{{trans('gems_configuration.no_of_gems')}}</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($configs as $config)
                        <tr>
                          <td></td>
                          <td>{{$config->game->game_name}}</td>
                          <td>{{ucfirst($config->allow_gems_payment)}}</td>
                          <td>{{$config->no_of_gems}}</td>
                          <td>
                            <form action="{{route('gems_config.destroy',$config->id)}}" method="post">
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
                </table>
              </div>
              <!-- /.box-body -->
            </div>
            @endif
          </div>
        </div>
      </div>
    </div> 
  </section>
@endsection
@section('js')
<script type="text/javascript">
  
  $(document).on('change', '.allow_gems', function() {
    if($(this).val() == 'yes'){
      $('.no_of_gems').show();
      if($('input[name=no_of_gems]').val() == ''){
        $('input[name=no_of_gems]').val(1);
      }
    } else {
      $('.no_of_gems').hide();
      if($('input[name=no_of_gems]').val() != ''){
        $('input[name=no_of_gems]').val("");
      }
    } 
  });
  $(document).on('change', '.game', function() {
    if($(this).val() != ''){
      $('input[name=game_id]').val($(this).val());
      $('.gems_config_row').show();
    } 
  });
</script>
@endsection     