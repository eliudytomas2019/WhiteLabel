$(document).ready(function (){
    var getResult = $("#getResult"),
        id_db_settings = $("#id_db_settings").val(),
        aPaulo = $(".aPaulo"),
        id_db_kwanzar = $('#id_db_kwanzar').val(),
        id_user = $("#id_user").val();

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

    $('form[name="FormCreateUsers"]').on('submit', function(){
        var button = $(this).find(':button'),
            name = $("#name").val(),
            username = $("#username").val(),
            email = $("#email").val(),
            levels = $("#levels").val();

        button.attr('disabled', true);

        $.ajax({
            url: './KwanzarApp/SystemApp/Settings.inc.php',
            type: 'POST',
            data: 'acao=FormCreateUsers'+
                "&name="+name+
                "&username="+username+
                "&email="+email+
                "&levels="+levels+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                button.html('Aguarde...');
            }, success: function(r){
                button.html('Salvar').attr('disabled', false);
                $("#aPaulo").html(r);
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

    $('form[name="FormValidateNib"]').on('submit', function(){
        var button = $(this).find(':button'),
            nib = $('#nib').val(),
            banco = $('#banco').val(),
            iban = $('#iban').val(),
            swift = $('#swift').val(),
            nib1 = $('#nib1').val(),
            banco1 = $('#banco1').val(),
            iban1 = $('#iban1').val(),
            swift1 = $('#swift1').val(),
            nib2 = $('#nib2').val(),
            banco2 = $('#banco2').val(),
            iban2 = $('#iban2').val(),
            swift2 = $('#swift2').val(),
            coordenadas = $('#coordenadas').val();

        button.attr('disabled', true);

        $.ajax({
            url: './KwanzarApp/SystemApp/Settings.inc.php',
            type: 'POST',
            data: 'acao=FormValidateNib'+
                "&nib="+nib+
                "&iban="+iban+
                "&banco="+banco+
                "&swift="+swift+
                "&nib1="+nib1+
                "&iban1="+iban1+
                "&banco1="+banco1+
                "&swift1="+swift1+
                "&nib2="+nib2+
                "&iban2="+iban2+
                "&banco2="+banco2+
                "&swift2="+swift2+
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
            //makeUp = $('#makeUp').val(),
            email = $('#email').val(),
            atividade = $('#atividade').val();

        var button = $(this).find(':button');
        button.attr('disabled', true);

        $.ajax({
            url: "./KwanzarApp/SystemApp/Settings.inc.php",
            type: "POST",
            data: "acao=update&id_db_settings="+id_db_settings+"&empresa="+empresa+"&nif="+nif+"&telefone="+telefone+"&endereco="+endereco+"&website="+website+"&email="+email+"&atividade="+atividade+"&id_db_kwanzar="+id_db_kwanzar,
            beforeSend: function(){
                button.html('Salvando...').attr('disabled', true);
            }, success: function(result){
                button.attr('disabled', false).html('Salvar dados');
                $("#StayStrong").html(result);
            }
        });

        return false;
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
            IncluirCover = $('#IncluirCover').val(),
            Idioma = $('#Idioma').val(),
            regimeIVA = $('#regimeIVA').val(),
            DocModel = $('#DocModel').val();

        var
            taxa_preferencial = $("#taxa_preferencial").val(),
            cambio_atual = $("#cambio_atual").val(),
            cambio_x_preco = $("#cambio_x_preco").val(),
            porcentagem_x_cambio = $("#porcentagem_x_cambio").val();

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
                "&Idioma="+Idioma+
                "&RetencaoDeFonte="+RetencaoDeFonte+
                "&IncluirNaFactura="+IncluirNaFactura+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&IncluirCover="+IncluirCover+
                "&ECommerce="+ECommerce+
                "&regimeIVA="+regimeIVA+
                "&PadraoAGT="+PadraoAGT+
                "&DocModel="+DocModel+
                "&taxa_preferencial="+taxa_preferencial+
                "&cambio_atual="+cambio_atual+
                "&cambio_x_preco="+cambio_x_preco+
                "&porcentagem_x_cambio="+porcentagem_x_cambio+
                "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                button.html('Aguarde...');
            }, success: function(r){
                button.html('Salvar').attr('disabled', false);
                $("#aPaulo").html(r);
            }
        });

        return false;
    });

    $("body").on('keyup', '#SearchDocuments', function () {
        var value = $(this).val(),
            level = $('#level').val(),
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

    $("body").on('keyup', '#SearchDocumentsProformas', function () {
        var value = $(this).val(),
            level = $('#level').val(),
            id_user = $('#id_user').val();

        if(value != ''){
            $.ajax({
                url: './KwanzarApp/SystemApp/POS.inc.php',
                type: 'POST',
                data: 'acao=SearchDocumentsProformas'+
                    "&searching="+value+
                    "&level="+level+
                    "&id_user="+id_user+
                    "&id_db_settings="+id_db_settings,
                success: function(r){
                    $("#Kings").html(r);
                }
            });
        }
    });

    $('body').on('keyup', ".data_expiracao_x", function(e){
        if(e.which == 13){
            var
                id_db_settings = $("#id_db_settings").val(),
                id_db_kwanzar  = $("#id_db_kwanzar").val(),
                level = $("#level").val(),
                id_user        = $('#id_user').val();

            var value = $(this).val();
            var id    = $(this).attr('data-file');

            $.ajax({
                url: "./KwanzarApp/SystemApp/POS.inc.php",
                type: "POST",
                data: "acao=data_expiracao_x"+
                    "&value="+value+
                    "&id="+id+
                    "&level="+level+
                    "&id_user="+id_user+
                    "&id_db_kwanzar="+id_db_kwanzar+
                    "&id_db_settings="+id_db_settings,
                success: function(r){
                    $('#aPaulo').html(r);
                }
            });
        }
        return false;
    });

    $('body').on('keyup', ".quantidade_x", function(e){
        if(e.which == 13){
            var
                id_db_settings = $("#id_db_settings").val(),
                id_db_kwanzar  = $("#id_db_kwanzar").val(),
                level = $("#level").val(),
                id_user        = $('#id_user').val();

            var value = $(this).val();
            var id    = $(this).attr('data-file');

            $.ajax({
                url: "./KwanzarApp/SystemApp/POS.inc.php",
                type: "POST",
                data: "acao=quantidadex_x"+
                    "&value="+value+
                    "&id="+id+
                    "&level="+level+
                    "&id_user="+id_user+
                    "&id_db_kwanzar="+id_db_kwanzar+
                    "&id_db_settings="+id_db_settings,
                success: function(r){
                    $('#aPaulo').html(r);
                }
            });
        }
        return false;
    });

    $('body').on('keyup', ".custo_compra_x", function(e){
        if(e.which == 13){
            var
                id_db_settings = $("#id_db_settings").val(),
                id_db_kwanzar  = $("#id_db_kwanzar").val(),
                level = $("#level").val(),
                id_user        = $('#id_user').val();

            var value = $(this).val();
            var id    = $(this).attr('data-file');

            $.ajax({
                url: "./KwanzarApp/SystemApp/POS.inc.php",
                type: "POST",
                data: "acao=custo_compra_x"+
                    "&value="+value+
                    "&id="+id+
                    "&level="+level+
                    "&id_user="+id_user+
                    "&id_db_kwanzar="+id_db_kwanzar+
                    "&id_db_settings="+id_db_settings,
                success: function(r){
                    $('#aPaulo').html(r);
                }
            });
        }
        return false;
    });

    $('body').on('keyup', ".Qtds", function(e){
        if(e.which == 13){
            var
                id_db_settings = $("#id_db_settings").val(),
                id_db_kwanzar  = $("#id_db_kwanzar").val(),
                level = $("#level").val(),
                id_user        = $('#id_user').val();

            var value = $(this).val();
            var page_found = $("#page_found").val();
            var id    = $(this).attr('data-file');

            $.ajax({
                url: "./KwanzarApp/SystemApp/POS.inc.php",
                type: "POST",
                data: "acao=Qtds"+
                    "&page_found="+page_found+
                    "&value="+value+
                    "&id="+id+
                    "&level="+level+
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

    $('body').on('keyup', ".QtdsX1", function(e){
        if(e.which == 13){
            var
                id_db_settings = $("#id_db_settings").val(),
                id_db_kwanzar  = $("#id_db_kwanzar").val(),
                number_x = $("#number_x").val(),
                InvoiceType_x  = $("#InvoiceType_x").val(),
                level = $("#level").val(),
                id_user        = $('#id_user').val();


            var value = $(this).val();
            var id    = $(this).attr('data-file');

            $.ajax({
                url: "./KwanzarApp/SystemApp/POS.inc.php",
                type: "POST",
                data: "acao=QtdsX1"+
                    "&value="+value+
                    "&id="+id+
                    "&level="+level+
                    "&id_user="+id_user+
                    "&Number="+number_x+
                    "&InvoiceType="+InvoiceType_x+
                    "&id_db_kwanzar="+id_db_kwanzar+
                    "&id_db_settings="+id_db_settings,
                success: function(r){
                    $('#RealNigga').html(r);
                }
            });
        }
        return false;
    });

    $('body').on('keyup', ".DescsX1", function(e){
        if(e.which == 13){
            var
                id_db_settings = $("#id_db_settings").val(),
                id_db_kwanzar  = $("#id_db_kwanzar").val(),
                number_x = $("#number_x").val(),
                InvoiceType_x  = $("#InvoiceType_x").val(),
                level = $("#level").val(),
                id_user        = $('#id_user').val();

            var value = $(this).val();
            var id    = $(this).attr('data-file');

            $.ajax({
                url: "./KwanzarApp/SystemApp/POS.inc.php",
                type: "POST",
                data: "acao=DescsX1"+
                    "&value="+value+
                    "&id="+id+
                    "&level="+level+
                    "&id_user="+id_user+
                    "&Number="+number_x+
                    "&InvoiceType="+InvoiceType_x+
                    "&id_db_kwanzar="+id_db_kwanzar+
                    "&id_db_settings="+id_db_settings,
                success: function(r){
                    $('#RealNigga').html(r);
                }
            });
        }
        return false;
    });

    $('body').on('keyup', ".PricingsX1", function(e){
        if(e.which == 13){
            var
                id_db_settings = $("#id_db_settings").val(),
                id_db_kwanzar  = $("#id_db_kwanzar").val(),
                number_x = $("#number_x").val(),
                InvoiceType_x  = $("#InvoiceType_x").val(),
                level = $("#level").val(),
                id_user        = $('#id_user').val();

            var value = $(this).val();
            var id    = $(this).attr('data-file');

            $.ajax({
                url: "./KwanzarApp/SystemApp/POS.inc.php",
                type: "POST",
                data: "acao=PricingsX1"+
                    "&value="+value+
                    "&id="+id+
                    "&level="+level+
                    "&id_user="+id_user+
                    "&Number="+number_x+
                    "&InvoiceType="+InvoiceType_x+
                    "&id_db_kwanzar="+id_db_kwanzar+
                    "&id_db_settings="+id_db_settings,
                success: function(r){
                    $('#RealNigga').html(r);
                }
            });
        }
        return false;
    });

    $('body').on('keyup', ".Descs", function(e){
        if(e.which == 13){
            var
                id_db_settings = $("#id_db_settings").val(),
                id_db_kwanzar  = $("#id_db_kwanzar").val(),
                level = $("#level").val(),
                id_user        = $('#id_user').val();

            var value = $(this).val();
            var page_found = $("#page_found").val();
            var id    = $(this).attr('data-file');

            $.ajax({
                url: "./KwanzarApp/SystemApp/POS.inc.php",
                type: "POST",
                data: "acao=Descs"+
                    "&page_found="+page_found+
                    "&value="+value+
                    "&id="+id+
                    "&level="+level+
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

    $('body').on('keyup', ".Pricings", function(e){
        if(e.which == 13){
            var
                id_db_settings = $("#id_db_settings").val(),
                id_db_kwanzar  = $("#id_db_kwanzar").val(),
                level = $("#level").val(),
                id_user        = $('#id_user').val();

            var value = $(this).val();
            var page_found = $("#page_found").val();
            var id    = $(this).attr('data-file');

            $.ajax({
                url: "./KwanzarApp/SystemApp/POS.inc.php",
                type: "POST",
                data: "acao=Pricings"+
                    "&page_found="+page_found+
                    "&value="+value+
                    "&id="+id+
                    "&level="+level+
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

    $("body").on('keyup', '#cartao_de_debito', function () {
        var value = $(this).val(),
            transferencia = $("#transferencia").val(),
            numerario = $("#numerario").val(),
            total = $('#totalGeral').val();

        if(value != ''){
            $.ajax({
                url: './KwanzarApp/SystemApp/POS.inc.php',
                type: 'POST',
                data: 'acao=CalcII'+
                    "&cartao_de_debito="+value+
                    "&transferencia="+transferencia+
                    "&numerario="+numerario+
                    "&total="+total+
                    "&id_db_settings="+id_db_settings,
                success: function(r){
                    $("#TodosOsDias").html(r);
                }
            });
        }
    });

    $("body").on('keyup', '#numerario', function () {
        var value = $(this).val(),
            transferencia = $("#transferencia").val(),
            cartao_de_debito = $("#cartao_de_debito").val(),
            total = $('#totalGeral').val();

        if(value != ''){
            $.ajax({
                url: './KwanzarApp/SystemApp/POS.inc.php',
                type: 'POST',
                data: 'acao=CalcII'+
                    "&numerario="+value+
                    "&transferencia="+transferencia+
                    "&cartao_de_debito="+cartao_de_debito+
                    "&total="+total+
                    "&id_db_settings="+id_db_settings,
                success: function(r){
                    $("#TodosOsDias").html(r);
                }
            });
        }
    });

    $("body").on('keyup', '#transferencia', function () {
        var value = $(this).val(),
            numerario = $("#numerario").val(),
            cartao_de_debito = $("#cartao_de_debito").val(),
            total = $('#totalGeral').val();

        if(value != ''){
            $.ajax({
                url: './KwanzarApp/SystemApp/POS.inc.php',
                type: 'POST',
                data: 'acao=CalcII'+
                    "&transferencia="+value+
                    "&numerario="+numerario+
                    "&cartao_de_debito="+cartao_de_debito+
                    "&total="+total+
                    "&id_db_settings="+id_db_settings,
                success: function(r){
                    $("#TodosOsDias").html(r);
                }
            });
        }
    });

    $('body').on('keyup', '#searchProductTxt', function(r){
        var txt = $(this).val(),
            id_db_kwanzar = $('#id_db_kwanzar').val(),
            level = $('#level').val(),
            id_db_settings = $('#id_db_settings').val();

        var Rualidade = document.getElementById('Rualidade');
        var Fama = document.getElementById('Fama');

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
                    Rualidade.href = 'export/index.php?postId='+id_db_settings+"&link="+txt;
                    Fama.href = 'export/stock.php?postId='+id_db_settings+"&link="+txt;
                }
            });
        }
    });

    $('body').on('keyup', '#QuandoOKumbuCair', function(r){
        var txt = $(this).val(),
            id_db_kwanzar = $('#id_db_kwanzar').val(),
            level = $('#level').val(),
            id_db_settings = $('#id_db_settings').val();

        if(txt != ''){
            $.ajax({
                url: "./KwanzarApp/SystemApp/Settings.inc.php",
                type: "POST",
                data: "acao=QuandoOKumbuCair"+
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

    $('body').on('keyup', '#searchCustommersTxt', function(r){
        var txt = $(this).val(),
            id_db_kwanzar = $('#id_db_kwanzar').val(),
            level = $('#level').val(),
            id_user = $("#id_user").val(),
            id_db_settings = $('#id_db_settings').val();

        if(txt != ''){
            $.ajax({
                url: "./KwanzarApp/SystemApp/Settings.inc.php",
                type: "POST",
                data: "acao=searchCustommersTxt"+
                    "&txt="+txt+
                    "&level="+level+
                    "&id_user="+id_user+
                    "&id_db_kwanzar="+id_db_kwanzar+
                    "&id_db_settings="+id_db_settings,
                success: function(r){
                    $("#Vuvu").html(r);
                }
            });
        }
    });

    $('form[name="FormCategory"]').on('submit', function(){
        var button = $(this).find(':button'),
            category_title = $("#category_title").val(),
            category_content = $("#category_content").val(),
            porcentagem_ganho = $("#porcentagem_ganho").val();


        button.attr('disabled', true);

        $.ajax({
            url: './KwanzarApp/SystemApp/Settings.inc.php',
            type: 'POST',
            data: 'acao=FormCategory'+
                "&category_title="+category_title+
                "&category_content="+category_content+
                "&porcentagem_ganho="+porcentagem_ganho+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                button.html('Aguarde...');
            }, success: function(r){
                button.html('Adicionar nova categoria').attr('disabled', false);
                getResult.html(r);
            }
        });

        return false;
    });

    $('form[name="FormMarca"]').on('submit', function(){
        var button = $(this).find(':button'),
            marca = $("#marca").val(),
            content = $("#content").val();


        button.attr('disabled', true);

        $.ajax({
            url: './KwanzarApp/SystemApp/Settings.inc.php',
            type: 'POST',
            data: 'acao=FormMarca'+
                "&marca="+marca+
                "&content="+content+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                button.html('Aguarde...');
            }, success: function(r){
                button.html('Adicionar nova Marca').attr('disabled', false);
                getResult.html(r);
            }
        });

        return false;
    });

    $('form[name="FormCreateAccounting"]').on('submit', function(){
        var name = $('#name').val(),
            username = $('#username').val(),
            password = $("#password").val(),
            telefone = $('#telefone').val();

        var button = $(this).find(':button');
        button.attr('disabled', true);

        $.ajax({
            url: '_disk/FunctionsApp/settings.inc.php',
            type: 'POST',
            data: 'acao=CreateAccounting'+
                "&name="+name+
                "&username="+username+
                "&password="+password+
                "&telefone="+telefone,
            beforeSend: function(){
                button.html('Aguarde...');
            }, success: function(r){
                button.html('Criar nova conta').attr('disabled', false);
                $("#getResult").html(r);
            }
        });

        return false;
    });

    $('form[name="form_register"]').on('submit', function(){
        var botao = $(this).find(':button');

        var empresa = $('#empresa').val(),
            nif = $("#nif").val(),
            telefone = $("#telefone").val(),
            email = $("#email").val(),
            endereco = $("#endereco").val(),
            atividade = $("#atividade").val();

        $.ajax({
            url: "_disk/FunctionsApp/settings.inc.php",
            type: "POST",
            data: "acao=Settings"+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&empresa="+empresa+
                "&nif="+nif+
                "&telefone="+telefone+
                "&email="+email+
                "&endereco="+endereco+
                "&atividade="+atividade,
            beforeSend: function(){
                botao.html('Aguarde...').attr('disabled', true);
            }, success: function(retorno){
                botao.attr('disabled', false).html('Salvar');
                $("#getResult").html(retorno);
            }
        });

        return false;
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

    $('form[name="FormCreateCustomer"]').on('submit', function(){
        var button = $(this).find(':button'),
            nome = $("#nome").val(),
            nif = $("#nif").val(),
            telefone = $("#telefone").val(),
            email = $("#email").val(),
            endereco = $("#endereco").val(),
            type = $("#type").val(),
            city = $("#city").val(),
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
                "&city="+city+
                "&obs="+obs+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                button.html('Aguarde...');
            }, success: function(r){
                readyCustomers();
                readyCustomersII();
                button.html('Salvar').attr('disabled', false);
                $("#getResult").html(r);
            }
        });

        return false;
    });


    $('form[name="FormCreateObs"]').on('submit', function(){
        var button = $(this).find(':button'),
            nome = $("#nomeS").val();

        button.attr('disabled', true);

        $.ajax({
            url: './KwanzarApp/SystemApp/Settings.inc.php',
            type: 'POST',
            data: 'acao=FormCreateObs'+
                "&nome="+nome+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
            beforeSend: function(){
                button.html('Aguarde...');
            }, success: function(r){
                readyObs();
                button.html('Salvar').attr('disabled', false);
                $("#getResult").html(r);
            }
        });

        return false;
    });

    $('#SearchProduct').keyup(function(){
        var searching = $(this).val(),
            SearchProduct01 = $("#SearchProduct01").val();

        $.ajax({
            url: './KwanzarApp/SystemApp/POS.inc.php',
            type: 'POST',
            data: 'acao=SearchProduct'+
                "&SearchProduct="+searching+
                "&SearchProduct01="+SearchProduct01+
                "&id_user="+id_user+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&level="+level+
                "&id_db_settings="+id_db_settings,
            success: function(r){
                $("#POSET").html(r);
            }
        });
    });

    $('#SearchProduct01').keyup(function(){
        var searching = $(this).val(),
            SearchProduct = $("#SearchProduct").val();


        $.ajax({
            url: './KwanzarApp/SystemApp/POS.inc.php',
            type: 'POST',
            data: 'acao=SearchProduct'+
                "&SearchProduct01="+searching+
                "&SearchProduct="+SearchProduct+
                "&id_user="+id_user+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&level="+level+
                "&id_db_settings="+id_db_settings,
            success: function(r){
                $("#POSET").html(r);
            }
        });
    });

    $('body').on('keyup', '#eliudyTomas', function(r){
        var txt = $(this).val();

        if(txt != ''){
            $.ajax({
                url: "./_disk/FunctionsApp/settings.inc.php",
                type: "POST",
                data: "acao=RealNigga"+
                    "&txt="+txt,
                success: function(r){
                    $("#IsabelDavid").html(r);
                }
            });

            $.ajax({
                url: "./_disk/FunctionsApp/settings.inc.php",
                type: "POST",
                data: "acao=MoDred"+
                    "&txt="+txt,
                success: function(r){
                    $("#Ack").html(r);
                }
            });
        }
    });

    $('body').on('keyup', "#PorcentagemP", function () {
        var porcentagem = $(this).val(),
            custo_compra = $("#custo_compra").val(),
            id_user = $("#id_user").val();

        if(custo_compra != ''){
            $.ajax({
                url: "./KwanzarApp/SystemApp/Settings.inc.php",
                type: "POST",
                data: "acao=PorcentagemP"+
                    "&porcentagem="+porcentagem+
                    "&custo_compra="+custo_compra+
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

    $('body').on('keyup', "#custo_compra", function () {
        var custo_compra = $(this).val(),
            PorcentagemP = $("#PorcentagemP").val(),
            id_user = $("#id_user").val();

        if(PorcentagemP != ''){
            $.ajax({
                url: "./KwanzarApp/SystemApp/Settings.inc.php",
                type: "POST",
                data: "acao=PorcentagemP"+
                    "&porcentagem="+PorcentagemP+
                    "&custo_compra="+custo_compra+
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

    loadingPOS(id_user);
    loadingPOSX(id_user);
    var getResult = $("#getResult"),
        StayStrong = $('#StayStrong'),
        aPaulo = $(".aPaulo"),
        id_db_kwanzar = $('#id_db_kwanzar').val(),
        id_db_settings = $('#id_db_settings').val(),
        method = $('#method').val(),
        level  = $('#level').val();


    $('#SearchProductxxx').keyup(function(){
        var searching = $(this).val()
            number_x = $("#number_x").val(),
            SearchProductxxx00 = $("#SearchProductxxx00").val(),
            InvoiceType_x  = $("#InvoiceType_x").val();

        $.ajax({
            url: './KwanzarApp/SystemApp/POS.inc.php',
            type: 'POST',
            data: 'acao=SearchProductxxx'+
                "&SearchProductxxx="+searching+
                "&SearchProductxxx00="+SearchProductxxx00+
                "&id_user="+id_user+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&level="+level+
                "&InvoiceType="+InvoiceType_x+
                "&Number="+number_x+
                "&id_db_settings="+id_db_settings,
            success: function(r){
                $("#POSETX").html(r);
            }
        });
    });

    $('#SearchProductxxx00').keyup(function(){
        var searching = $(this).val(),
            SearchProductxxx = $("#SearchProductxxx").val(),
            number_x = $("#number_x").val(),
            InvoiceType_x  = $("#InvoiceType_x").val();


        $.ajax({
            url: './KwanzarApp/SystemApp/POS.inc.php',
            type: 'POST',
            data: 'acao=SearchProductxxx'+
                "&SearchProductxxx00="+searching+
                "&SearchProductxxx="+SearchProductxxx+
                "&id_user="+id_user+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&level="+level+
                "&InvoiceType="+InvoiceType_x+
                "&Number="+number_x+
                "&id_db_settings="+id_db_settings,
            success: function(r){
                $("#POSETX").html(r);
            }
        });
    });
});
/**
 * Aceitar e rejeitar os termos de serviços.
 * @type {boolean}
 */
document.getElementById("btnCreateNewCount").disabled = true;
function TermsAnd(a){
    if(a.checked){
        document.getElementById("btnCreateNewCount").disabled = false;
    }else{
        document.getElementById("btnCreateNewCount").disabled = true;
    }
}

function readyCustomers(){
    id_db_settings = document.getElementById("id_db_settings").value;
    id_db_kwanzar = document.getElementById('id_db_kwanzar').value;
    levels = document.getElementById('level').value;

    $.ajax({
        url: './KwanzarApp/SystemApp/Settings.inc.php',
        type: 'POST',
        data: 'acao=readyCustomers'+
            "&id_db_kwanzar="+id_db_kwanzar+
            "&level="+levels+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            $("#Vuvu").html(r);
        }
    });
}

function readyCustomersII(){
    id_db_settings = document.getElementById("id_db_settings").value;
    id_db_kwanzar = document.getElementById('id_db_kwanzar').value;
    levels = document.getElementById('level').value;

    $.ajax({
        url: './KwanzarApp/SystemApp/Settings.inc.php',
        type: 'POST',
        data: 'acao=readyCustomersII'+
            "&id_db_kwanzar="+id_db_kwanzar+
            "&level="+levels+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            $("#customer").html(r);
        }
    });
}

function readyObs(){
    id_db_settings = document.getElementById("id_db_settings").value;
    id_db_kwanzar = document.getElementById('id_db_kwanzar').value;
    levels = document.getElementById('level').value;

    $.ajax({
        url: './KwanzarApp/SystemApp/Settings.inc.php',
        type: 'POST',
        data: 'acao=readyObs'+
            "&id_db_kwanzar="+id_db_kwanzar+
            "&level="+levels+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            $("#Seketxe").html(r);
        }
    });
}

function DeleteCategory(id){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_db_kwanzar = document.getElementById('id_db_kwanzar').value;
    var getResult = document.getElementById('getResult');

    if(confirm('Ops: certeza que desejas eliminar a Categoria?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/Settings.inc.php",
            type: "POST",
            data: "acao=DeleteCategory"+
                "&id="+id+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
            success: function(result){
                getResult.html(result);
            }
        });
    }
}

function DeleteMarca(id){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_db_kwanzar = document.getElementById('id_db_kwanzar').value;
    var getResult = document.getElementById('getResult');

    if(confirm('Ops: certeza que desejas eliminar a Marca?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/Settings.inc.php",
            type: "POST",
            data: "acao=DeleteMarca"+
                "&id="+id+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
            success: function(result){
                getResult.html(result);
            }
        });
    }
}

function DeleteProduct(id){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_db_kwanzar = document.getElementById('id_db_kwanzar').value;
    var getResult = document.getElementById('getResult');

    if(confirm('Ops: certeza que desejas eliminar o Produto?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/Settings.inc.php",
            type: "POST",
            data: "acao=DeleteProduct"+
                "&id="+id+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
            success: function(result){
                $("#aPaulo").html(result);
            }
        });
    }
}

function DeleteProductx(id){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_db_kwanzar = document.getElementById('id_db_kwanzar').value;
    var getResult = document.getElementById('getResult');

    if(confirm('Ops: certeza que desejas eliminar o Material?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/Settings.inc.php",
            type: "POST",
            data: "acao=DeleteProductx"+
                "&id="+id+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
            success: function(result){
                $("#getResult").html(result);
            }
        });
    }
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

function SuspanseL(id){
    if(confirm('Confirme a suspensão/activação do cPanel!')){
        $.post('./KwanzarApp/SystemApp/Configurations.inc.php', {
            acao: 'SuspanseL',
            id: id
        }, function(ret){
            $("#getResult").html(ret);
        });
    }
}

function DeleteCustomer(id){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_db_kwanzar = document.getElementById('id_db_kwanzar').value;
    var getResult = document.getElementById('aPaulo');

    if(confirm('Oops: desejas apagar o cliente da base de dados?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/Settings.inc.php",
            type: "POST",
            data: "acao=DeleteCustomer"+
                "&id="+id+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
            success: function(result){
                $("#aPaulo").html(result);
            }
        });
    }
}

function DeleteObs(id){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_db_kwanzar = document.getElementById('id_db_kwanzar').value;
    var getResult = document.getElementById('aPaulo');

    if(confirm('Oops: desejas apagar a observação da base de dados?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/Settings.inc.php",
            type: "POST",
            data: "acao=DeleteObs"+
                "&id="+id+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
            success: function(result){
                $("#aPaulo").html(result);
            }
        });
    }
}

function AnularVenda(){
    var level          = document.getElementById('level').value;
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user        = document.getElementById('id_user').value;

    if(confirm('Desejas suspender a venda?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/POS.inc.php",
            type: "POST",
            data: "acao=AnularVenda"+
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
                        $('#RealNigga').html(eu);
                    }
                });
            }
        });
    }
}

function FinalizarVenda(){
    //var level = document.getElementById('id_db_settings').value;
    var page_found = document.getElementById("page_found").value;
    var id_db_kwanzar = document.getElementById("id_db_kwanzar").value;
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user        = document.getElementById('id_user').value;
    var pagou          = document.getElementById('pagou').value;
    var troco          = document.getElementById('troco').value;
    var level          = document.getElementById('level').value;

    var cartao_de_debito   = document.getElementById('cartao_de_debito').value;
    var transferencia      = document.getElementById('transferencia').value;
    var numerario          = document.getElementById('numerario').value;
    var all_total          = document.getElementById('all_total').value;

    if(confirm('Desejas salvar permanentemente a venda?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/POS.inc.php",
            type: "POST",
            data: "acao=FinalizarVenda"+
                "&page_found="+page_found+
                "&level="+level+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings+
                "&id_user="+id_user+
                "&pagou="+pagou+
                "&cartao_de_debito="+cartao_de_debito+
                "&transferencia="+transferencia+
                "&numerario="+numerario+
                "&all_total="+all_total+
                "&troco="+troco,
            beforeSend: function(object){
                $("#sd_billing").html("Mensagem: "+object);
            }, success: function(r){
                $("#sd_billing").html(r);

                $.ajax({
                    url: "./KwanzarApp/SystemApp/POS.inc.php",
                    type: "POST",
                    data: "acao=Atualiza"+
                        "&page_found="+page_found+
                        "&level="+level+
                        "&id_db_kwanzar="+id_db_kwanzar+
                        "&id_db_settings="+id_db_settings+
                        "&id_user="+id_user,
                    success: function(eu){
                        $('#RealNigga').html(eu);
                    }
                });

                $.ajax({
                    url: "./KwanzarApp/SystemApp/POS.inc.php",
                    type: "POST",
                    data: "acao=Fac"+
                        "&page_found="+page_found+
                        "&id_db_settings="+id_db_settings+
                        "&id_user="+id_user+
                        "&level="+level,
                    success: function(m){
                        $('#King').html(m);
                    }
                });

                $.ajax({
                    url: "./KwanzarApp/SystemApp/POS.inc.php",
                    type: "POST",
                    data: "acao=Venda01"+
                        "&page_found="+page_found+
                        "&id_db_settings="+id_db_settings+
                        "&id_user="+id_user+
                        "&level="+level,
                    success: function(url){
                        //alert(url);
                        window.open(url);
                    }
                });

                loadingPOS(id_user);
            }
        });
    }
}

function FinalizarProforma(){
    //var level = document.getElementById('id_db_settings').value;
    var page_found = document.getElementById("page_found").value;
    var id_db_kwanzar = document.getElementById("id_db_kwanzar").value;
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user        = document.getElementById('id_user').value;
    var pagou          = document.getElementById('pagou').value;
    var troco          = document.getElementById('troco').value;
    var level          = document.getElementById('level').value;

    if(confirm('Desejas salvar permanentemente a proforma?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/POS.inc.php",
            type: "POST",
            data: "acao=FinalizarVendaII"+
                "&page_found="+page_found+
                "&level="+level+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings+
                "&id_user="+id_user+
                "&pagou="+pagou+
                "&troco="+troco,
            beforeSend: function(object){
                $("#sd_billing").html("Mensagem: "+object);
            }, success: function(r){
                $("#sd_billing").html(r);

                $.ajax({
                    url: "./KwanzarApp/SystemApp/POS.inc.php",
                    type: "POST",
                    data: "acao=Atualiza"+
                        "&page_found="+page_found+
                        "&level="+level+
                        "&id_db_kwanzar="+id_db_kwanzar+
                        "&id_db_settings="+id_db_settings+
                        "&id_user="+id_user,
                    success: function(eu){
                        //alert(eu);
                        $('#RealNigga').html(eu);
                    }
                });

                $.ajax({
                    url: "./KwanzarApp/SystemApp/POS.inc.php",
                    type: "POST",
                    data: "acao=Facs"+
                        "&page_found="+page_found+
                        "&id_db_settings="+id_db_settings+
                        "&id_user="+id_user+
                        "&level="+level,
                    success: function(m){
                        //alert(eu);
                        $('#Kings').html(m);
                    }
                });

                $.ajax({
                    url: "./KwanzarApp/SystemApp/POS.inc.php",
                    type: "POST",
                    data: "acao=Proforma01"+
                        "&page_found="+page_found+
                        "&id_db_settings="+id_db_settings+
                        "&id_user="+id_user+
                        "&level="+level,
                    success: function(url){
                        //alert(url);
                        window.open(url);
                    }
                });

                loadingPOS(id_user);
            }
        });
    }
}

function DadosDaFactura(){
    var page_found       = document.getElementById('page_found').value;
    var id_db_kwanzar       = document.getElementById('id_db_kwanzar').value;
    var id_db_settings       = document.getElementById('id_db_settings').value;
    var level                = document.getElementById('level').value;
    var id_user              = document.getElementById('id_user').value;
    var id_obs              = document.getElementById('id_obs').value;
    var referencia           = document.getElementById('referencia').value;
    var TaxPointDate         = document.getElementById('TaxPointDate').value;
    var customer             = document.getElementById('customer').value;
    var InvoiceType          = document.getElementById('InvoiceType').value;
    var SourceBilling        = document.getElementById('SourceBilling').value;
    var method               = document.getElementById('method').value;
    var settings_desc_financ = document.getElementById('settings_desc_financ').value;
    var id_veiculos        = document.getElementById('id_veiculos').value;
    var matriculas               = document.getElementById('matriculas').value;
    var id_fabricante = document.getElementById('id_fabricante').value;
    //var pagou = document.getElementById('pagou').value;
    //var troco = document.getElementById('troco').value;



    //if(confirm('Deseja criar/alterar factura?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/POS.inc.php",
            type: "POST",
            data: "acao=DadosDaFactura"+
                "&page_found="+page_found+
                "&level="+level+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings+
                "&id_user="+id_user+
                "&id_obs="+id_obs+
                "&TaxPointDate="+TaxPointDate+
                "&customer="+customer+
                "&SourceBilling="+SourceBilling+
                "&InvoiceType="+InvoiceType+
                "&referencia="+referencia+
                "&settings_desc_financ="+settings_desc_financ+
                "&id_veiculos="+id_veiculos+
                "&matriculas="+matriculas+
                "&id_fabricante="+id_fabricante+
                "&method="+method,
            beforeSend: function(object){
                $("#sd_billing").html("Mensagem: "+object);
            }, success: function(r){
                $("#sd_billing").html(r);
            }
        });
    //}
}

function DadosDaFactura01(){
    var page_found       = document.getElementById('page_found').value;
    var id_db_kwanzar       = document.getElementById('id_db_kwanzar').value;
    var id_db_settings       = document.getElementById('id_db_settings').value;
    var referencia           = document.getElementById('referencia').value;
    var level                = document.getElementById('level').value;
    var id_user              = document.getElementById('id_user').value;
    var id_obs              = document.getElementById('id_obs').value;
    var TaxPointDate         = document.getElementById('TaxPointDate').value;
    var customer             = document.getElementById('customer').value;
    var InvoiceType          = document.getElementById('InvoiceType').value;
    var SourceBilling        = document.getElementById('SourceBilling').value;
    var method               = document.getElementById('method').value;
    var settings_desc_financ = document.getElementById('settings_desc_financ').value;
    var id_veiculos        = document.getElementById('id_veiculos').value;
    var matriculas               = document.getElementById('matriculas').value;
    var id_fabricante = document.getElementById('id_fabricante').value;
    //var pagou = document.getElementById('pagou').value;
    //var troco = document.getElementById('troco').value;



    //if(confirm('Deseja criar/alterar factura?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/POS.inc.php",
            type: "POST",
            data: "acao=DadosDaFactura01"+
                "&page_found="+page_found+
                "&level="+level+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings+
                "&id_user="+id_user+
                "&id_obs="+id_obs+
                "&TaxPointDate="+TaxPointDate+
                "&customer="+customer+
                "&referencia="+referencia+
                "&SourceBilling="+SourceBilling+
                "&InvoiceType="+InvoiceType+
                "&settings_desc_financ="+settings_desc_financ+
                "&id_veiculos="+id_veiculos+
                "&matriculas="+matriculas+
                "&id_fabricante="+id_fabricante+
                "&method="+method,
            beforeSend: function(object){
                $("#sd_billing").html("Mensagem: "+object);
            }, success: function(r){
                $("#sd_billing").html(r);
            }
        });
    //}
}

function RemovePS(id){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var level = document.getElementById("level").value;
    var id_user = document.getElementById('id_user').value;
    var page_found = document.getElementById('page_found').value;

    if(confirm('Deseja remover o item selecionado da factura?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/POS.inc.php",
            type: "POST",
            data: "acao=RemovePS"+
                "&page_found="+page_found+
                "&id_product="+id+
                "&level="+level+
                "&id_db_settings="+id_db_settings+
                "&id_user="+id_user,
            beforeSend: function(object){
                $("#RealNigga").html("Mensagem: "+object);
            }, success: function(r){
                $("#RealNigga").html(r);
            }
        });
    }
}

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

function fecharModal() {
    document.getElementById('ModalsCarregarProdutos').style.display = 'none';
    $('#ModalsCarregarProdutos').modal('hide');
}

function adicionar(id){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var page_found = document.getElementById('page_found').value;
    var id_user = document.getElementById('id_user').value;
    var quantidade = document.getElementById('quantidade_'+id).value;
    var preco = document.getElementById('preco_'+id).value;
    var taxa = document.getElementById('taxa_'+id).value;
    var level = document.getElementById("level").value;
    var desconto = document.getElementById('desconto_'+id).value;
    var codigo_barras = document.getElementById('codigo_barras_'+id).value;

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
            "&page_found="+page_found+
            "&id_product="+id+
            "&id_db_settings="+id_db_settings+
            "&id_user="+id_user+
            "&level="+level+
            "&codigo_barras="+codigo_barras+
            "&quantidade="+quantidade+
            "&preco="+preco+
            "&taxa="+taxa+
            "&desconto="+desconto,
        beforeSend: function(object){
            $("#RealNigga").html("Mensagem: "+object);
        }, success: function(r){
            $("#RealNigga").html(r);
            fecharModal();
            $("#ModalsCarregarProdutos").hide();
            $(".modal-backdrop").hide();
            document.body.style.overflow = '';
        }
    });
}

function Retification(id, Invoice){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user        = document.getElementById('id_user').value;
    var TaxPointDate   = document.getElementById('TaxPointDate').value;
    var InvoiceType    = document.getElementById('InvoiceType').value;
    var method         = document.getElementById('method').value;
    //var SourceBilling  = document.getElementById('SourceBilling').value;
    var settings_doctype= document.getElementById('settings_doctype').value;

    if(confirm('Deseja criar o documento de retificação?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/POS.inc.php",
            type: "POST",
            data: "acao=Retification"+
                "&Invoice="+Invoice+
                "&id_db_settings="+id_db_settings+
                "&id_user="+id_user+
                "&TaxPointDate="+TaxPointDate+
                "&InvoiceType="+InvoiceType+
                "&settings_doctype="+settings_doctype+
                "&method="+method+
                "&id_invoice="+id,
            beforeSend: function(object){
                $("#Rap").html("Mensagem: "+object);
            }, success: function(r){
                $("#Rap").html(r);
            }
        });
    }
}

function AddRetification(id, InvoiceType, iddInvoice, Number){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_invoice = document.getElementById('id_invoice').value;
    var id_user        = document.getElementById('id_user').value;
    var quantidade     = document.getElementById('quantidade_'+id).value;
    var status         = document.getElementById('status_'+id).value;
    var idd            = document.getElementById('idd_'+id).value;


    if(isNaN(quantidade)){
        alert('Ops: o campo quantidade tem que ser do tipo numerico, isso é: não pode conter espaços, pontou ou virgulas.');
        quantidade = document.getElementById('quantidade_'+id).focus();
        return false;
    }

    if(confirm('Deseja adiconar o seguinte item no documento de retificação?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/POS.inc.php",
            type: "POST",
            data: "acao=AddRetification"+
                "&id_sd_billing_pmp="+id+
                "&InvoiceType="+InvoiceType+
                "&id_db_settings="+id_db_settings+
                "&Number="+Number+
                "&id_user="+id_user+
                "&status="+status+
                "&idd="+idd+
                "&iddInvoice="+iddInvoice+
                "&quantidade="+quantidade,
            beforeSend: function(object){
                $("#getAlert").html("Mensagem: "+object);
            }, success: function(r){
                $("#getAlert").html(r);

                $.ajax({
                    url: "./KwanzarApp/SystemApp/POS.inc.php",
                    type: "POST",
                    data: "acao=Xvideos"+
                        "&id_sd_billing_pmp="+id+
                        "&id_invoice="+id_invoice+
                        "&InvoiceType="+InvoiceType+
                        "&id_db_settings="+id_db_settings+
                        "&id_user="+id_user+
                        "&status="+status+
                        "&idd="+idd+
                        "&iddInvoice="+iddInvoice,
                    success: function(eu){
                        //alert(eu);
                        $('#Rap').html(eu);
                    }
                });
            }
        });
    }
}

function RemFinish(InvoiceType, Number, iddInvoice, is_number){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user = document.getElementById('id_user').value;
    var level = document.getElementById('level').value;

    if(confirm('Deseja finalizar o documento de retificação?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/POS.inc.php",
            type: "POST",
            data: "acao=RemFinish"+
                "&Number="+Number+
                "&InvoiceType="+InvoiceType+
                "&id_db_settings="+id_db_settings+
                "&iddInvoice="+iddInvoice+
                "&is_number="+is_number+
                "&id_user="+id_user,
            beforeSend: function(object){
                $("#getAlert").html("Mensagem: "+object);
            }, success: function(r){
                $("#getAlert").html(r);


                $.ajax({
                    url: "./KwanzarApp/SystemApp/POS.inc.php",
                    type: "POST",
                    data: "acao=Atualiza"+
                        "&Number="+Number+
                        "&InvoiceType="+InvoiceType+
                        "&iddInvoice="+iddInvoice+
                        "&id_db_settings="+id_db_settings+
                        "&id_user="+id_user,
                    success: function(eu){
                        //alert(eu);
                        $('#RealNigga').html(eu);
                    }
                });

                $.ajax({
                    url: "./KwanzarApp/SystemApp/POS.inc.php",
                    type: "POST",
                    data: "acao=Fac"+
                        "&Number="+Number+
                        "&InvoiceType="+InvoiceType+
                        "&id_db_settings="+id_db_settings+
                        "&iddInvoice="+iddInvoice+
                        "&id_user="+id_user+
                        "&level="+level,
                    success: function(m){
                        //alert(eu);
                        $('#King').html(m);
                    }
                });

                $.ajax({
                    url: "./KwanzarApp/SystemApp/POS.inc.php",
                    type: "POST",
                    data: "acao=Xvideos"+
                        "&id_invoice="+Number+
                        "&InvoiceType="+InvoiceType+
                        "&id_db_settings="+id_db_settings+
                        "&id_user="+id_user+
                        "&iddInvoice="+iddInvoice,
                    success: function(eu){
                        $('#Rap').html(eu);
                    }
                });

                $.ajax({
                    url: "./KwanzarApp/SystemApp/POS.inc.php",
                    type: "POST",
                    data: "acao=Venda02"+
                        "&id_db_settings="+id_db_settings+
                        "&id_user="+id_user+
                        "&level="+level,
                    success: function(url){
                        //alert(url);
                        window.open(url);
                    }
                });
            }
        });
    }
}


function Guid(id, Invoice){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user        = document.getElementById('id_user').value;
    var TaxPointDate   = document.getElementById('TaxPointDate').value;
    var InvoiceType    = document.getElementById('InvoiceType').value;
    var method         = document.getElementById('method').value;
    //var SourceBilling  = document.getElementById('SourceBilling').value;
    var guid_name      = document.getElementById('guid_name').value;
    var guid_matricula = document.getElementById('guid_matricula').value;
    var guid_obs       = document.getElementById('guid_obs').value;
    var guid_endereco  = document.getElementById('guid_endereco').value;
    var guid_city      = document.getElementById('guid_city').value;
    var guid_postal    = document.getElementById('guid_postal').value;

    if(confirm('Deseja criar emitir a guia de transporte?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/POS.inc.php",
            type: "POST",
            data: "acao=Guid"+
                "&Invoice="+Invoice+
                "&id_db_settings="+id_db_settings+
                "&id_user="+id_user+
                "&TaxPointDate="+TaxPointDate+
                "&InvoiceType="+InvoiceType+
                //"&SourceBilling="+SourceBilling+
                "&method="+method+
                "&guid_name="+guid_name+
                "&guid_matricula="+guid_matricula+
                "&guid_obs="+guid_obs+
                "&guid_endereco="+guid_endereco+
                "&guid_city="+guid_city+
                "&guid_postal="+guid_postal+
                "&id_invoice="+id,
            beforeSend: function(object){
                $("#Rap").html("Mensagem: "+object);
            }, success: function(r){
                $("#Rap").html(r);
            }
        });
    }
}


function AddGuid(id, InvoiceType){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user        = document.getElementById('id_user').value;
    var quantidade     = document.getElementById('quantidade_'+id).value;
    var status         = document.getElementById('status_'+id).value;
    var idd            = document.getElementById('idd_'+id).value;


    if(isNaN(quantidade)){
        alert('Ops: o campo quantidade tem que ser do tipo numerico, isso é: não pode conter espaços, pontou ou virgulas.');
        quantidade = document.getElementById('quantidade_'+id).focus();
        return false;
    }

    if(confirm('Deseja adiconar o seguinte item na Guia de transporte?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/POS.inc.php",
            type: "POST",
            data: "acao=AddGuid"+
                "&id_sd_billing_pmp="+id+
                "&InvoiceType="+InvoiceType+
                "&id_db_settings="+id_db_settings+
                "&id_user="+id_user+
                "&status="+status+
                "&idd="+idd+
                "&quantidade="+quantidade,
            beforeSend: function(object){
                $("#getAlert").html("Mensagem: "+object);
            }, success: function(r){
                $("#getAlert").html(r);
            }
        });
    }
}

function GuidFinish(InvoiceType, Number){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user = document.getElementById('id_user').value;
    var level = document.getElementById('level').value;

    if(confirm('Deseja finalizar a guia de transporte?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/POS.inc.php",
            type: "POST",
            data: "acao=GuidFinish"+
                "&Number="+Number+
                "&InvoiceType="+InvoiceType+
                "&id_db_settings="+id_db_settings+
                "&id_user="+id_user,
            beforeSend: function(object){
                $("#getAlert").html("Mensagem: "+object);
            }, success: function(r){
                $("#getAlert").html(r);

                $.ajax({
                    url: "./KwanzarApp/SystemApp/POS.inc.php",
                    type: "POST",
                    data: "acao=AtualizaGuid"+
                        "&Number="+Number+
                        "&InvoiceType="+InvoiceType+
                        "&id_db_settings="+id_db_settings+
                        "&id_user="+id_user,
                    success: function(eu){
                        //alert(eu);
                        $('#RealNigga').html(eu);
                    }
                });

                $.ajax({
                    url: "./KwanzarApp/SystemApp/POS.inc.php",
                    type: "POST",
                    data: "acao=Fac"+
                        "&Number="+Number+
                        "&InvoiceType="+InvoiceType+
                        "&id_db_settings="+id_db_settings+
                        "&id_user="+id_user+
                        "&level="+level,
                    success: function(m){
                        //alert(eu);
                        $('#King').html(m);
                    }
                });
            }
        });
    }
}

