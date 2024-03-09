/**
 * Created by Kwanzar Soft on 13/05/2020.
 */

$(document).ready(function(){
    var id_user     = $('#id_user').val();

    // 08.10.2020 05:14
    $('body').on('click', '.lightbox', function(){
        $('.background, .my-modal').css('display', 'block');
        $('.background, .my-modal').animate({"opacity":'.60'}, 500, 'linear');
        $('.background, .my-modal').animate({"opacity":'1.00'}, 500, 'linear');
    });

    $('body').on('click', '.close_header', function(){
        $('.background, .my-modal, .believer').animate({'opacity':'0'}, 500, 'linear', function(){
            $('.background, .my-modal, .believer').css('display', 'none');
        });
    });

    // 18.08.2020
    $('body').on('keyup', ".Qtds", function(e){
        if(e.which == 13){
            var
                id_db_settings = $("#id_db_settings").val(),
                id_db_kwanzar  = $("#id_db_kwanzar").val(),
                id_user        = $('#id_user').val();

            var value = $(this).val();
            var id    = $(this).attr('data-file');

            $.ajax({
                url: "./KwanzarApp/SystemApp/POS.inc.php",
                type: "POST",
                data: "acao=Qtds"+
                "&value="+value+
                "&id="+id+
                "&id_user="+id_user+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
                success: function(r){
                    $('#RealNigga').html(r);
                }
            });
        }
        return false;
    });

    $('body').on('keyup', "#PorcentagemP", function (f) {
        var porcentagem = $(this).val(),
            CustoCompraP = $("#CustoCompraP").val();

        if(CustoCompraP != ''){
            $.ajax({
                url: "./KwanzarApp/SystemApp/Settings.inc.php",
                type: "POST",
                data: "acao=PorcentagemP"+
                "&porcentagem="+porcentagem+
                "&CustoCompraP="+CustoCompraP+
                "&level="+level+
                "&id_user="+id_user+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
                success: function(r){
                    $("#preco_venda").val(r);
                }
            });
        }
    });

    $('body').on('keyup', '#searchPurchase', function(r){
        var txt = $(this).val(),
            id_db_kwanzar = $('#id_db_kwanzar').val(),
            level = $('#level').val(),
            id_db_settings = $('#id_db_settings').val();

        if(txt != ''){
            $.ajax({
                url: "./KwanzarApp/SystemApp/Settings.inc.php",
                type: "POST",
                data: "acao=searchPurchase"+
                "&txt="+txt+
                "&level="+level+
                "&id_user="+id_user+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
                success: function(r){
                    $("#hPro").html(r);
                }
            });
        }
    });

    $('body').on('keyup', '#searchProductTxt', function(r){
        var txt = $(this).val(),
            id_db_kwanzar = $('#id_db_kwanzar').val(),
            level = $('#level').val(),
            id_db_settings = $('#id_db_settings').val();

        if(txt != ''){
            $.ajax({
                url: "./KwanzarApp/SystemApp/Settings.inc.php",
                type: "POST",
                data: "acao=searchProductTxt"+
                "&txt="+txt+
                "&level="+level+
                "&id_user="+id_user+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
                success: function(r){
                    $("#getResult").html(r);
                }
            });
        }
    });

    // Chats 08.08.2020
    jQuery('body').on('keyup', '.msg', function(e){
        if(e.which == 13){
            var texto = jQuery(this).val();
            var id    = jQuery(this).attr('id');
            var Split = id.split(':');
            var para  = Number(Split[1]);

            if(texto != ''){
                jQuery.ajax({
                    type: "POST",
                    url: 'KwanzarApp/sys/submit.php',
                    data: {
                        mensagem: texto,
                        de: id_user,
                        para: para
                    }, success: function(retorno){
                        if(retorno == 'ok'){
                            jQuery('.msg').val('');
                            Disney(para, id_user);
                            ///retorna_historico(para);
                        }else{
                            alert('Ocorreu um erro ao enviar a mensagem...');
                        }
                    }
                });
            }
        }
    });

    function retorna_historico(id_conversa){
        jQuery.ajax({
            type: "POST",
            url: 'KwanzarApp/sys/historico.php',
            data: {conversacom: id_conversa, online: id_user},
            dataType: 'json',
            success: function(retorno){
                alert(retorno);
                jQuery.each(retorno, function(i, msg){
                    if(id_user == msg.de){
                        jQuery('#janela_'+msg.janela_de+' .mensagens ul').append('<li id="'+msg.id+'"<p>'+msg.mensagem+'</p></li>');
                    }else{
                        jQuery('#janela_'+msg.janela_de+' .mensagens ul').append('<li id"'+msg.id+'"><p>'+msg.mensagem+'</p></li>');
                    }
                });
            }
        });
    }

    //
    loadingPOS(id_user);

    var getResult = $("#getResult"),
        StayStrong = $('#StayStrong'),
        aPaulo = $(".aPaulo"),
        id_db_kwanzar = $('#id_db_kwanzar').val(),
        id_db_settings = $('#id_db_settings').val(),
        method = $('#method').val(),
        level  = $('#level').val();

    $("body").on('keyup', '#pagou', function () {
        var value = $(this).val(),
            total = $('#totalGeral').val();

        if(value != ''){
            $.ajax({
                url: './KwanzarApp/SystemApp/POS.inc.php',
                type: 'POST',
                data: 'acao=Calc'+
                "&pagou="+value+
                "&total="+total+
                "&id_db_settings="+id_db_settings,
                success: function(r){
                    $("#RapCosciente").html(r);
                }
            });
        }
    });

    $("body").on('keyup', '#SearchDocuments', function () {
        var value = $(this).val();
            id_user = $('#id_user').val();

        if(value != ''){
            $.ajax({
                url: './KwanzarApp/SystemApp/POS.inc.php',
                type: 'POST',
                data: 'acao=SearchDocuments'+
                "&searching="+value+
                "&level="+level+
                "&id_user="+id_user+
                "&id_db_settings="+id_db_settings,
                success: function(r){
                    $("#King").html(r);
                }
            });
        }
    });

    $('#SearchProduct').keyup(function(){
        var searching = $(this).val();

        $.ajax({
            url: './KwanzarApp/SystemApp/POS.inc.php',
            type: 'POST',
            data: 'acao=SearchProduct'+
            "&searching="+searching+
            "&id_user="+id_user+
            "&id_db_kwanzar="+id_db_kwanzar+
            "&level="+level+
            "&id_db_settings="+id_db_settings,
            success: function(r){
                $("#POSET").html(r);
            }
        });
    });

    $('#SearchChanges').keyup(function(){
        var searching = $(this).val();

        $.ajax({
            url: './KwanzarApp/SystemApp/POS.inc.php',
            type: 'POST',
            data: 'acao=SearchChanges'+
            "&searching="+searching+
            "&id_user="+id_user+
            "&id_db_kwanzar="+id_db_kwanzar+
            "&level="+level+
            "&id_db_settings="+id_db_settings,
            success: function(r){
                $("#Changes").html(r);
            }
        });
    });

    $('#searchProductInfo').keyup(function(){
        var searching = $(this).val();

        $.ajax({
            url: './KwanzarApp/SystemApp/POS.inc.php',
            type: 'POST',
            data: 'acao=searchProductInfo'+
            "&searching="+searching+
            "&id_user="+id_user+
            "&id_db_kwanzar="+id_db_kwanzar+
            "&level="+level+
            "&id_db_settings="+id_db_settings,
            success: function(r){
                $("#getResult").html(r);
            }
        });
    });

    $('#searchProductAlerts').keyup(function(){
        var searching = $(this).val();

        $.ajax({
            url: './KwanzarApp/SystemApp/POS.inc.php',
            type: 'POST',
            data: 'acao=searchProductAlerts'+
            "&searching="+searching+
            "&id_user="+id_user+
            "&id_db_kwanzar="+id_db_kwanzar+
            "&level="+level+
            "&id_db_settings="+id_db_settings,
            success: function(r){
                $("#getResult").html(r);
            }
        });
    });

    $('form[name="FormCreateGarcom"]').on('submit', function(){
        var button = $(this).find(':button'),
            name = $("#name").val(),
            telefone = $("#telefone").val(),
            porcentagem = $("#porcentagem").val();

        button.attr('disabled', true);

        $.ajax({
            url: './KwanzarApp/SystemApp/Settings.inc.php',
            type: 'POST',
            data: 'acao=FormCreateGarcom'+
            "&name="+name+
            "&telefone="+telefone+
            "&porcentagem="+porcentagem+
            "&id_db_kwanzar="+id_db_kwanzar+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                button.html('Aguarde...');
            }, success: function(r){
                button.html('Salvar').attr('disabled', false);
                getResult.html(r);
            }
        });

        return false;
    });

    $('form[name="FormCreateMesa"]').on('submit', function(){
        var button = $(this).find(':button'),
            name = $("#name").val(),
            localizacao = $("#localizacao").val(),
            capacidade = $("#capacidade").val(),
            obs = $("#obs").val();

        button.attr('disabled', true);

        $.ajax({
            url: './KwanzarApp/SystemApp/Settings.inc.php',
            type: 'POST',
            data: 'acao=FormCreateMesa'+
            "&name="+name+
            "&localizacao="+localizacao+
            "&capacidade="+capacidade+
            "&obs="+obs+
            "&id_db_kwanzar="+id_db_kwanzar+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                button.html('Aguarde...');
            }, success: function(r){
                button.html('Salvar').attr('disabled', false);
                getResult.html(r);
            }
        });

        return false;
    });

    $('form[name="FormCreateCustomer"]').on('submit', function(){
        var button = $(this).find(':button'),
            nome = $("#nome").val(),
            nif = $("#nif").val(),
            telefone = $("#telefone").val(),
            email = $("#email").val(),
            endereco = $("#endereco").val(),
            type = $("#type").val(),
            addressDetail = $("#addressDetail").val(),
            city = $("#city").val(),
            country = $("#country").val(),
            obs = $("#obs").val();

        button.attr('disabled', true);

        $.ajax({
            url: './KwanzarApp/SystemApp/Settings.inc.php',
            type: 'POST',
            data: 'acao=FormCreateCustomer'+
            "&nome="+nome+
            "&nif="+nif+
            "&telefone="+telefone+
            "&email="+email+
            "&endereco="+endereco+
            "&type="+type+
            "&addressDetail="+addressDetail+
            "&city="+city+
            "&country="+country+
            "&obs="+obs+
            "&id_db_kwanzar="+id_db_kwanzar+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                button.html('Aguarde...');
            }, success: function(r){
                button.html('Salvar').attr('disabled', false);
                StayStrong.html(r);
            }
        });

        return false;
    });

    $('form[name="FormProductAndServices"]').on('submit', function(){
        var button = $(this).find(':button'),
            Description = $("#Description").val(),
            preco_venda = $("#preco_venda").val(),
            iva = $("#iva").val(),
            unidade_medida = $("#unidade_medida").val(),
            type = $("#type").val(),
            id_category = $("#id_category").val(),
            codigo_barras = $("#codigo_barras").val(),
            codigo = $("#codigo").val(),
            product = $("#product").val(),
            id_user = $("#id_user").val();

        button.attr('disabled', true);

        $.ajax({
            url: './KwanzarApp/SystemApp/Settings.inc.php',
            type: 'POST',
            data: 'acao=FormProductAndServices'+
            "&Description="+Description+
            "&preco_venda="+preco_venda+
            "&iva="+iva+
            "&unidade_medida="+unidade_medida+
            "&type="+type+
            "&id_category="+id_category+
            "&codigo_barras="+codigo_barras+
            "&codigo="+codigo+
            "&product="+product+
            "&id_db_kwanzar="+id_db_kwanzar+
            "&id_db_settings="+id_db_settings+
            "&id_user="+id_user,
            beforeSend: function(){
                button.html('Aguarde...');
            }, success: function(r){
                button.html('Salvar').attr('disabled', false);
                getResult.html(r);
            }
        });

        return false;
    });

    $('form[name="FormCategory"]').on('submit', function(){
        var button = $(this).find(':button'),
            category_title = $("#category_title").val(),
            category_content = $("#category_content").val();


        button.attr('disabled', true);

        $.ajax({
            url: './KwanzarApp/SystemApp/Settings.inc.php',
            type: 'POST',
            data: 'acao=FormCategory'+
            "&category_title="+category_title+
            "&category_content="+category_content+
            "&id_db_kwanzar="+id_db_kwanzar+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                button.html('Aguarde...');
            }, success: function(r){
                button.html('Salvar').attr('disabled', false);
                getResult.html(r);
            }
        });

        return false;
    });

    $('form[name="FormTaxTable"]').on('submit', function(){
        var button = $(this).find(':button'),
            taxCode = $("#taxCode").val(),
            taxType = $("#taxType").val(),
            description = $("#description").val(),
            taxPercentage = $("#taxPercentage").val(),
            taxAmount = $("#taxAmount").val(),
            TaxCountryRegion = $("#TaxCountryRegion").val(),
            TaxExemptionReason = $("#TaxExemptionReason").val();


        button.attr('disabled', true);

        $.ajax({
            url: './KwanzarApp/SystemApp/Settings.inc.php',
            type: 'POST',
            data: 'acao=FormTaxTable'+
            "&taxCode="+taxCode+
            "&taxType="+taxType+
            "&description="+description+
            "&taxPercentage="+taxPercentage+
            "&taxAmount="+taxAmount+
            "&TaxCountryRegion="+TaxCountryRegion+
            "&TaxExemptionReason="+TaxExemptionReason+
            "&id_db_kwanzar="+id_db_kwanzar+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                button.html('Aguarde...');
            }, success: function(r){
                button.html('Salvar').attr('disabled', false);
                getResult.html(r);
            }
        });

        return false;
    });

    $('form[name="FormCreateUsers"]').on('submit', function(){
        var button = $(this).find(':button'),
            name = $("#name").val(),
            username = $("#username").val(),
            levels = $("#levels").val();

        button.attr('disabled', true);

        $.ajax({
            url: './KwanzarApp/SystemApp/Settings.inc.php',
            type: 'POST',
            data: 'acao=FormCreateUsers'+
            "&name="+name+
            "&username="+username+
            "&levels="+levels+
            "&id_db_kwanzar="+id_db_kwanzar+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                button.html('Aguarde...');
            }, success: function(r){
                button.html('Salvar').attr('disabled', false);
                aPaulo.html(r);
            }
        });

        return false;
    });

    $('#username').keyup(function(){
        var keyuping = $(this).val();

        if(keyuping != ''){
            $.post('./KwanzarApp/SystemApp/Configurations.inc.php', {
                acao: 'username',
                username: keyuping
            }, function(ret){
                aPaulo.html(ret);
            });
        }else{
            aPaulo.html('');
        }
    });

    $('form[name="FormConfig"]').on('submit', function(){
        var button = $(this).find(':button'),
            JanuarioSakalumbu = $('#JanuarioSakalumbu').val(),
            MethodDefault = $('#MethodDefault').val(),
            moeda = $('#moeda').val(),
            estoque_minimo = $('#estoque_minimo').val(),
            sequencialCode = $('#sequencialCode').val(),
            WidthLogotype = $('#WidthLogotype').val(),
            HeightLogotype = $("#HeightLogotype").val(),
            HeliosPro = $('#HeliosPro').val(),
            RetencaoDeFonte = $('#RetencaoDeFonte').val(),
            IncluirNaFactura = $('#IncluirNaFactura').val(),
            ECommerce = $('#ECommerce').val(),
            PadraoAGT = $('#PadraoAGT').val(),
            IncluirCover = $('#IncluirCover').val();

        button.attr('disabled', true);

        $.ajax({
            url: './KwanzarApp/SystemApp/Settings.inc.php',
            type: 'POST',
            data: 'acao=FormConfig'+
            "&JanuarioSakalumbu="+JanuarioSakalumbu+
            "&moeda="+moeda+
            "&MethodDefault="+MethodDefault+
            "&estoque_minimo="+estoque_minimo+
            "&sequencialCode="+sequencialCode+
            "&WidthLogotype="+WidthLogotype+
            "&HeightLogotype="+HeightLogotype+
            "&HeliosPro="+HeliosPro+
            "&RetencaoDeFonte="+RetencaoDeFonte+
            "&IncluirNaFactura="+IncluirNaFactura+
            "&id_db_kwanzar="+id_db_kwanzar+
            "&IncluirCover="+IncluirCover+
            "&ECommerce="+ECommerce+
            "&PadraoAGT="+PadraoAGT+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                button.html('Aguarde...');
            }, success: function(r){
                button.html('Salvar').attr('disabled', false);
                aPaulo.html(r);
            }
        });

        return false;
    });

    $('form[name="FormValidateNib"]').on('submit', function(){
        var button = $(this).find(':button'),
            nib = $('#nib').val(),
            iban = $('#iban').val(),
            swift = $('#swift').val(),
            coordenadas = $('#coordenadas').val();

        button.attr('disabled', true);

        $.ajax({
            url: './KwanzarApp/SystemApp/Settings.inc.php',
            type: 'POST',
            data: 'acao=FormValidateNib'+
                "&nib="+nib+
                "&iban="+iban+
                "&swift="+swift+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&coordenadas="+coordenadas+
                "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                button.html('Aguarde...');
            }, success: function(r){
                button.html('Salvar').attr('disabled', false);
                getResult.html(r);
            }
        });

        return false;
    });


    $('form[name="form_settings_update"]').on('submit', function(){
        var empresa = $('#empresa').val(),
            nif = $('#nif').val(),
            telefone = $('#telefone').val(),
            endereco = $('#endereco').val(),
            website = $('#website').val(),
            businessName = $('#businessName').val(),
            addressDetail = $('#addressDetail').val(),
            city = $('#city').val(),
            taxEntity = $('#taxEntity').val(),
            makeUp = $('#makeUp').val(),
            country = $('#country').val(),
            BuildingNumber = $('#BuildingNumber').val(),
            email = $('#email').val(),
            atividade = $('#atividade').val(),
            typeVenda = $('#typeVenda').val();

        var button = $(this).find(':button');
        button.attr('disabled', true);

        $.ajax({
            url: "./KwanzarApp/SystemApp/Settings.inc.php",
            type: "POST",
            data: "acao=update&id_db_settings="+id_db_settings+"&empresa="+empresa+"&nif="+nif+"&telefone="+telefone+"&endereco="+endereco+"&website="+website+"&addressDetail="+addressDetail+"&city="+city+"&taxEntity="+taxEntity+"&makeUp="+makeUp+"&country="+country+"&BuildingNumber="+BuildingNumber+"&email="+email+"&businessName="+businessName+"&atividade="+atividade+"&typeVenda="+typeVenda+"&id_db_kwanzar="+id_db_kwanzar,
            beforeSend: function(){
                button.html('Salvando...').attr('disabled', true);
            }, success: function(result){
                button.attr('disabled', false).html('Salvar dados');
                StayStrong.html(result);
            }
        });

        return false;
    });
});






