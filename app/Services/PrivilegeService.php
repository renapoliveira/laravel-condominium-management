<?php

namespace App\Services;

use App\Http\Controllers\Controller;

class PrivilegeService extends Controller
{

 public function __construct()
 {

 }

 public function getPrivileges() 
 {

    return [
        (object)['page' => 'profile', 'label' => 'Cadastro de Perfis', 'actions' => [
            (object)['id' => 1, 'action' => 'create', 'label' => 'Criar'],
            (object)['id' => 2, 'action' => 'view', 'label' => 'Visualizar'],
            (object)['id' => 3, 'action' => 'edit', 'label' => 'Editar'],
            (object)['id' => 4, 'action' => 'remove', 'label' => 'Excluir'],
        ]],
        (object)['page' => 'user', 'label' => 'Cadastro de Usuários', 'actions' => [
            (object)['id' => 5, 'action' => 'create', 'label' => 'Criar'],
            (object)['id' => 6, 'action' => 'view', 'label' => 'Visualizar'],
            (object)['id' => 7, 'action' => 'edit', 'label' => 'Editar'],
            (object)['id' => 8, 'action' => 'remove', 'label' => 'Excluir'],
        ]]
    ];


}

}
