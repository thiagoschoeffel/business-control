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
            <a title="Voltar" href="<?= base_url('materia_prima/movimento/apontamento/moldado/refugo/lst/' . $molded['requisition'] . '/' . $molded_refugee['molded']) ?>" class="btn btn-sm btn-dark">
                <i class="fas fa-arrow-circle-left fa-fw"></i> Voltar
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <form id="j_app_send_molded_refugee" method="post" action="<?= base_url('materia_prima/movimento/apontamento/moldado/refugo/frm/' . $molded['requisition'] . '/' . $molded_refugee['molded'] . '/' . $molded_refugee['id']) ?>">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="form-row">                        
                        <div class="col-12 col-lg-2">
                            <div class="form-group">
                                <label class="small" for="molded">Moldado</label>
                                <input type="text" class="form-control form-control-sm" value="<?= $molded_refugee['molded'] ?>" disabled>
                            </div>
                        </div>

                        <div class="col-12 col-lg-2">
                            <div class="form-group">
                                <label class="small" for="id">Código</label>
                                <input type="text" name="id" id="id" class="form-control form-control-sm" value="<?= $molded_refugee['id'] ?>" disabled>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label class="small" for="quantity">Quantidade</label>
                                <input type="text" name="quantity" id="quantity" class="form-control form-control-sm j_app_mask_decimal_two" value="<?= (empty($molded_refugee['quantity'])) ? $molded_refugee['quantity'] : number_format($molded_refugee['quantity'], 2, ',', '.') ?>">
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label class="small" for="reason">Motivo</label>
                                <select name="reason" id="reason" class="custom-select custom-select-sm">
                                    <option value="">SELECIONE...</option>
                                    <?php
                                    foreach ($reasons as $reason) :
                                        echo '<option value="' . $reason['id'] . '"';
                                        if ($reason['id'] == $molded_refugee['reason']):
                                            echo ' selected';
                                        endif;
                                        echo '>' . $reason['description'] . '</option>';
                                    endforeach;
                                    ?>
                                </select>
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
    $("#j_app_send_molded_refugee").on("submit", function (e) {
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