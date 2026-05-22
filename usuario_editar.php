<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./css/usuarios2.css">

    <link rel="stylesheet" href="./css/mobile6.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>

        function salvarUsuario(){

            let vId =
                document.getElementById("id").value;

            let vNome =
                document.getElementById("nome").value;

            let vLogin =
                document.getElementById("login").value;

            let vSenha =
                document.getElementById("senha").value;

            if(
                vId.trim() === "" ||
                vNome.trim() === "" ||
                vLogin.trim() === "" ||
                vSenha.trim() === ""
            ){

                alert(
                    "Preencha todos os campos obrigatórios!"
                );

                return;

            }

            $.ajax({

                url: './acao_editar.php',

                type: 'POST',

                dataType: 'json',

                data: {
                    pId: vId,
                    pNome: vNome,
                    pLogin: vLogin,
                    pSenha: vSenha
                },

                success: function(data){

                    if(data.status === 'success'){

                        alert(data.message);

                        window.location.href =
                            "usuario_listar.php";

                    } else {

                        alert(data.message);

                    }

                },

                error: function(
                    jqXHR,
                    textStatus,
                    errorThrown
                ){

                    alert(
                        "Erro na requisição: " +
                        textStatus +
                        " - " +
                        errorThrown
                    );

                    console.log(
                        jqXHR.responseText
                    );

                }

            });

        }

        function voltarPagina(){

            window.location.href =
                "./usuario_listar.php";

        }

    </script>

</head>

<?php

    error_reporting(E_ALL);

    ini_set('display_errors', 1);

    ini_set('display_startup_errors', 1);

    require_once 'conexao.php';

    $usuario_id =
        $_GET["usuario_id"] ?? '';

    if($usuario_id == ''){

        echo "
            <script>

                alert('Usuário não informado.');

                window.location.href =
                    './usuario_listar.php';

            </script>
        ";

        exit;

    }

    $nome = '';

    $login = '';

    $sql = "
        SELECT
            usuario_id,
            nome,
            login
        FROM tbUsuarios
        WHERE usuario_id = ?
    ";

    $stmt = $conexao->prepare($sql);

    if(!$stmt){

        die(
            "Erro no prepare: " .
            $conexao->error
        );

    }

    $stmt->bind_param(
        "i",
        $usuario_id
    );

    $stmt->execute();

    $stmt->bind_result(
        $idBanco,
        $nome,
        $login
    );

    if(!$stmt->fetch()){

        echo "
            <script>

                alert('Usuário não encontrado.');

                window.location.href =
                    './usuario_listar.php';

            </script>
        ";

        exit;

    }

    $stmt->close();

?>

<body>

    <main id="principal">

        <div class="container">

            <h2>USUARIO - EDITAR</h2>

            <form
                id="formUsuario"
                onsubmit="return false;"
            >

                <button
                    type="button"
                    onclick="voltarPagina()"
                >
                    Voltar
                </button>

                <button
                    type="button"
                    onclick="salvarUsuario()"
                >
                    Gravar
                </button>

                <div>

                    <label for="id">
                        ID
                    </label>

                    <input
                        type="text"
                        id="id"
                        name="pId"
                        readonly
                        value="<?php echo htmlspecialchars($usuario_id); ?>"
                        style="background-color: #e9ecef;"
                    >

                </div>

                <div>

                    <label for="nome">
                        Nome Completo
                    </label>

                    <input
                        type="text"
                        id="nome"
                        name="pNome"
                        value="<?php echo htmlspecialchars($nome); ?>"
                    >

                </div>

                <div>

                    <label for="login">
                        Login
                    </label>

                    <input
                        type="text"
                        id="login"
                        name="pLogin"
                        value="<?php echo htmlspecialchars($login); ?>"
                    >

                </div>

                <div>

                    <label for="senha">
                        Nova Senha
                    </label>

                    <input
                        type="password"
                        id="senha"
                        name="pSenha"
                    >

                </div>

            </form>

        </div>

    </main>

</body>

</html>