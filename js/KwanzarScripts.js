$(document).ready(function(){
    var getResult = $("#getResult"),
        id_db_kwanzar = $('#id_db_kwanzar').val();

    // Login
    $('form[name="FormLockScreen"]').on('submit', function(){
        var Session_id = $('#Session_id').val(),
            pass = $('#pass').val();

        var button = $(this).find(':button');
        button.attr('disabled', true);


        $.ajax({
            url: './KwanzarApp/SystemApp/Configurations.inc.php',
            type: 'POST',
            data: 'acao=FormLockScreen'+
            "&Session_id="+Session_id+
            "&pass="+pass,
            beforeSend: function(){
                button.html('Aguarde...');
            }, success: function(r){
                button.html('Desbloquear').attr('disabled', false);
                getResult.html(r);
            }
        });

        return false;
    });

    $('form[name="FormPassword"]').on('submit', function(){
        var Session_id = $('#Session_id').val(),
            password_atual = $('#password_atual').val(),
            password = $('#password').val(),
            replace_password = $('#replace_password').val();

        var button = $(this).find(':button');
        button.attr('disabled', true);


        $.ajax({
            url: './KwanzarApp/SystemApp/Configurations.inc.php',
            type: 'POST',
            data: 'acao=FormPassword'+
            "&Session_id="+Session_id+
            "&password_atual="+password_atual+
            "&password="+password+
            "&replace_password="+replace_password,
            beforeSend: function(){
                button.html('Aguarde...');
            }, success: function(r){
                button.html('Atualizar senha').attr('disabled', false);
                getResult.html(r);
            }
        });

        return false;
    });

    $('form[name="FormUsersLogin"]').on('submit', function(){
        var user = $('#user').val(),
            pass = $('#pass').val();

        var button = $(this).find(':button');
        button.attr('disabled', true);


        $.ajax({
            url: './KwanzarApp/SystemApp/Configurations.inc.php',
            type: 'POST',
            data: 'acao=Login'+
            "&user="+user+
            "&pass="+pass,
            beforeSend: function(){
                button.html('Aguarde...');
            }, success: function(r){
                button.html('Entrar').attr('disabled', false);
                getResult.html(r);
            }
        });

        return false;
    });
    // Criar contas
        $('form[name="FormCreateAccounting"]').on('submit', function(){
            var name = $('#name').val(),
                username = $('#username').val(),
                password = $("#password").val(),
                replace_password = $('#replace_password').val();

            var button = $(this).find(':button');
            button.attr('disabled', true);

            $.ajax({
                url: './KwanzarApp/SystemApp/Configurations.inc.php',
                type: 'POST',
                data: 'acao=CreateAccounting'+
                    "&name="+name+
                    "&username="+username+
                    "&password="+password+
                    "&replace_password="+replace_password,
                beforeSend: function(){
                    button.html('Aguarde...');
                }, success: function(r){
                    button.html('Crie tua conta Kwanzar').attr('disabled', false);
                    getResult.html(r);
                }
            });

            return false;
        });

        $('#username').keyup(function(){
            var keyuping = $(this).val(),
                OhGod = $('#OhGod');

            if(keyuping != ''){
                $.post('./KwanzarApp/SystemApp/Configurations.inc.php', {
                    acao: 'username',
                    username: keyuping
                }, function(ret){
                    OhGod.html(ret);
                });
            }else{
                OhGod.html('');
            }
        });

        $('#password').keyup(function(){
            var keyuping = $(this).val(),
                OhGod = $('#pass');

            if(keyuping != ''){
                $.post('./KwanzarApp/SystemApp/Configurations.inc.php', {
                    acao: 'password',
                    password: keyuping
                }, function(ret){
                    OhGod.html(ret);
                });
            }else{
                OhGod.html('');
            }
        });

        $('#replace_password').keyup(function(){
            var keyuping = $(this).val(),
                password = $('#password').val(),
                OhGod = $('#novinho');

            if(keyuping != ''){
                $.post('./KwanzarApp/SystemApp/Configurations.inc.php', {
                    acao: 'replace_password',
                    replace_password: keyuping,
                    password: password
                }, function(ret){
                    OhGod.html(ret);
                });
            }else{
                OhGod.html('');
            }
        });

    // Envio de E-mail's para suporte
        $('form[name="FormSendEmail"]').on('submit', function(){
            var RemetenteName = $('#RemetenteName').val(),
                RemetenteEmail = $('#RemetenteEmail').val(),
                RemetenteAssunto = $('#RemetenteAssunto').val(),
                RemetenteMensagem = $("#RemetenteMensagem").val();

            var button = $(this).find(':button');
            button.attr('disabled', true);


            $.ajax({
                url: './KwanzarApp/SystemApp/Configurations.inc.php',
                type: 'POST',
                data: 'acao=SendEmail'+
                "&RemetenteName="+RemetenteName+
                "&RemetenteEmail="+RemetenteEmail+
                "&RemetenteAssunto="+RemetenteAssunto+
                "&RemetenteMensagem="+RemetenteMensagem,
                beforeSend: function(){
                    button.html('Aguarde...');
                }, success: function(r){
                    button.html('Enviar agora').attr('disabled', false);
                    getResult.html(r);
                }
            });

            return false;
        });

        // Verificar se o campo foi devidamente prenchido
        $('#RemetenteEmail').keyup(function(){
            var keyuping = $(this).val(),
                OhGod = $('#OhGod');

            if(keyuping != ''){
                $.post('./KwanzarApp/SystemApp/Configurations.inc.php', {
                    acao: 'RemetenteEmail',
                    RemetenteEmail: keyuping
                }, function(ret){
                    OhGod.html(ret);
                    //var stay = $('form[name="FormSendEmail"]').find(':button');
                    //stay.attr('disabled', true);
                });
            }
        });
    /** Registro de empresas **/
    var atual_fs, next_fs, prev_fs;

    $('.next').click(function(){
        atual_fs = $(this).parent();
        next_fs = $(this).parent().next();

        $('#progress li').eq($('fieldset').index(next_fs)).addClass('ativo');
        atual_fs.hide(800);
        next_fs.show(800);
    });

    $('.prev').click(function(){
        atual_fs = $(this).parent();
        prev_fs = $(this).parent().prev();

        $('#progress li').eq($('fieldset').index(atual_fs)).removeClass('ativo');
        atual_fs.hide(800);
        prev_fs.show(800);
    });

    $('#formulario input[type="submit"]').click(function(){
        return false;
    });

    // Registro de usuários e empresa.
    $('form[name="form_register"]').on('submit', function(){
        var botao = $(this).find(':button');

        //var forma = $(this).serialize();
        var empresa = $('#empresa').val(),
            nif = $("#nif").val(),
            telefone = $("#telefone").val(),
            website = $("#website").val(),
            email = $("#email").val(),
            endereco = $("#endereco").val(),
            addressDetail = $("#addressDetail").val(),
            city = $("#city").val(),
            BuildingNumber = $("#BuildingNumber").val(),
            country = $("#country").val(),
            taxEntity = $("#taxEntity").val(),
            typeVenda = $("#typeVenda").val(),
            atividade = $("#atividade").val();

        $.ajax({
            url: "./KwanzarApp/SystemApp/Configurations.inc.php",
            type: "POST",
            data: "acao=Settings"+
            "&id_db_kwanzar="+id_db_kwanzar+
            "&empresa="+empresa+
            "&nif="+nif+
            "&telefone="+telefone+
            "&website="+website+
            "&email="+email+
            "&endereco="+endereco+
            "&addressDetail="+addressDetail+
            "&city="+city+
            "&BuildingNumber="+BuildingNumber+
            "&country="+country+
            "&taxEntity="+taxEntity+
            "&typeVenda="+typeVenda+
            "&atividade="+atividade,
            beforeSend: function(){
                botao.html('Aguarde...').attr('disabled', true);
            }, success: function(retorno){
                botao.attr('disabled', false).html('Finalizar');
                getResult.html(retorno);
            }
        });

        return false;
    });

    $('#empresa').keyup(function(){
        var keyuping = $(this).val();

        if(keyuping != ''){
            $.post('./KwanzarApp/SystemApp/Configurations.inc.php', {
                acao: 'empresa',
                id_db_kwanzar: id_db_kwanzar,
                empresa: keyuping
            }, function(ret){
                getResult.html(ret);
            });
        }else{
            OhGod.html('');
        }
    });

    $('#nif').keyup(function(){
        var keyuping = $(this).val();

        if(keyuping != ''){
            $.post('./KwanzarApp/SystemApp/Configurations.inc.php', {
                acao: 'nif',
                id_db_kwanzar: id_db_kwanzar,
                nif: keyuping
            }, function(ret){
                getResult.html(ret);
            });
        }else{
            OhGod.html('');
        }
    });
});

