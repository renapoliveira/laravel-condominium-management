@extends('dashboard.layout')

@section('content')

<ol class="breadcrumb">
  <li class="breadcrumb-item">
    Blocos
</li>
</ol>

<div class="container-fluid">
    @if (session()->get('success'))
    <div class="alert alert-success">
      <ul>
          <li>{{ session()->get('success') }}</li>
      </ul>
  </div>
  @endif

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
            <label>Número de blocos</label>
            <input name="units" class="form-control" placeholder="Número de blocos" value="{{ old('units', @$data->units) }}" required>
        </fieldset>

        <fieldset class="form-group">
            <label>Número de andares por bloco</label>
            <input name="floors" class="form-control" placeholder="Número de andares" value="{{ old('floors', @$data->floors) }}" required>
        </fieldset>

        <fieldset class="form-group">
            <label>Número de apartamentos por andar</label>
            <input name="apartments" class="form-control" placeholder="Número de apartamentos" value="{{ old('apartments', @$data->apartments) }}" required>
        </fieldset>

        <div class="text-center">
          <button type="submit" class="btn btn-success">Salvar</button>
          <a href="{{url('blocos')}}" type="button" class="btn btn-default">Cancelar</a>
      </div>

  </form>
</div>
</div>


</div>


@endsection