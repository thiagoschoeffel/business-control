<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
</div><!-- container-fluid -->
</div><!-- app_content -->
</div><!-- app_wrapper -->

<div id="j_app_modal_delete" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confiramção Exclusão Registro</h5>

                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="requisition" id="requisition" value="">
                <input type="hidden" name="molded" id="molded" value="">
                <input type="hidden" name="id" id="id" value="">

                <p class="mb-0">Você realmente deseja excluir este registro?</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">
                    <i class="fas fa-times-circle fa-fw"></i> Não
                </button>

                <button type="button" id="j_app_send_delete" class="btn btn-sm btn-danger">
                    <i class="fas fa-check-circle fa-fw"></i> Sim
                </button>
            </div>
        </div>
    </div>
</div>