function ConfigUsers(){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user = document.getElementById('id_user').value;
    var Impression = document.getElementById('Impression').value;
    var NumberOfCopies = document.getElementById('NumberOfCopies').value;
    var PRecuvaPassword = document.getElementById('PRecuvaPassword').value;
    var RecuvaPassword = document.getElementById('RecuvaPassword').value;
    var Language = document.getElementById('Language').value;
    var positionMenu = document.getElementById('positionMenu').value;
    //var  = document.getElementById('').value;

    $.ajax({
        url: "./KwanzarApp/SystemApp/POS.inc.php",
        type: "POST",
        data: "acao=ConfigUsers"+
            "&id_db_settings="+id_db_settings+
            "&id_user="+id_user+
            "&Impression="+Impression+
            "&NumberOfCopies="+NumberOfCopies+
            "&PRecuvaPassword="+PRecuvaPassword+
            "&RecuvaPassword="+RecuvaPassword+
            "&Language="+Language+
            "&positionMenu="+positionMenu,
        beforeSend: function(object){
            $("#getError").html("Mensagem: "+object);
        }, success: function(r){
            $("#getError").html(r);
        }
    });
}

function DeleteTaxTable(idTax){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_db_kwanzar = document.getElementById('id_db_kwanzar').value;
    var getResult = document.getElementById('aPaulo');

    if(confirm('Ops: certeza que desejas eliminar a taxa de imposto?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/Settings.inc.php",
            type: "POST",
            data: "acao=DeleteTaxTable"+
                "&idTax="+idTax+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
            success: function(result){
                getResult.html(result);
            }
        });
    }
}

