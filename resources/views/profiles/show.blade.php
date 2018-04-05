@extends('dashboard.layout')

@section('content')

<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ url('perfis') }}">Perfis</a>
  </li>
  <li class="breadcrumb-item active">{{ $profile->id }}</li>
  <li class="breadcrumb-item active">Visualizar</li>
</ol>

<div class="container">

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

        @foreach ($privileges as $p)
        <div class="form-group">
          <label>{{$p->label}}</label>            
          @foreach ($p->actions as $a)
          <label class="checkbox-inline">
            <input type="checkbox" name="privileges[]" value="{{$a->id}}" <?php echo (in_array($a->id, $profilesPrivileges)) ? 'checked="checked"' : ''; ?>" disabled="disabled">{{$a->label}}
          </label>
          @endforeach            
        </div>
        @endforeach        

      </form>
    </div>
  </div>
</div>
@endsection