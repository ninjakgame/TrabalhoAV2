<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastro</title>

    <link rel="stylesheet" href="cadastro.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>

        function salvarUsuario(){

            let vNome = document.getElementById("nome").value;
            let vLogin = document.getElementById("login").value;
            let vSenha = document.getElementById("senha").value;

            if(
                vNome.trim() === "" ||
                vLogin.trim() === "" ||
                vSenha.trim() === ""
            ){
                alert("Preencha todos os campos!");
                return;
            }

            $.ajax({

                url: 'acao_incluir.php',

                type: 'POST',

                dataType: 'json',

                data: {
                    pNome: vNome,
                    pLogin: vLogin,
                    pSenha: vSenha
                },

                success: function(data){

                    if(data.status === "success"){

                        alert(data.message);

                        document.getElementById("formulario").reset();

                        window.location.href = "login.php";

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

            window.location.href = "login.php";

        }

    </script>

</head>

<body>

<div class="container">

    <div class="containerConteudo">

        <div class="imagem">

            <img src="image 11.jpg" id="imagemLogin">

        </div>

        <div class="conteudo">

            <form id="formulario" onsubmit="return false;">

                <p>CADASTRO</p>

                <input
                    type="text"
                    id="nome"
                    required
                    placeholder="Usuário"
                >

                <input
                    type="text"
                    id="login"
                    required
                    placeholder="Login"
                >

                <input
                    type="password"
                    id="senha"
                    required
                    placeholder="Senha"
                >

                <div class="bot">

                    <button
                        type="button"
                        onclick="salvarUsuario()"
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