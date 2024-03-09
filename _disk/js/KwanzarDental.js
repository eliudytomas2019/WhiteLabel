$(document).ready(function (){
    var getResult = $("#getResult"),
        id_db_settings = $("#id_db_settings").val(),
        level = $("#level").val(),
        id_user = $("#id_user").val(),
        id_db_kwanzar = $('#id_db_kwanzar').val(),
        id_event_schudule = $('#id_event_schudule').val();

    $('body').on('keyup', '#searchProcedimentos', function(r){
        var txt = $(this).val(),
            id_db_kwanzar = $('#id_db_kwanzar').val(),
            level = $('#level').val(),
            id_db_settings = $('#id_db_settings').val();

        if(txt != ''){
            $.ajax({
                url: "./_disk/SystemClinic/Dental.inc.php",
                type: "POST",
                data: "acao=searchProcedimentos"+
                    "&value="+txt+
                    "&level="+level+
                    "&id_user="+id_user+
                    "&id_db_kwanzar="+id_db_kwanzar+
                    "&id_db_settings="+id_db_settings,
                success: function(r){
                    $("#TheBox").html(r);
                }
            });
        }
    });

    if(id_event_schudule != ''){
        $.ajax({
            url: './_disk/SystemClinic/Dental.inc.php',
            type: 'POST',
            data: 'acao=id_event_schudule'+
                "&id_event_schudule="+id_event_schudule+
                "&level="+level+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
            success: function(r){
                $("#ProlenBeats").html(r);
            }
        });
    }

    $("body").on('keyup', '#SearchUsersX', function () {
        var value = $(this).val();

        if(value != ''){
            $.ajax({
                url: './_disk/SystemClinic/Dental.inc.php',
                type: 'POST',
                data: 'acao=SearchUsersX'+
                    "&value="+value+
                    "&id_db_kwanzar="+id_db_kwanzar+
                    "&id_db_settings="+id_db_settings,
                success: function(r){
                    $("#King2Da").html(r);
                }
            });
        }
    });

    $("body").on('keyup', '#searchPacientes', function () {
        var value = $(this).val();

        if(value != ''){
            $.ajax({
                url: './_disk/SystemClinic/Dental.inc.php',
                type: 'POST',
                data: 'acao=searchPacientes'+
                    "&value="+value+
                    "&level="+level+
                    "&id_user="+id_user+
                    "&id_db_kwanzar="+id_db_kwanzar+
                    "&id_db_settings="+id_db_settings,
                success: function(r){
                    $("#TheBox").html(r);
                }
            });
        }
    });

    $("body").on('keyup', '#searchProductx', function () {
        var value = $(this).val();

        if(value != ''){
            $.ajax({
                url: './_disk/SystemClinic/Dental.inc.php',
                type: 'POST',
                data: 'acao=searchProductx'+
                    "&value="+value+
                    "&level="+level+
                    "&id_user="+id_user+
                    "&id_db_kwanzar="+id_db_kwanzar+
                    "&id_db_settings="+id_db_settings,
                success: function(r){
                    $("#DaSo").html(r);
                }
            });
        }
    });
});

function ClinicHorario(id_userX, id_db_settings){
    var
        hora_f    = $('#hora_f').val(),
        hora_i    = $('#hora_i').val(),
        dia_da_semana     = $('#dia_da_semana').val();

    $.ajax({
        url: "./_disk/SystemClinic/Dental.inc.php",
        type: "POST",
        data: "acao=ClinicHorario"+
            "&hora_f="+hora_f+
            "&hora_i="+hora_i+
            "&dia_da_semana="+dia_da_semana+
            "&id_user="+id_userX+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            $('#getResult2023').html(r);
            ReadHorario(id_userX, id_db_settings);
        }
    });

    return false;
}

function ReadHorario(id_userX, id_db_settings){
    $.ajax({
        url: "./_disk/SystemClinic/Dental.inc.php",
        type: "POST",
        data: "acao=ReadHorario"+
            "&id_user="+id_userX+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#TheBox').html(f);
        }
    });

    return false;
}

function DeleteHorario(id, id_userX){
    var id_db_settings = document.getElementById('id_db_settings').value;

    if(confirm('Tem certeza que deseja apagar este arquivo?')){
        $.ajax({
            url: "./_disk/SystemClinic/Dental.inc.php",
            type: "POST",
            data: "acao=DeleteHorario"+
                "&id="+id+
                "&id_user="+id_userX+
                "&id_db_settings="+id_db_settings,
            success: function(r){
                $('#getResult').html(r);
                ReadHorario(id_userX, id_db_settings);
            }
        });
    }

    return false;
}

