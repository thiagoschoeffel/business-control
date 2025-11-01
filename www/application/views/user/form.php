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
            <a title="Voltar" href="<?= base_url('usuario/lst') ?>" class="btn btn-sm btn-dark">
                <i class="fas fa-arrow-circle-left fa-fw"></i> Voltar
            </a>
        </div>
    </div>
</div>


<div class="row mb-3">
    <div class="col-12">
        <form id="j_app_send_requisition" method="post" action="<?= base_url('usuario/frm/' . $user['id']) ?>">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-12 col-lg-2">
                            <div class="form-group">
                                <label class="small" for="id">Código</label>
                                <input type="text" class="form-control form-control-sm" value="<?= $user['id'] ?>" disabled>
                            </div>
                        </div>

                        <div class="col-12 col-lg-5">
                            <div class="form-group">
                                <label class="small" for="first_name">Nome</label>
                                <input type="text" name="first_name" id="first_name" class="form-control form-control-sm j_app_mask_uppercase" value="<?= $user['first_name'] ?>">
                            </div>
                        </div>

                        <div class="col-12 col-lg-5">
                            <div class="form-group">
                                <label class="small" for="last_name">Sobrenome</label>
                                <input type="text" name="last_name" id="last_name" class="form-control form-control-sm j_app_mask_uppercase" value="<?= $user['last_name'] ?>">
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label class="small" for="email">E-Mail</label>
                                <input type="text" name="email" id="email" class="form-control form-control-sm j_app_mask_lowercase" value="<?= $user['email'] ?>">
                            </div>
                        </div>

                        <div class="col-12 col-lg-3">
                            <div class="form-group">
                                <label class="small" for="login">Usuário</label>
                                <input type="text" name="login" id="login" class="form-control form-control-sm" value="<?= $user['login'] ?>">
                            </div>
                        </div>

                        <div class="col-12 col-lg-3">
                            <div class="form-group">
                                <label class="small" for="password">Senha</label>
                                <input type="password" name="password" id="password" class="form-control form-control-sm" value="">
                            </div>
                        </div>

                        <div class="col-12 col-lg-2">
                            <div class="form-group">
                                <label class="small" class="small" for="first_access">Já Acessou?</label>
                                <select name="first_access" id="first_access" class="custom-select custom-select-sm">
                                    <option value="N" <?= ($user['first_access'] === 'N') ? 'selected' : '' ?> >SIM</option>
                                    <option value="S" <?= ($user['first_access'] === 'S') ? 'selected' : '' ?> >NÃO</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="small">Permissões</label>
                                <div class="form-row">
                                    <div class="col-12">
                                        <?php
                                        $arrPermissions = explode(', ', $user['permissions']);
                                        foreach ($modules as $module) :
                                            echo '<div class="custom-control custom-checkbox">';
                                            echo '<input type="checkbox" name="permissions[]" id="' . $module['id'] . '" class="custom-control-input" value="' . $module['level_class'] . '"';
                                            if (in_array($module['level_class'], $arrPermissions)) :
                                                echo ' checked';
                                            endif;
                                            echo '><label for="' . $module['id'] . '" class="custom-control-label">' . $module['description'] . '</label>';
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