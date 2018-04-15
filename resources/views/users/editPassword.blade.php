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
          <input name="login" class="form-control" placeholder="Login" value="{{$user->login}}" disabled="disabled">
        </fieldset>

        <fieldset class="form-group">
          <label>Nova senha</label>
          <input type="password" name="password" class="form-control" placeholder="Nova senha" value="{{ old('password') }}" required>
        </fieldset>

        <fieldset class="form-group">
          <label>Confirmar senha</label>
          <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar senha" value="{{ old('password') }}" required>
        </fieldset>

        <div class="text-center">
          <button type="submit" class="btn btn-success">Salvar</button>
          <a href="{{url('usuarios')}}" type="button" class="btn btn-default">Cancelar</a>
        </div>

      </form>
    </div>
  </div>
</div>

@endsection