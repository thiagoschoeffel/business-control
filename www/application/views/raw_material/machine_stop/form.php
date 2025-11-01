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
            <a title="Voltar" href="<?= base_url('materia_prima/movimento/parada/lst') ?>" class="btn btn-sm btn-dark">
                <i class="fas fa-arrow-circle-left fa-fw"></i> Voltar
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <form id="j_app_send_machine_stop" method="post" action="<?= base_url('materia_prima/movimento/parada/frm/' . $machine_stop['id']) ?>">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-2">
                            <div class="form-group">
                                <label class="small" for="id">Código</label>
                                <input type="text" class="form-control form-control-sm" value="<?= $machine_stop['id'] ?>" disabled>
                            </div>
                        </div>

                        <div class="col-12 col-lg-5">
                            <div class="form-group">
                                <label class="small" for="date_time_start">Data/Hora Inicial</label>
                                <input type="text" name="date_time_start" id="date_time_start" class="form-control form-control-sm j_app_mask_datetime j_app_datetimepicker" value="<?= date('d/m/Y H:i:s', strtotime($machine_stop['date_time_start'])) ?>">
                            </div>
                        </div>

                        <div class="col-12 col-lg-5">
                            <div class="form-group">
                                <label class="small" for="date_time_finish">Data/Hora Final</label>
                                <input type="text" name="date_time_finish" id="date_time_finish" class="form-control form-control-sm j_app_mask_datetime j_app_datetimepicker" value="<?= date('d/m/Y H:i:s', strtotime($machine_stop['date_time_finish'])) ?>">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="small" for="machine">Máquina</label>
                                <select name="machine" id="machine" class="custom-select custom-select-sm">
                                    <option value="">SELECIONE...</option>
                                    <?php
                                    foreach ($machines as $machine) :
                                        echo '<option value="' . $machine['id'] . '"';
                                        if ($machine['id'] == $machine_stop['machine']):
                                            echo ' selected';
                                        endif;
                                        echo '>' . $machine['name'] . '</option>';
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="small" for="reason">Motivo</label>
                                <select name="reason" id="reason" class="custom-select custom-select-sm">
                                    <option value="">SELECIONE...</option>
                                    <?php
                                    foreach ($reasons as $reason) :
                                        echo '<option value="' . $reason['id'] . '"';
                                        if ($reason['id'] == $machine_stop['reason']):
                                            echo ' selected';
                                        endif;
                                        echo '>' . $reason['description'] . '</option>';
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="small" for="note">Observação</label>
                                <textarea name="note" id="note" rows="5" class="form-control form-control-sm"><?= $machine_stop['note'] ?></textarea>
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
    $("#j_app_send_machine_stop").on("submit", function (e) {
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