function DeleteUsers(IdUsers){
    var id_db_setting = document.getElementById('id_db_settings').value;
    var id_db_kwanzar = document.getElementById('id_db_kwanzar').value;
    var getResult = document.getElementById('getResult');

    if(confirm('Ops: deseja eliminar o presente usuário?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/Settings.inc.php",
            type: "POST",
            data: "acao=DeleteUsers"+
                "&IdUsers="+IdUsers+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_setting="+id_db_setting,
            success: function(result){
                getResult.html(result);
            }
        });
    }
}

function SuspenderConta(IdUsers){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_db_kwanzar = document.getElementById('id_db_kwanzar').value;
    var getResult = document.getElementById('getResult');

    if(confirm('Ops: deseja suspender a conta do presente usuário?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/Settings.inc.php",
            type: "POST",
            data: "acao=SuspenderConta"+
                "&IdUsers="+IdUsers+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
            success: function(result){
                getResult.html(result);
            }
        });
    }
}

function KwanzarDocsOne(){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user = document.getElementById('id_user').value;
    var dateI = document.getElementById('dateI').value;
    var dateF = document.getElementById('dateF').value;
    var TypeDoc = document.getElementById('TypeDoc').value;
    var Function_id = document.getElementById('Function_id').value;
    var Customers_id = document.getElementById('Customers_id').value;
    var Itens_id = document.getElementById('Itens_id').value;
    var Categories_id = document.getElementById('Categories_id').value;
    var method_id = document.getElementById('method_id').value;
    var Itens_type = document.getElementById('Itens_type').value;

    $.ajax({
        url: "./KwanzarApp/AppData/KwanzarDocsOne.php",
        type: "POST",
        data: "acao=DocumentPdv"+
            "&id_db_settings="+id_db_settings+
            "&id_user="+id_user+
            "&TypeDoc="+TypeDoc+
            "&Itens_id="+Itens_id+
            "&Itens_type="+Itens_type+
            "&Categories_id="+Categories_id+
            "&Function_id="+Function_id+
            "&Customers_id="+Customers_id+
            "&method_id="+method_id+
            "&dateI="+dateI+
            "&dateF="+dateF,
        beforeSend: function(object){
            $("#Azagia").html("Mensagem: "+object);
        }, success: function(r){
            $("#Azagia").html(r);
        }
    });
}

