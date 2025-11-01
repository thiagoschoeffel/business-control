<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Business Control</title>

        <!--Node CSS-->
        <link rel="stylesheet" href="<?= base_url('node_modules/bootstrap/dist/css/bootstrap.min.css') ?>">
        <link rel="stylesheet" href="<?= base_url('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') ?>">
        <link rel="stylesheet" href="<?= base_url('node_modules/@fortawesome/fontawesome-free/css/all.min.css') ?>">        
        <link rel="stylesheet" href="<?= base_url('node_modules/air-datepicker/dist/css/datepicker.min.css') ?>">
        <link rel="stylesheet" href="<?= base_url('node_modules/metismenu/dist/metisMenu.min.css') ?>">

        <!--Node JS-->
        <script src="<?= base_url('node_modules/jquery/dist/jquery.min.js') ?>"></script>
        <script src="<?= base_url('node_modules/popper.js/dist/umd/popper.min.js') ?>"></script>
        <script src="<?= base_url('node_modules/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
        <script src="<?= base_url('node_modules/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
        <script src="<?= base_url('node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
        <script src="<?= base_url('node_modules/jquery-mask-plugin/dist/jquery.mask.min.js') ?>"></script>
        <script src="<?= base_url('node_modules/air-datepicker/dist/js/datepicker.min.js') ?>"></script>
        <script src="<?= base_url('node_modules/air-datepicker/dist/js/i18n/datepicker.pt-BR.js') ?>"></script>
        <script src="<?= base_url('node_modules/moment/min/moment.min.js') ?>"></script>
        <script src="<?= base_url('node_modules/highcharts/highcharts.js') ?>"></script>
        <script src="<?= base_url('node_modules/metismenu/dist/metisMenu.min.js') ?>"></script>

        <!--App CSS-->
        <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

        <!--App JS-->
        <script src="<?= base_url('assets/js/momentdatetime.js') ?>"></script>
        <script src="<?= base_url('assets/js/script.js') ?>"></script>

        <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.png') ?>">
    </head>
    <body>

        <div class="app_loader">
            <div class="app_loader_content rounded-sm shadow-sm d-flex justify-content-center align-items-center flex-column">
                <i class="fas fa-circle-notch fa-spin fa-3x mb-1"></i>
                <h5 class="mb-0">Processando</h5>
            </div>
        </div>

        <div class="app_notifications p-3" style="<?= ($this->session->flashdata('notification')) ? 'display: block;' : '' ?>">
            <?php
            if ($this->session->flashdata('notification')) :
                $notification = $this->session->flashdata('notification');

                echo "<div class=\"alert alert-{$notification['type']} alert-dismissible fade show m-0 mb-2\">";
                echo "{$notification['message']}";
                echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>";
                echo "</div>";
            endif;
            ?>
        </div>