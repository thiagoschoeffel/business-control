var now = function refreshDateTime() {
    $('.j_app_clock').html(moment(new Date()).format('DD/MM/YYYY HH:mm:ss'));
};

$(document).ready(function () {
    setInterval(now, 1000);

    $("#metismenu").metisMenu();

    $(".j_app_mask_datetime").mask("00/00/0000 00:00:00");
    $(".j_app_mask_date").mask("00/00/0000");
    $('.j_app_mask_integer').mask('0000000', { reverse: true });
    $('.j_app_mask_decimal_two').mask('000.000.000.000.000,00', { reverse: true });
    $('.j_app_mask_decimal_four').mask('000.000.000.000.000,0000', { reverse: true });
    $('.j_app_mask_only_numbers').mask('#0', { reverse: true });
    $(".j_app_mask_uppercase").on("blur", function () {
        var input = $(this);

        input.val(input.val().toUpperCase());
    });
    $(".j_app_mask_lowercase").on("blur", function () {
        var input = $(this);

        input.val(input.val().toLowerCase());
    });

    $(".j_app_datetimepicker").datepicker({
        language: 'pt-BR',
        dateFormat: 'dd/mm/yyyy',
        timeFormat: 'hh:ii:00',
        autoClose: true,
        keyboardNav: false,
        clearButton: true,
        timepicker: true
    });

    $(".j_app_datepicker").datepicker({
        language: 'pt-BR',
        dateFormat: 'dd/mm/yyyy',
        autoClose: true,
        keyboardNav: false,
        clearButton: true,
        timepicker: false
    });

    $('.j_app_sidebar_toggle').on('click', function (e) {
        e.preventDefault();

        $('.app_sidebar').toggleClass('app_sidebar_open');
        $('.app_content').toggleClass('app_content_full');

        var url = $(this).attr('data-url');

        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json'
        });
    });

    $('.j_app_logout').on('click', function (e) {
        e.preventDefault();

        var url = $(this).attr('data-url');

        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                loaderOn();
                notificationClear();
            },
            success: function (response) {
                if (response.notification) {
                    notificationShow(response.notification.type, response.notification.message);
                }

                if (response.redirect) {
                    window.location = response.redirect;
                }
            },
            error: function () {
                loaderOff();
            },
            complete: function () {
                loaderOff();
            }
        });
    });

    Highcharts.setOptions({
        lang: {
            decimalPoint: ',',
            thousandsSep: '.'
        },
        global: {
            timezone: 'America/Sao_Paulo'
        }
    });
});

function loaderOn() {
    $('.app_loader').fadeIn();
}

function loaderOff() {
    $('.app_loader').fadeOut();
}

function notificationShow(type, message) {
    $(".app_notifications").append("<div class=\"alert alert-" + type + " alert-dismissible fade show m-0 mb-2\">" + message + "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>");
    $(".app_notifications").fadeIn().css("display", "block");
}

function notificationClear() {
    $(".app_notifications").html("").css("display", "none");
}

$.fn.dataTable.moment('DD/MM/YYYY HH:mm:ss');
$.fn.dataTable.moment('DD/MM/YYYY HH:mm');
$.fn.dataTable.moment('DD/MM/YYYY');

$.extend(true, $.fn.dataTable.defaults, {
    "scrollY": 400,
    "scrollX": true,
    "info": false,
    "searching": true,
    "stateSave": true,
    "pagingType": "simple_numbers",
    "language": {
        "processing": "Carregando...",
        "lengthMenu": "Listar _MENU_",
        "search": "Buscar",
        "zeroRecords": "Desculpe, Nenhum Registro Encontrado",
        "info": "Página _PAGE_ de _PAGES_",
        "infoEmpty": "Nenhum Registro Encontrado",
        "infoFiltered": "(Filtrando a Partir de _MAX_ Registros)",
        "paginate": {
            "first": "<i class=\"fas fa-angle-double-left\"></i>",
            "last": "<i class=\"fas fa-angle-double-right\"></i>",
            "next": "<i class=\"fas fa-angle-right\"></i>",
            "previous": "<i class=\"fas fa-angle-left\"></i>"
        }
    },
    "drawCallback": function () {
        $('.dataTables_paginate > .pagination').addClass('pagination-sm mt-3');
    }
});

function convertStrDecimal(strDecimal) {
    var replacePointByEmpty = strDecimal.replace('.', '');
    var replaceCommaByPoint = replacePointByEmpty.replace(',', '.');
    var convertedStrDecimal = replaceCommaByPoint;

    return parseFloat(convertedStrDecimal);
}

function getNumberStylized(number, bold = false) {
    var stylizedBold = bold ? 'font-weight-bold' : '';
    var stylizedText = '<span class="text-primary ' + stylizedBold + '">' + number + '</span>';

    if (convertStrDecimal(number) > 0) {
        stylizedText = '<span class="text-success ' + stylizedBold + '">' + number + '</span>';
    }

    if (convertStrDecimal(number) < 0) {
        stylizedText = '<span class="text-danger ' + stylizedBold + '">' + number + '</span>';
    }

    return stylizedText;
}

function getProgressBar(percentual, height = 18, font_size = 0.75, font_weight = 'normal') {
    var progressBar = '<span class="badge badge-dark w-100 d-flex justify-content-center align-items-center" style="height: ' + height + 'px; font-size: ' + font_size + 'rem; font-weight: ' + font_weight + ';">SEM FATURAMENTO</span>';
    var progressBarType = '';

    if (convertStrDecimal(percentual) > 0) {

        if (convertStrDecimal(percentual) > 0 && convertStrDecimal(percentual) < 33) {
            progressBarType = 'danger';
        }

        if (convertStrDecimal(percentual) >= 33 && convertStrDecimal(percentual) < 90) {
            progressBarType = 'warning';
        }

        if (convertStrDecimal(percentual) >= 90) {
            progressBarType = 'success';
        }

        progressBar = '<div class="progress" style="height: ' + height + 'px;">\n\
                   <div class="progress-bar progress-bar-striped progress-bar-animated bg-' + progressBarType + '" style="width: ' + convertStrDecimal(percentual) + '%;"><span style="font-size: ' + font_size + 'rem; font-weight: ' + font_weight + ';">' + percentual + '%</span></div>\n\
                   </div>';
    }

    return progressBar;
}

function getFormatedDate(date) {
    var split_date = date.split("/");
    return new Date(split_date[2], split_date[1] - 1, split_date[0]);
}

function getActiveTableLine(line_date) {
    var actual_date = new Date();
    line_date = getFormatedDate(line_date);

    if ((line_date.getDate() == actual_date.getDate()) && (line_date.getMonth() == actual_date.getMonth()) && (line_date.getFullYear() == actual_date.getFullYear())) {
        return true;
    }

    return false;
}

function getCompareDay(filter_date, line_date) {
    line_date = getFormatedDate(line_date);

    if (filter_date == line_date.getDate()) {
        return true;
    }

    return false;
}