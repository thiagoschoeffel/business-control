<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row align-items-center mb-3">
    <div class="col-12 col-lg-6 d-flex align-items-center mb-3 mb-lg-0">
        <i class="<?= $frame_icon ?> fa-fw fa-2x mr-2"></i>

        <div>
            <small class="d-block"><?= $frame_module ?></small>
            <h5 class="mb-0 font-weight-bold"><?= $frame_title ?></h5>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <form id="j_app_send_new_password" method="post" action="<?= base_url('alterar_senha') ?>">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <small class="d-block mb-3"><i class="fas fa-exclamation-circle"></i> Você está vendo esta tela por este ser seu primeiro acesso ao sistema ou porque solicitou a alteração de senha para o administrador. Você está acessando com uma senha provisória, solicitamos que crie uma nova senha abaixo, isto para sua segurança e privacidade.</small>
                    <div class="form-row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="small" for="new_password">Nova Senha</label>
                                <input type="password" name="new_password" id="new_password" class="form-control form-control-sm">
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
    $("#j_app_send_new_password").on("submit", function (e) {
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