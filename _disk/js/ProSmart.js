$(document).ready(function () {
    var getResult = $("#getResult"),
        id_user = $("#id_user").val(),
        id_db_settings = $("#id_db_settings").val(),
        id_db_kwanzar = $('#id_db_kwanzar').val();

    $("body").on('keyup', "#SearchDocs", function (){
        var search    = $(this).val(),
            id_db_settings = $("#id_db_settings").val(),
            id_user   = $("#id_user").val();

        $.ajax({
            url: "./_disk/SystemApp/Documents.inc.php",
            type: "POST",
            data: "acao=SearchDocs"+
                "&search="+search+
                "&id_db_settings="+id_db_settings+
                "&id_user="+id_user,
            success: function(r){
                $("#ReturnDocs").html(r);
            }
        });

        return false;
    });

    $('body').on('keyup', '#AbiudyTomas', function(r){
        var txt = $(this).val();

        if(txt != ''){
            $.ajax({
                url: "./_disk/FunctionsApp/settings.inc.php",
                type: "POST",
                data: "acao=AbiudyTomas"+
                    "&id_db_settings="+id_db_settings+
                    "&txt="+txt,
                success: function(r){
                    $("#CamiloMiguel").html(r);
                }
            });
        }
    });

    $('body').on('keyup', '#PatriciaPalucha', function(r){
        var txt = $(this).val();

        if(txt != ''){
            $.ajax({
                url: "./_disk/FunctionsApp/settings.inc.php",
                type: "POST",
                data: "acao=PatriciaPalucha"+
                    "&id_db_settings="+id_db_settings+
                    "&txt="+txt,
                success: function(r){
                    $("#ReadPatrimonio").html(r);
                }
            });
        }
    });

    $('body').on('keyup', '#DjamilaTomas', function(r){
        var txt = $(this).val();

        if(txt != ''){
            $.ajax({
                url: "./_disk/FunctionsApp/settings.inc.php",
                type: "POST",
                data: "acao=DjamilaTomas"+
                    "&id_db_settings="+id_db_settings+
                    "&txt="+txt,
                success: function(r){
                    $("#ReadLocal").html(r);
                }
            });
        }
    });

    $('body').on('keyup', '#MackbookPro', function(r){
        var txt = $(this).val();

        if(txt != ''){
            $.ajax({
                url: "./_disk/FunctionsApp/settings.inc.php",
                type: "POST",
                data: "acao=MackbookPro"+
                    "&id_db_settings="+id_db_settings+
                    "&txt="+txt,
                success: function(r){
                    $("#ReadFuncionario").html(r);
                }
            });
        }
    });

    $('body').on('keyup', '#AuriaRafaela', function(r){
        var txt = $(this).val();

        if(txt != ''){
            $.ajax({
                url: "./_disk/FunctionsApp/settings.inc.php",
                type: "POST",
                data: "acao=AuriaRafaela"+
                    "&id_db_settings="+id_db_settings+
                    "&txt="+txt,
                success: function(r){
                    $("#ReadTipoPatrimonio").html(r);
                }
            });
        }
    });

    $('#searchPDV').keyup(function(){
        var searching = $(this).val();

        $.ajax({
            url: './_disk/SystemApp/ProSmart.inc.php',
            type: 'POST',
            data: 'acao=SearchProduct'+
                "&searching="+searching+
                "&id_user="+id_user+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings,
            success: function(r){
                $("#list-itens").html(r);
            }
        });
    });

    $('body').on('keyup', ".matrix", function(e){
        if(e.which == 13){
            var
                id_db_settings = $("#id_db_settings").val(),
                id_db_kwanzar  = $("#id_db_kwanzar").val(),
                id_mesa  = $("#id_mesa").val(),
                id_user        = $('#id_user').val();

            var value = $(this).val();
            var id    = $(this).attr('data-file');

            $.ajax({
                url: "./_disk/SystemApp/ProSmart.inc.php",
                type: "POST",
                data: "acao=matrix"+
                    "&value="+value+
                    "&id="+id+
                    "&id_mesa="+id_mesa+
                    "&id_user="+id_user+
                    "&id_db_kwanzar="+id_db_kwanzar+
                    "&id_db_settings="+id_db_settings,
                success: function(r){
                    $('#kebrada').html(r);
                }
            });
        }
        return false;
    });

    $("body").on('keyup', "#search_itens_fo", function (){
        var search    = $(this).val(),
            id_db_settings = $("#id_db_settings").val(),
            id_user   = $("#id_user").val();

        $.ajax({
            url: "./_disk/SystemApp/Documents.inc.php",
            type: "POST",
            data: "acao=search_itens_fo"+
                "&search="+search+
                "&id_db_settings="+id_db_settings+
                "&id_user="+id_user,
            success: function(r){
                $("#Itens02").html(r);
            }
        });

        return false;
    });

    loadingPDV(id_user);
    Spitter();
    SelectPlaca();
    SelectVeiculos();
    SelectDataEntrada();
    SelectKilometragem();
});

