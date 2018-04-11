@extends('dashboard.layout')

@section('content')

<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ url('perfis') }}">Perfis</a>
  </li>
  <li class="breadcrumb-item active">{{ $profile->id }}</li>
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
          <label>Nome</label>
          <input name="name" class="form-control" placeholder="Nome do perfil" value="{{ $profile->name }}" disabled="disabled">
        </fieldset>

        <fieldset class="form-group">
          <label>Privilégios</label>
        </fieldset>        

        <table class="table table-striped">
          @foreach ($privileges as $p)
          <tr>
            <td>{{$p->label}}</td>
            @foreach ($p->actions as $a)
            <td><input type="checkbox" name="privileges[]" value="{{$a->id}}" <?php echo (in_array($a->id, $profilesPrivileges)) ? 'checked="checked"' : ''; ?>" disabled="disabled"> {{$a->label}}</td>
            @endforeach
          </tr>
          @endforeach
        </table>

      </form>
    </div>
  </div>
</div>
@endsection