function WhitelabelDocsOne(){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var dateI = document.getElementById('dateI').value;
    var dateF = document.getElementById('dateF').value;
    var operacao = document.getElementById("operacao").value;

    $.ajax({
        url: "./KwanzarApp/AppData/WhitelabelDocsOne.php",
        type: "POST",
        data: "acao=DocumentPdv"+
            "&id_db_settings="+id_db_settings+
            "&dateI="+dateI+
            "&operacao="+operacao+
            "&dateF="+dateF,
        beforeSend: function(object){
            $("#getResult").html("Mensagem: "+object);
        }, success: function(r){
            $("#getResult").html(r);
        }
    });
}

function WhitelabelDocsTwo(){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var dateI = document.getElementById('dateI').value;
    var dateF = document.getElementById('dateF').value;

    $.ajax({
        url: "./KwanzarApp/AppData/WhitelabelDocsTwo.php",
        type: "POST",
        data: "acao=DocumentPdv"+
            "&id_db_settings="+id_db_settings+
            "&dateI="+dateI+
            "&dateF="+dateF,
        beforeSend: function(object){
            $("#getResult").html("Mensagem: "+object);
        }, success: function(r){
            $("#getResult").html(r);
        }
    });
}

function ProSmatDocsOne(){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var ILoja = document.getElementById('ILoja').value;
    var id_iva = document.getElementById('id_iva').value;
    var Itens_type = document.getElementById('Itens_type').value;
    var Categories_id = document.getElementById('Categories_id').value;

    $.ajax({
        url: "./KwanzarApp/AppData/ProSmartDocsOne.php",
        type: "POST",
        data: "acao=DocumentProducut"+
            "&id_db_settings="+id_db_settings+
            "&ILoja="+ILoja+
            "&id_iva="+id_iva+
            "&Itens_type="+Itens_type+
            "&Categories_id="+Categories_id,
        beforeSend: function(object){
            $("#getResult").html("Mensagem: "+object);
        }, success: function(r){
            $("#getResult").html(r);
        }
    });
}