function AllPDV(){
    var id_db_kwanzar = document.getElementById("id_db_kwanzar").value;
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user        = document.getElementById('id_user').value;
    var id_mesa        = document.getElementById('id_mesa').value;
    var pagou          = document.getElementById('pagou').value;
    var troco          = document.getElementById('troco').value;
    var level          = document.getElementById('level').value;

    if(confirm('Desejas finalizar venda?')){
        $.ajax({
            url: "./_disk/SystemApp/ProSmart.inc.php",
            type: "POST",
            data: "acao=FinishPDV"+
                "&level="+level+
                "&id_db_kwanzar="+id_db_kwanzar+
                "&id_db_settings="+id_db_settings+
                "&id_mesa="+id_mesa+
                "&id_user="+id_user+
                "&pagou="+pagou+
                "&troco="+troco,
            beforeSend: function(object){
                $("#EndFamily").html("Mensagem: "+object);
            }, success: function(r){
                $("#EndFamily").html(r);

                $.ajax({
                    url: "./_disk/SystemApp/ProSmart.inc.php",
                    type: "POST",
                    data: "acao=loadingPDV"+
                        "&id_mesa="+id_mesa+
                        "&level="+level+
                        "&id_db_kwanzar="+id_db_kwanzar+
                        "&id_db_settings="+id_db_settings+
                        "&id_user="+id_user,
                    success: function(eu){
                        //alert(eu);
                        $('#kebrada').html(eu);
                    }
                });

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

function DataPDV(){
    var id_db_settings       = document.getElementById('id_db_settings').value;
    var level                = document.getElementById('level').value;
    var id_user              = document.getElementById('id_user').value;
    var id_garcom            = document.getElementById('id_garcom').value;
    var id_mesa              = document.getElementById('id_mesa').value;
    var TaxPointDate         = document.getElementById('TaxPointDate').value;
    var customer             = document.getElementById('customer').value;
    var InvoiceType          = document.getElementById('InvoiceType').value;
    var SourceBilling        = document.getElementById('SourceBilling').value;
    var method               = document.getElementById('method').value;
    var settings_desc_financ = document.getElementById('settings_desc_financ').value;

    if(confirm('Deseja criar/alterar a venda?')){
        $.ajax({
            url: "./_disk/SystemApp/ProSmart.inc.php",
            type: "POST",
            data: "acao=DataPDV"+
                "&level="+level+
                "&id_garcom="+id_garcom+
                "&id_mesa="+id_mesa+
                "&id_db_settings="+id_db_settings+
                "&id_user="+id_user+
                "&TaxPointDate="+TaxPointDate+
                "&customer="+customer+
                "&SourceBilling="+SourceBilling+
                "&InvoiceType="+InvoiceType+
                "&settings_desc_financ="+settings_desc_financ+
                "&method="+method,
            beforeSend: function(object){
                $("#EndFamily").html("Mensagem: "+object);
            }, success: function(r){
                $("#EndFamily").html(r);
            }
        });
    }
}

function loadingPDV(id_user){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_mesa = document.getElementById('id_mesa').value;

    $.ajax({
        url: "./_disk/SystemApp/ProSmart.inc.php",
        type: "POST",
        data: "acao=loadingPDV"+
            "&id_mesa="+id_mesa+
            "&id_db_settings="+id_db_settings+
            "&id_user="+id_user,
        beforeSend: function(object){
            $("#kebrada").html("Mensagem: "+object);
        }, success: function(r){
            $("#kebrada").html(r);

            $.ajax({
                url: "./_disk/SystemApp/ProSmart.inc.php",
                type: "POST",
                data: "acao=RelodingPDV" +
                    "&id_db_settings=" + id_db_settings +
                    "&id_mesa=" + id_mesa +
                    "&id_user=" + id_user,
                beforeSend: function (object) {
                    $("#EndFamily").html("Mensagem: " + object);
                }, success: function (r) {
                    $("#EndFamily").html(r);
                }
            });
        }
    });
}

function RemovePDV(id){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user = document.getElementById('id_user').value;
    var id_mesa = document.getElementById('id_mesa').value;

    if(confirm('Deseja remover o item selecionado?')){
        $.ajax({
            url: "./_disk/SystemApp/ProSmart.inc.php",
            type: "POST",
            data: "acao=RemovePDV"+
                "&id_mesa="+id_mesa+
                "&id_product="+id+
                "&id_db_settings="+id_db_settings+
                "&id_user="+id_user,
            beforeSend: function(object){
                $("#kebrada").html("Mensagem: "+object);
            }, success: function(r){
                $("#kebrada").html(r);
            }
        });
    }
}

function AdsMsg(id){
    $.ajax({
        url: "./_disk/SystemApp/ProSmart.inc.php",
        type: "POST",
        data: "acao=AdsMsg"+
            "&postId="+id,
        beforeSend: function(object){
            $("#NGA").html("Mensagem: "+object);
        }, success: function(r){
            $("#NGA").html(r);
        }
    });
}

function AdsHome(){
    $.ajax({
        url: "./_disk/SystemApp/ProSmart.inc.php",
        type: "POST",
        data: "acao=AdsHome",
        beforeSend: function(object){
            $("#NGA").html("Mensagem: "+object);
        }, success: function(r){
            $("#NGA").html(r);
        }
    });
}

function AdicionarPDV(id_product){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var id_user = document.getElementById('id_user').value;
    var id_mesa = document.getElementById('id_mesa').value;

    $.ajax({
        url: "./_disk/SystemApp/ProSmart.inc.php",
        type: "POST",
        data: "acao=AdicionarPDV"+
            "&id_mesa="+id_mesa+
            "&id_product="+id_product+
            "&id_db_settings="+id_db_settings+
            "&id_user="+id_user,
        beforeSend: function(object){
            $("#kebrada").html("Mensagem: "+object);
        }, success: function(r){
            $("#kebrada").html(r);
        }
    });
}

function ReadPDV(id_user){
    var id_db_settings = document.getElementById('id_db_settings').value;
    var level          = document.getElementById('level').value;

    $.ajax({
        url: "./_disk/SystemApp/ProSmart.inc.php",
        type: "POST",
        data: "acao=ReadPDV"+
            "&id_user="+id_user+
            "&level="+level+
            "&id_db_settings="+id_db_settings,
        success: function(result){
            $("#list-itens").html(result);
        }
    })
}

function testimony(){
    var id_user = document.getElementById('id_user').value;
    var testemunho = document.getElementById('testemunho').value;

    if(confirm('Desejas salvar o presente testemunho?')){
        $.ajax({
            url: "./_disk/SystemApp/ProSmart.inc.php",
            type: "POST",
            data: "acao=testimony"+
                "&testemunho="+testemunho+
                "&id_user="+id_user,
            beforeSend: function(object){
                $("#getResult").html("Mensagem: "+object);
            }, success: function(r){
                $("#getResult").html(r);
            }
        });
    }
}

/**
 * Folha de obra
 */

function SearchDocs(){
    var search    = $(this).val(),
        id_db_settings = $("#id_db_settings").val(),
        id_user   = $("#id_user").val();

    $.ajax({
        url: "./_disk/SystemApp/Documents.inc.php",
        type: "POST",
        data: "acao=SearchDocs"+
            "&search="+search+
            "&id_db_settings="+id_db_settings+
            "&id_user="+id_user,
        success: function(r){
            $("#ReturnDocs").html(r);
        }
    });
    return false;
}

function ReadDocuments(id_db_settings, id_user){
    $.ajax({
        url: "./_disk/SystemApp/Documents.inc.php",
        type: "POST",
        data: "acao=ReadDocuments"+
            "&id_db_settings="+id_db_settings+
            "&id_user="+id_user,
        success: function(r){
            $("#RealModal").html(r);
        }
    });
}

function BioloRapido(){
    var id_db_settings = document.getElementById("id_db_settings").value;
    var id_user   = document.getElementById("id_user").value;

    var date_i   = document.getElementById("date_i").value;
    var date_f   = document.getElementById("date_f").value;
    var pesquisar   = document.getElementById("pesquisar").value;
    var id_users  = document.getElementById("id_users").value;

    $.ajax({
        url: "./_disk/SystemApp/Reports.inc.php",
        type: "POST",
        data: "acao=HeliosPro" +
            "&date_i="+date_i+
            "&date_f="+date_f+
            "&pesquisar="+pesquisar+
            "&id_users="+id_users+
            "&id_db_settings=" + id_db_settings +
            "&id_user=" + id_user,
        beforeSend: function (object) {
            $("#BioloRapido").html("Mensagem: " + object);
        }, success: function (r) {
            $("#BioloRapido").html(r);
        }
    });
}

function WhatsApp(id_db_settings){
    $.ajax({
        url: "./_disk/SystemApp/Documents.inc.php",
        type: "POST",
        data: "acao=WhatsApp"+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            $("#RealModal").html(r);
        }
    });
    return false;
}

function search_itens_fo(){
    var search    = $(this).val(),
        id_db_settings = $("#id_db_settings").val(),
        id_user   = $("#id_user").val();

    $.ajax({
        url: "./_disk/SystemApp/Documents.inc.php",
        type: "POST",
        data: "acao=search_itens_of"+
            "&search="+search+
            "&id_db_settings="+id_db_settings+
            "&id_user="+id_user,
        success: function(r){
            $("#Itens02").html(r);
        }
    });
    return false;
}

function adicionarII(id){
    var id_db_settings = document.getElementById("id_db_settings").value;
    var id_user   = document.getElementById("id_user").value;
    var quantidade = document.getElementById("quantidade_"+id).value;

    if(isNaN(quantidade)){
        alert("Ops: o campo quantidade tem que ser do tipo númerico!");
        document.getElementById("quantidade_"+id).value;
        return  false;
    }

    $.ajax({
        url: "./_disk/SystemApp/Documents.inc.php",
        type: "POST",
        data: "acao=adicionarII"+
            "&postId="+id+
            "&id_db_settings="+id_db_settings+
            "&id_user="+id_user+
            "&quantidade="+quantidade,
        beforeSend: function(object){
            $("#RealNiggaII").html("Mensagem: "+object);
        }, success: function(r){
            $("#RealNiggaII").html(r);
        }
    });
}

function cancelII(id_product){
    var id_db_settings = document.getElementById("id_db_settings").value;
    var id_user   = document.getElementById("id_user").value;

    if(confirm("Desejas remover o item selecionado?")){
        $.ajax({
            url: "./_disk/SystemApp/Documents.inc.php",
            type: "POST",
            data: "acao=cancelII"+
                "&postId="+id_product+
                "&id_db_settings="+id_db_settings+
                "&id_user="+id_user,
            beforeSend: function(object){
                $("#RealNiggaII").html("Mensagem: "+object);
            }, success: function(r){
                $("#RealNiggaII").html(r);
            }
        });
    }
}

function FinishII(id_db_settings){
    var
        id_user = document.getElementById("id_user").value,
        id_cliente = document.getElementById("id_cliente").value,
        documents = document.getElementById("document").value,
        id_veiculo = document.getElementById("id_veiculo").value,
        matricula = document.getElementById("matricula").value,
        id_mecanico = document.getElementById("id_mecanico").value,
        kilometragem = document.getElementById("kilometragem").value,
        fo_data_entrada = document.getElementById("fo_data_entrada").value;

    var
        fo_problema = $("#fo_problema").val(),
        fo_laudo = $("#fo_laudo").val(),
        fo_observacoes = $("#fo_observacoes").val();

    if(confirm("Desejas finalizar o documento?")){
        $.ajax({
            url: "./_disk/SystemApp/Documents.inc.php",
            type: "POST",
            data: "acao=FinishII"+
                "&fo_problema="+fo_problema+
                "&fo_laudo="+fo_laudo+
                "&fo_observacoes="+fo_observacoes+
                "&id_cliente="+id_cliente+
                "&id_veiculo="+id_veiculo+
                "&matricula="+matricula+
                "&id_mecanico="+id_mecanico+
                "&kilometragem="+kilometragem+
                "&fo_data_entrada="+fo_data_entrada+
                "&document="+documents+
                "&id_db_settings="+id_db_settings+
                "&id_user="+id_user,
            beforeSend: function(object){
                $("#RealNiggaII").html("Mensagem: "+object);
            }, success: function(r){
                $("#RealNiggaII").html(r);
                ReadDocuments(id_db_settings, id_user);
            }
        });
    }
}

function SelectPlaca(){
    var id_db_settings = document.getElementById("id_db_settings").value;
    var id_user   = document.getElementById("id_user").value;
    var id_cliente = document.getElementById("id_cliente").value
    var id_veiculo = document.getElementById("id_veiculo").value;

    $.ajax({
        url: "./_disk/SystemApp/Documents.inc.php",
        type: "POST",
        data: "acao=SelectPlaca" +
            "&id_veiculo="+id_veiculo+
            "&id_cliente="+id_cliente+
            "&id_db_settings=" + id_db_settings +
            "&id_user=" + id_user,
        beforeSend: function (object) {
            $("#matricula").val("Mensagem: " + object);
        }, success: function (r) {
            $("#matricula").val(r);
        }
    });
}

function SelectPlacaII(){
    var id_db_settings = document.getElementById("id_db_settings").value;
    var id_user   = document.getElementById("id_user").value;
    var id_cliente = document.getElementById("customer").value
    var id_veiculos = document.getElementById("id_veiculos").value;

    $.ajax({
        url: "./_disk/SystemApp/Documents.inc.php",
        type: "POST",
        data: "acao=SelectPlacaII" +
            "&id_veiculos="+id_veiculos+
            "&id_cliente="+id_cliente+
            "&id_db_settings=" + id_db_settings +
            "&id_user=" + id_user,
        beforeSend: function (object) {
            $("#matriculas").val("Mensagem: " + object);
        }, success: function (r) {
            $("#matriculas").val(r);
        }
    });
}

function SelectFabricante(){
    var id_db_settings = document.getElementById("id_db_settings").value;
    var id_user   = document.getElementById("id_user").value;
    var id_cliente = document.getElementById("customer").value
    var id_veiculos = document.getElementById("id_veiculos").value;

    $.ajax({
        url: "./_disk/SystemApp/Documents.inc.php",
        type: "POST",
        data: "acao=SelectFabricante" +
            "&id_veiculos="+id_veiculos+
            "&id_cliente="+id_cliente+
            "&id_db_settings=" + id_db_settings +
            "&id_user=" + id_user,
        beforeSend: function (object) {
            $("#id_fabricante").val("Mensagem: " + object);
        }, success: function (r) {
            $("#id_fabricante").val(r);
        }
    });
}

function SelectVeiculos(){
    var id_db_settings = document.getElementById("id_db_settings").value;
    var id_user   = document.getElementById("id_user").value;
    var id_cliente = document.getElementById("id_cliente").value;

    $.ajax({
        url: "./_disk/SystemApp/Documents.inc.php",
        type: "POST",
        data: "acao=SelectVeiculos" +
            "&id_cliente="+id_cliente+
            "&id_db_settings=" + id_db_settings +
            "&id_user=" + id_user,
        beforeSend: function (object) {
            $("#id_veiculo").html("Mensagem: " + object);
        }, success: function (r) {
            $("#id_veiculo").html(r);
            SelectPlaca();
            SelectKilometragem();
            SelectDataEntrada();
        }
    });
}

function SelectVeiculoII(){
    var id_db_settings = document.getElementById("id_db_settings").value;
    var id_user   = document.getElementById("id_user").value;
    var id_customer = document.getElementById("customer").value;

    $.ajax({
        url: "./_disk/SystemApp/Documents.inc.php",
        type: "POST",
        data: "acao=SelectVeiculoII" +
            "&id_customer="+id_customer+
            "&id_db_settings=" + id_db_settings +
            "&id_user=" + id_user,
        beforeSend: function (object) {
            $("#id_veiculos").html("Mensagem: " + object);
        }, success: function (r) {
            $("#id_veiculos").html(r);
            SelectPlacaII();
            SelectFabricante();
        }
    });
}


/**
 * Gestāo mecanica
 */

function CreateUnidades(id_db_settings){
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=CreateUnidades"+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#RealModal').html(f);
        }
    });
}

function UnidadeCreate(id_db_settings){
    var
        unidade    = $('#unidade').val(),
        simbolo     = $('#simbolo').val();

    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=UnidadeCreate"+
            "&unidade="+unidade+
            "&simbolo="+simbolo+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            VisiblitDiv();
            $('.getResult').html(r);
            HiddenDiv();
            ReadUnidade(id_db_settings);
        }
    });

    return false;
}

