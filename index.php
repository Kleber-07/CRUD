<?php

error_reporting(E_ALL);

session_start();

try{
    $pdo = new PDO(
        'mysql: host=localhost; dbname=usuario', 'root', '');
}

catch(Exception $exception)
{
    echo json_encode(["mensagem"=>"Ocorreu um erro. tente denovo"]);
}

$method = $_SERVER["REQUEST_METHOD"];


if($method == "PUT"){
    parse_str(file_get_contents('php://input'), $_PUT);
}


$url = explode("?", $_SERVER["REQUEST_URI"]);

$url = explode("/", $url[0]);


//POST login O.K
if(isset($url[2]) and $url[2]=="login" and strtolower($method)=="post" and !isset($url[3])){


        $user = $_POST["user"];

        $senha = $_POST["pass"];


    try{
        $consulta = $pdo->query("select count(id) as num from usuario where nome='$user' and senha=$senha");

            if ($consulta->fetch(PDO::FETCH_ASSOC)["num"]==1){

                $consulta = $pdo->query("select * from usuario");

               $registro = $consulta->fetchAll(PDO::FETCH_ASSOC);
                    echo json_encode([
                    "mensagem" => "ok",
                    "dados" => $registro
                ]

                );

            }
            
        }

    catch(Exception $exception)
        {
            echo json_encode(["mensagem"=>"Ocorreu um erro. tente denovo"]);
        }   




//cadastrar O.K
}elseif(isset($url[2]) and $url[2]=="cadastro" and strtolower($method)=="post" and !isset($url[3])){



    $name = $_POST["name"];

    $idade = $_POST["idade"];

    $cpf = $_POST["cpf"];

    $senha = $_POST["pass"];

    try{
    $consulta = $pdo->query("insert into usuario (nome,idade,cpf,senha) 
    values ('{$name}', {$idade}, {$cpf}, {$senha})");

    if($consulta->rowCount()==1)

    $registro = listar();
    
    echo json_encode(["mensagem"=>"inserido com sucesso",
        "dados"=> $registro]);
    }

    catch(Exception $exception)
    {
        echo json_encode(["mensagem"=>"Ocorreu um erro. tente denovo"]);
    }   
}


elseif(isset($url[2]) and $url[2]=="user" and strtolower($method)=="delete" and isset($url[3])){

try{
        $nome = $url[3];
        
        $resultado = $pdo->query("delete from usuario WHERE nome = '$nome'");

        if($resultado->rowCount()==1){
            $registro = listar();
            echo json_encode([
                "mensagem"=>"Deletado",
                "dados"=> $registro
            ]);
        }
    }
    catch(Exception $exception)
    {
        echo json_encode([
            "mensagem"=>"Erro tente de novo!"
        ]);
    } 
}
function listar(){
    $pdo = new PDO("mysql: host=localhost; dbname=usuario", "root", "");

    $resultado = $pdo->query("select * from usuario");

    $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);

    return $resultado;
}

?>