function EliudyTomasDocs(){
    var dateI = document.getElementById('dateI').value;
    var dateF = document.getElementById('dateF').value;

    $.ajax({
        url: "./_disk/FunctionsApp/settings.inc.php",
        type: "POST",
        data: "acao=EliudyTomasDocs"+
            "&dateI="+dateI+
            "&dateF="+dateF,
        beforeSend: function(object){
            $("#EliudyTomasDocs").html("Mensagem: "+object);
        }, success: function(r){
            $("#EliudyTomasDocs").html(r);
        }
    });
}

function OnPurchase(){
    var id_product     = document.getElementById('id_product').value;
    var id_db_settings = document.getElementById('id_db_settings').value;
    var quantidade     = document.getElementById('quantidade').value;
    var unidade        = document.getElementById('unidade').value;
    var id_user        = document.getElementById('id_user').value;
    var level          = document.getElementById('level').value;


    if(confirm('Certeza que dejesas prosseguir com a entrada de estoque?')){
        $.ajax({
            url: './KwanzarApp/SystemApp/Settings.inc.php',
            type: 'POST',
            data: "acao=FormPurchase"+
                "&id_product="+id_product+
                "&quantidade="+quantidade+
                "&unidade="+unidade+
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

function TwoPurchase(id){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var quantidade     = document.getElementById('quantidade').value;
    var unidade        = document.getElementById('unidade').value;
    var id_user        = document.getElementById('id_user').value;


    if(confirm("Dejas mover os produtos para loja?")){
        $.ajax({
            url: './KwanzarApp/SystemApp/Settings.inc.php',
            type: 'POST',
            data: "acao=TwoPurchase"+
                "&id="+id+
                "&quantidade="+quantidade+
                "&unidade="+unidade+
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

function DeleteMesa(id){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_db_kwanzar = document.getElementById('id_db_kwanzar').value;
    var getResult = document.getElementById('aPaulo');

    if(confirm('Ops: certeza que desejas eliminar a Mesa?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/Settings.inc.php",
            type: "POST",
            data: "acao=DeleteMesa"+
                "&id="+id+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
            success: function(result){
                //alert(result);
                $("#aPaulo").html(result);
            }
        });
    }
}

function DeleteGarcom(id){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_db_kwanzar = document.getElementById('id_db_kwanzar').value;
    var getResult = document.getElementById('aPaulo');

    if(confirm('Ops: certeza que desejas eliminar o garçom?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/Settings.inc.php",
            type: "POST",
            data: "acao=DeleteGarcom"+
                "&id="+id+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
            success: function(result){
                $("#aPaulo").html(result);
            }
        });
    }
}

function Figma(postId){
    var id_db_kwanzar       = document.getElementById('id_db_kwanzar').value;
    var id_db_settings       = document.getElementById('id_db_settings').value;
    var level                = document.getElementById('level').value;
    var id_user              = document.getElementById('id_user').value;

    var InvoiceType          = document.getElementById('InvoiceType').value;
    var customer          = document.getElementById('customer').value;
    var method          = document.getElementById('method').value;

    var pagou          = document.getElementById('pagou').value;
    var troco          = document.getElementById('troco').value;

    var cartao_de_debito   = document.getElementById('cartao_de_debito').value;
    var transferencia      = document.getElementById('transferencia').value;
    var numerario          = document.getElementById('numerario').value;
    var all_total          = document.getElementById('all_total').value;

    if(confirm('Desejas converter esse documento?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/POS.inc.php",
            type: "POST",
            data: "acao=Figma"+
                "&postId="+postId+
                "&level="+level+
                "&method="+method+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings+
                "&customer="+customer+
                "&InvoiceType="+InvoiceType+
                "&id_user="+id_user+
                "&pagou="+pagou+
                "&cartao_de_debito="+cartao_de_debito+
                "&transferencia="+transferencia+
                "&numerario="+numerario+
                "&all_total="+all_total+
                "&troco="+troco,
            beforeSend: function(object){
                $("#Figma").html("Mensagem: "+object);
            }, success: function(r){
                $("#Figma").html(r);

                $.ajax({
                    url: "./KwanzarApp/SystemApp/POS.inc.php",
                    type: "POST",
                    data: "acao=Fac"+
                        "&id_db_settings="+id_db_settings+
                        "&id_user="+id_user+
                        "&level="+level,
                    success: function(m){
                        //alert(eu);
                        $('#King').html(m);
                    }
                });

                $.ajax({
                    url: "./KwanzarApp/SystemApp/POS.inc.php",
                    type: "POST",
                    data: "acao=Venda01"+
                        "&id_db_settings="+id_db_settings+
                        "&id_user="+id_user+
                        "&level="+level,
                    success: function(url){
                        //alert(url);
                        window.open(url);
                    }
                });
            }
        });
    }
}

function ExtractCustomer(){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var dateI = document.getElementById('dateI').value;
    var dateF = document.getElementById('dateF').value;;
    var Customers_id = document.getElementById('Customers_id').value;
    var method_id = document.getElementById('method_id').value;

    $.ajax({
        url: "./_disk/AppData/ExtractCustomer.inc.php",
        type: "POST",
        data: "acao=ExtractCustomer"+
            "&id_db_settings="+id_db_settings+
            "&dateI="+dateI+
            "&dateF="+dateF+
            "&Customers_id="+Customers_id+
            "&method_id="+method_id,
        beforeSend: function(object){
            $("#getResult").html("Mensagem: "+object);
        }, success: function(r){
            $("#getResult").html(r);
        }
    });
}

function RemovePSX(id){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var level = document.getElementById("level").value;
    var id_user = document.getElementById('id_user').value;

    var number_x = document.getElementById("number_x").value;
    var InvoiceType_x = document.getElementById('InvoiceType_x').value;

    if(confirm('Deseja remover o item selecionado da factura?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/POS.inc.php",
            type: "POST",
            data: "acao=RemovePSX"+
                "&id_product="+id+
                "&level="+level+
                "&Number="+number_x+
                "&InvoiceType="+InvoiceType_x+
                "&id_db_settings="+id_db_settings+
                "&id_user="+id_user,
            beforeSend: function(object){
                $("#RealNigga").html("Mensagem: "+object);
            }, success: function(r){
                $("#RealNigga").html(r);
            }
        });
    }
}

function loadingPOSX(id_user){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var level          = document.getElementById('level').value;
    var getResult      = document.getElementById('POSET');

    var number_x = document.getElementById("number_x").value;
    var InvoiceType_x = document.getElementById('InvoiceType_x').value;

    $.ajax({
        url: "./KwanzarApp/SystemApp/POS.inc.php",
        type: "POST",
        data: "acao=loadingPOSX"+
            "&id_user="+id_user+
            "&Number="+number_x+
            "&InvoiceType="+InvoiceType_x+
            "&level="+level+
            "&id_db_settings="+id_db_settings,
        success: function(result){
            $("#POSETX").html(result);
        }
    })
}

function adicionarX(id){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user = document.getElementById('id_user').value;
    var quantidade = document.getElementById('quantidade_'+id).value;
    var preco = document.getElementById('preco_'+id).value;
    var taxa = document.getElementById('taxa_'+id).value;
    var level = document.getElementById("level").value;
    var desconto = document.getElementById('desconto_'+id).value;

    var number_x = document.getElementById("number_x").value;
    var InvoiceType_x = document.getElementById('InvoiceType_x').value;

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
        data: "acao=AddX"+
            "&id_product="+id+
            "&id_db_settings="+id_db_settings+
            "&id_user="+id_user+
            "&level="+level+
            "&Number="+number_x+
            "&InvoiceType="+InvoiceType_x+
            "&quantidade="+quantidade+
            "&preco="+preco+
            "&taxa="+taxa+
            "&desconto="+desconto,
        beforeSend: function(object){
            $("#RealNigga").html("Mensagem: "+object);
        }, success: function(r){
            $("#RealNigga").html(r);
            fecharModal();
            $("#ModalsCarregarProdutos").hide();
            $(".modal-backdrop").hide();
            document.body.style.overflow = '';
        }
    });
}

function Mypassword() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

function AddViews(){
    var id_db_settings = document.getElementById('id_db_settings').value;

    $.ajax({
        url: "./KwanzarApp/SystemApp/POS.inc.php",
        type: "POST",
        data: "acao=AddViews"+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            $("#ReadViews").html(r);
        }
    });
}

function MyCheckBox(){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user = document.getElementById('id_user').value;
    var checkbox = document.getElementById("SalesType"),
        value = null;

    // Verificar se o checkbox está marcado ou desmarcado
    if (checkbox.checked) {
        value = 1;
    } else {
        value = 0;
    }

    $.ajax({
        url: "./KwanzarApp/SystemApp/POS.inc.php",
        type: "POST",
        data: "acao=MyCheckBox"+
            "&SalesType="+value+
            "&id_user="+id_user+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            $("#OnCheckBox").html(r);
            //loadingPOS(id_user);
            //loadingPOSX(id_user);
        }
    });
}

