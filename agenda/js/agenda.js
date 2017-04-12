function resizeModal(idClassModal) {
    $(idClassModal).css({
        'left': '50%',
        'width' : '100%',
        'height' : $(window).height() * 0.7,
        'max-width': $(window).width() * 0.9,
        'max-height': $(window).height(),
        'margin-left': ( (($(window).width() * 0.9) / 2) * -1)
    });
    $(idClassModal).find('modal-body').css({'height' : $(window).height() * 0.75});
}

function setContactFields() {
    $('#frmContato input').val();
}

function ligarAPP(numero_s_ddi, nome) {
    $.directcall_app().comando('1|chamar|55' + numero_s_ddi + '|' + nome);
}

function openModal(modalId, title) {
    var modal = $(modalId);
    var modalTitle = $(modalId + ' .modal-title');

    if (modalTitle[0]) {
        modalTitle.html(title);
    }
    resizeModal(modalId + " .modal-dialog");

    modal.modal('show');
}

function getModalHelper(url, dados) {

    var token = '';
    $.ajax({
        url: 'ajax.php',
        method: "POST",
        data: '&action=getToken',
        dataType: 'json',
        beforeSend: function () {
            $('#modalHelper .modal-body').html('<img src="images/ajax-loader-hex.gif">');
        },
    }).success(function (response) {

        token = response.token;

    }).done(function () {
        $('#modalHelper .modal-body').html('<iframe width="100%" style="border: none;" height="' + ($(window).height() * 0.75) + '" src="' + url + '/access_token/' + token + dados + '"><img src="images/ajax-loader-hex.gif"></iframe>');
        openModal('#modalHelper', '');
    });
}

function helperSMS(contatoId) {
    var destino = $('#mobile_' + contatoId).attr('number');
    getModalHelper('http://painel.directcallsoft.com/enviar-sms', '/destino/' + destino);

}

function helperExtratoLigacao() {
    getModalHelper('http://painel.directcallsoft.com/consumivel/relatorio/chamadas', '');
}

function helperExtratoSMS() {
    getModalHelper('http://painel.directcallsoft.com/consumivel/relatorio/sms-unitario', '');
}

function helperExtratoSMSChat () {
    getModalHelper('http://painel.directcallsoft.com/consumivel/relatorio/sms-estilo-chat', '');
}

function editContact(contatoId) {
    //Carrega tabela.
    $.ajax({
        url: 'ajax.php',
        method: "POST",
        data: '&action=cons&contatoId=' + contatoId,
        dataType: 'json',
        beforeSend: function () {
        },
    }).success(function (response) {
        openModal("#modalContato", 'Alterar o contato: ' + $('#name_' + contatoId).html());
        setContactFields();

        $("#nome").val(response.nome);
        $("#empresa").val(response.empresa);
        $("#email").val(response.email);
        $("#fixo").val(response.fixo);
        $("#celular").val(response.celular);

    }).done(function (response) {

        $('#frmContatoId').val(contatoId);
        $('#actionFrmContato').val('alter');
        console.log(response);
        //setButtonsTable();
    }).fail(function (e) {
        console.log(e);
    });
}

function deleteContact(contatoId) {
    //Carrega tabela.
    $.ajax({
        url: 'ajax.php',
        method: "POST",
        data: '&action=cons&contatoId=' + contatoId,
        dataType: 'json',
        beforeSend: function () {
        },
    }).success(function (response) {
        openModal("#modalContato", 'Deletar o contato: ' + $('#name_' + contatoId).html());
        setContactFields();

        $("#nome").val(response.nome);
        $("#empresa").val(response.empresa);
        $("#email").val(response.email);
        $("#fixo").val(response.fixo);
        $("#celular").val(response.celular);

    }).done(function (response) {

        $('#frmContatoId').val(contatoId);
        $('#actionFrmContato').val('delete');
        console.log(response);
        //setButtonsTable();
    }).fail(function (e) {
        console.log(e);
    });
}


function setButtonsTable() {
    $('.makeCall').on('click', function () {

        var btnCall = $(this);
        var phoneType = btnCall.attr("phoneType");
        var contatoId = btnCall.attr("contatoId");

        ligarAPP($('#' + phoneType + '_' + contatoId).attr('number'), $('#name_' + contatoId).html());
    });

    $('.sendSms').on('click', function () {
        var btnSms = $(this);
        var contatoId = btnSms.attr('contatoId');
    });


    $('.fa-edit').on('click', function () {
        editContact($(this).attr('contatoId'));
    });

    $('.fa-times').on('click', function () {
        deleteContact($(this).attr('contatoId'));
    });
    $('.fa-commenting').on('click', function () {
        helperSMS($(this).attr('contatoId'));
    });

    var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        spOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };

    $('.numberFormat').mask(SPMaskBehavior, spOptions);
}
function loadTable() {
    var table = $('#tableContatos>tbody');
    //Carrega tabela.
    $.ajax({
        url: 'ajax.php',
        method: "POST",
        data: '&action=read',
        dataType: 'json',
        beforeSend: function () {
            table.html('');
        },
    })
        .success(function (response) {
            var html = "";
            for (var x in response) {
                html += "<tr>";
                html += '<td><span id="name_' + response[x].id + '">' + response[x].nome + '</span></td>';
                html += "<td>" + response[x].empresa + "</td>";
                html += "<td>" + response[x].email + "</td>";
                html += '<td>';
                html += '<span class="numberFormat" id="mobile_' + response[x].id + '" number="' + response[x].celular + '">' + response[x].celular + '</span>';
                html += '<button class="btn btn-circle btn-success fa fa-phone makeCall" type="button" phoneType="mobile"  contatoId="' + response[x].id + '"></button>';
                html += '</td>';
                html += '<td>';
                html += '<span class="numberFormat" id="phone_' + response[x].id + '" number="' + response[x].fixo + '">' + response[x].fixo + '</span>';
                if (response[x].fixo != '') {
                    html += '<button class="btn btn-circle btn-success fa fa-phone makeCall" phoneType="phone" contatoId="' + response[x].id + '"></button>';
                }
                html += '</td>';
                html += '<td width="15%" class="text-right">';
                html += '<span class="botoes"><button contatoId="' + response[x].id + '" class="btn btn-circle btn-warning fa fa-commenting" alt="Enviar SMS p/ o contato" title="Enviar SMS p/ o contato"></button></span>';
                html += '<span class="botoes"><button contatoId="' + response[x].id + '" class="btn btn-circle btn-primary fa fa-edit" alt="Alterar contato" title="Alterar contato"></button></span>';
                html += '<span class="botoes"><button contatoId="' + response[x].id + '" class="btn btn-circle btn-danger fa fa-times" alt="Excluir contato" title="Excluir contato"></button></span>';
                html += '</td>';
                html += "</tr>";
                //console.log(response[x]);
            }
            if (html == "") {
                html += '<tr><td colspan="6"><div class="alert alert-danger">Nenhum contato encontrado</td></tr>';

            }
            table.append(html);
        }).done(function (response) {
        setButtonsTable();
    }).fail(function (e) {
        console.log(e);
    });
}