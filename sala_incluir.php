<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastro</title>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>

        function salvarSala(){

            let vNumero = document.getElementById("numero").value;

            if(
                vNumero.trim() === "" 
            ){
                alert("Preencha todos os campos!");
                return;
            }

            $.ajax({

                url: './acaoSala_incluir.php',

                type: 'POST',

                dataType: 'json',

                data: {
                    pNumero: vNumero
                },

                success: function(data){

                    if(data.status === "success"){

                        alert(data.message);

                        document.getElementById("formulario").reset();

                        window.location.href = "./sala_listar.php";

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

            window.location.href = "./sala_listar.php";

        }

    </script>

</head>

<body>

<div class="container">

    <div class="containerConteudo">

        <div class="conteudo">

            <form id="formulario" onsubmit="return false;">

                <p>CADASTRO DE SALAS</p>

                <input
                    type="number"
                    id="numero"
                    required
                    placeholder="numero"
                >

                <div class="bot">

                    <button
                        type="button"
                        onclick="salvarSala()"
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