function UnidadeUpdate(id){
    var
        id_db_settings     = $('#id_db_settings').val();

    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=UnidadeUpdate"+
            "&postId="+id,
        success: function(f){
            $('#RealModal').html(f);
        }
    });
}

function DeleteUnidade(id){
    if(confirm("Desejas deletar a unidade?")){
        var id_db_settings = $("#id_db_settings").val();

        $.ajax({
            url: "./_disk/SystemApp/Canon.inc.php",
            type: "POST",
            data: "acao=DeleteUnidade"+
                "&postId="+id,
            success: function(f){
                $('#getAlert').html(f);
                ReadUnidade(id_db_settings);
            }
        });
    }
}

function UpdateUnidade(id){
    var
        id_db_settings     = $('#id_db_settings').val(),
        id_user       = $("#id_user").val();

    var
        unidade    = $('#unidade').val(),
        simbolo     = $('#simbolo').val();

    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=UpdateUnidade"+
            "&postId="+id+
            "&unidade="+unidade+
            "&simbolo="+simbolo+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            VisiblitDiv();
            $('.getResult').html(r);
            HiddenDiv();
            ReadUnidade(id_db_settings);
        }
    });
    return false;
}

function ReadUnidade(id_db_settings){
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=ReadUnidade"+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#ReadUnidade').html(f);
        }
    });
}

