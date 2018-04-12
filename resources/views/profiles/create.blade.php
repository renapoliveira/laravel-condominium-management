@extends('dashboard.layout')

@section('content')

<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ url('perfis') }}">Perfis</a>
  </li>
  <li class="breadcrumb-item active">Novo perfil</li>
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
      <form role="form" method="POST" action="novo">
        {{ csrf_field() }}
        <fieldset class="form-group">
          <label>Nome</label>
          <input name="name" class="form-control" placeholder="Nome do perfil" value="{{ old('name') }}" required>
        </fieldset>

        <fieldset class="form-group">
          <label>Privilégios</label>
        </fieldset>

        <div class="form-group">
          <label class="checkbox-inline">
            <input type="checkbox" onClick="toggle(this)" /> Selecionar todos<br/>
          </label>
        </div>

        <table class="table table-striped">
          @foreach ($privileges as $p)
          <tr>
            <td>{{$p->label}}</td>
            @foreach ($p->actions as $a)
            <td><input type="checkbox" name="privileges[]" value="{{$a->id}}" id="{{$a->id}}"> <label for="{{$a->id}}">{{$a->label}}</label></td>
            @endforeach
          </tr>
          @endforeach
        </table>

        <div class="text-center">
          <button type="submit" class="btn btn-success">Salvar</button>
          <a href="{{url('perfis')}}" type="button" class="btn btn-default">Cancelar</a>
        </div>

      </form>
    </div>
  </div>
</div>
<script language="JavaScript">
  function toggle(source) {
    checkboxes = document.getElementsByName('privileges[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = source.checked;
    }
  }

</script>

@endsection