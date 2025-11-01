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
            <div class="input-group input-group-sm">
                <input type="text" name="filter_date_time_start" id="filter_date_time_start" class="form-control form-control-sm j_app_mask_datetime j_app_datetimepicker" value="<?= date('01/m/Y 05:00:00') ?>">

                <input type="text" name="filter_date_time_finish" id="filter_date_time_finish" class="form-control form-control-sm j_app_mask_datetime j_app_datetimepicker" value="<?= date('d/m/Y H:i:s') ?>">

                <div class="input-group-append">
                    <button type="button" id="j_app_send_filter" class="btn btn-sm btn-dark">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm mb-3">
            <div class="card-body text-center">
                <h5 class="font-weight-light mb-3">Paradas de Máquina</h5>

                <small class="d-block">Quantidade</small>
                <h3 class="mb-3 font-weight-bold" id="resume_stop_machine_machine_stop_count"></h3>

                <small class="d-block">Tempo</small>
                <h3 class="mb-0 font-weight-bold" id="resume_stop_machine_machine_stop_time"></h3>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="card shadow-sm mb-3">
            <div class="card-body text-center">
                <h5 class="font-weight-light mb-3">Requisições de Matéria-Prima</h5>

                <small class="d-block">Quantidade</small>
                <h3 class="mb-0 font-weight-bold" id="resume_requisition_requisition_quantity"></h3>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="card shadow-sm mb-3">
            <div class="card-body text-center">
                <h5 class="font-weight-light mb-3">Produção de Blocos</h5>

                <small class="d-block">Quantidade</small>
                <h3 class="mb-3 font-weight-bold" id="resume_block_block_count"></h3>

                <small class="d-block">Metros Cúbicos</small>
                <h3 class="mb-3 font-weight-bold" id="resume_block_block_cubic_meters"></h3>

                <small class="d-block">Matéria-Prima Virgem</small>
                <h3 class="mb-3 font-weight-bold" id="resume_block_block_virgin_weight"></h3>

                <small class="d-block">Matéria-Prima Reciclada</small>
                <h3 class="mb-0 font-weight-bold" id="resume_block_block_recycled_weight"></h3>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm mb-3">
            <div class="card-body text-center">
                <h5 class="font-weight-light mb-3">Produção de Moldados</h5>

                <small class="d-block">Quantidade</small>
                <h3 class="mb-3 font-weight-bold" id="resume_molded_molded_quantity"></h3>

                <small class="d-block">Refugos</small>
                <h3 class="mb-3 font-weight-bold" id="resume_molded_molded_refugee_quantity"></h3>

                <small class="d-block">Metros Cúbicos</small>
                <h3 class="mb-3 font-weight-bold" id="resume_molded_molded_total_cubic_meters"></h3>

                <small class="d-block">Matéria-Prima Virgem</small>
                <h3 class="mb-3 font-weight-bold" id="resume_molded_molded_total_weight_considered"></h3>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-xl-6">
        <div class="card shadow-sm mb-3">
            <div class="card-body text-center">
                <h5 class="font-weight-light">Paradas de Máquina</h5>
                <small class="d-block mb-3">Máquina/Quantidade</small>

                <div id="machine_stops_count_by_machine" style="width:100%; height:300px;"></div>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-6">
        <div class="card shadow-sm mb-3">
            <div class="card-body text-center">
                <h5 class="font-weight-light">Paradas de Máquina</h5>
                <small class="d-block mb-3">Máquina/Tempo</small>

                <div id="machine_stops_time_by_machine" style="width:100%; height:300px;"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-xl-6">
        <div class="card shadow-sm mb-3">
            <div class="card-body text-center">
                <h5 class="font-weight-light">Requisições de Matéria-Prima</h5>
                <small class="d-block mb-3">Tipo/Quantidade</small>
                <div id="requisition_by_raw_material_count" style="width:100%; height:400px;"></div>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-6">
        <div class="card shadow-sm mb-3">
            <div class="card-body text-center">
                <h5 class="font-weight-light">Requisições de Matéria-Prima</h5>
                <small class="d-block mb-3">Data/Quantidade</small>
                <div id="requisition_by_raw_material_date" style="width:100%; height:400px;"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mb-3">
            <div class="card-body text-center">
                <h5 class="font-weight-light">Produção de Blocos</h5>
                <small class="d-block mb-3">Data/Quantidade Produzida</small>

                <div id="block_by_date_count" style="width:100%; height:500px;"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="card shadow-sm mb-3">
            <div class="card-body text-center">
                <h5 class="font-weight-light">Produção de Blocos</h5>
                <div class="table-responsive">
                    <table class="table table-striped text-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Tipo</th>
                                <th>Altura (mm)</th>
                                <th>Quantidade (und)</th>
                                <th>Metros Cúbicos (m³)</th>
                                <th>Matéria-Prima Virgem (kg)</th>
                                <th>Matéria-Prima Reciclada (kg)</th>
                            </tr>
                        </thead>
                        <tbody id="table_block_production_by_type"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6">
        <div class="card shadow-sm mb-3">
            <div class="card-body text-center">
                <h5 class="font-weight-light">Saída de Blocos</h5>
                <div class="table-responsive">
                    <table class="table table-striped text-center mb-0">
                        <thead class="bg-light">
                        <tr>
                            <th>Tipo</th>
                            <th>Altura (mm)</th>
                            <th>Quantidade (und)</th>
                            <th>Metros Cúbicos (m³)</th>
                            <th>Matéria-Prima Virgem (kg)</th>
                            <th>Matéria-Prima Reciclada (kg)</th>
                        </tr>
                        </thead>
                        <tbody id="table_block_output_by_type"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mb-3">
            <div class="card-body text-center">
                <h5 class="font-weight-light">Produção de Moldados</h5>
                <small class="d-block mb-3">Data/Produzido/Refugado</small>

                <div id="molded_by_date_count" style="width:100%; height:500px;"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm mb-3">
            <div class="card-body text-center">
                <h5 class="font-weight-light">Ranking de Refugos dos Moldados</h5>
                <small class="d-block mb-4">Motivo/Quantidade</small>

                <div class="d-flex justify-content-around align-items-center">
                    <i class="fas fa-exclamation-circle fa-fw fa-3x text-warning"></i>

                    <div class="d-flex justify-content-center align-items-center text-left">
                        <div id="ranking_molded_refugee_by_reason"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="card shadow-sm mb-3">
            <div class="card-body text-center">
                <h5 class="font-weight-light">Aproveitamento da Produção dos Moldados</h5>
                <small class="d-block mb-4">Aproveitamento/Perca</small>

                <div class="d-flex justify-content-around align-items-center">
                    <div class="d-flex justify-content-around align-items-center mr-2">
                        <i class="fas fa-check-circle fa-fw fa-2x text-success"></i>
                        <h4 class="mb-0 font-weight-bold" id="exploitation_molded_use"></h4>
                    </div>

                    <div class="d-flex justify-content-around align-items-center">
                        <i class="fas fa-times-circle fa-fw fa-2x text-danger"></i>
                        <h4 class="mb-0 font-weight-bold" id="exploitation_molded_miss"></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mb-3">
            <div class="card-body text-center">
                <h5 class="font-weight-light">Estoque de Matéria-Prima</h5>
                <small class="d-block mb-3">Tipo/Peso</small>

                <div class="table-responsive">
                    <table class="table table-striped text-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Tipo</th>
                                <th>Inicial (kg)</th>
                                <th>Entradas (kg)</th>
                                <th>Requisições (kg)</th>
                                <th>Saldo (kg)</th>
                            </tr>
                        </thead>
                        <tbody id="table_stock_by_raw_material_type"></tbody>
                        <tfoot class="bg-light" id="table_stock_by_raw_material_type_footer"></tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mb-3">
            <div class="card-body text-center">
                <h5 class="font-weight-light">Estoque de Blocos</h5>
                <small class="d-block mb-2">Tipo/Altura</small>

                <div class="table-responsive">
                    <table class="table table-striped text-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Tipo</th>
                                <th>Altura (mm)</th>
                                <th>Inicial (und)</th>
                                <th>Entrada (und)</th>
                                <th>Saída (und)</th>
                                <th>Saldo (und)</th>
                                <th>Metros Cúbicos (m³)</th>
                            </tr>
                        </thead>

                        <tbody id="blocks_balance"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mb-3">
            <div class="card-body text-center">
                <h5 class="font-weight-light">Estoque de Moldados</h5>
                <small class="d-block mb-3">Tipo/Quantidade</small>

                <div class="table-responsive">
                    <table class="table table-striped text-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Descrição</th>
                                <th>Quantidade por pacote</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>

                        <tbody id="table_stock_by_raw_moldeds"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function getDashboardData(filter_date_time_start, filter_date_time_finish) {
        var data = {
            'filter_date_time_start': filter_date_time_start,
            'filter_date_time_finish': filter_date_time_finish
        };
        $.ajax({
            url: "<?= base_url('dashboard/materia_prima') ?>",
            type: "post",
            dataType: "json",
            data: data,
            beforeSend: function() {
                loaderOn();
            },
            success: function(response) {
                if (response.notification) {
                    notificationShow(response.notification.type, response.notification.message);
                    loaderOff();
                }

                // Resumo.
                $('#resume_stop_machine_machine_stop_count').html(response.resume_stop_machine.machine_stop_count);

                if (response.resume_stop_machine.machine_stop_time > 0) {
                    var time = response.resume_stop_machine.machine_stop_time;
                    var hours1 = parseInt(time / 3600);
                    var mins1 = parseInt((parseInt(time % 3600)) / 60);

                    $('#resume_stop_machine_machine_stop_time').html(hours1 + 'h ' + mins1 + 'min');
                } else {
                    $('#resume_stop_machine_machine_stop_time').html('0h 0min');
                }

                $('#resume_requisition_requisition_quantity').html(response.resume_requisition.requisition_quantity);
                $('#resume_block_block_count').html(response.resume_block.block_count);
                $('#resume_block_block_cubic_meters').html(response.resume_block.block_cubic_meters);
                $('#resume_block_block_virgin_weight').html(response.resume_block.block_virgin_weight);
                $('#resume_block_block_recycled_weight').html(response.resume_block.block_recycled_weight);
                $('#resume_molded_molded_quantity').html(response.resume_molded.molded_quantity);
                $('#resume_molded_molded_refugee_quantity').html(response.resume_molded.molded_refugee_quantity);
                $('#resume_molded_molded_total_cubic_meters').html(response.resume_molded.molded_total_cubic_meters);
                $('#resume_molded_molded_total_weight_considered').html(response.resume_molded.molded_total_weight_considered);

                // Produção de Blocos
                $('#table_block_production_by_type').html('');
                if (response.table_block_production_by_type) {
                    $.each(response.table_block_production_by_type, function(index, value) {
                        $('#table_block_production_by_type').append('<tr><td>' + value.block_description + '</td><td>' + value.block_height + '</td><td>' + value.block_quantity + '</td><td>' + value.block_cubic_meters + '</td><td>' + value.block_virgin_weight + '</td><td>' + value.block_recycled_weight + '</td></tr>');
                    });
                }

                // Saída de Blocos
                $('#table_block_output_by_type').html('');
                if (response.table_block_output_by_type) {
                    $.each(response.table_block_output_by_type, function(index, value) {
                        $('#table_block_output_by_type').append('<tr><td>' + value.block_description + '</td><td>' + value.block_height + '</td><td>' + value.block_quantity + '</td><td>' + value.block_cubic_meters + '</td><td>' + value.block_virgin_weight + '</td><td>' + value.block_recycled_weight + '</td></tr>');
                    });
                }

                // Ranking de Refugos dos Moldados
                $('#ranking_molded_refugee_by_reason').html('');
                if (response.ranking_molded_refugee_by_reason) {
                    $.each(response.ranking_molded_refugee_by_reason, function(index, value) {
                        $('#ranking_molded_refugee_by_reason').append('<div class="d-flex align-items-center mb-3"><h2 class="mb-0 mr-2 font-weight-bolder">' + (index + 1) + 'º</h2><div><small>' + value.reason_description + '</small><h5 class="mb-0 font-weight-bolder" id="">' + value.molded_refugee_quantity + '</h5></div>');
                    });
                }

                // Aproveitamento da Produção dos Moldados
                $('#exploitation_molded_use').html(response.exploitation_molded_use);
                $('#exploitation_molded_miss').html(response.exploitation_molded_miss);

                // Estoque da Matéria-Prima
                $('#table_stock_by_raw_material_type').html('');
                $('#table_stock_by_raw_material_type_footer').html('');

                if (response.table_stock_by_raw_material_type) {
                    $.each(response.table_stock_by_raw_material_type.lines, function(index, value) {
                        $('#table_stock_by_raw_material_type').append('<tr><td>' + value.description + '</td><td>' + value.quantity_initial_inventory + '</td><td>' + value.quantity_entrance + '</td><td>' + value.quantity_requisition + '</td><td>' + value.quantity_balance + '</td></tr>');
                    });

                    $('#table_stock_by_raw_material_type_footer').append('<tr><th>Totais</th><th>' + response.table_stock_by_raw_material_type.total_inventory + '</th><th>' + response.table_stock_by_raw_material_type.total_balance + '</th><th>' + response.table_stock_by_raw_material_type.total_requisition + '</th><th>' + response.table_stock_by_raw_material_type.total_entrance + '</th></tr>');
                }

                // Estoque de Blocos
                $('#blocks_balance').html('');
                if (response.blocks_balance) {
                    $.each(response.blocks_balance, function(index, value) {
                        $('#blocks_balance').append('<tr><td>' + value.block_description + '</td><td>' + value.block_height + '</td><td>' + value.block_quantity_initial_inventory + '</td><td>' + value.block_quantity_production + '</td><td>' + value.block_quantity_output + '</td><td>' + value.block_quantity_balance + '</td><td>' + value.block_cubic_meters_balance + '</td></tr>');
                    });
                }

                // Estoque de Moldados
                $('#table_stock_by_raw_moldeds').html('');
                if (response.molded_balance) {
                    $.each(response.molded_balance, function(index, value) {
                        $('#table_stock_by_raw_moldeds').append('<tr><td>' + value.molded_description + '</td><td>' + value.molded_package_quantity + '</td><td>' + value.molded_quantity + '</td></tr>');
                    });
                }

                // Gráficos
                setChartStopMachineCount(response.chart_machine_stops_by_machine_count.data);
                setChartStopMachineTime(response.chart_machine_stops_by_machine_time.data);
                setChartRequisitionRawMaterialCount(response.chart_requisition_by_raw_material_count.data);
                setChartRequisitionRawMaterialDate(response.chart_requisition_by_date_time_start.data);
                setChartBlockDateCount(response.chart_block_by_date_time_start.data);
                setChartMoldedDateCount(response.chart_molded_by_date_time_start.data);
            },
            error: function() {
                loaderOff();
            },
            complete: function() {
                loaderOff();
            }
        });
    }

    function setChartStopMachineCount(data) {
        var chartStopMachineQuantity = Highcharts.chart('machine_stops_count_by_machine', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: false,
            legend: false,
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.y:,.0f}',
                        formatter: function() {
                            return '<b>' + this.point.name + '</b>: ' + Highcharts.numberFormat(this.point.y, 0);
                        },
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    return 'Quantidade (und): <b>' + this.point.y + '</b>';
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: false,
                labels: {
                    format: '{value}'
                }
            },
            series: [{
                name: 'Paradas (und)',
                colorByPoint: true,
                data: data
            }]
        });
    }

    function setChartStopMachineTime(data) {
        var chartStopMachineTime = Highcharts.chart('machine_stops_time_by_machine', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: false,
            legend: false,
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            var time = this.point.y;
                            var hours1 = parseInt(time / 3600);
                            var mins1 = parseInt((parseInt(time % 3600)) / 60);
                            return '<b>' + this.point.name + '</b>: ' + hours1 + ':' + mins1;
                        },
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    var time = this.point.y;
                    var hours1 = parseInt(time / 3600);
                    var mins1 = parseInt((parseInt(time % 3600)) / 60);
                    return 'Tempo (hh:mm): <b>' + hours1 + ':' + mins1 + '</b>';
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: false,
                labels: {
                    format: '{value}'
                }
            },
            series: [{
                name: 'Paradas (hh:mm)',
                colorByPoint: true,
                data: data
            }]
        });
    }

    function setChartRequisitionRawMaterialCount(data) {
        var chartRequisitionRawMaterialCount = Highcharts.chart('requisition_by_raw_material_count', {
            chart: {
                type: 'column'
            },
            title: false,
            legend: false,
            plotOptions: {
                column: {
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            return '<b>' + Highcharts.numberFormat(this.point.y, 2) + '</b>';
                        },
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    return 'Quantidade (kg): <b>' + Highcharts.numberFormat(this.point.y, 2) + '</b>';
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: false,
                labels: {
                    format: '{value}'
                }
            },
            series: [{
                name: 'Quantidade (kg)',
                colorByPoint: true,
                data: data
            }]
        });
    }

    function setChartRequisitionRawMaterialDate(data) {
        var chartRequisitionRawMaterialDate = Highcharts.chart('requisition_by_raw_material_date', {
            chart: {
                type: 'line'
            },
            title: false,
            legend: false,
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            return '<b>' + Highcharts.numberFormat(this.point.y, 2) + '</b>';
                        },
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    return '<b>' + this.key + '</b><br>Quantidade (kg): <b>' + Highcharts.numberFormat(this.point.y, 2) + '</b>';
                }
            },
            xAxis: {
                type: 'category',
                categories: data.categories
            },
            yAxis: {
                title: false,
                labels: {
                    format: '{value}'
                }
            },
            series: [{
                name: 'Quantidade (kg)',
                colorByPoint: false,
                data: data.series
            }]
        });
    }

    function setChartBlockDateCount(data) {
        var chartBlockDateCount = Highcharts.chart('block_by_date_count', {
            chart: {
                type: 'area'
            },
            title: false,
            legend: false,
            plotOptions: {
                area: {
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            return '<b>' + Highcharts.numberFormat(this.point.y, 2) + '</b>';
                        },
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    return '<b>' + this.key + '</b><br>Quantidade (und): <b>' + Highcharts.numberFormat(this.point.y, 2) + '</b>';
                }
            },
            xAxis: {
                type: 'category',
                categories: data.categories
            },
            yAxis: {
                title: false,
                labels: {
                    format: '{value}'
                }
            },
            series: [{
                name: 'Quantidade (und)',
                colorByPoint: false,
                data: data.series
            }]
        });
    }

    function setChartMoldedDateCount(data) {
        var chartMoldedDateCount = Highcharts.chart('molded_by_date_count', {
            chart: {
                type: 'area'
            },
            title: false,
            legend: {
                enabled: true
            },
            plotOptions: {
                area: {
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            return '<b>' + Highcharts.numberFormat(this.point.y, 2) + '</b>';
                        },
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    return '<b>' + this.key + '</b><br>Quantidade (und): <b>' + Highcharts.numberFormat(this.point.y, 2) + '</b>';
                }
            },
            xAxis: {
                type: 'category',
                categories: data.categories
            },
            yAxis: {
                title: false,
                labels: {
                    format: '{value}'
                }
            },
            series: [{
                    name: 'Quantidade Produção (und)',
                    colorByPoint: false,
                    data: data.series.production
                },
                {
                    name: 'Quantidade Refugos (und)',
                    colorByPoint: false,
                    data: data.series.refugee
                }
            ]
        });
    }

    $(document).ready(function() {
        getDashboardData('<?= date('01/m/Y 05:00:00') ?>', '<?= date('d/m/Y H:i:s') ?>');
    });
    $('#j_app_send_filter').on('click', function() {
        getDashboardData($('#filter_date_time_start').val(), $('#filter_date_time_finish').val());
    });
</script>