function CreateFabricante(id_db_settings){
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=CreateFabricante"+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#RealModal').html(f);
        }
    });
}

function FabricanteCreate(id_db_settings){
    var
        name    = $('#name').val(),
        content     = $('#content').val();

    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=FabricanteCreate"+
            "&name="+name+
            "&content="+content+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            VisiblitDiv();
            $('.getResult').html(r);
            HiddenDiv();
            ReadFabricante(id_db_settings);
        }
    });
    return false;
}

function SalvarVeiculo(id_db_settings){
    var
        veiculo = $("#veiculo").val(),
        id_cliente = $("#id_cliente").val(),
        id_fabricante = $("#id_fabricante").val(),
        km_atual = $("#km_atual").val(),
        placa = $("#placa").val(),
        modelo = $("#modelo").val(),
        content = $("#content").val(),
        motor = $("#motor").val(),
        cor = $("#cor").val(),
        chassi = $("#chassi").val(),
        data_entrada = $("#data_entrada").val();

    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=SalvarVeiculo"+
            "&veiculo="+veiculo+
            "&id_cliente="+id_cliente+
            "&id_fabricante="+id_fabricante+
            "&km_atual="+km_atual+
            "&placa="+placa+
            "&modelo="+modelo+
            "&content="+content+
            "&motor="+motor+
            "&cor="+cor+
            "&chassi="+chassi+
            "&data_entrada="+data_entrada+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            VisiblitDiv();
            $('.getResult').html(r);
            HiddenDiv();
            ReadVeiculo(id_db_settings);
        }
    });
    return false;
}

