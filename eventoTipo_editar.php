<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>

        function salvarEvento(){

            let vId =
                document.getElementById("id").value;

            let vNome =
                document.getElementById("nome").value;

            if(
                vId.trim() === "" ||
                vNome.trim() === "" 
            ){

                alert(
                    "Preencha todos os campos obrigatórios!"
                );

                return;

            }

            $.ajax({

                url: './acaoEventoTipo_editar.php',

                type: 'POST',

                dataType: 'json',

                data: {
                    pId: vId,
                    pNome: vNome
                },

                success: function(data){

                    if(data.status === 'success'){

                        alert(data.message);

                        window.location.href =
                            "eventoTipo_listar.php";

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
                "./eventoTipo_listar.php";

        }

    </script>

</head>

<?php

    error_reporting(E_ALL);

    ini_set('display_errors', 1);

    ini_set('display_startup_errors', 1);

    require_once 'conexao.php';

    $evento_tipo_id =
        $_GET["evento_tipo_id"] ?? '';

    if($evento_tipo_id== ''){

        echo "
            <script>

                alert('Evento não informado.');

                window.location.href =
                    './evento_tipo_listar.php';

            </script>
        ";

        exit;

    }

    $nome = '';

    $sql = "
        SELECT
            evento_tipo_id,
            nome
        FROM tbEventoTipo
        WHERE evento_tipo_id = ?
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
        $evento_tipo_id
    );

    $stmt->execute();

    $stmt->bind_result(
        $idBanco,
        $nome
    );

    if(!$stmt->fetch()){

        echo "
            <script>

                alert('Evento não encontrado.');

                window.location.href =
                    './evento_tipo_listar.php';

            </script>
        ";

        exit;

    }

    $stmt->close();

?>

<body>

    <main id="principal">

        <div class="container">

            <h2>NOME EVENTO - EDITAR</h2>

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
                    onclick="salvarEvento()"
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
                        value="<?php echo htmlspecialchars($evento_tipo_id); ?>"
                        style="background-color: #e9ecef;"
                    >

                </div>

                <div>

                    <label for="nome">
                        Nome do Evento
                    </label>

                    <input
                        type="text"
                        id="nome"
                        name="pNome"
                        value="<?php echo htmlspecialchars($nome); ?>"
                    >

                </div>                

            </form>

        </div>

    </main>

</body>

</html>