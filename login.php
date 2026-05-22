<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SALA+</title>

    <link rel="shortcut icon" href="agendamento.png">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link rel="stylesheet" href="login.css">

    <link rel="stylesheet" href="mobile2.css">

    <script>

        function login_validar(){

            let vLogin = document.getElementById("login").value;
            let vSenha = document.getElementById("senha").value;

            if(
                vLogin.trim() === "" ||
                vSenha.trim() === ""
            ){
                alert("Preencha login e senha");
                return;
            }

            $.ajax({

                type: 'POST',

                url: 'login_validar.php',

                data: {
                    pLogin: vLogin,
                    pSenha: vSenha
                },

                success: function(data){

                    let vRetorno = data.trim();

                    if(vRetorno == "1"){

                        alert("Login válido com sucesso!");

                        window.location.href = "paginaInicial.html";

                    } else {

                        alert("Login inválido");

                    }

                },

                error: function(xhr, status, error){

                    alert(
                        "Erro ao validar login.\n\n" +
                        "Status HTTP: " + xhr.status + "\n" +
                        "Tipo de erro: " + status + "\n" +
                        "Mensagem: " + error + "\n\n" +
                        "Resposta do servidor:\n" + xhr.responseText
                    );

                }

            });

        }

        function cadastro(){

            window.location.href = "usuario_incluir.php";

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

            <form onsubmit="login_validar(); return false;">

                <p>LOGIN</p>

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

                    <button type="submit">

                        Entrar

                    </button>

                    <button
                        type="button"
                        onclick="cadastro()"
                    >

                        Cadastrar-se

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>