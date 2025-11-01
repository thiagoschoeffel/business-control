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
            <a title="Voltar" href="<?= base_url('materia_prima/movimento/apontamento/bloco/lst/' . $block['requisition']) ?>" class="btn btn-sm btn-dark">
                <i class="fas fa-arrow-circle-left fa-fw"></i> Voltar
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <form id="j_app_send_block" method="post" action="<?= base_url('materia_prima/movimento/apontamento/bloco/frm/' . $block['requisition'] . '/' . $block['id']) ?>">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-12 col-lg-2">
                            <div class="form-group">
                                <label class="small" for="requisition">Requisição</label>
                                <input type="text" class="form-control form-control-sm" value="<?= $block['requisition'] ?>" disabled>
                            </div>
                        </div>

                        <div class="col-12 col-lg-2">
                            <div class="form-group">
                                <label class="small" for="id">Código</label>
                                <input type="text" class="form-control form-control-sm" value="<?= $block['id'] ?>" disabled>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label class="small" for="date_time_start">Data/Hora Inicial</label>
                                <input type="text" name="date_time_start" id="date_time_start" class="form-control form-control-sm j_app_mask_datetime j_app_datetimepicker" value="<?= date('d/m/Y H:i:s', strtotime($block['date_time_start'])) ?>">
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label class="small" for="date_time_finish">Data/Hora Final</label>
                                <input type="text" name="date_time_finish" id="date_time_finish" class="form-control form-control-sm j_app_mask_datetime j_app_datetimepicker" value="<?= date('d/m/Y H:i:s', strtotime($block['date_time_finish'])) ?>">
                            </div>
                        </div>

                        <div class="col-12 col-lg-2">
                            <div class="form-group">
                                <label class="small" for="record">Ficha</label>
                                <input type="text" name="record" id="record" class="form-control form-control-sm j_app_mask_only_numbers" value="<?= $block['record'] ?>">
                            </div>
                        </div>

                        <div class="col-12 col-lg-2">
                            <div class="form-group">
                                <label class="small" for="weight">Peso</label>
                                <input type="text" name="weight" id="weight" class="form-control form-control-sm j_app_mask_decimal_two" value="<?= (empty($block['weight'])) ? $block['weight'] : number_format($block['weight'], 2, ',', '.') ?>">
                            </div>
                        </div>

                        <div class="col-12 col-lg-5">
                            <div class="form-group">
                                <label class="small" for="block_type">Tipo</label>
                                <select name="block_type" id="block_type" class="custom-select custom-select-sm">
                                    <option value="">SELECIONE...</option>
                                    <?php
                                    foreach ($block_types as $block_type) :
                                        echo '<option value="' . $block_type['id'] . '"';
                                        if ($block_type['id'] == $block['block_type']):
                                            echo ' selected';
                                        endif;
                                        echo '>' . $block_type['description'] . '</option>';
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-3">
                            <div class="form-group">
                                <label class="small" for="height">Altura</label>
                                <input type="text" name="height" id="height" class="form-control form-control-sm j_app_mask_integer" value="<?= $block['height'] ?>">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="small">Silos</label>
                                <div class="form-row">
                                    <div class="col-12">
                                        <?php
                                        $arrSilos = explode(', ', $block['silos']);
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
                                        $arrOperators = explode(', ', $block['operators']);
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
    $("#j_app_send_block").on("submit", function (e) {
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
            error: function () {
                loaderOff();
            },
            complete: function () {
                loaderOff();
            }
        });
    });
</script>