function loadingPOS(id_user){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var level          = document.getElementById('level').value;
    var getResult      = document.getElementById('POSET');

    $.ajax({
        url: "./KwanzarApp/SystemApp/POS.inc.php",
        type: "POST",
        data: "acao=loadingPOS"+
        "&id_user="+id_user+
        "&level="+level+
        "&id_db_settings="+id_db_settings,
        success: function(result){
            $("#POSET").html(result);
        }
    })
}

function slidetoggle(){
    var modal = document.getElementById('content-modal');

    if(modal.style.left == "0px"){
        modal.style.left = "-100%";
        modal.style.visibility = "hidden";
    }else{
        modal.style.left = "0px";
        modal.style.visibility = "visible";
    }
}

function asatoggle(){
    var modal = document.getElementById('asa-modal');

    if(modal.style.top == "0px"){
        modal.style.top = "-100%";
        modal.style.visibility = "hidden";
    }else{
        modal.style.top = "0px";
        modal.style.visibility = "visible";
    }
}

function alltoggle(){
    var modal = document.getElementById('all-modal');

    if(modal.style.top == "0px"){
        modal.style.top = "-100%";
        modal.style.visibility = "hidden";
    }else{
        modal.style.top = "0px";
        modal.style.visibility = "visible";
    }
}

