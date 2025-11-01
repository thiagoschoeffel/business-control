<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
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
            <a title="Cadastrar" href="<?= base_url('materia_prima/movimento/saida_bloco/frm') ?>" class="btn btn-sm btn-dark">
                <i class="fas fa-plus-circle fa-fw"></i> Cadastrar
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <form id="j_app_send_requisition" method="post" action="<?= base_url('materia_prima/movimento/saida_bloco/lst/filtrar') ?>">
                    <div class="form-row">
                        <!-- <div class="col-12 col-lg-2">
                            <div class="form-group">
                                <label class="small" for="id">Código</label>
                                <input type="text" name="id" id="id" class="form-control form-control-sm j_app_mask_integer" value="<?= ($this->session->userdata('list_block_output_filter_id')) ? $this->session->userdata('list_block_output_filter_id') : '' ?>">
                            </div>
                        </div> -->

                        <div class="col-12 col-lg-3">
                            <div class="form-group">
                                <label class="small" for="date_time_output_start">Data/Hora Saída (de)</label>
                                <input type="text" name="date_time_output_start" id="date_time_output_start" class="form-control form-control-sm j_app_mask_datetime j_app_datetimepicker" value="<?= ($this->session->userdata('list_block_output_filter_date_time_output_start')) ? $this->session->userdata('list_block_output_filter_date_time_output_start') : '' ?>">
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="form-group">
                                <label class="small" for="date_time_output_finish">Data/Hora Saída (até)</label>
                                <input type="text" name="date_time_output_finish" id="date_time_output_finish" class="form-control form-control-sm j_app_mask_datetime j_app_datetimepicker" value="<?= ($this->session->userdata('list_block_output_filter_date_time_output_finish')) ? $this->session->userdata('list_block_output_filter_date_time_output_finish') : '' ?>">
                            </div>
                        </div>

                        <div class="col-12 col-lg-3">
                            <div class="form-group">
                                <label class="small" for="requisition">Requisição</label>
                                <input type="text" name="requisition" id="requisition" class="form-control form-control-sm j_app_mask_integer" value="<?= ($this->session->userdata('list_block_output_filter_requisition')) ? $this->session->userdata('list_block_output_filter_requisition') : '' ?>">
                            </div>
                        </div>

                        <div class="col-12 col-lg-3">
                            <div class="form-group">
                                <label class="small" for="fabrication_order">Ordem Fabricação</label>
                                <input type="text" name="fabrication_order" id="fabrication_order" class="form-control form-control-sm j_app_mask_integer" value="<?= ($this->session->userdata('list_block_output_filter_fabrication_order')) ? $this->session->userdata('list_block_output_filter_fabrication_order') : '' ?>">
                            </div>
                        </div>

                        <div class="col-12 col-lg-3">
                            <div class="form-group">
                                <label class="small" for="block_type">Tipo</label>
                                <select name="block_type" id="block_type" class="custom-select custom-select-sm">
                                    <option value="">SELECIONE...</option>
                                    <?php
                                        foreach ($block_types as $block_type) :
                                            echo '<option value="' . $block_type['id'] . '"';
                                            if ($block_type['id'] == ($this->session->userdata('list_block_output_filter_block_type')) ? $this->session->userdata('list_block_output_filter_block_type') : '') :
                                                echo ' selected';
                                            endif;
                                            echo '>' . $block_type['description'] . '</option>';
                                        endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-3">
                            <div class="form-group">
                                <label class="small" for="block_height">Altura Bloco (mm)</label>
                                <input type="text" name="block_height" id="block_height" class="form-control form-control-sm j_app_mask_integer" value="<?= ($this->session->userdata('list_block_output_filter_block_height')) ? $this->session->userdata('list_block_output_filter_block_height') : '' ?>">
                            </div>
                        </div>
                    </div>

                    <button title="Filtrar" type="submit" class="btn btn-sm btn-dark">
                        <i class="fas fa-filter fa-fw"></i> Filtrar
                    </button>
                </form>

                <div class="table-responsive mt-4">
                    <table class="table table-striped mb-0" style="width:100%">
                        <thead class="bg-light">
                            <tr>
                                <th></th>
                                <th></th>
                                <!-- <th>Código</th> -->
                                <th>Data Saída</th>
                                <th>Req.</th>
                                <th>Seq.</th>
                                <th>Ord. Fab.</th>
                                <th>Peso (kg)</th>
                                <th>Dens. (kg/m³)</th>
                                <th>Tipo</th>
                                <th>Comp. (mm)</th>
                                <th>Larg. (mm)</th>
                                <th>Alt. (mm)</th>
                                <th>M³ (m³)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($blocks_output as $block_output) : ?>
                                <tr>
                                    <td><a title="Editar Registro" href="<?= base_url('materia_prima/movimento/saida_bloco/frm/' . $block_output['id']) ?>" class="btn btn-sm btn-dark"><i class="fas fa-pencil-alt fa-fw"></i> Editar</a></td>
                                    <td><button title="Deletar Registro" type="button" class="btn btn-sm btn-danger j_app_open_delete_modal" data-toggle="modal" data-target="#j_app_modal_delete" data-register-id="<?= $block_output['id'] ?>"><i class="fas fa-trash-alt fa-fw"></i> Deletar</button></td>
                                    <!-- <td><?= $block_output['id'] ?></td> -->
                                    <td><?= date('d/m/Y H:i:s', strtotime($block_output['date_time_output'])) ?></td>
                                    <td><?= $block_output['requisition'] ?></td>
                                    <td><?= $block_output['requisition_sequence'] ?></td>
                                    <td><?= $block_output['fabrication_order'] ?></td>
                                    <td><?= number_format($block_output['weight'], 2, ',', '.') ?></td>
                                    <td><?= number_format($block_output['density'], 2, ',', '.') ?></td>
                                    <td><?= $block_output['block_type_description'] ?></td>
                                    <td><?= $block_output['length'] ?></td>
                                    <td><?= $block_output['width'] ?></td>
                                    <td><?= $block_output['height'] ?></td>
                                    <td><?= number_format($block_output['cubic_meters'], 4, ',', '.') ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-lg-end">
                    <?= $pagination_links ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("#j_app_send_requisition").on("submit", function(e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr("action");
        var data = form.serialize();

        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: data,
            beforeSend: function() {
                loaderOn();
                notificationClear();
            },
            success: function(response) {
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
            complete: function() {
                loaderOff();
            }
        });
    });

    $(document).on('click', '.j_app_open_delete_modal', function() {
        var id = $(this).attr('data-register-id');

        $('#id').val(id);
    });

    $(document).on('click', '#j_app_send_delete', function(e) {
        e.preventDefault();

        var url = "<?= base_url('materia_prima/movimento/saida_bloco/dlt') ?>";
        var data = {
            "id": $('#id').val()
        };

        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: data,
            beforeSend: function() {
                loaderOn();
                notificationClear();
            },
            success: function(response) {
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
            error: function() {
                loaderOff();
            },
            complete: function() {
                loaderOff();
            }
        });
    });
</script>