/**
 * Created by Kwanzar Soft on 28/08/2020.
 */

var id_db_settings = document.getElementById("id_db_settings").value;
var id_db_kwanzar  = document.getElementById("id_db_kwanzar").value;
var id_user        = document.getElementById("id_user").value;
var level          = document.getElementById("level").value;

function Vinculo(id){
    var capital    = document.getElementById("capital").value;
    var valor      = document.getElementById("valor").value;
    var admissao   = document.getElementById("admissao").value;
    var tipo       = document.getElementById("tipo").value;
    var status     = document.getElementById("status").value;

    if(confirm("Desejas vincular o sócio na empresa?")){
        $.ajax({
            url: './KwanzarApp/SystemApp/RH.inc.php',
            type: 'POST',
            data: "acao=Vinculo"+
            "&id="+id+
            "&capital="+capital+
            "&valor="+valor+
            "&admissao="+admissao+
            "&tipo="+tipo+
            "&status="+status+
            "&level="+level+
            "&id_user="+id_user+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                $("#getResult").html();
            }, success: function(r){
                $("#getResult").html(r);
            }
        });
    }
}

function DeleteSocios(id){
    if(confirm("Desejas deletar o Sócio?")){
        $.ajax({
            url: './KwanzarApp/SystemApp/RH.inc.php',
            type: 'POST',
            data: "acao=DeleteSocios"+
            "&id="+id+
            "&level="+level+
            "&id_user="+id_user+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                $("#getResult").html();
            }, success: function(r){
                $("#getResult").html(r);
            }
        });
    }
}

function Socios(){
    var nome               = document.getElementById("nome").value;
    var nif                = document.getElementById("nif").value;
    var sexo               = document.getElementById("sexo").value;
    var data_nascimento    = document.getElementById("data_nascimento").value;
    var nacionalidade      = document.getElementById("nacionalidade").value;
    var estado_civil       = document.getElementById("estado_civil").value;
    var regime_matrimonial = document.getElementById("regime_matrimonial").value;
    var raca_cor           = document.getElementById("raca_cor").value;
    var dificiencia        = document.getElementById("dificiencia").value;
    var grau_instrucao     = document.getElementById("grau_instrucao").value;
    var nome_pai           = document.getElementById("nome_pai").value;
    var nome_mae           = document.getElementById("nome_mae").value;
    var nome_conjuge       = document.getElementById("nome_conjuge").value;
    var pais_nacionalidade = document.getElementById("pais_nacionalidade").value;
    var herdeiro_legal     = document.getElementById("herdeiro_legal").value;
    var telefone           = document.getElementById("telefone").value;
    var email              = document.getElementById("email").value;
    var endereco           = document.getElementById("endereco").value;
    var profissao          = document.getElementById("profissao").value;
    var descricao          = document.getElementById("descricao").value;

    if(confirm("Desejas Salvar os dados do Sócio?")){
        $.ajax({
            url: './KwanzarApp/SystemApp/RH.inc.php',
            type: 'POST',
            data: "acao=Socios"+
            "&nome="+nome+
            "&nif="+nif+
            "&sexo="+sexo+
            "&data_nascimento="+data_nascimento+
            "&nacionalidade="+nacionalidade+
            "&estado_civil="+estado_civil+
            "&regime_matrimonial="+regime_matrimonial+
            "&raca_cor="+raca_cor+
            "&dificiencia="+dificiencia+
            "&grau_instrucao="+grau_instrucao+
            "&nome_pai="+nome_pai+
            "&nome_mae="+nome_mae+
            "&nome_conjuge="+nome_conjuge+
            "&pais_nacionalidade="+pais_nacionalidade+
            "&herdeiro_legal="+herdeiro_legal+
            "&telefone="+telefone+
            "&email="+email+
            "&endereco="+endereco+
            "&profissao="+profissao+
            "&descricao="+descricao+
            "&level="+level+
            "&id_user="+id_user+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                $("#getResult").html();
            }, success: function(r){
                $("#getResult").html(r);
            }
        });
    }
}

function DeleteGrau(id){
    if(confirm("Desejas deletar o Grau de Instrução?")){
        $.ajax({
            url: './KwanzarApp/SystemApp/RH.inc.php',
            type: 'POST',
            data: "acao=DeleteGrau"+
            "&id="+id+
            "&level="+level+
            "&id_user="+id_user+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                $("#getResult").html();
            }, success: function(r){
                $("#getResult").html(r);
            }
        });
    }
}

function DeleteSubsidios(id){
    if(confirm("Desejas deletar o Subsídio?")){
        $.ajax({
            url: './KwanzarApp/SystemApp/RH.inc.php',
            type: 'POST',
            data: "acao=DeleteSubsidios"+
            "&id="+id+
            "&level="+level+
            "&id_user="+id_user+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                $("#getResult").html();
            }, success: function(r){
                $("#getResult").html(r);
            }
        });
    }
}

function DeleteDescontos(id){
    if(confirm("Desejas deletar o Desconto?")){
        $.ajax({
            url: './KwanzarApp/SystemApp/RH.inc.php',
            type: 'POST',
            data: "acao=DeleteDescontos"+
            "&id="+id+
            "&level="+level+
            "&id_user="+id_user+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                $("#getResult").html();
            }, success: function(r){
                $("#getResult").html(r);
            }
        });
    }
}

