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
            <a title="Voltar" href="<?= base_url('materia_prima/movimento/inventario_bloco/lst') ?>" class="btn btn-sm btn-dark">
                <i class="fas fa-arrow-circle-left fa-fw"></i> Voltar
            </a>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <form id="j_app_send_requisition" method="post" action="<?= base_url('materia_prima/movimento/inventario_bloco/frm/' . $block_inventory['id']) ?>">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-12 col-lg-2">
                            <div class="form-group">
                                <label class="small" for="id">Código</label>
                                <input type="text" class="form-control form-control-sm" value="<?= $block_inventory['id'] ?>  " disabled>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label class="small" for="date_time_inventory">Data/Hora Inventário</label>
                                <input type="text" name="date_time_inventory" id="date_time_inventory" class="form-control form-control-sm j_app_mask_datetime j_app_datetimepicker" value="<?= date('d/m/Y H:i:s', strtotime($block_inventory['date_time_inventory'])) ?>">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="small" for="block_type">Tipo</label>
                                <select name="block_type" id="block_type" class="custom-select custom-select-sm">
                                    <option value="">SELECIONE...</option>
                                    <?php
                                    foreach ($block_types as $block_type) :
                                        echo '<option value="' . $block_type['id'] . '"';
                                        if ($block_type['id'] == $block_inventory['block_type']) :
                                            echo ' selected';
                                        endif;
                                        echo '>' . $block_type['description'] . '</option>';
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="small" for="height">Altura</label>
                                <input type="text" name="height" id="height" class="form-control form-control-sm j_app_mask_integer" value="<?= $block_inventory['height'] ?>">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="small" for="quantity_inventory">Quantidade (und)</label>
                                <input type="text" name="quantity_inventory" id="quantity_inventory" class="form-control form-control-sm j_app_mask_decimal_two" value="<?= (empty($block_inventory['quantity_inventory'])) ? $block_inventory['quantity_inventory'] : number_format($block_inventory['quantity_inventory'], 2, ',', '.') ?>">
                            </div>
                        </div>
                    </div>

                    <button title="Confirmar" type="submit" class="btn btn-sm btn-dark">
                        <i class="fas fa-check-circle fa-fw"></i> Confirmar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
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
                }
            },
            complete: function() {
                loaderOff();
            }
        });
    });
</script>