function CategorySelect(){
    var id_category = document.getElementById('id_category').value;
    var id_db_settings = document.getElementById('id_db_settings').value;

    var product = document.getElementById("product");
    var PorcentagemP = document.getElementById("PorcentagemP");

    $.ajax({
        url: "./KwanzarApp/SystemApp/Configurations.inc.php",
        type: "POST",
        data: "acao=CategorySelect"+
            "&id_category="+id_category+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            product.value = r;
        }
    });

    $.ajax({
        url: "./KwanzarApp/SystemApp/Configurations.inc.php",
        type: "POST",
        data: "acao=CategorySelectII"+
            "&id_category="+id_category+
            "&id_db_settings="+id_db_settings,
        success: function(ddd){
            PorcentagemP.value = ddd;
        }
    });
}

function MarcaSelect(){
    var id_marca = document.getElementById('id_marca').value;
    var id_db_settings = document.getElementById('id_db_settings').value;

    var product = document.getElementById("codigo");

    $.ajax({
        url: "./KwanzarApp/SystemApp/Configurations.inc.php",
        type: "POST",
        data: "acao=MarcaSelect"+
            "&id_marca="+id_marca+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            product.value += r;
        }
    });
}

function AdminSusPassword(id){
    if(confirm("Desejas repor a password do usuário?")){
        $.ajax({
            url: '_disk/_help/9e581bf659daf84b4f20a873cecdb47f.inc.php',
            type: 'POST',
            data: 'acao=06'+
                "&id="+id,
            success: function(r){
                $("#getResult").html(r);
            }
        });
    }
}

