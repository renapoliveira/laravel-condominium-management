@extends('dashboard.layout')

@section('content')

<ol class="breadcrumb">
  <li class="breadcrumb-item">
    Perfis
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

  <div class="row">
    <div class="col-lg-12">
        <a href="{{ url("perfis/novo") }}" class="btn btn-success"><i class="fa fa-plus-circle fa-fw"></i> Novo perfil</a>
    </div>
</div>

<div class="row" style="margin-top: 10px;">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Lista de perfis
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Última atualização</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                            <tr>
                                <td>{{$d->id}}</td>
                                <td>{{$d->name}}</td>
                                <td>{{ date('d/m/Y H:i:s', strtotime($d->updated_at)) }}</td>
                                <td>
                                    <a href="{{ url('perfis/' . $d->id . '/visualizar') }}" class="btn btn-default btn-circle"><i class="fa fa-eye"></i></a>
                                    <a href="{{ url('perfis/' . $d->id . '/editar') }}" class="btn btn-primary btn-circle"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger btn-circle" data-toggle="modal" data-target="#myModal" value="{{ url('perfis/' . $d->id . '/remover') }}" onClick="createModalLink(this)"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                            @if (count($data) == 0)
                            <tr><td colspan="4" align="center">Não há perfis configurados</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->    
</div>
<div id="paginator" class="col-md-12 col-lg-12 col-xl-12" style="text-align: center;">{{ $data->links() }}</div>
<!-- /.row -->
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Excluir Perfil</h4>
            </div>
            <div class="modal-body">
                Você tem certeza que deseja excluir o perfil?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a id="remove_confirm" href="" type="button" class="btn btn-primary">Excluir</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
    function createModalLink(source) {        
        document.getElementById("remove_confirm").href = source.value;
    }
</script>
@endsection