function TudoQueEuSou(){
    var username = document.getElementById('username').value;
    var PRecuvaPassword = document.getElementById('PRecuvaPassword').value;
    var pw0 = document.getElementById('pw0').value;
    var password = document.getElementById('password').value;
    var replace_password = document.getElementById('replace_password').value;

    $.post('./KwanzarApp/SystemApp/Configurations.inc.php', {
        acao: 'RecuvaPassword',
        username: username,
        PRecuvaPassword: PRecuvaPassword,
        pw0: pw0,
        password: password,
        replace_password: replace_password
    }, function(ret){
        $("#getResult").html(ret);
    });
}

function Suspanse(id){
    if(confirm('Confirme a suspensão/activação do cPanel!')){
        $.post('./KwanzarApp/SystemApp/Configurations.inc.php', {
            acao: 'Suspanse',
            id: id
        }, function(ret){
            $("#getResult").html(ret);
        });
    }
}

function SettingsTransfer(){
    var IDcPanel  = document.getElementById("IDcPanel").value;
    var IDEmpresa = document.getElementById("IDEmpresa").value;

    if(IDcPanel == ''){
        alert("Ops: preencha todos os campos!");
        document.getElementById('IDcPanel').focus();
        return false;
    }

    if(IDEmpresa == ''){
        alert("Ops: preencha todos os campos!");
        document.getElementById('IDEmpresa').focus();
        return false;
    }

    if(isNaN(IDcPanel)){
        alert('Ops: Todos so campos tem que ser preenchidos com números!');
        document.getElementById('IDcPanel').focus();
        return false;
    }

    if(isNaN(IDEmpresa)){
        alert('Ops: Todos so campos tem que ser preenchidos com números!');
        document.getElementById('IDEmpresa').focus();
        return false;
    }

    if(confirm("Desejas transferir a empresa ID: "+IDEmpresa+" para o cPanel ID: "+IDcPanel+"?")){
        $.post('./KwanzarApp/SystemApp/Configurations.inc.php', {
            acao: 'SettingsTransfer',
            IDEmpresa: IDEmpresa,
            IDcPanel: IDcPanel
        }, function(ret){
            $("#getError").html(ret);
        });
    }
}

function MyXpassword() {
    var x = document.getElementById("pass");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}