function downtoggle(){
    var modal = document.getElementById('down-modal');

    if(modal.style.right == "0px"){
        modal.style.right = "-100%";
        modal.style.visibility = "hidden";
    }else{
        modal.style.right = "0px";
        modal.style.visibility = "visible";
    }
}

// Adicionar productos na factura

function adicionar(id){
    var id_db_settings = document.getElementById('id_db_settings_'+id).value;
    var id_user = document.getElementById('session_id_'+id).value;
    var quantidade = document.getElementById('quantidade_'+id).value;
    var preco = document.getElementById('preco_'+id).value;
    var taxa = document.getElementById('taxa_'+id).value;
    var desconto = document.getElementById('desconto_'+id).value;

    if(isNaN(preco)){
        alert('Ops: o campo preço tem que ser do tipo numerico, isso é: não pode conter espaços, pontou ou virgulas.');
        document.getElementById('preco_'+id).focus();
        return false;
    }

    if(isNaN(quantidade)){
        alert('Ops: o campo quantidade tem que ser do tipo numerico, isso é: não pode conter espaços, pontou ou virgulas.');
        quantidade = document.getElementById('quantidade_'+id).focus();
        return false;
    }

    $.ajax({
        url: "./KwanzarApp/SystemApp/POS.inc.php",
        type: "POST",
        data: "acao=Add"+
            "&id_product="+id+
            "&id_db_settings="+id_db_settings+
            "&id_user="+id_user+
            "&quantidade="+quantidade+
            "&preco="+preco+
            "&taxa="+taxa+
            "&desconto="+desconto,
        beforeSend: function(object){
            $("#RealNigga").html("Mensagem: "+object);
        }, success: function(r){
            $("#RealNigga").html(r);
        }
    });
}