function AtualizarMethod(){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user = document.getElementById('id_user').value;

    var method = document.getElementById('method');
    var opcaoSelecionada = method.value;

    if (opcaoSelecionada === 'NU') {
        $.ajax({
            url: "./KwanzarApp/SystemApp/POS.inc.php",
            type: 'POST',
            data: 'acao=Champanhe01'+
                "&id_db_settings="+id_db_settings+
                "&id_user="+id_user,
            success: function(r){
                $("#Champanhe").html(r);
            }
        });
    } else if (opcaoSelecionada === 'ALL') {
        $.ajax({
            url: "./KwanzarApp/SystemApp/POS.inc.php",
            type: 'POST',
            data: 'acao=Champanhe02'+
                "&id_db_settings="+id_db_settings+
                "&id_user="+id_user,
            success: function(r){
                $("#Champanhe").html(r);
            }
        });
    } else {
        $.ajax({
            url: "./KwanzarApp/SystemApp/POS.inc.php",
            type: 'POST',
            data: 'acao=Champanhe03'+
                "&id_db_settings="+id_db_settings+
                "&id_user="+id_user,
            success: function(r){
                $("#Champanhe").html(r);
            }
        });
    }
}

function TaxPointDate(postId, Number){
    var TaxPointDate = document.getElementById("TaxPointDate").value;
    var id_db_kwanzar       = document.getElementById('id_db_kwanzar').value;
    var id_db_settings       = document.getElementById('id_db_settings').value;
    var level                = document.getElementById('level').value;
    var id_user              = document.getElementById('id_user').value;

    if(confirm('Desejas alterar a data do presente documento?')){
        $.ajax({
            url: "./KwanzarApp/SystemApp/POS.inc.php",
            type: "POST",
            data: "acao=TaxPointDate"+
                "&postId="+postId+
                "&level="+level+
                "&Number="+Number+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings+
                "&TaxPointDate="+TaxPointDate+
                "&id_user="+id_user,
            beforeSend: function(object){
                $("#DepoisDaTorne").html("Mensagem: "+object);
            }, success: function(r){
                $("#DepoisDaTorne").html(r);

                $.ajax({
                    url: "./KwanzarApp/SystemApp/POS.inc.php",
                    type: "POST",
                    data: "acao=Fac"+
                        "&id_db_settings="+id_db_settings+
                        "&id_user="+id_user+
                        "&level="+level,
                    success: function(m){
                        //alert(eu);
                        $('#King').html(m);
                    }
                });
            }
        });
    }
}