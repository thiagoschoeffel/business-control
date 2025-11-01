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
            <a title="Cadastrar" href="<?= base_url('materia_prima/cadastro/motivo/frm') ?>" class="btn btn-sm btn-dark">
                <i class="fas fa-plus-circle fa-fw"></i> Cadastrar
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <table id="j_app_datatable_requisition" class="table table-striped" style="width:100%">
                    <thead class="bg-light">
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Código</th>
                            <th>Tipo</th>
                            <th>Descrição</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#j_app_datatable_requisition").DataTable({
            "columnDefs": [
                {
                    "orderable": false,
                    "targets": 0
                },
                {
                    "orderable": false,
                    "targets": 1
                }
            ],
            "order": [
                [
                    2,
                    "desc"
                ]
            ],
            ajax: {
                url: "<?= base_url('materia_prima/cadastro/motivo/lst') ?>",
                "dataSrc": "data",
                beforeSend: function () {
                    loaderOn();
                },
                error: function () {
                    loaderOff();
                },
                complete: function () {
                    loaderOff();
                }
            },
            "columns": [
                {"data": "edit"},
                {"data": "delete"},
                {"data": "id"},
                {"data": "type"},
                {"data": "description"}
            ]
        });
    });

    $(document).on('click', '.j_app_open_delete_modal', function () {
        var id = $(this).attr('data-register-id');

        $('#id').val(id);
    });

    $(document).on('click', '#j_app_send_delete', function (e) {
        e.preventDefault();

        var url = "<?= base_url('materia_prima/cadastro/motivo/dlt') ?>";
        var data = {
            "id": $('#id').val()
        };

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