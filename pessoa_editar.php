<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>

        function salvarPessoa(){

            let vId =
                document.getElementById("id").value;

            let vNome =
                document.getElementById("nome").value;

            let vCpf =
                document.getElementById("cpf").value;

            let vNascimento =
                document.getElementById("nascimento").value;

            let vTelefone =
                document.getElementById("telefone").value;

            if(
                vId.trim() === "" ||
                vNome.trim() === "" ||
                vCpf.trim() === "" ||
                vNascimento.trim() === ""||
                vTelefone.trim() === ""
            ){

                alert(
                    "Preencha todos os campos obrigatórios!"
                );

                return;

            }

            $.ajax({

                url: './acaoPessoa_editar.php',

                type: 'POST',

                dataType: 'json',

                data: {
                    pId: vId,
                    pNome: vNome,
                    pCpf: vCpf,
                    pNascimento: vNascimento,
                    pTelefone: vTelefone
                },

                success: function(data){

                    if(data.status === 'success'){

                        alert(data.message);

                        window.location.href =
                            "pessoa_listar.php";

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
                "./pessoa_listar.php";

        }

    </script>

</head>

<?php

    error_reporting(E_ALL);

    ini_set('display_errors', 1);

    ini_set('display_startup_errors', 1);

    require_once 'conexao.php';

    $pessoa_id =
        $_GET["pessoa_id"] ?? '';

    if($pessoa_id == ''){

        echo "
            <script>

                alert('Usuário não informado.');

                window.location.href =
                    './pessoa_listar.php';

            </script>
        ";

        exit;

    }

    $nome = '';

    $cpf = '';

    $nascimento = '';

    $telefone = '';

    $sql = "
        SELECT
            pessoa_id,
            nome,
            cpf,
            nascimento,
            telefone
        FROM tbPessoas
        WHERE pessoa_id = ?
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
        $pessoa_id
    );

    $stmt->execute();

    $stmt->bind_result(
        $idBanco,
        $nome,
        $cpf,
        $nascimento,
        $telefone
    );

    if(!$stmt->fetch()){

        echo "
            <script>

                alert('Usuário não encontrado.');

                window.location.href =
                    './pessoa_listar.php';

            </script>
        ";

        exit;

    }

    $stmt->close();

?>

<body>

    <main id="principal">

        <div class="container">

            <h2>PESSOA - EDITAR</h2>

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
                    onclick="salvarPessoa()"
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
                        value="<?php echo htmlspecialchars($pessoa_id); ?>"
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

                    <label for="cpf">
                        Cpf
                    </label>

                    <input
                        type="text"
                        id="cpf"
                        name="pCpf"
                        value="<?php echo htmlspecialchars($cpf); ?>"
                    >

                </div>

                <div>

                    <label for="nascimento">
                        Nascimento
                    </label>

                    <input
                        type="date"
                        id="nascimento"
                        name="pNascimento"
                        value="<?php echo htmlspecialchars($nascimento); ?>"
                    >

                </div>

                <div>

                    <label for="telefone">
                        Telefone
                    </label>

                    <input
                        type="text"
                        id="telefone"
                        name="pTelefone"
                        value="<?php echo htmlspecialchars($telefone); ?>"
                    >

                </div>

                

            </form>

        </div>

    </main>

</body>

</html>