function SuspenseVenda(){
    var level          = document.getElementById('level').value;
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user        = document.getElementById('id_user').value;

    if(confirm('Desejas tirar as vendas da suspensão?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/POS.inc.php",
            type: "POST",
            data: "acao=SuspenseVenda"+
            "&level="+level+
            "&id_db_settings="+id_db_settings+
            "&id_user="+id_user,
            beforeSend: function(object){
                $("#sd_billing").html("Mensagem: "+object);
            }, success: function(r){
                $("#sd_billing").html(r);

                $.ajax({
                    url: "./KwanzarApp/SystemApp/POS.inc.php",
                    type: "POST",
                    data: "acao=Atualiza"+
                    "&level="+level+
                    "&id_db_settings="+id_db_settings+
                    "&id_user="+id_user,
                    success: function(eu){
                        //alert(eu);
                        $('#RealNigga').html(eu);
                    }
                });
            }
        });
    }
}





function KwanzarDocsTwo(){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user = document.getElementById('id_user').value;
    var dateI = document.getElementById('dateI').value;
    var dateF = document.getElementById('dateF').value;
    var Function_id = document.getElementById('Function_id').value;

    $.ajax({
        url: "./KwanzarApp/AppData/KwanzarDocsTwo.php",
        type: "POST",
        data: "acao=DocumentPdv"+
            "&id_db_settings="+id_db_settings+
            "&id_user="+id_user+
            "&Function_id="+Function_id+
            "&dateI="+dateI+
            "&dateF="+dateF,
        beforeSend: function(object){
            $("#getResult").html("Mensagem: "+object);
        }, success: function(r){
            $("#getResult").html(r);
        }
    });
}

