@extends('dashboard.layout')

@section('content')

<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ url('perfis') }}">Perfis</a>
  </li>
  <li class="breadcrumb-item active">{{ $profile->id }}</li>
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
          <label>Nome</label>
          <input name="name" class="form-control" placeholder="Nome do perfil" value="{{ old('name', $profile->name) }}" required>
        </fieldset>

        <fieldset class="form-group">
          <label>Privilégios</label>
        </fieldset>

        <div class="form-group">
          <label class="checkbox-inline">
            <input id="input_toggle" type="checkbox" onClick="toggle(this)" /> Selecionar todos<br/>
          </label>
        </div>        

        <table class="table table-striped">
          @foreach ($privileges as $p)
          <tr>
            <td>{{$p->label}}</td>
            @foreach ($p->actions as $a)
            <td><input type="checkbox" name="privileges[]" value="{{$a->id}}" <?php echo (in_array($a->id, $profilesPrivileges)) ? 'checked="checked"' : ''; ?> id="{{$a->id}}"> <label for="{{$a->id}}">{{$a->label}}</label></td>
            @endforeach
          </tr>
          @endforeach
        </table>

        <div class="text-center">
          <button type="submit" class="btn btn-success">Salvar</button>
          <a href="{{url('perfis')}}" type="button" class="btn btn-default">Cancelar</a>
        </div>

        <input type="hidden" name="id" value="{{$profile->id}}" />
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

  document.addEventListener('DOMContentLoaded', function() {

    function checkAllToggled () {
      var allToggled = true;
      checkboxes = document.getElementsByName('privileges[]');
      
      for(var i=0, n=checkboxes.length;i<n;i++) {
        if(checkboxes[i].checked != true){
          allToggled = false;
        }
      }
      if(allToggled) {
        document.getElementById("input_toggle").checked = "checked";
      }      
    }
    checkAllToggled();
  }, false);

</script>

@endsection