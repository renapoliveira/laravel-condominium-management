@extends('dashboard.layout')

@section('content')

<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ url('perfis') }}">Perfis</a>
  </li>
  <li class="breadcrumb-item active">{{ $profile->id }}</li>
  <li class="breadcrumb-item active">Editar</li>
</ol>

<div class="container">    

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

  <div class="row" style="margin-top: 10px;">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
      <form role="form" method="POST" action="">
        {{ csrf_field() }}
        <fieldset class="form-group">
          <label>Nome</label>
          <input name="name" class="form-control" placeholder="Nome do perfil" value="{{ $profile->name }}" required>
        </fieldset>

        <fieldset class="form-group">
          <label>Privilégios</label>
        </fieldset>

        <div class="form-group">
          <label class="checkbox-inline">
            <input type="checkbox" onClick="toggle(this)" /> Selecionar todos<br/>
          </label>
        </div>

        @foreach ($privileges as $p)
        <div class="form-group">
          <label>{{$p->label}}</label>            
          @foreach ($p->actions as $a)
          <label class="checkbox-inline">
            <input type="checkbox" name="privileges[]" value="{{$a->id}}" <?php echo (in_array($a->id, $profilesPrivileges)) ? 'checked="checked"' : ''; ?>>{{$a->label}}
          </label>
          @endforeach            
        </div>
        @endforeach

        <div class="text-center">
          <button type="submit" class="btn btn-success">Salvar</button>
          <input type="reset" class="btn btn-secondary" value="Limpar Formulário" />
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

</script>

@endsection