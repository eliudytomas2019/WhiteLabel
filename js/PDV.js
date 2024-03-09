/**
 * Created by Kwanzar Soft on 12/08/2020.
 */

$(document).ready(function(){
    $('body').on('keyup', "#valuePagou", function(){
        var valueTotal = $('#valueTotal').attr("data-file"),
            valuePagou = $(this).val();

        var id_mesa        = $('#id_mesa').val(),
            id_db_settings = $("#id_db_settings").val(),
            id_db_kwanzar  = $("#id_db_kwanzar").val(),
            id_user        = $('#id_user').val();

        $.ajax({
            url: "./KwanzarApp/SystemApp/PDV.inc.php",
            type: "POST",
            data: "acao=valuePagou"+
            "&valueTotal="+valueTotal+
            "&valuePagou="+valuePagou+
            "&id_user="+id_user+
            "&id_mesa="+id_mesa+
            "&id_db_kwanzar="+id_db_kwanzar+
            "&id_db_settings="+id_db_settings,
            success: function(eu){
                $('#valueTroco').val(eu);
            }
        });
    });

    $('body').on('keyup', ".Qtds", function(e){
        if(e.which == 13){
            var id_mesa        = $('#id_mesa').val(),
                id_db_settings = $("#id_db_settings").val(),
                id_db_kwanzar  = $("#id_db_kwanzar").val(),
                id_user        = $('#id_user').val(),
                level          = $("#level").val();

            var value = $(this).val();
            var id    = $(this).attr('data-file');

            $.ajax({
                url: "./KwanzarApp/SystemApp/PDV.inc.php",
                type: "POST",
                data: "acao=Qtds"+
                "&level="+level+
                "&value="+value+
                "&id="+id+
                "&id_user="+id_user+
                "&id_mesa="+id_mesa+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
                success: function(r){
                    $.ajax({
                        url: "./KwanzarApp/SystemApp/PDV.inc.php",
                        type: "POST",
                        data: "acao=MesaInfo"+
                        "&level="+level+
                        "&id_db_settings="+id_db_settings+
                        "&id_mesa="+id_mesa+
                        "&id_user="+id_user,
                        success: function(eu){
                            $('.MyGod').html(eu);
                        }
                    });
                }
            });
        }
        return false;
    });

    $('body').on('keyup', "#Down", function(){
        var value = $(this).val(),
            level = $("#level").val();

        var id_mesa        = $('#id_mesa').val(),
            id_db_settings = $("#id_db_settings").val(),
            id_db_kwanzar  = $("#id_db_kwanzar").val(),
            id_user        = $('#id_user').val();

        $.ajax({
            url: "./KwanzarApp/SystemApp/PDV.inc.php",
            type: "POST",
            data: "acao=Down"+
            "&level="+level+
            "&value="+value+
            "&id_user="+id_user+
            "&id_mesa="+id_mesa+
            "&id_db_kwanzar="+id_db_kwanzar+
            "&id_db_settings="+id_db_settings,
            success: function(r){
                $('#AllMyAll').html(r);
            }
        });

        return false;
    });

    $('body').on('click', '.lightbox', function(){
        $('.background, .my-modal').css('display', 'block');
        $('.background, .my-modal').animate({"opacity":'.60'}, 500, 'linear');
        $('.background, .my-modal').animate({"opacity":'1.00'}, 500, 'linear');
    });

    $('body').on('click', '.dificil', function(){
        $('.background, .believer').css('display', 'block');
        $('.background, .believer').animate({"opacity":'.60'}, 500, 'linear');
        $('.background, .believer').animate({"opacity":'1.00'}, 500, 'linear');
    });

    $('body').on('click', '.close_header', function(){
        $('.background, .my-modal, .believer').animate({'opacity':'0'}, 500, 'linear', function(){
            $('.background, .my-modal, .believer').css('display', 'none');
        });
    });
});

function FinishPDV(id_db_settings, id_user, id_mesa){
    var level                = document.getElementById('level').value;
    var TaxPointDate         = document.getElementById('TaxPointDate').value;
    var id_customer          = document.getElementById('customer').value;
    var InvoiceType          = document.getElementById('InvoiceType').value;
    var method               = document.getElementById('method').value;
    var settings_desc_financ = document.getElementById('settings_desc_financ').value;
    var id_garcom            = document.getElementById('id_garcom').value;
    var troco                = document.getElementById('valueTroco').value;
    var pagou                = document.getElementById('valuePagou').value;

    if(confirm("Desejas finalizar a venda?")){
        $.ajax({
            url: "./KwanzarApp/SystemApp/PDV.inc.php",
            type: "POST",
            data: "acao=FinishPDV"+
            "&level="+level+
            "&TaxPointDate="+TaxPointDate+
            "&id_customer="+id_customer+
            "&InvoiceType="+InvoiceType+
            "&method="+method+
            "&settings_desc_financ="+settings_desc_financ+
            "&id_garcom="+id_garcom+
            "&troco="+troco+
            "&pagou="+pagou+
            "&id_db_settings="+id_db_settings+
            "&id_mesa="+id_mesa+
            "&id_user="+id_user,
            success: function(u){
                $('#getReturn').html(u);

                $.ajax({
                    url: "./KwanzarApp/SystemApp/PDV.inc.php",
                    type: "POST",
                    data: "acao=MesaInfo"+
                    "&level="+level+
                    "&id_db_settings="+id_db_settings+
                    "&id_mesa="+id_mesa+
                    "&id_user="+id_user,
                    success: function(eu){
                        $('.MyGod').html(eu);
                        $('.background').css('display', 'none');
                    }
                });
            }
        });
    }
}