function DocumentPdv(){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user = document.getElementById('id_user').value;
    var dateI = document.getElementById('dateI').value;
    var dateF = document.getElementById('dateF').value;
    var TypeDoc = document.getElementById('TypeDoc').value;
    var SourceBilling = document.getElementById('SourceBilling').value;
    var Function_id = document.getElementById('Function_id').value;
    var Customers_id = document.getElementById('Customers_id').value;

    $.ajax({
        url: "./KwanzarApp/SystemApp/POS.inc.php",
        type: "POST",
        data: "acao=DocumentPdv"+
        "&id_db_settings="+id_db_settings+
        "&id_user="+id_user+
        "&TypeDoc="+TypeDoc+
        "&SourceBilling="+SourceBilling+
        "&Function_id="+Function_id+
        "&Customers_id="+Customers_id+
        "&dateI="+dateI+
        "&dateF="+dateF,
        beforeSend: function(object){
            $("#getResult").html("Mensagem: "+object);
        }, success: function(r){
            $("#getResult").html(r);
        }
    });
}

function ExportExcelOne(){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user = document.getElementById('id_user').value;
    var dateI = document.getElementById('dateI').value;
    var dateF = document.getElementById('dateF').value;

    $.ajax({
        url: "./KwanzarApp/SystemApp/POS.inc.php",
        type: "POST",
        data: "acao=ExportExcelOne"+
        "&id_db_settings="+id_db_settings+
        "&id_user="+id_user+
        "&dateI="+dateI+
        "&dateF="+dateF,
        beforeSend: function(object){
            $("#getResult").html("Mensagem: "+object);
        }, success: function(r){
            $("#getResult").html(r);
        }
    });
}