function DeletePorcentagem(id){
    var id_db_settings = document.getElementById('id_db_settings').value;

    if(confirm('Tem certeza que deseja apagar este arquivo?')){
        $.ajax({
            url: "./_disk/SystemClinic/Dental.inc.php",
            type: "POST",
            data: "acao=DeletePorcentagem"+
                "&id="+id+
                "&id_db_settings="+id_db_settings,
            success: function(r){
                $('#getResult').html(r);
                ReadGanhos(id_db_settings);
            }
        });
    }

    return false;
}

function ClinicHorarioUpdate(id_user, id_db_settings, postId){
    var
        hora_f    = $('#hora_f').val(),
        hora_i    = $('#hora_i').val(),
        dia_da_semana     = $('#dia_da_semana').val();

    $.ajax({
        url: "./_disk/SystemClinic/Dental.inc.php",
        type: "POST",
        data: "acao=ClinicHorarioUpdate"+
            "&hora_f="+hora_f+
            "&hora_i="+hora_i+
            "&dia_da_semana="+dia_da_semana+
            "&id_user="+id_user+
            "&postId="+postId+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            $('#getResult').html(r);
        }
    });

    return false;
}

function PorcentagemGanhos(){
    var porcentagem = document.getElementById('porcentagem').value;
    var id_user = document.getElementById('id_userx').value;
    var id_db_settings = document.getElementById('id_db_settings').value;

    $.ajax({
        url: "./_disk/SystemClinic/Dental.inc.php",
        type: "POST",
        data: "acao=PorcentagemGanhos"+
            "&id_user="+id_user+
            "&porcentagem="+porcentagem+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            $('#getResult').html(r);
            ReadGanhos(id_db_settings);
        }
    });

    return false;
}

function ReadGanhos(id_db_settings){
    $.ajax({
        url: "./_disk/SystemClinic/Dental.inc.php",
        type: "POST",
        data: "acao=ReadGanhos"+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#TheBox').html(f);
        }
    });

    return false;
}

function SalvePaciente(){
    var nome = document.getElementById('nome').value;
    var nif = document.getElementById('nif').value;
    var telefone = document.getElementById('telefone').value;
    var email = document.getElementById('email').value;
    var endereco = document.getElementById('endereco').value;

    var level = document.getElementById('level').value;
    var id_db_settings = document.getElementById('id_db_settings').value;

    $.ajax({
        url: "./_disk/SystemClinic/Dental.inc.php",
        type: "POST",
        data: "acao=SalvePaciente"+
            "&nome="+nome+
            "&nif="+nif+
            "&telefone="+telefone+
            "&email="+email+
            "&endereco="+endereco+
            "&level="+level+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            $('#Kialumingo').html(r);
            ReadPacientes(id_db_settings, level);
        }
    });

    return false;
}

function ReadPacientes(id_db_settings, level){
    $.ajax({
        url: "./_disk/SystemClinic/Dental.inc.php",
        type: "POST",
        data: "acao=ReadPacientes"+
            "&level="+level+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#TheBox').html(f);
        }
    });

    return false;
}

function DeletePaciente(id){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_db_kwanzar = document.getElementById('id_db_kwanzar').value;
    var level = document.getElementById('level');

    if(confirm('Desejas apagar a ficha do paciente selecionado?')){
        $.ajax({
            url: "./_disk/SystemClinic/Dental.inc.php",
            type: "POST",
            data: "acao=DeletePaciente"+
                "&id="+id+
                "&level="+level+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
            success: function(result){
                $("#eTomas").html(result);
                ReadPacientes(id_db_settings, level);
            }
        });
    }
}

function CreateSchedule(){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_db_kwanzar = document.getElementById('id_db_kwanzar').value;
    var level = document.getElementById('level');


    var date_schedule = document.getElementById('date_schedule').value;
    var hora_i_schedule = document.getElementById('hora_i_schedule').value;
    var hora_f_schedule = document.getElementById('hora_f_schedule').value;
    var content_schedule = document.getElementById('content_schedule').value;
    var status_schedule = document.getElementById('status_schedule').value;
    var id_medico = document.getElementById('id_medico').value;
    var id_paciente = document.getElementById('id_paciente').value;

    $.ajax({
        url: "./_disk/SystemClinic/Dental.inc.php",
        type: "POST",
        data: "acao=CreateSchedule"+
            "&date_schedule="+date_schedule+
            "&hora_i_schedule="+hora_i_schedule+
            "&hora_f_schedule="+hora_f_schedule+
            "&content_schedule="+content_schedule+
            "&status_schedule="+status_schedule+
            "&id_medico="+id_medico+
            "&id_paciente="+id_paciente+
            "&level="+level+
            "&id_db_kwanzar="+id_db_kwanzar+
            "&id_db_settings="+id_db_settings,
        success: function(result){
            $("#getResult").html(result);
        }
    });
}