function OptionMesa(){
    var optionMesa     = document.getElementById('optionMesa').value;
    var idMesa         = document.getElementById('idMesa').value;
    var id_db_settings = document.getElementById('id_db_settings').value;

    if(confirm('Desejas mudar o estado da mesa?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/PDV.inc.php",
            type: "POST",
            data: "acao=Option"+
            "&idMesa="+idMesa+
            "&optionMesa="+optionMesa+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(object){
                $("#getReturn").html("Mensagem: "+object);
            }, success: function(r){
                $("#getReturn").html(r);
            }
        });
    }
}

function Transfer(){
    var idDe           = document.getElementById('idDe').value;
    var idPara         = document.getElementById('idPara').value;
    var id_db_settings = document.getElementById('id_db_settings').value;

    if(confirm('Desejas transferir os pedidos de uma mesa para outra?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/PDV.inc.php",
            type: "POST",
            data: "acao=Transfer"+
            "&idDe="+idDe+
            "&idPara="+idPara+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(object){
                $("#getReturn").html("Mensagem: "+object);
            }, success: function(r){
                $("#getReturn").html(r);
            }
        });
    }
}

function RemoveMesa(id){
    var level          = document.getElementById('level').value;
    var id_mesa        = document.getElementById('id_mesa').value;
    var id_user        = document.getElementById('id_user').value;
    var id_db_settings = document.getElementById('id_db_settings').value;

    if(confirm('Desejas remover o item da factura?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/PDV.inc.php",
            type: "POST",
            data: "acao=RemoveMesa"+
            "&level="+level+
            "&id_user="+id_user+
            "&id_mesa="+id_mesa+
            "&id="+id+
            "&id_db_settings="+id_db_settings,
            success: function(r){
                $.ajax({
                    url: "./KwanzarApp/SystemApp/PDV.inc.php",
                    type: "POST",
                    data: "acao=MesaInfo"+
                    "&level="+level+
                    "&id_db_settings="+id_db_settings+
                    "&id_mesa="+id_mesa+
                    "&id_user="+id_user,
                    success: function(eu){
                        $('.MyGod').html(eu);
                    }
                });
            }
        });
    }
}

function AddMesa(id_db_settings, id_user, id_mesa, id){
    var level = document.getElementById('level').value;

    if(confirm("Desejas adicionar o Item a mesa?")){
        $.ajax({
            url: "./KwanzarApp/SystemApp/PDV.inc.php",
            type: "POST",
            data: "acao=AddMesa"+
            "&id_user="+id_user+
            "&id_mesa="+id_mesa+
            "&id="+id+
            "&id_db_settings="+id_db_settings,
            success: function(r){

                $.ajax({
                    url: "./KwanzarApp/SystemApp/PDV.inc.php",
                    type: "POST",
                    data: "acao=MesaInfo"+
                    "&level="+level+
                    "&id_db_settings="+id_db_settings+
                    "&id_mesa="+id_mesa+
                    "&id_user="+id_user,
                    success: function(eu){
                        $('.MyGod').html(eu);
                    }
                });
            }
        });
    }
}

function CancelMesa(id_db_settings, id_user, id_mesa){
    var level = document.getElementById('level').value;

    if(confirm("Desejas cancelar os pedidos da presente mesa?")){
        $.ajax({
            url: "./KwanzarApp/SystemApp/PDV.inc.php",
            type: "POST",
            data: "acao=CancelMesa"+
            "&level="+level+
            "&id_user="+id_user+
            "&id_mesa="+id_mesa+
            "&id_db_settings="+id_db_settings,
            success: function(r){
                $.ajax({
                    url: "./KwanzarApp/SystemApp/PDV.inc.php",
                    type: "POST",
                    data: "acao=MesaInfo"+
                    "&level="+level+
                    "&id_db_settings="+id_db_settings+
                    "&id_mesa="+id_mesa+
                    "&id_user="+id_user,
                    success: function(eu){
                        $('.MyGod').html(eu);
                    }
                });
            }
        });
    }
}

function Magia(){
    var value = document.getElementById('method').value;

    if(value == "NU"){
        $('.magic').css('visibility', 'visible');
    }
}