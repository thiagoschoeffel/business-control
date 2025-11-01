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
            <a title="Cadastrar" href="<?= base_url('materia_prima/movimento/parada/frm') ?>" class="btn btn-sm btn-dark">
                <i class="fas fa-plus-circle fa-fw"></i> Cadastrar
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <table id="j_app_datatable_machine_stop" class="table table-striped" style="width:100%">
                    <thead class="bg-light">
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Código</th>
                            <th>Data/Hora Inicial</th>
                            <th>Data/Hora Final</th>
                            <th>Tempo Total Parada</th>
                            <th>Nome Máquina</th>
                            <th>Descrição Motivo</th>
                            <th>Observação</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#j_app_datatable_machine_stop").DataTable({
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
                    3,
                    "desc"
                ]
            ],
            ajax: {
                url: "<?= base_url('materia_prima/movimento/parada/lst') ?>",
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
                {"data": "date_time_start"},
                {"data": "date_time_finish"},
                {"data": "total_stop_time"},
                {"data": "machine_name"},
                {"data": "reason_description"},
                {"data": "note"}
            ]
        });
    });

    $(document).on('click', '.j_app_open_delete_modal', function () {
        var id = $(this).attr('data-register-id');
        $('#id').val(id);
    });

    $(document).on('click', '#j_app_send_delete', function (e) {
        e.preventDefault();

        var url = "<?= base_url('materia_prima/movimento/parada/dlt') ?>";
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