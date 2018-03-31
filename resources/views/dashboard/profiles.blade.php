@extends('dashboard.layout')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Perfis</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-lg-12">
        <a href="{{ url("perfis/novo") }}" class="btn btn-success"><i class="fa fa-plus-circle fa-fw"></i> Novo</a>
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
                            <tr>
                                <td>1</td>
                                <td>Mark</td>
                                <td>10/02/2017 10:31:00</td>
                                <td>
                                    <a href="" class="btn btn-default btn-circle"><i class="fa fa-eye"></i></a>
                                    <a href="" class="btn btn-primary btn-circle"><i class="fa fa-pencil"></i></a>
                                    <a href="" class="btn btn-danger btn-circle"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Mark</td>
                                <td>12/02/2017 10:31:00</td>
                                <td>
                                    <a href="" class="btn btn-default btn-circle"><i class="fa fa-eye"></i></a>
                                    <a href="" class="btn btn-primary btn-circle"><i class="fa fa-pencil"></i></a>
                                    <a href="" class="btn btn-danger btn-circle"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>                            
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

@endsection