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
            <a title="Voltar" href="<?= base_url('materia_prima/movimento/apontamento/moldado/lst/' . $molded['requisition']) ?>" class="btn btn-sm btn-dark mr-2">
                <i class="fas fa-arrow-circle-left fa-fw"></i> Voltar
            </a>
            <a title="Cadastrar" href="<?= base_url('materia_prima/movimento/apontamento/moldado/refugo/frm/' . $molded['requisition'] . '/' . $molded['id']) ?>" class="btn btn-sm btn-dark">
                <i class="fas fa-plus-circle fa-fw"></i> Cadastrar
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-12">
                        <p class="mb-0 font-weight-bold">Moldados</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-2 mb-2">
                        <small class="d-block">Requisição</small>
                        <small class="d-block font-weight-bold"><?= $molded['requisition'] ?></small>
                    </div>

                    <div class="col-12 col-md-6 col-lg-2 mb-2">
                        <small class="d-block">Moldado</small>
                        <small class="d-block font-weight-bold"><?= $molded['id'] ?></small>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <small class="d-block">Data/Hora Inicial</small>
                        <small class="d-block font-weight-bold"><?= date('d/m/Y H:i:s', strtotime($molded['date_time_start'])) ?></small>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <small class="d-block">Data/Hora Final</small>
                        <small class="d-block font-weight-bold"><?= date('d/m/Y H:i:s', strtotime($molded['date_time_finish'])) ?></small>
                    </div>

                    <div class="col-12 col-md-6 col-lg-2 mb-2">
                        <small class="d-block">Ficha</small>
                        <small class="d-block font-weight-bold"><?= $molded['record'] ?></small>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <small class="d-block">Quantidade (und)</small>
                        <small class="d-block font-weight-bold"><?= (empty($molded['quantity'])) ? $molded['quantity'] : number_format($molded['quantity'], 2, ',', '.') ?></small>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <small class="d-block">Peso Médio (kg)</small>
                        <small class="d-block font-weight-bold"><?= (empty($molded['package_weight'])) ? $molded['package_weight'] : number_format($molded['package_weight'], 2, ',', '.') ?></small>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <small class="d-block">Silos</small>
                        <small class="d-block font-weight-bold"><?= $molded['silos'] ?></small>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <small class="d-block">Operadores</small>
                        <small class="d-block font-weight-bold"><?= $molded['operators'] ?></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <table id="j_app_datatable_molded_refugee" class="table table-striped" style="width:100%">
                    <thead class="bg-light">
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Código</th>
                            <th>Moldada</th>
                            <th>Quantidade (und)</th>
                            <th>Motivo</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#j_app_datatable_molded_refugee").DataTable({
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
                url: "<?= base_url('materia_prima/movimento/apontamento/moldado/refugo/lst/' . $molded['requisition'] . '/' . $molded['id']) ?>",
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
                {"data": "molded"},
                {"data": "quantity"},
                {"data": "description"}
            ]
        });
    });

    $(document).on('click', '.j_app_open_delete_modal', function () {
        var molded = $(this).attr('data-register-molded');
        var id = $(this).attr('data-register-id');

        $('#molded').val(molded);
        $('#id').val(id);
    });

    $(document).on('click', '#j_app_send_delete', function (e) {
        e.preventDefault();

        var url = "<?= base_url('materia_prima/movimento/apontamento/moldado/refugo/dlt') ?>";
        var data = {
            "requisition": <?= $molded['requisition'] ?>,
            "molded": $('#molded').val(),
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