function DeleteHorarios(id){
    if(confirm("Desejas deletar o Horário?")){
        $.ajax({
            url: './KwanzarApp/SystemApp/RH.inc.php',
            type: 'POST',
            data: "acao=DeleteHorarios"+
            "&id="+id+
            "&level="+level+
            "&id_user="+id_user+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                $("#getResult").html();
            }, success: function(r){
                $("#getResult").html(r);
            }
        });
    }
}

function Subsidios(){
    if(confirm("Desejas salvar o Subsídio?")){
        var subsidio        = document.getElementById('subsidio').value;
        var descricao       = document.getElementById('descricao').value;

        $.ajax({
            url: './KwanzarApp/SystemApp/RH.inc.php',
            type: 'POST',
            data: "acao=Subsidios"+
            "&subsidio="+subsidio+
            "&descricao="+descricao+
            "&level="+level+
            "&id_user="+id_user+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                $("#getResult").html();
            }, success: function(r){
                $("#getResult").html(r);
            }
        });
    }
}

function Descontos(){
    if(confirm("Desejas salvar o Desconto?")){
        var desconto        = document.getElementById('desconto').value;
        var descricao       = document.getElementById('descricao').value;

        $.ajax({
            url: './KwanzarApp/SystemApp/RH.inc.php',
            type: 'POST',
            data: "acao=Descontos"+
            "&desconto="+desconto+
            "&descricao="+descricao+
            "&level="+level+
            "&id_user="+id_user+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                $("#getResult").html();
            }, success: function(r){
                $("#getResult").html(r);
            }
        });
    }
}

function Horarios(){
    if(confirm("Desejas salvar o Horário?")){
        var horario  = document.getElementById('horario').value;
        var entrada  = document.getElementById('entrada').value;
        var almoco   = document.getElementById('almoco').value;
        var saida    = document.getElementById('saida').value;
        var dias     = document.getElementById('dias').value;

        $.ajax({
            url: './KwanzarApp/SystemApp/RH.inc.php',
            type: 'POST',
            data: "acao=Horarios"+
            "&horario="+horario+
            "&entrada="+entrada+
            "&almoco="+almoco+
            "&saida="+saida+
            "&dias="+dias+
            "&level="+level+
            "&id_user="+id_user+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                $("#getResult").html();
            }, success: function(r){
                $("#getResult").html(r);
            }
        });
    }
}

function Grau(){
    if(confirm("Desejas salvar o Grau de Instrução?")){
        var grau        = document.getElementById('grau').value;
        var observacoes = document.getElementById('observacoes').value;

        $.ajax({
            url: './KwanzarApp/SystemApp/RH.inc.php',
            type: 'POST',
            data: "acao=Grau"+
            "&grau="+grau+
            "&observacoes="+observacoes+
            "&level="+level+
            "&id_user="+id_user+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                $("#getResult").html();
            }, success: function(r){
                $("#getResult").html(r);
            }
        });
    }
}

function DeleteDificiencia(id){
    if(confirm("Desejas deletar a dificiência?")){
        $.ajax({
            url: './KwanzarApp/SystemApp/RH.inc.php',
            type: 'POST',
            data: "acao=DeleteDificiencia"+
            "&id="+id+
            "&level="+level+
            "&id_user="+id_user+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                $("#getResult").html();
            }, success: function(r){
                $("#getResult").html(r);
            }
        });
    }
}

function Dificiencia(){
    if(confirm("Desejas salvar a Dificiência?")){
        var dificiencia = document.getElementById('dificiencia').value;
        var observacoes = document.getElementById('observacoes').value;

        $.ajax({
            url: './KwanzarApp/SystemApp/RH.inc.php',
            type: 'POST',
            data: "acao=Dificiencia"+
            "&dificiencia="+dificiencia+
            "&observacoes="+observacoes+
            "&level="+level+
            "&id_user="+id_user+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                $("#getResult").html();
            }, success: function(r){
                $("#getResult").html(r);
            }
        });
    }
}

function DeleteNacionalidade(id){
    if(confirm("Desejas deletar a nacionalidade?")){
        $.ajax({
            url: './KwanzarApp/SystemApp/RH.inc.php',
            type: 'POST',
            data: "acao=DeleteNacionalidade"+
            "&id="+id+
            "&level="+level+
            "&id_user="+id_user+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                $("#getResult").html();
            }, success: function(r){
                $("#getResult").html(r);
            }
        });
    }
}

function Nacionalidades(){
    if(confirm("Desejas salvar a nacionalidade?")){
        var nacionalidade = document.getElementById('nacionalidade').value;
        var pais          = document.getElementById('pais').value;

        $.ajax({
            url: './KwanzarApp/SystemApp/RH.inc.php',
            type: 'POST',
            data: "acao=Nacionalidades"+
            "&nacionalidade="+nacionalidade+
            "&pais="+pais+
            "&level="+level+
            "&id_user="+id_user+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                $("#getResult").html();
            }, success: function(r){
                $("#getResult").html(r);
            }
        });
    }
}