function eventClickSchudule(id){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_db_kwanzar = document.getElementById('id_db_kwanzar').value;
    var level = document.getElementById('level');

    $.ajax({
        url: './_disk/SystemClinic/Dental.inc.php',
        type: 'POST',
        data: 'acao=id_event_schudule'+
            "&id_event_schudule="+id+
            "&level="+level+
            "&id_db_kwanzar="+id_db_kwanzar+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            $("#ProlenBeats").html(r);
        }
    });
}

function UpdateSchedule(id_event_schudule){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_db_kwanzar = document.getElementById('id_db_kwanzar').value;
    var level = document.getElementById('level');


    var date_schedule = document.getElementById('date_schedule').value;
    var hora_i_schedule = document.getElementById('hora_i_schedule').value;
    var hora_f_schedule = document.getElementById('hora_f_schedule').value;
    var content_schedule = document.getElementById('content_schedule').value;
    var status_schedule = document.getElementById('status_schedule').value;
    var id_medico = document.getElementById('id_medico').value;
    var id_paciente = document.getElementById('id_paciente').value;

    $.ajax({
        url: "./_disk/SystemClinic/Dental.inc.php",
        type: "POST",
        data: "acao=UpdateSchedule"+
            "&postId="+id_event_schudule+
            "&date_schedule="+date_schedule+
            "&hora_i_schedule="+hora_i_schedule+
            "&hora_f_schedule="+hora_f_schedule+
            "&content_schedule="+content_schedule+
            "&status_schedule="+status_schedule+
            "&id_medico="+id_medico+
            "&id_paciente="+id_paciente+
            "&level="+level+
            "&id_db_kwanzar="+id_db_kwanzar+
            "&id_db_settings="+id_db_settings,
        success: function(result){
            $("#getResult").html(result);
        }
    });
}

function DeleteArquivo(id_paciente, id){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_db_kwanzar = document.getElementById('id_db_kwanzar').value;
    var level = document.getElementById('level');

    if(confirm('Desejas apagar o ficheiro selecionado?')){
        $.ajax({
            url: "./_disk/SystemClinic/Dental.inc.php",
            type: "POST",
            data: "acao=DeleteArquivo"+
                "&id="+id+
                "&level="+level+
                "&id_paciente="+id_paciente+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
            success: function(result){
                $("#eTomas").html(result);
                ReadArquivo(id_db_settings, level, id_paciente);
            }
        });
    }
}

function ReadArquivo(id_db_settings, level, id_paciente){
    $.ajax({
        url: "./_disk/SystemClinic/Dental.inc.php",
        type: "POST",
        data: "acao=ReadArquivo"+
            "&level="+level+
            "&id_paciente="+id_paciente+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#TheBox').html(f);
        }
    });

    return false;
}

function DeleteProcedimento(id){
    var id_db_settings = document.getElementById('id_db_settings').value;

    if(confirm('Tem certeza que deseja apagar este procedimento?')){
        $.ajax({
            url: "./_disk/SystemClinic/Dental.inc.php",
            type: "POST",
            data: "acao=DeleteProcedimento"+
                "&postId="+id+
                "&id_db_settings="+id_db_settings,
            success: function(r){
                $('#getResult').html(r);
                ReadProcedimentos(id_db_settings);
            }
        });
    }

    return false;
}

function ReadProcedimentos(id_db_settings){
    $.ajax({
        url: "./_disk/SystemClinic/Dental.inc.php",
        type: "POST",
        data: "acao=ReadProcedimentos"+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#TheBox').html(f);
        }
    });

    return false;
}

function Marmelada(id, id_paciente){
    var id_db_settings = document.getElementById('id_db_settings').value;

    $.ajax({
        url: "./_disk/SystemClinic/Dental.inc.php",
        type: "POST",
        data: "acao=Marmelada"+
            "&id="+id+
            "&id_paciente="+id_paciente+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#IrmaosAlmeida').html(f);
        }
    });

    return false;
}