function SalvarTipoPatrimonio(id_db_settings){
    var
        nome = $("#nome").val(),
        descricao = $("#descricao").val();

    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=SalvarTipoPatrimonio"+
            "&nome="+nome+
            "&descricao="+descricao+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            VisiblitDiv();
            $('.getResult').html(r);
            HiddenDiv();
            ReadTipoPatrimonio(id_db_settings);
        }
    });
    return false;
}

function SalvarLocal(id_db_settings){
    var
        nome = $("#nome").val(),
        escritorio = $("#escritorio").val();

    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=SalvarLocal"+
            "&nome="+nome+
            "&escritorio="+escritorio+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            VisiblitDiv();
            $('.getResult').html(r);
            HiddenDiv();
            ReadLocal(id_db_settings);
        }
    });
    return false;
}

function SalvarPatrimonio(id_db_settings){
    var
        referencia = $("#referencia").val(),
        id_type = $("#id_type").val(),
        marca = $("#marca").val(),
        modelo = $("#modelo").val(),
        time_last = $("#time_last").val(),
        data_last = $("#data_last").val(),
        nome = $("#nome").val(),
        preco = $("#preco").val();

    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=SalvarPatrimonio"+
            "&nome="+nome+
            "&id_type="+id_type+
            "&referencia="+referencia+
            "&marca="+marca+
            "&modelo="+modelo+
            "&time_last="+time_last+
            "&data_last="+data_last+
            "&preco="+preco+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            VisiblitDiv();
            $('.getResult').html(r);
            HiddenDiv();
            ReadPatrimonio(id_db_settings);
        }
    });
    return false;
}