function Distancia(id){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var qtdOne         = document.getElementById('qtdOne_'+id).value;
    var id_user        = document.getElementById('id_user').value;
    var level          = document.getElementById('level').value;


    if(confirm('Dejesas fazer pedido no estoque?')){
        $.ajax({
            url: './KwanzarApp/SystemApp/POS.inc.php',
            type: 'POST',
            data: "acao=Distancia"+
            "&id_product="+id+
            "&qtdOne="+qtdOne+
            "&id_user="+id_user+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                $("#BillieJean").html();
            }, success: function(r){
                $("#BillieJean").html(r);
            }
        });
    }
}

function TreePurchase(id){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var quantidade     = document.getElementById('quantidade').value;
    var Type           = document.getElementById('Type').value;
    var unidade        = document.getElementById('unidade').value;
    var id_user        = document.getElementById('id_user').value;


    if(confirm("Desejas fazer o reajuste de estoque?")){
        $.ajax({
            url: './KwanzarApp/SystemApp/Settings.inc.php',
            type: 'POST',
            data: "acao=TreePurchase"+
            "&id="+id+
            "&quantidade="+quantidade+
            "&unidade="+unidade+
            "&Type="+Type+
            "&id_user="+id_user+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                $("#getInfo").html();
            }, success: function(r){
                $("#getInfo").html(r);
            }
        });
    }
}



