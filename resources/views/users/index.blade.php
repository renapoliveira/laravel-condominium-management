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
                                @foreach($tableTitles as $t)                                    
                                    <th>{!! $t !!}</th>
                                @endforeach                                
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form action="" method="GET">
                                <tr>
                                    <td></td>
                                    <td><input class="form-control" type="text" name="login" value="{{ $search['login'] or '' }}" /></td>
                                    <td>
                                        <select class="form-control" name="profile_id">
                                            <option value=""></option>
                                            <option value="0" {{ (isset($search['profile_id']) && $search['profile_id'] == "0") ? 'selected="selected"' : ''}}>Nenhum</option>
                                            @foreach($profiles as $p)
                                                <option value="{{$p->id}}" {{ (isset($search['profile_id']) && $search['profile_id'] == $p->id) ? 'selected="selected"' : ''}}>{{$p->name}}</option>
                                            @endforeach            
                                        </select>
                                    </td>                                
                                    <td>
                                        <select class="form-control" name="status">
                                            <option value=""></option>
                                            <option value="1" {{ (isset($search['status']) && $search['status'] == "1") ? 'selected="selected"' : ''}}>Ativo</option>
                                            <option value="0" {{ (isset($search['status']) && $search['status'] == "0") ? 'selected="selected"' : ''}}>Bloqueado</option>
                                        </select>
                                    </td>
                                    <td></td>                                
                                    <td><button type="submit" class="btn btn-primary">Filtrar</button> <a onClick="reset()" class="btn btn-default">Limpar</a></td>
                                </tr>
                            </form>
                            @foreach ($data as $d)
                            <tr>
                                <td>{{$d->id}}</td>
                                <td>{{$d->login}}</td>
                                <td>{{$d->profile->name}}</td>
                                @if ($d->status == 1)
                                <td>Ativo</td>
                                @else
                                <td>Bloqueado</td>
                                @endif
                                <td>{{ date('d/m/Y H:i:s', strtotime($d->updated_at)) }}</td>
                                <td>
                                    <a href="{{ url('usuarios/' . $d->id . '/visualizar') }}" class="btn btn-default btn-circle" title="Visualizar usuário"><i class="fa fa-eye"></i></a>
                                    <a href="{{ url('usuarios/' . $d->id . '/editar') }}" class="btn btn-primary btn-circle" title="Editar usuário"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger btn-circle" data-toggle="modal" data-target="#myModal" value="{{ url('usuarios/' . $d->id . '/remover') }}" onClick="createModalLink(this)" title="Remover usuário"><i class="fa fa-trash"></i></button>
                                    <a href="{{ url('usuarios/' . $d->id . '/nova_senha') }}" class="btn btn-warning btn-circle" title="Alterar senha"><i class="fa fa-key"></i></a>
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
    <div class="col-md-12 col-lg-12 col-xl-12">Total: {{ $data->total() }}</div>
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
    function reset(){        
        var elements = document.getElementsByClassName("form-control");
        for(var i = 0; i < elements.length; i++) {            
            elements[i].value = "";
        }
    }    
</script>
@endsection