function Guilheirmina(id, id_paciente){
    var id_db_settings = document.getElementById('id_db_settings').value;

    var status = document.getElementById('status').value;
    var content = document.getElementById('content').value;

    $.ajax({
        url: "./_disk/SystemClinic/Dental.inc.php",
        type: "POST",
        data: "acao=IrmaosAlmeida"+
            "&id="+id+
            "&status="+status+
            "&content="+content+
            "&id_paciente="+id_paciente+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#getResult').html(f);
            ReadGulheirmina(id_paciente, id_db_settings);
        }
    });

    return false;
}

function ReadGulheirmina(id_paciente, id_db_settings){
    $.ajax({
        url: "./_disk/SystemClinic/Dental.inc.php",
        type: "POST",
        data: "acao=ReadGulheirmina"+
            "&id_paciente="+id_paciente+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#Gulheirmina').html(f);
        }
    });

    return false;
}

function Tratamento(id_paciente, id_user, id_db_settings){
    var content_data = document.getElementById('content_data').value;
    var dente = document.getElementById('dente').value;
    var face = document.getElementById('face').value;
    var id_procedimento = document.getElementById('id_procedimento').value;
    var data = document.getElementById('data').value;
    var hora = document.getElementById('hora').value;

    $.ajax({
        url: "./_disk/SystemClinic/Dental.inc.php",
        type: "POST",
        data: "acao=Tratamento"+
            "&content_data="+content_data+
            "&dente="+dente+
            "&face="+face+
            "&id_procedimento="+id_procedimento+
            "&hora="+hora+
            "&data="+data+
            "&id_user="+id_user+
            "&id_paciente="+id_paciente+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#TiPaulito').html(f);
            ReadTratamento(id_paciente, id_db_settings);
            ReadGulheirmina(id_paciente, id_db_settings);
        }
    });

    return false;
}

function ReadTratamento(id_paciente, id_db_settings){
    $.ajax({
        url: "./_disk/SystemClinic/Dental.inc.php",
        type: "POST",
        data: "acao=ReadTratamento"+
            "&id_paciente="+id_paciente+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#OFilme').html(f);
        }
    });

    return false;
}

function DeleteTratamento(id, id_paciente, id_db_settings){
    if(confirm('Tem certeza que deseja apagar este tratamento?')){
        $.ajax({
            url: "./_disk/SystemClinic/Dental.inc.php",
            type: "POST",
            data: "acao=DeleteTratamento"+
                "&id="+id+
                "&id_paciente="+id_paciente+
                "&id_db_settings="+id_db_settings,
            success: function(r){
                $('#TiPaulito').html(r);
                ReadTratamento(id_paciente, id_db_settings);
                ReadGulheirmina(id_paciente, id_db_settings);
            }
        });
    }

    return false;
}

function FinalizarTratamento(id, id_paciente, id_db_settings){
    if(confirm('Tem certeza que deseja finalizar o tratamento?')){
        $.ajax({
            url: "./_disk/SystemClinic/Dental.inc.php",
            type: "POST",
            data: "acao=FinalizarTratamento"+
                "&id="+id+
                "&id_paciente="+id_paciente+
                "&id_db_settings="+id_db_settings,
            success: function(r){
                $('#TiPaulito').html(r);
                ReadTratamento(id_paciente, id_db_settings);
                ReadGulheirmina(id_paciente, id_db_settings);
            }
        });
    }

    return false;
}

function KwanzarDentalDocs(){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user = document.getElementById('id_user').value;
    var dateI = document.getElementById('dateI').value;
    var dateF = document.getElementById('dateF').value;
    var users_id_x = document.getElementById('users_id_x').value;
    var moviment_x = document.getElementById('moviment_x').value;
    var product_x = document.getElementById('product_x').value;

    $.ajax({
        url: "./KwanzarApp/AppData/KwanzarDentalDocs.php",
        type: "POST",
        data: "acao=DocumentPdv"+
            "&id_db_settings="+id_db_settings+
            "&id_user="+id_user+
            "&moviment_x="+moviment_x+
            "&users_id_x="+users_id_x+
            "&product_x="+product_x+
            "&dateI="+dateI+
            "&dateF="+dateF,
        beforeSend: function(object){
            $("#getResult").html("Mensagem: "+object);
        }, success: function(r){
            $("#getResult").html(r);
        }
    });
}