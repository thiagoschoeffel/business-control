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
            <a title="Voltar" href="<?= base_url('materia_prima/movimento/apontamento/lst') ?>" class="btn btn-sm btn-dark">
                <i class="fas fa-arrow-circle-left fa-fw"></i> Voltar
            </a>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <form id="j_app_send_requisition" method="post" action="<?= base_url('materia_prima/movimento/apontamento/frm/' . $requisition['id']) ?>">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-12 col-lg-2">
                            <div class="form-group">
                                <label class="small" for="id">Código</label>
                                <input type="text" class="form-control form-control-sm" value="<?= $requisition['id'] ?>" disabled>
                            </div>
                        </div>

                        <div class="col-12 col-lg-5">
                            <div class="form-group">
                                <label class="small" for="date_time_start">Data/Hora Inicial</label>
                                <input type="text" name="date_time_start" id="date_time_start" class="form-control form-control-sm j_app_mask_datetime j_app_datetimepicker" value="<?= date('d/m/Y H:i:s', strtotime($requisition['date_time_start'])) ?>">
                            </div>
                        </div>

                        <div class="col-12 col-lg-5">
                            <div class="form-group">
                                <label class="small" for="date_time_finish">Data/Hora Final</label>
                                <input type="text" name="date_time_finish" id="date_time_finish" class="form-control form-control-sm j_app_mask_datetime j_app_datetimepicker" value="<?= date('d/m/Y H:i:s', strtotime($requisition['date_time_finish'])) ?>">
                            </div>
                        </div>

                        <div class="col-12 col-lg-2">
                            <div class="form-group">
                                <label class="small" for="record">Ficha</label>
                                <input type="text" name="record" id="record" class="form-control form-control-sm j_app_mask_only_numbers" value="<?= $requisition['record'] ?>">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="small" for="raw_material">Matéria-Prima</label>
                                <select name="raw_material" id="raw_material" class="custom-select custom-select-sm">
                                    <option value="">SELECIONE...</option>
                                    <?php
                                    foreach ($raw_materials as $raw_material) :
                                        echo '<option value="' . $raw_material['id'] . '"';
                                        if ($raw_material['id'] == $requisition['raw_material']):
                                            echo ' selected';
                                        endif;
                                        echo '>' . $raw_material['description'] . '</option>';
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label class="small" for="quantity">Quantidade</label>
                                <input type="text" name="quantity" id="quantity" class="form-control form-control-sm j_app_mask_decimal_two" value="<?= (empty($requisition['quantity'])) ? $requisition['quantity'] : number_format($requisition['quantity'], 2, ',', '.') ?>">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="small">Silos</label>
                                <div class="form-row">
                                    <div class="col-12">
                                        <?php
                                        $arrSilos = explode(', ', $requisition['silos']);
                                        foreach ($silos as $silo) :
                                            echo '<div class="custom-control custom-checkbox custom-control-inline">';
                                            echo '<input type="checkbox" name="silos[]" id="' . $silo['description'] . '" class="custom-control-input" value="' . $silo['description'] . '"';
                                            if (in_array($silo['description'], $arrSilos)) :
                                                echo ' checked';
                                            endif;
                                            echo '><label for="' . $silo['description'] . '" class="custom-control-label">' . $silo['description'] . '</label>';
                                            echo '</div>';
                                        endforeach;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="small">Operadores</label>
                                <div class="form-row">
                                    <div class="col-12">
                                        <?php
                                        $arrOperators = explode(', ', $requisition['operators']);
                                        foreach ($operators as $operator) :
                                            echo '<div class="custom-control custom-checkbox custom-control-inline">';
                                            echo '<input type="checkbox" name="operators[]" id="' . $operator['name'] . '" class="custom-control-input" value="' . $operator['name'] . '"';
                                            if (in_array($operator['name'], $arrOperators)) :
                                                echo ' checked';
                                            endif;
                                            echo '><label for="' . $operator['name'] . '" class="custom-control-label">' . $operator['name'] . '</label>';
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