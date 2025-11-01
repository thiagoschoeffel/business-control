<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="app_wrapper">

    <div class="app_sidebar <?= ($this->session->userdata('menu_status') == 'open') ? 'app_sidebar_open' : '' ?>">
        <div class="app_sidebar_content">
            <div class="d-flex justify-content-between align-items-center p-3">
                <div class="text-center">
                    <i class="fas fa-user-circle fa-3x d-block mb-1"></i>
                    <h6 class="m-0"><?= $this->session->userdata('logged_user')['first_name'] ?></h6>
                    <small class="j_app_clock"><?= date('d/m/Y H:i:s') ?></small>
                </div>

                <div class="text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-cog fa-fw"></i> Opções
                        </button>

                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="<?= base_url('usuario/lst') ?>" class="dropdown-item">
                                <i class="fas fa-user-alt fa-fw"></i> Gestão de Usuários
                            </a>

                            <div class="dropdown-divider"></div>

                            <a href="#" class="dropdown-item j_app_logout" data-url="<?= base_url('logout') ?>">
                                <i class="fas fa-sign-out-alt fa-fw"></i> Sair
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="list-unstyled mb-0" id="metismenu">
                <li>
                    <a href="<?= base_url('inicio') ?>" <?= ($this->uri->segment(1) == 'inicio') ? 'class="active"' : '' ?>>
                        <i class="fas fa-home fa-fw"></i> Início
                    </a>
                </li>

                <li <?= ($this->uri->segment(1) == 'dashboard') ? 'class="mm-active"' : '' ?>>
                    <a href="#" class="has-arrow <?= ($this->uri->segment(1) == 'dashboard') ? 'active' : '' ?>">
                        <i class="fas fa-folder fa-fw"></i> Dashboards
                    </a>

                    <ul class="list-unstyled">
                        <li>
                            <a href="<?= base_url('dashboard/materia_prima') ?>" <?= ($this->uri->segment(2) == 'materia_prima') ? 'class="active"' : '' ?>>
                                <i class="fas fa-chart-bar fa-fw"></i> Matéria-Prima
                            </a>
                        </li>
                    </ul>
                </li>

                <li <?= ($this->uri->segment(1) == 'materia_prima') ? 'class="mm-active"' : '' ?>>
                    <a href="#" class="has-arrow <?= ($this->uri->segment(1) == 'materia_prima') ? 'active' : '' ?>">
                        <i class="fas fa-folder fa-fw"></i> Gestão Matéria-Prima
                    </a>

                    <ul class="list-unstyled">
                        <li <?= ($this->uri->segment(1) == 'materia_prima' && $this->uri->segment(2) == 'cadastro') ? 'class="mm-active"' : '' ?>>
                            <a href="#" class="has-arrow <?= ($this->uri->segment(1) == 'materia_prima' && $this->uri->segment(2) == 'cadastro') ? 'active' : '' ?>">
                                <i class="fas fa-folder fa-fw"></i> Cadastros
                            </a>

                            <ul class="list-unstyled">
                                <li>
                                    <a href="<?= base_url('materia_prima/cadastro/materia_prima/lst') ?>" <?= ($this->uri->segment(1) == 'materia_prima' && $this->uri->segment(2) == 'cadastro' && $this->uri->segment(3) == 'materia_prima') ? 'class="active"' : '' ?>>
                                        <i class="far fa-window-maximize fa-fw"></i> Matéria-Prima
                                    </a>
                                </li>

                                <li>
                                    <a href="<?= base_url('materia_prima/cadastro/tipo_bloco/lst') ?>" <?= ($this->uri->segment(1) == 'materia_prima' && $this->uri->segment(2) == 'cadastro' && $this->uri->segment(3) == 'tipo_bloco') ? 'class="active"' : '' ?>>
                                        <i class="far fa-window-maximize fa-fw"></i> Tipo de Blocos
                                    </a>
                                </li>

                                <li>
                                    <a href="<?= base_url('materia_prima/cadastro/tipo_moldado/lst') ?>" <?= ($this->uri->segment(1) == 'materia_prima' && $this->uri->segment(2) == 'cadastro' && $this->uri->segment(3) == 'tipo_moldado') ? 'class="active"' : '' ?>>
                                        <i class="far fa-window-maximize fa-fw"></i> Tipo de Moldados
                                    </a>
                                </li>

                                <li>
                                    <a href="<?= base_url('materia_prima/cadastro/motivo/lst') ?>" <?= ($this->uri->segment(1) == 'materia_prima' && $this->uri->segment(2) == 'cadastro' && $this->uri->segment(3) == 'motivo') ? 'class="active"' : '' ?>>
                                        <i class="far fa-window-maximize fa-fw"></i> Motivos
                                    </a>
                                </li>

                                <li>
                                    <a href="<?= base_url('materia_prima/cadastro/silo/lst') ?>" <?= ($this->uri->segment(1) == 'materia_prima' && $this->uri->segment(2) == 'cadastro' && $this->uri->segment(3) == 'silo') ? 'class="active"' : '' ?>>
                                        <i class="far fa-window-maximize fa-fw"></i> Silos
                                    </a>
                                </li>

                                <li>
                                    <a href="<?= base_url('materia_prima/cadastro/operador/lst') ?>" <?= ($this->uri->segment(1) == 'materia_prima' && $this->uri->segment(2) == 'cadastro' && $this->uri->segment(3) == 'operador') ? 'class="active"' : '' ?>>
                                        <i class="far fa-window-maximize fa-fw"></i> Operadores
                                    </a>
                                </li>

                                <li>
                                    <a href="<?= base_url('materia_prima/cadastro/maquina/lst') ?>" <?= ($this->uri->segment(1) == 'materia_prima' && $this->uri->segment(2) == 'cadastro' && $this->uri->segment(3) == 'maquina') ? 'class="active"' : '' ?>>
                                        <i class="far fa-window-maximize fa-fw"></i> Máquinas
                                    </a>
                                </li>

                                <li>
                                    <a href="<?= base_url('materia_prima/cadastro/setor/lst') ?>" <?= ($this->uri->segment(1) == 'materia_prima' && $this->uri->segment(2) == 'cadastro' && $this->uri->segment(3) == 'setor') ? 'class="active"' : '' ?>>
                                        <i class="far fa-window-maximize fa-fw"></i> Setores
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <ul class="list-unstyled">
                        <li <?= ($this->uri->segment(1) == 'materia_prima' && $this->uri->segment(2) == 'movimento') ? 'class="mm-active"' : '' ?>>
                            <a href="#" class="has-arrow <?= ($this->uri->segment(1) == 'materia_prima' && $this->uri->segment(2) == 'movimento') ? 'active' : '' ?>">
                                <i class="fas fa-folder fa-fw"></i> Movimentos
                            </a>

                            <ul class="list-unstyled">
                                <li>
                                    <a href="<?= base_url('materia_prima/movimento/entrada/lst') ?>" <?= ($this->uri->segment(1) == 'materia_prima' && $this->uri->segment(2) == 'movimento' && $this->uri->segment(3) == 'entrada') ? 'class="active"' : '' ?>>
                                        <i class="far fa-window-maximize fa-fw"></i> Entrada de Matéria-Prima
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= base_url('materia_prima/movimento/apontamento/lst') ?>" <?= ($this->uri->segment(1) == 'materia_prima' && $this->uri->segment(2) == 'movimento' && $this->uri->segment(3) == 'apontamento') ? 'class="active"' : '' ?>>
                                        <i class="far fa-window-maximize fa-fw"></i> Apontamento de Produção
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= base_url('materia_prima/movimento/parada/lst') ?>" <?= ($this->uri->segment(1) == 'materia_prima' && $this->uri->segment(2) == 'movimento' && $this->uri->segment(3) == 'parada') ? 'class="active"' : '' ?>>
                                        <i class="far fa-window-maximize fa-fw"></i> Parada de Máquina
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= base_url('materia_prima/movimento/saida_bloco/lst') ?>" <?= ($this->uri->segment(1) == 'materia_prima' && $this->uri->segment(2) == 'movimento' && $this->uri->segment(3) == 'saida_bloco') ? 'class="active"' : '' ?>>
                                        <i class="far fa-window-maximize fa-fw"></i> Saída de Bloco
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= base_url('materia_prima/movimento/saida_moldado/lst') ?>" <?= ($this->uri->segment(1) == 'materia_prima' && $this->uri->segment(2) == 'movimento' && $this->uri->segment(3) == 'saida_moldado') ? 'class="active"' : '' ?>>
                                        <i class="far fa-window-maximize fa-fw"></i> Saída de Moldado
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= base_url('materia_prima/movimento/inventario_bloco/lst') ?>" <?= ($this->uri->segment(1) == 'materia_prima' && $this->uri->segment(2) == 'movimento' && $this->uri->segment(3) == 'inventario_bloco') ? 'class="active"' : '' ?>>
                                        <i class="far fa-window-maximize fa-fw"></i> Inventário de Bloco
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>

            <div class="app_sidebar_content_logo">
                <img alt="Business Control" title="Business Control" src="<?= base_url('assets/images/logo.png') ?>" width="160">
            </div>
        </div>
    </div>

    <div class="app_content_nav d-flex justify-content-between align-items-center flex-wrap px-2">
        <button type="button" class="btn btn-sm btn-dark j_app_sidebar_toggle" data-url="<?= base_url('menu') ?>">
            <i class="fas fa-bars fa-fw"></i>
        </button>

        <img alt="Nome da Empresa Contratante" title="Nome da Empresa Contratante" src="<?= base_url('assets/images/logo.png') ?>" class="app_content_nav_logo">

        <div class="btn-group btn-group-sm">
            <?php
            if (isset($countdown) && $countdown == 'active') :
                ?>
                <button type="button" class="btn btn-sm btn-dark" id="j_app_countdown_pause">
                    <i class="fas fa-pause-circle fa-fw"></i>
                </button>

                <button type="button" class="btn btn-sm btn-dark" id="j_app_countdown_play">
                    <i class="fas fa-play-circle fa-fw"></i>
                </button>

                <div class="btn btn-sm btn-dark" id="j_app_countdown_next"></div>
                <?php
            endif;
            ?>
        </div>
    </div>

    <div class="app_content <?= ($this->session->userdata('menu_status') == 'close') ? 'app_content_full' : '' ?>">
        <div class="container-fluid">