function ForPurchase(id){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var quantidade     = document.getElementById('qtdOne_'+id).value;
    var unidade        = document.getElementById('unidade').value;
    var id_user        = document.getElementById('id_user').value;


    if(confirm("Dejas mover os produtos para loja?")){
        $.ajax({
            url: './KwanzarApp/SystemApp/Settings.inc.php',
            type: 'POST',
            data: "acao=ForPurchase"+
            "&id="+id+
            "&quantidade="+quantidade+
            "&unidade="+unidade+
            "&id_user="+id_user+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                $("#aPaulo").html();
            }, success: function(r){
                $("#aPaulo").html(r);
            }
        });
    }
}

function SearchDays(){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user        = document.getElementById('id_user').value;
    var level          = document.getElementById('level').value;
    var dateI          = document.getElementById('DateI').value;
    var dateF          = document.getElementById('DateF').value;

    $.ajax({
        url: './KwanzarApp/SystemApp/Settings.inc.php',
        type: 'POST',
        data: "acao=SearchDays"+
        "&id_user="+id_user+
        "&level="+level+
        "&dateI="+dateI+
        "&dateF="+dateF+
        "&id_db_settings="+id_db_settings,
        beforeSend: function(){
            $("#pResult").html();
        }, success: function(r){
            $("#pResult").html(r);
        }
    });
}

function Spending(){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user        = document.getElementById('id_user').value;
    var level          = document.getElementById('level').value;

    var descricao = document.getElementById('descricaoX').value;
    var preco = document.getElementById('precoX').value;
    var quantidade = document.getElementById('quantidadeX').value;
    var natureza = document.getElementById('naturezaX').value;

    if(confirm("Desejas salvar a presente despesa?")){
        $.ajax({
            url: './KwanzarApp/SystemApp/Settings.inc.php',
            type: 'POST',
            data: "acao=Spending"+
            "&id_user="+id_user+
            "&level="+level+
            "&descricao="+descricao+
            "&preco="+preco+
            "&natureza="+natureza+
            "&quantidade="+quantidade+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                $("#AllNewAllNew").html();
            }, success: function(r){
                $("#AllNewAllNew").html(r);
            }
        });
    }
}

function DeleteSpending(id){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user        = document.getElementById('id_user').value;
    var level          = document.getElementById('level').value;

    if(confirm("Desejas eliminar a presente despesa?")){
        $.ajax({
            url: './KwanzarApp/SystemApp/Settings.inc.php',
            type: 'POST',
            data: "acao=DeleteSpending"+
            "&id="+id+
            "&id_user="+id_user+
            "&level="+level+
            "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                $("#Waya").html();
            }, success: function(r){
                $("#Waya").html(r);
            }
        });
    }
}

