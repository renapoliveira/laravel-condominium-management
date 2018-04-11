@extends('dashboard.layout')

@section('content')

<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ url('usuarios') }}">Usuários</a>
  </li>
  <li class="breadcrumb-item active">Visualizar</li>
</ol>

<div class="container-fluid">  
  
  <div class="row">
    <div class="col-lg-12">
      <a href="{{ URL::previous() }}" class="btn btn-default"><i class="fa fa-arrow-left fa-fw"></i> Voltar</a>
    </div>
  </div>  

  <div class="row" style="margin-top: 10px;">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
      <form role="form" method="POST" action="novo">
        {{ csrf_field() }}

        <fieldset class="form-group">
          <label>Login</label>
          <input name="login" class="form-control" placeholder="Login" value="{{$user->login}}" disabled="disabled">
        </fieldset>        

        <div class="form-group">
          <label>Status</label>
          <select class="form-control" name="blocked" disabled="disabled">
            <option value="0" <?php echo ($user->blocked == 0) ? 'selected="selected"' : ''; ?>>Ativo</option>
            <option value="1" <?php echo ($user->blocked == 1) ? 'selected="selected"' : ''; ?>>Bloqueado</option>
          </select>
        </div>

        <div class="form-group">
          <label>Perfil</label>
          <select class="form-control" name="profile" disabled="disabled">
            <option value="0">Nenhum</option>
            @foreach($profiles as $p)
              <option value="{{$p->id}}" <?php echo ($user->profile->id == $p->id) ? 'selected="selected"' : ''; ?>>{{$p->name}}</option>
            @endforeach            
          </select>
        </div>        

      </form>
    </div>
  </div>
</div>

@endsection