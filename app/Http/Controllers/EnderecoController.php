<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    public function cadastrarEndereco()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST['id_pessoa']) || empty($_POST['id_pessoa'])) {
                var_dump($_POST);
                die("Erro: ID da pessoa não encontrado.");
            }

            $dadosEndereco = [
                'id_pessoa' => $_POST['id_pessoa'],
                'cep' => $_POST['cep'],
                'logradouro' => $_POST['logradouro'],
                'numero' => $_POST['numero'],
                'complemento' => $_POST['complemento'],
                'bairro' => $_POST['bairro'],
                'estado' => $_POST['estado'],
                'cidade' => $_POST['cidade']
            ];

            if (salvarEndereco($dadosEndereco)) {
                header('Location: index.php?action=pesquisa');
                exit;
            } else {
                echo "Erro ao cadastrar endereço.";
            }
        } else {
            include '../app/Views/cadastroEndereco.php';
        }
    }
}