function SalvarFuncionario(id_db_settings){
    var
        departamento = $("#departamento").val(),
        telefone = $("#telefone").val(),
        email = $("#email").val(),
        endereco = $("#endereco").val(),
        sexo = $("#sexo").val(),
        nome = $("#nome").val(),
        bi = $("#bi").val();

    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=SalvarFuncionario"+
            "&nome="+nome+
            "&departamento="+departamento+
            "&telefone="+telefone+
            "&email="+email+
            "&endereco="+endereco+
            "&sexo="+sexo+
            "&bi="+bi+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            VisiblitDiv();
            $('.getResult').html(r);
            HiddenDiv();
            ReadFuncionario(id_db_settings);
        }
    });
    return false;
}

function VeiculoUpdate(id){
    var id_db_settings = $("#id_db_settings").val();
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=VeiculoUpdate"+
            "&id_db_settings="+id_db_settings+
            "&postId="+id,
        success: function(f){
            $('#RealModal').html(f);
        }
    });
}

function TipoPatrimonioUpdate(id){
    var id_db_settings = $("#id_db_settings").val();
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=TipoPatrimonioUpdate"+
            "&id_db_settings="+id_db_settings+
            "&postId="+id,
        success: function(f){
            $('#RealModal').html(f);
        }
    });
}

function LocalUpdate(id){
    var id_db_settings = $("#id_db_settings").val();
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=LocalUpdate"+
            "&id_db_settings="+id_db_settings+
            "&postId="+id,
        success: function(f){
            $('#RealModal').html(f);
        }
    });
}

function PatrimonioUpdate(id){
    var id_db_settings = $("#id_db_settings").val();
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=PatrimonioUpdate"+
            "&id_db_settings="+id_db_settings+
            "&postId="+id,
        success: function(f){
            $('#RealModal').html(f);
        }
    });
}

function FuncionarioUpdate(id){
    var id_db_settings = $("#id_db_settings").val();
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=FuncionarioUpdate"+
            "&id_db_settings="+id_db_settings+
            "&postId="+id,
        success: function(f){
            $('#RealModal').html(f);
        }
    });
}

function UpdateVeiculo(id){
    var
        id_db_settings = $("#id_db_settings").val();

    var
        veiculo = $("#veiculo").val(),
        id_cliente = $("#id_cliente").val(),
        id_fabricante = $("#id_fabricante").val(),
        km_atual = $("#km_atual").val(),
        placa = $("#placa").val(),
        modelo = $("#modelo").val(),
        content = $("#content").val(),
        motor = $("#motor").val(),
        cor = $("#cor").val(),
        chassi = $("#chassi").val(),
        data_entrada = $("#data_entrada").val();

    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=UpdateVeiculo"+
            "&veiculo="+veiculo+
            "&id_cliente="+id_cliente+
            "&id_fabricante="+id_fabricante+
            "&km_atual="+km_atual+
            "&placa="+placa+
            "&modelo="+modelo+
            "&content="+content+
            "&motor="+motor+
            "&cor="+cor+
            "&chassi="+chassi+
            "&data_entrada="+data_entrada+
            "&postId="+id+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            VisiblitDiv();
            $('.getResult').html(r);
            HiddenDiv();
            ReadVeiculo(id_db_settings);
        }
    });

    return false;
}

function EditarAtribuicao(id){
    var
        id_db_settings = $("#id_db_settings").val();

    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=EditarAtribuicao"+
            "&postId="+id+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            $('#RealModal').html(r);
        }
    });

    return false;
}

function OperacaoPatrimonial(){
    var
        id_db_settings = $("#id_db_settings").val(),
        id_user = document.getElementById("id_user").value;
    var
        id_table = $("#id_table").val(),
        id_local = $("#id_local").val(),
        id_funcionario = $("#id_funcionario").val(),
        descricao = $("#descricao").val();

    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=OperacaoPatrimonial"+
            "&id_table="+id_table+
            "&id_user="+id_user+
            "&id_local="+id_local+
            "&id_funcionario="+id_funcionario+
            "&descricao="+descricao+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            $('#Obama').html(r);
            ReadHistoricoAtribuicoes(id_db_settings);
        }
    });

    return false;
}

function UpdateTipoPatrimonio(id){
    var
        id_db_settings = $("#id_db_settings").val();

    var
        nome = $("#nome").val(),
        descricao = $("#descricao").val();

    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=UpdateTipoPatrimonio"+
            "&nome="+nome+
            "&descricao="+descricao+
            "&postId="+id+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            VisiblitDiv();
            $('.getResult').html(r);
            HiddenDiv();
            ReadTipoPatrimonio(id_db_settings);
        }
    });

    return false;
}

function UpdateLocal(id){
    var
        id_db_settings = $("#id_db_settings").val();

    var
        nome = $("#nome").val(),
        escritorio = $("#escritorio").val();

    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=UpdateLocal"+
            "&nome="+nome+
            "&escritorio="+escritorio+
            "&postId="+id+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            VisiblitDiv();
            $('.getResult').html(r);
            HiddenDiv();
            ReadLocal(id_db_settings);
        }
    });

    return false;
}

