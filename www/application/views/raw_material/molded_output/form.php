<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
            <a title="Voltar" href="<?= base_url('materia_prima/movimento/saida_moldado/lst') ?>" class="btn btn-sm btn-dark">
                <i class="fas fa-arrow-circle-left fa-fw"></i> Voltar
            </a>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <form id="j_app_send_requisition" method="post" action="<?= base_url('materia_prima/movimento/saida_moldado/frm/' . $molded_output['id']) ?>">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-12 col-lg-2">
                            <div class="form-group">
                                <label class="small" for="id">Código</label>
                                <input type="text" class="form-control form-control-sm" value="<?= $molded_output['id'] ?>" disabled>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label class="small" for="date_time_output">Data/Hora Saída</label>
                                <input type="text" name="date_time_output" id="date_time_output" class="form-control form-control-sm j_app_mask_datetime j_app_datetimepicker" value="<?= date('d/m/Y H:i:s', strtotime($molded_output['date_time_output'])) ?>">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="small" for="molded_type">Tipo Moldado</label>
                                <select name="molded_type" id="molded_type" class="custom-select custom-select-sm">
                                    <option value="">SELECIONE...</option>
                                    <?php
                                    foreach ($molded_types as $molded_type) :
                                        echo '<option value="' . $molded_type['id'] . '"';
                                        if ($molded_type['id'] == $molded_output['molded_type']):
                                            echo ' selected';
                                        endif;
                                        echo '>' . $molded_type['description'] . '</option>';
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="small" for="quantity_output">Quantidade Saída</label>
                                <input type="text" name="quantity_output" id="quantity_output" class="form-control form-control-sm j_app_mask_decimal_three" value="<?= (empty($molded_output['quantity_output'])) ? $molded_output['quantity_output'] : number_format($molded_output['quantity_output'], 3, ',', '.') ?>">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="small" for="fabrication_order">Ordem Fabricação</label>
                                <input type="text" name="fabrication_order" id="fabrication_order" class="form-control form-control-sm j_app_mask_integer" value="<?= (empty($molded_output['fabrication_order'])) ? $molded_output['fabrication_order'] : number_format($molded_output['fabrication_order'], 0, ',', '.') ?>">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="small">Operador Requisitante</label>
                                <div class="form-row">
                                    <div class="col-12">
                                        <?php
                                        $arrRequisitonOperators = explode(', ', $molded_output['requisition_operators']);
                                        foreach ($requisition_operators as $requisition_operator) :
                                            echo '<div class="custom-control custom-checkbox custom-control-inline">';
                                            echo '<input type="checkbox" name="requisition_operators[]" id="requisiton-' . $requisition_operator['name'] . '" class="custom-control-input" value="' . $requisition_operator['name'] . '"';
                                            if (in_array($requisition_operator['name'], $arrRequisitonOperators)) :
                                                echo ' checked';
                                            endif;
                                            echo '><label for="requisiton-' . $requisition_operator['name'] . '" class="custom-control-label">' . $requisition_operator['name'] . '</label>';
                                            echo '</div>';
                                        endforeach;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="small">Operador Retirada</label>
                                <div class="form-row">
                                    <div class="col-12">
                                        <?php
                                        $arrOutputOperators = explode(', ', $molded_output['output_operators']);
                                        foreach ($output_operators as $output_operator) :
                                            echo '<div class="custom-control custom-checkbox custom-control-inline">';
                                            echo '<input type="checkbox" name="output_operators[]" id="output-' . $output_operator['name'] . '" class="custom-control-input" value="' . $output_operator['name'] . '"';
                                            if (in_array($output_operator['name'], $arrOutputOperators)) :
                                                echo ' checked';
                                            endif;
                                            echo '><label for="output-' . $output_operator['name'] . '" class="custom-control-label">' . $output_operator['name'] . '</label>';
                                            echo '</div>';
                                        endforeach;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    $("#j_app_send_requisition").on("submit", function (e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr("action");
        var data = form.serialize();

        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: data,
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

                if (response.result && response.result === true) {
                    form[0].reset();
                }
            },
            complete: function () {
                loaderOff();
            }
        });
    });
</script>