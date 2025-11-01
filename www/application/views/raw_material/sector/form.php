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
            <a title="Voltar" href="<?= base_url('materia_prima/cadastro/setor/lst') ?>" class="btn btn-sm btn-dark">
                <i class="fas fa-arrow-circle-left fa-fw"></i> Voltar
            </a>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <form id="j_app_send_requisition" method="post" action="<?= base_url('materia_prima/cadastro/setor/frm/' . $sector['id']) ?>">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-12 col-lg-2">
                            <div class="form-group">
                                <label class="small" for="id">Código</label>
                                <input type="text" class="form-control form-control-sm" value="<?= $sector['id'] ?>" disabled>
                            </div>
                        </div>

                        <div class="col-12 col-lg-10">
                            <div class="form-group">
                                <label class="small" for="name">Nome</label>
                                <input type="text" name="name" id="name" class="form-control form-control-sm j_app_mask_uppercase" value="<?= $sector['name'] ?>">
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