function SearchSpending(){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user        = document.getElementById('id_user').value;
    var level          = document.getElementById('level').value;
    var dateI          = document.getElementById('DateI').value;
    var dateF          = document.getElementById('DateF').value;

    $.ajax({
        url: './KwanzarApp/SystemApp/Settings.inc.php',
        type: 'POST',
        data: "acao=SearchSpending"+
        "&id_user="+id_user+
        "&level="+level+
        "&dateI="+dateI+
        "&dateF="+dateF+
        "&id_db_settings="+id_db_settings,
        beforeSend: function(){
            $("#pResult").html();
        }, success: function(r){
            $("#pResult").html(r);
        }
    });
}

function  FormCreateCustomer() {
    var nome           = document.getElementById('nome').value;
    var nif            = document.getElementById('nif').value;
    var endereco       = document.getElementById('endereco').value;
    var type           = document.getElementById('type').value;
    var city           = document.getElementById('city').value;
    var country        = document.getElementById('country').value;
    var id_db_kwanzar  = document.getElementById('id_db_kwanzar').value;
    var id_db_settings = document.getElementById('id_db_settings').value;

    if(confirm("Desejas Registrar o presente cliente?")){
        $.ajax({
            url: './KwanzarApp/SystemApp/Settings.inc.php',
            type: 'POST',
            data: 'acao=FormCreateCustomers'+
            "&nome="+nome+
            "&nif="+nif+
            "&endereco="+endereco+
            "&type="+type+
            "&city="+city+
            "&country="+country+
            "&id_db_kwanzar="+id_db_kwanzar+
            "&id_db_settings="+id_db_settings,
            success: function(r){
                $("#getReturnII").html(r);
            }
        });
    }
}

/*** 18.07.2020 ***/
function OpenBox(id_db_settings, id_user){
    var value_open = document.getElementById('value_open').value;

    if(confirm('Att.: Informamos quê, se encontrarmos uma operação semelhante em aberto no sistema os dados serão atualizados!')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/POS.inc.php",
            type: "POST",
            data: "acao=OpenBox"+
            "&id_db_settings="+id_db_settings+
            "&id_user="+id_user+
            "&value_open="+value_open,
            beforeSend: function(object){
                $("#Changes").html("Mensagem: "+object);
            }, success: function(r){
                $("#Changes").html(r);
            }
        });
    }
}

function SangriaBox(id_db_settings, id_user){
    var value_sangria = document.getElementById('value_sangria').value;
    var text_sangria  = document.getElementById('text_sangria').value;

    if(confirm('Desejas Sangria o caixa?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/POS.inc.php",
            type: "POST",
            data: "acao=SangriaBox"+
            "&id_db_settings="+id_db_settings+
            "&id_user="+id_user+
            "&value_sangria="+value_sangria+
            "&text_sangria="+text_sangria,
            beforeSend: function(object){
                $("#Changes").html("Mensagem: "+object);
            }, success: function(r){
                $("#Changes").html(r);
            }
        });
    }
}

function BoxClose(id_db_settings, id_user, level){
    if(confirm('Deseja realmente fechar esse caixa?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/POS.inc.php",
            type: "POST",
            data: "acao=BoxClose"+
            "&level="+level+
            "&id_db_settings="+id_db_settings+
            "&id_user="+id_user,
            beforeSend: function(object){
                $("#Changes").html("Mensagem: "+object);
            }, success: function(r){
                $("#Changes").html(r);
            }
        });
    }
}

function Disney(id_conversa, online){
    //alert(id_conversa);
    $.ajax({
        url: 'KwanzarApp/sys/historico.php',
        type: "POST",
        data: {conversacom: id_conversa, online: online}, success: function(r){
            $("#HPForLife").html(r);
            LerMsg(id_conversa, online);
            Scroll();
            ScrollII();
        }
    });
}

function LerMsg(id_conversa, online){
    $.ajax({
        url: 'KwanzarApp/sys/ReadMsg.php',
        type: "POST",
        data: {id_conversa: id_conversa, online: online}, success: function(r){
            //$("#All-msg").html(r);
        }
    });
}

function Scroll(){
    var altura = jQuery('.mensagens').height();
    jQuery('.mensagens').animate({scrollTop: altura}, '500');
}

function ScrollII(){
    var altura = jQuery('.sms').height();
    jQuery('.sms').animate({scrollTop: altura}, '500');
}

function Channel(id){
    $.ajax({
        url: 'KwanzarApp/sys/msg.php',
        type: "POST",
        data: {online: id}, success: function(r){
            $("#All-msg").html(r);
        }
    });
}

