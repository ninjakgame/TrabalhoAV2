<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastro</title>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>

        function salvarEvento(){

            let vNome = document.getElementById("nome").value;

            if(
                vNome.trim() === "" 
            ){
                alert("Preencha todos os campos!");
                return;
            }

            $.ajax({

                url: './acaoEventoTipo_incluir.php',

                type: 'POST',

                dataType: 'json',

                data: {
                    pNome: vNome
                },

                success: function(data){

                    if(data.status === "success"){

                        alert(data.message);

                        document.getElementById("formulario").reset();

                        window.location.href = "./eventoTipo_listar.php";

                    } else {

                        alert(data.message);

                    }

                },

                error: function(jqXHR, textStatus, errorThrown){

                    alert(
                        "Erro na requisição:\n\n" +
                        textStatus + "\n" +
                        errorThrown
                    );

                    console.log(jqXHR.responseText);

                }

            });

        }

        function voltarPagina(){

            window.location.href = "./eventoTipo_listar.php";

        }

    </script>

</head>

<body>

<div class="container">

    <div class="containerConteudo">

        <div class="conteudo">

            <form id="formulario" onsubmit="return false;">

                <p>CADASTRO DE EVENTOS</p>

                <input
                    type="text"
                    id="nome"
                    required
                    placeholder="nome"
                >

                <div class="bot">

                    <button
                        type="button"
                        onclick="salvarEvento()"
                    >
                        Cadastrar
                    </button>

                    <button
                        type="button"
                        onclick="voltarPagina()"
                    >
                        Voltar
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>