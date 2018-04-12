@extends('dashboard.layout')

@section('content')

<ol class="breadcrumb">
  <li class="breadcrumb-item">
    Usuários
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
        <a href="{{ url("usuarios/novo") }}" class="btn btn-success"><i class="fa fa-plus-circle fa-fw"></i> Novo usuário</a>
    </div>
</div>

<div class="row" style="margin-top: 10px;">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Lista de usuários
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Login</th>
                                <th>Perfil</th>
                                <th>Status</th>
                                <th>Última atualização</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                            <tr>
                                <td>{{$d->id}}</td>
                                <td>{{$d->login}}</td>
                                <td>{{$d->profile->name}}</td>
                                @if ($d->blocked == 0)
                                    <td>Ativo</td>
                                @else
                                    <td>Bloqueado</td>
                                @endif
                                <td>{{ date('d/m/Y H:i:s', strtotime($d->created_at)) }}</td>
                                <td>
                                    <a href="{{ url('usuarios/' . $d->id . '/visualizar') }}" class="btn btn-default btn-circle"><i class="fa fa-eye"></i></a>
                                    <a href="{{ url('usuarios/' . $d->id . '/editar') }}" class="btn btn-primary btn-circle"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger btn-circle" data-toggle="modal" data-target="#myModal" value="{{ url('usuarios/' . $d->id . '/remover') }}" onClick="createModalLink(this)"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                            @if (count($data) == 0)
                            <tr><td colspan="4" align="center">Não há usuários configurados</td></tr>
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
<!-- /.row -->
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Excluir Usuário</h4>
            </div>
            <div class="modal-body">
                Você tem certeza que deseja excluir o usuário?
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