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
            <a title="Voltar" href="<?= base_url('materia_prima/movimento/apontamento/lst') ?>" class="btn btn-sm btn-dark mr-2">
                <i class="fas fa-arrow-circle-left fa-fw"></i> Voltar
            </a>
            <a title="Cadastrar" href="<?= base_url('materia_prima/movimento/apontamento/moldado/frm/' . $requisition['id']) ?>" class="btn btn-sm btn-dark">
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
                        <p class="mb-0 font-weight-bold">Requisição</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-2 mb-2">
                        <small class="d-block">Código</small>
                        <small class="d-block font-weight-bold"><?= $requisition['id'] ?></small>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <small class="d-block">Data/Hora Inicial</small>
                        <small class="d-block font-weight-bold"><?= date('d/m/Y H:i', strtotime($requisition['date_time_start'])) ?></small>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <small class="d-block">Data/Hora Final</small>
                        <small class="d-block font-weight-bold"><?= date('d/m/Y H:i', strtotime($requisition['date_time_finish'])) ?></small>
                    </div>

                    <div class="col-12 col-md-6 col-lg-2 mb-2">
                        <small class="d-block">Ficha</small>
                        <small class="d-block font-weight-bold"><?= $requisition['record'] ?></small>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <small class="d-block">Matéria-Prima</small>
                        <small class="d-block font-weight-bold"><?= $requisition['raw_material_description'] ?></small>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <small class="d-block">Quantidade (kg)</small>
                        <small class="d-block font-weight-bold"><?= number_format($requisition['quantity'], 2, ',', '.') ?></small>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <small class="d-block">Silos</small>
                        <small class="d-block font-weight-bold"><?= $requisition['silos'] ?></small>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <small class="d-block">Operadores</small>
                        <small class="d-block font-weight-bold"><?= $requisition['operators'] ?></small>
                    </div>
                </div>

                <hr>

                <div class="row mb-2">
                    <div class="col-12">
                        <p class="mb-0 font-weight-bold">Blocos</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <small class="d-block">Quantidade (und)</small>
                        <small class="d-block font-weight-bold"><?= $requisition['block_count'] ?></small>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <small class="d-block">Quantidade (m³)</small>
                        <small class="d-block font-weight-bold"><?= $requisition['block_cubic_meters'] ?></small>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <small class="d-block">Peso Virgem (kg)</small>
                        <small class="d-block font-weight-bold"><?= $requisition['block_virgin_weight'] ?></small>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <small class="d-block">Peso Reciclado (kg)</small>
                        <small class="d-block font-weight-bold"><?= $requisition['block_recycled_weight'] ?></small>
                    </div>
                </div>

                <hr>

                <div class="row mb-2">
                    <div class="col-12">
                        <p class="mb-0 font-weight-bold">Moldados</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <small class="d-block">Quantidade (und)</small>
                        <small class="d-block font-weight-bold"><?= $requisition['molded_quantity'] ?></small>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <small class="d-block">Quantidade Refugo (und)</small>
                        <small class="d-block font-weight-bold"><?= $requisition['molded_refugee_quantity'] ?></small>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <small class="d-block">Peso Total (kg)</small>
                        <small class="d-block font-weight-bold"><?= $requisition['molded_total_weight_considered'] ?></small>
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
                <table id="j_app_datatable_molded" class="table table-striped" style="width:100%">
                    <thead class="bg-light">
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Código</th>
                            <th>Requisição</th>
                            <th>Tipo</th>
                            <th>Data/Hora Inicial</th>
                            <th>Data/Hora Final</th>
                            <th>Ficha</th>
                            <th>Quantidade (und)</th>
                            <th>Peso Médio do Pacote (kg)</th>
                            <th>Peso Unitário Considerado (kg)</th>
                            <th>Peso Total Considerado (kg)</th>
                            <th>Silos</th>
                            <th>Operadores</th>
                            <th>Moldados Refugados (und)</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#j_app_datatable_molded").DataTable({
            "columnDefs": [
                {
                    "orderable": false,
                    "targets": 0
                },
                {
                    "orderable": false,
                    "targets": 1
                },
                {
                    "orderable": false,
                    "targets": 2
                }
            ],
            "order": [
                [
                    3,
                    "desc"
                ]
            ],
            ajax: {
                url: "<?= base_url('materia_prima/movimento/apontamento/moldado/lst/' . $requisition['id']) ?>",
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
                {"data": "refugee"},
                {"data": "id"},
                {"data": "requisition"},
                {"data": "molded_type_description"},
                {"data": "date_time_start"},
                {"data": "date_time_finish"},
                {"data": "record"},
                {"data": "quantity"},
                {"data": "package_weight"},
                {"data": "weight_considered_unit"},
                {"data": "total_weight_considered"},
                {"data": "silos"},
                {"data": "operators"},
                {"data": "molded_refugee_quantity"}
            ]
        });
    });

    $(document).on('click', '.j_app_open_delete_modal', function () {
        var id = $(this).attr('data-register-id');
        var requisition = $(this).attr('data-register-requisition');

        $('#id').val(id);
        $('#requisition').val(requisition);
    });

    $(document).on('click', '#j_app_send_delete', function (e) {
        e.preventDefault();

        var url = "<?= base_url('materia_prima/movimento/apontamento/moldado/dlt') ?>";
        var data = {
            "id": $('#id').val(),
            "requisition": $('#requisition').val()
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