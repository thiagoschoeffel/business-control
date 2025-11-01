<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row align-items-center mb-3">
    <div class="col-12 col-lg-6 d-flex align-items-center mb-3 mb-lg-0">
        <i class="<?= $frame_icon ?> fa-fw fa-2x mr-2"></i>

        <div>
            <small class="d-block"><?= $frame_module ?></small>
            <h5 class="mb-0 font-weight-bold"><?= $frame_title ?></h5>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="d-flex justify-content-lg-end">
            <a title="Voltar" href="<?= base_url('materia_prima/movimento/saida_bloco/lst') ?>" class="btn btn-sm btn-dark">
                <i class="fas fa-arrow-circle-left fa-fw"></i> Voltar
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <form id="j_app_send_requisition" method="post" action="<?= base_url('materia_prima/movimento/saida_bloco/frm/' . $block_output['id']) ?>">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-12 col-lg-2">
                            <div class="form-group">
                                <label class="small">Código</label>
                                <input type="text" class="form-control form-control-sm" value="<?= $block_output['id'] ?> " disabled>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label class="small" for="date_time_output">Data/Hora Saída</label>
                                <input type="text" name="date_time_output" id="date_time_output" class="form-control form-control-sm j_app_mask_datetime j_app_datetimepicker" value="<?= date('d/m/Y H:i:s', strtotime($block_output['date_time_output'])) ?>">
                            </div>
                        </div>

                        <div class="col-12 col-lg-2 <?= (!empty($block_output['id'])) ? 'col-lg-2' : 'col-lg-3' ?>">
                            <div class="form-group">
                                <label class="small" for="fabrication_order">Ord. Fab.</label>
                                <input type="text" name="fabrication_order" id="fabrication_order" class="form-control form-control-sm j_app_mask_integer" value="<?= (empty($block_output['fabrication_order'])) ? $block_output['fabrication_order'] : number_format($block_output['fabrication_order'], 0, '', '') ?>">
                            </div>
                        </div>

                        <div class="col-12 <?= (!empty($block_output['id'])) ? 'col-lg-2' : 'col-lg-3' ?>">
                            <div class="form-group">
                                <label class="small" for="requisition">Requisição</label>
                                <input type="text" name="requisition" id="requisition" class="form-control form-control-sm j_app_mask_integer" value="<?= (empty($block_output['requisition'])) ? $block_output['requisition'] : number_format($block_output['requisition'], 0, '', '') ?>" data-action="<?= base_url('materia_prima/movimento/saida_bloco/frm/pegar_blocos_disponiveis') ?>" <?= (!empty($block_output['id']) ? ' disabled' : '') ?>>
                            </div>
                        </div>

                        <?php if (!empty($block_output['id']) && isset($block_output['requisition_sequence'])) : ?>
                            <div class="col-12 col-lg-2">
                                <div class="form-group">
                                    <label class="small" for="requisition_sequence">Sequência</label>
                                    <input type="text" name="requisition_sequence" id="requisition_sequence" class="form-control form-control-sm j_app_mask_integer" value="<?= (empty($block_output['requisition_sequence'])) ? $block_output['requisition_sequence'] : number_format($block_output['requisition_sequence'], 0, '', '') ?>" <?= (!empty($block_output['id']) ? ' disabled' : '') ?>>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (empty($block_output['id'])) : ?>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="small">Sequências</label>

                                    <div class="form-row">
                                        <div class="col-12 j_requisition_sequences">
                                            <small class="d-block text-info"><i class="fas fa-info-circle"></i> Informe um número de requisição para carregar as sequências de blocos disponíveis.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <button title="Confirmar" type="submit" class="btn btn-sm btn-dark">
                <i class="fas fa-check-circle fa-fw"></i> Confirmar
            </button>
        </form>
    </div>
</div>
<script>
    $("#requisition").on("blur", function() {
        $('.j_requisition_sequences').html('<small class="d-block text-info"><i class="fas fa-info-circle"></i> Informe um número de requisição para carregar as sequências de blocos disponíveis.</small>')

        var url = $("#requisition").attr("data-action");
        var requisition_value = $("#requisition").val();

        if (requisition_value.length > 0) {
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: {
                    requisition: requisition_value
                },
                beforeSend: function() {
                    loaderOn();
                    notificationClear();
                },
                success: function(response) {
                    if (response.length === 0) {
                        $('.j_requisition_sequences').html('<small class="d-block text-danger"><i class="fas fa-exclamation-circle"></i> Não existe nenhum bloco disponível para baixa nesta requisição.</small>');
                        return;
                    }

                    var html = '';

                    $.each(response, function(index, value) {
                        html += '<div class="custom-control custom-checkbox mb-2">'
                        html +=     '<input type="checkbox" name="requisition_sequence[]" id="' + value.requisition_sequence + '" class="custom-control-input" value="' + value.requisition_sequence + '">'
                        html +=     '<label for="' + value.requisition_sequence + '" class="custom-control-label">'
                        html +=         '<small class="">' + value.requisition_sequence + ' &raquo; ' + value.block_type_description + ' - ' + value.length + 'mm x ' + value.width + 'mm x ' + value.height + 'mm - ' + value.cubic_meters + 'm³</small>'
                        html +=     '</label>'
                        html += '</div>'
                    });

                    $('.j_requisition_sequences').html(html);
                },
                complete: function() {
                    loaderOff();
                }
            });
        }
    });

    $("#j_app_send_requisition").on("submit", function(e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr("action");
        var data = form.serialize();

        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: data,
            beforeSend: function() {
                loaderOn();
                notificationClear();
            },
            success: function(response) {
                if (response.notification) {
                    notificationShow(response.notification.type, response.notification.message);
                }

                if (response.redirect) {
                    window.location = response.redirect;
                }

                if (response.result && response.result === true) {
                    form[0].reset();

                    $('.j_requisition_sequences').html('<small class="d-block text-info"><i class="fas fa-info-circle"></i> Informe um número de requisição para carregar as sequências de blocos disponíveis.</small>')
                }
            },
            complete: function() {
                loaderOff();
            }
        });
    });
</script>