function UpdatePatrimonio(id){
    var
        id_db_settings = $("#id_db_settings").val(),
        id_type = $("#id_type").val(),
        referencia = $("#referencia").val(),
        marca = $("#marca").val(),
        modelo = $("#modelo").val(),
        time_last = $("#time_last").val(),
        data_last = $("#data_last").val(),
        nome = $("#nome").val(),
        status = $("#status").val(),
        preco = $("#preco").val();

    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=UpdatePatrimonio"+
            "&nome="+nome+
            "&id_type="+id_type+
            "&referencia="+referencia+
            "&marca="+marca+
            "&modelo="+modelo+
            "&time_last="+time_last+
            "&data_last="+data_last+
            "&preco="+preco+
            "&status="+status+
            "&postId="+id+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            VisiblitDiv();
            $('.getResult').html(r);
            HiddenDiv();
            ReadPatrimonio(id_db_settings);
        }
    });
    return false;
}

function UpdateFuncionario(id){
    var
        id_db_settings = $("#id_db_settings").val(),
        departamento = $("#departamento").val(),
        telefone = $("#telefone").val(),
        email = $("#email").val(),
        endereco = $("#endereco").val(),
        sexo = $("#sexo").val(),
        nome = $("#nome").val(),
        bi = $("#bi").val();

    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=UpdateFuncionario"+
            "&nome="+nome+
            "&departamento="+departamento+
            "&telefone="+telefone+
            "&email="+email+
            "&endereco="+endereco+
            "&sexo="+sexo+
            "&bi="+bi+
            "&postId="+id+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            VisiblitDiv();
            $('.getResult').html(r);
            HiddenDiv();
            ReadFuncionario(id_db_settings);
        }
    });
    return false;
}

function StatusAtribuicao(id){
    var
        id_db_settings = $("#id_db_settings").val(),
        status = $("#status").val();

    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=StatusAtribuicao"+
            "&status="+status+
            "&postId="+id+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            VisiblitDiv();
            $('#Obama').html(r);
            HiddenDiv();
            ReadHistoricoAtribuicoes(id_db_settings);
        }
    });
    return false;
}

function DeleteVeiculo(id){
    if(confirm("Desejas deletar o veiculo?")){
        var id_db_settings = $("#id_db_settings").val();

        $.ajax({
            url: "./_disk/SystemApp/Canon.inc.php",
            type: "POST",
            data: "acao=DeleteVeiculo"+
                "&id_db_settings="+id_db_settings+
                "&postId="+id,
            success: function(f){
                $('#getAlert').html(f);
                ReadVeiculo(id_db_settings);
            }
        });
    }
}

function DeleteTipoPatrimonio(id){
    if(confirm("Desejas deletar o tipo de patrimonio?")){
        var id_db_settings = $("#id_db_settings").val();

        $.ajax({
            url: "./_disk/SystemApp/Canon.inc.php",
            type: "POST",
            data: "acao=DeleteTipoPatrimonio"+
                "&id_db_settings="+id_db_settings+
                "&postId="+id,
            success: function(f){
                $('#aPaulo').html(f);
                ReadTipoPatrimonio(id_db_settings);
            }
        });
    }
}

function DeleteLocal(id){
    if(confirm("Desejas deletar o Local de Armazenamento?")){
        var id_db_settings = $("#id_db_settings").val();

        $.ajax({
            url: "./_disk/SystemApp/Canon.inc.php",
            type: "POST",
            data: "acao=DeleteLocal"+
                "&id_db_settings="+id_db_settings+
                "&postId="+id,
            success: function(f){
                $('#aPaulo').html(f);
                ReadLocal(id_db_settings);
            }
        });
    }
}

function DeletePatrimonio(id){
    if(confirm("Desejas deletar o patrimonio?")){
        var id_db_settings = $("#id_db_settings").val();

        $.ajax({
            url: "./_disk/SystemApp/Canon.inc.php",
            type: "POST",
            data: "acao=DeletePatrimonio"+
                "&id_db_settings="+id_db_settings+
                "&postId="+id,
            success: function(f){
                $('#aPaulo').html(f);
                ReadPatrimonio(id_db_settings);
            }
        });
    }
}

function DeleteFuncionario(id){
    if(confirm("Desejas deletar o funcionário?")){
        var id_db_settings = $("#id_db_settings").val();

        $.ajax({
            url: "./_disk/SystemApp/Canon.inc.php",
            type: "POST",
            data: "acao=DeleteFuncionario"+
                "&id_db_settings="+id_db_settings+
                "&postId="+id,
            success: function(f){
                $('#aPaulo').html(f);
                ReadFuncionario(id_db_settings);
            }
        });
    }
}

function CreateFornecedores(id_db_settings){
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=CreateFornecedores"+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#RealModal').html(f);
        }
    });
}

function FornecedoresUpdate(id){
    var id_db_settings = $("#id_db_settings").val();
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=FornecedoresUpdate"+
            "&id_db_settings="+id_db_settings+
            "&postId="+id,
        success: function(f){
            $('#RealModal').html(f);
        }
    });
}

