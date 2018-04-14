@extends('dashboard.layout')

@section('content')

<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ url('usuarios') }}">Usuários</a>
  </li>
  <li class="breadcrumb-item active">{{ $user->id }}</li>
  <li class="breadcrumb-item active">Editar</li>
</ol>

<div class="container-fluid">

  <div class="card-body">
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
  </div>
  
  <div class="row">
    <div class="col-lg-12">
      <a href="{{ URL::previous() }}" class="btn btn-default"><i class="fa fa-arrow-left fa-fw"></i> Voltar</a>
    </div>
  </div>  

  <div class="row" style="margin-top: 10px;">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
      <form role="form" method="POST" action="">
        {{ csrf_field() }}

        <fieldset class="form-group">
          <label>Login</label>
          <input name="login" class="form-control" placeholder="Login" value="{{$user->login}}">
        </fieldset>

        <div class="form-group">
          <label>Status</label>
          <select class="form-control" name="status">
            <option value="1" <?php echo ($user->status == 1) ? 'selected="selected"' : ''; ?>>Ativo</option>
            <option value="0" <?php echo ($user->status == 0) ? 'selected="selected"' : ''; ?>>Bloqueado</option>
          </select>
        </div>

        <div class="form-group">
          <label>Perfil</label>
          <select class="form-control" name="profile">
            <option value="0">Nenhum</option>
            @foreach($profiles as $p)
              <option value="{{$p->id}}" <?php echo ($user->profile->id == $p->id) ? 'selected="selected"' : ''; ?>>{{$p->name}}</option>
            @endforeach            
          </select>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-success">Salvar</button>
          <a href="{{url('usuarios')}}" type="button" class="btn btn-default">Cancelar</a>
        </div>

      </form>
    </div>
  </div>
</div>

@endsection