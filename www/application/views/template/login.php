<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card mb-3 shadow-sm">
                <div class="row no-gutters">
                    <div class="col-12 col-sm-6 app_login_presentation" style="background-image: url('<?= base_url('assets/images/presentation.png') ?>')">
                    </div>

                    <div class="col-12 col-sm-6 d-flex align-items-center">
                        <div class="card-body">
                            <img alt="Business Control" title="Business Control" src="<?= base_url('assets/images/logo.png') ?>" class="d-block mx-auto mb-3" width="180">

                            <p class="mb-3 text-center">Esta é uma <strong>área restrita</strong>, para acessar você primeiro deve informar seu usuário e senha.</p>

                            <form id="j_app_send_login" method="post" action="<?= base_url('login') ?>" autocomplete="off">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-user fa-fw"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="login" class="form-control form-control-sm" placeholder="Usuário">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-key fa-fw"></i>
                                            </span>
                                        </div>
                                        <input type="password" name="password" class="form-control form-control-sm" placeholder="Senha">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-sm btn-dark">
                                        <i class="fas fa-sign-in-alt fa-fw"></i> Entrar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("#j_app_send_login").on("submit", function (e) {
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