function SalvarFornecedores(id_db_settings){
    var
        name = $("#name").val(),
        type = $("#type").val(),
        nif = $("#nif").val(),
        email = $("#email").val(),
        telefone = $("#telefone").val(),
        endereco = $("#endereco").val(),
        city = $("#city").val(),
        country = $("#country").val(),
        obs = $("#obs").val();

    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=SalvarFornecedores"+
            "&name="+name+
            "&type="+type+
            "&nif="+nif+
            "&email="+email+
            "&telefone="+telefone+
            "&endereco="+endereco+
            "&city="+city+
            "&country="+country+
            "&obs="+obs+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            VisiblitDiv();
            $('.getResult').html(r);
            HiddenDiv();
            ReadFornecedores(id_db_settings);
        }
    });

    return false;
}

function UpdatesFornecedores(id){
    var
        name = $("#name").val(),
        type = $("#type").val(),
        nif = $("#nif").val(),
        email = $("#email").val(),
        telefone = $("#telefone").val(),
        endereco = $("#endereco").val(),
        city = $("#city").val(),
        country = $("#country").val(),
        id_db_settings = $("#id_db_settings").val(),
        obs = $("#obs").val();

    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=UpdatesFornecedores"+
            "&name="+name+
            "&type="+type+
            "&postId="+id+
            "&nif="+nif+
            "&email="+email+
            "&telefone="+telefone+
            "&endereco="+endereco+
            "&city="+city+
            "&country="+country+
            "&obs="+obs+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            VisiblitDiv();
            $('.getResult').html(r);
            HiddenDiv();
            ReadFornecedores(id_db_settings);
        }
    });
    return false;
}

function ReadFornecedores(id_db_settings){
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=ReadFornecedores"+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#ReadFornecedores').html(f);
        }
    });
}

function ReadVeiculo(id_db_settings){
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=ReadVeiculo"+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#ReadVeiculo').html(f);
        }
    });
}

function ReadTipoPatrimonio(id_db_settings){
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=ReadTipoPatrimonio"+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#ReadTipoPatrimonio').html(f);
        }
    });
}

function ReadHistoricoAtribuicoes(id_db_settings){
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=ReadHistoricoAtribuicoes"+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#CamiloMiguel').html(f);
        }
    });
}

function ReadLocal(id_db_settings){
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=ReadLocal"+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#ReadLocal').html(f);
        }
    });
}

function ReadPatrimonio(id_db_settings){
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=ReadPatrimonio"+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#ReadPatrimonio').html(f);
        }
    });
}

function ReadFuncionario(id_db_settings){
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=ReadFuncionario"+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#ReadFuncionario').html(f);
        }
    });
}

function CreateVeiculos(id_db_settings){
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=CreateVeiculos"+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#RealModal').html(f);
        }
    });
}

function TypePatrimonio(id_db_settings){
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=TypePatrimonio"+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#RealModal').html(f);
        }
    });
}

function Local(id_db_settings){
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=Local"+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#RealModal').html(f);
        }
    });
}

function Patrimonio(id_db_settings){
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=Patrimonio"+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#RealModal').html(f);
        }
    });
}

function Funcionario(id_db_settings){
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=Funcionario"+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#RealModal').html(f);
        }
    });
}

function UpdateFabricante(id){
    var
        id_db_settings     = $('#id_db_settings').val(),
        id_user       = $("#id_user").val();

    var
        name    = $('#name').val(),
        content     = $('#content').val();

    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=UpdateFabricante"+
            "&postId="+id+
            "&id_user="+id_user+
            "&name="+name+
            "&content="+content+
            "&id_db_settings="+id_db_settings,
        success: function(r){
            VisiblitDiv();
            $('.getResult').html(r);
            HiddenDiv();
            ReadFabricante(id_db_settings);
        }
    });
    return false;
}

function DeleteFornecedores(id){
    if(confirm("Desejas deletar o fornecedor?")){
        var id_db_settings = $("#id_db_settings").val();

        $.ajax({
            url: "./_disk/SystemApp/Canon.inc.php",
            type: "POST",
            data: "acao=DeleteFornecedores"+
                "&postId="+id,
            success: function(f){
                $('#aPaulo').html(f);
                ReadFornecedores(id_db_settings);
            }
        });
    }
}

function DeleteFabricante(id){
    if(confirm("Desejas deletar o fabricante?")){
        var id_db_settings = $("#id_db_settings").val();

        $.ajax({
            url: "./_disk/SystemApp/Canon.inc.php",
            type: "POST",
            data: "acao=DeleteFabricante"+
                "&postId="+id,
            success: function(f){
                $('#aPaulo').html(f);
                ReadFabricante(id_db_settings);
            }
        });
    }
}

function FabricanteUpdate(id){
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=FabricanteUpdate"+
            "&postId="+id,
        success: function(f){
            $('#RealModal').html(f);
        }
    });
}

function ReadFabricante(id_db_settings){
    $.ajax({
        url: "./_disk/SystemApp/Canon.inc.php",
        type: "POST",
        data: "acao=ReadFabricante"+
            "&id_db_settings="+id_db_settings,
        success: function(f){
            $('#ReadFabricante').html(f);
        }
    });
}

function VisiblitDiv(){
    setTimeout(function (){
        $("#getResult").fadeIn();
    }, 500);
}

function HiddenDiv(){
    setTimeout(function (){
        $("#getResult").fadeOut();
    }, 5000);
}