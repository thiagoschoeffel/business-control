<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*
 * Rotas padrões do app.
 */
$route['login'] = 'login/index';
$route['logout'] = 'login/logout';
$route['alterar_senha'] = 'login/modify_password';
$route['dashboard'] = 'web/index';
$route['menu'] = 'web/menu_status';

/*
 * Rotas personalizadas do cliente.
 */
$route['inicio'] = 'web/index';

/*
 * Rotas da gestão de usuários
 */
$route['usuario/lst'] = 'user';
$route['usuario/frm'] = 'user/form';
$route['usuario/frm/(:num)'] = 'user/form/$1';
$route['usuario/dlt'] = 'user/delete';

/*
 * Rotas das dashboards do cliente.
 */
$route['dashboard/materia_prima'] = 'raw_material/dashboard/index';
$route['dashboard/processamento'] = 'processing/dashboard/index';

/*
 * Rotas da gestão de matéria-prima
 */

//  Cadastro de Matéria-Prima
$route['materia_prima/cadastro/materia_prima/lst'] = 'raw_material/raw_material';
$route['materia_prima/cadastro/materia_prima/frm'] = 'raw_material/raw_material/form';
$route['materia_prima/cadastro/materia_prima/frm/(:num)'] = 'raw_material/raw_material/form/$1';
$route['materia_prima/cadastro/materia_prima/dlt'] = 'raw_material/raw_material/delete';

// Cadastro de Tipos de Bloco
$route['materia_prima/cadastro/tipo_bloco/lst'] = 'raw_material/block_type';
$route['materia_prima/cadastro/tipo_bloco/frm'] = 'raw_material/block_type/form';
$route['materia_prima/cadastro/tipo_bloco/frm/(:num)'] = 'raw_material/block_type/form/$1';
$route['materia_prima/cadastro/tipo_bloco/dlt'] = 'raw_material/block_type/delete';

// Cadastro de Tipos de Moldados
$route['materia_prima/cadastro/tipo_moldado/lst'] = 'raw_material/molded_type';
$route['materia_prima/cadastro/tipo_moldado/frm'] = 'raw_material/molded_type/form';
$route['materia_prima/cadastro/tipo_moldado/frm/(:num)'] = 'raw_material/molded_type/form/$1';
$route['materia_prima/cadastro/tipo_moldado/dlt'] = 'raw_material/molded_type/delete';

// Cadastro de Silos
$route['materia_prima/cadastro/silo/lst'] = 'raw_material/silo';
$route['materia_prima/cadastro/silo/frm'] = 'raw_material/silo/form';
$route['materia_prima/cadastro/silo/frm/(:num)'] = 'raw_material/silo/form/$1';
$route['materia_prima/cadastro/silo/dlt'] = 'raw_material/silo/delete';

// Cadastro de Operadores
$route['materia_prima/cadastro/operador/lst'] = 'raw_material/operator';
$route['materia_prima/cadastro/operador/frm'] = 'raw_material/operator/form';
$route['materia_prima/cadastro/operador/frm/(:num)'] = 'raw_material/operator/form/$1';
$route['materia_prima/cadastro/operador/dlt'] = 'raw_material/operator/delete';

// Cadastro de Motivos
$route['materia_prima/cadastro/motivo/lst'] = 'raw_material/reason';
$route['materia_prima/cadastro/motivo/frm'] = 'raw_material/reason/form';
$route['materia_prima/cadastro/motivo/frm/(:num)'] = 'raw_material/reason/form/$1';
$route['materia_prima/cadastro/motivo/dlt'] = 'raw_material/reason/delete';

// Cadastro de Máquinas
$route['materia_prima/cadastro/maquina/lst'] = 'raw_material/machine';
$route['materia_prima/cadastro/maquina/frm'] = 'raw_material/machine/form';
$route['materia_prima/cadastro/maquina/frm/(:num)'] = 'raw_material/machine/form/$1';
$route['materia_prima/cadastro/maquina/dlt'] = 'raw_material/machine/delete';

// Cadastro de Setor
$route['materia_prima/cadastro/setor/lst'] = 'raw_material/sector';
$route['materia_prima/cadastro/setor/frm'] = 'raw_material/sector/form';
$route['materia_prima/cadastro/setor/frm/(:num)'] = 'raw_material/sector/form/$1';
$route['materia_prima/cadastro/setor/dlt'] = 'raw_material/sector/delete';

// Entradas de Matéria Prima
$route['materia_prima/movimento/entrada/lst'] = 'raw_material/raw_material_entrance';
$route['materia_prima/movimento/entrada/frm'] = 'raw_material/raw_material_entrance/form';
$route['materia_prima/movimento/entrada/frm/(:num)'] = 'raw_material/raw_material_entrance/form/$1';
$route['materia_prima/movimento/entrada/dlt'] = 'raw_material/raw_material_entrance/delete';

// Apontamento de Requisições
$route['materia_prima/movimento/apontamento/lst'] = 'raw_material/requisition';
$route['materia_prima/movimento/apontamento/frm'] = 'raw_material/requisition/form';
$route['materia_prima/movimento/apontamento/frm/(:num)'] = 'raw_material/requisition/form/$1';
$route['materia_prima/movimento/apontamento/dlt'] = 'raw_material/requisition/delete';

// Apontamento de Blocos
$route['materia_prima/movimento/apontamento/bloco/lst/(:num)'] = 'raw_material/block/index/$1';
$route['materia_prima/movimento/apontamento/bloco/frm/(:num)'] = 'raw_material/block/form/$1';
$route['materia_prima/movimento/apontamento/bloco/frm/(:num)/(:num)'] = 'raw_material/block/form/$1/$2';
$route['materia_prima/movimento/apontamento/bloco/edt'] = 'raw_material/block/edit';
$route['materia_prima/movimento/apontamento/bloco/dlt'] = 'raw_material/block/delete';

// Apontamento de Moldados
$route['materia_prima/movimento/apontamento/moldado/lst/(:num)'] = 'raw_material/molded/index/$1';
$route['materia_prima/movimento/apontamento/moldado/frm/(:num)'] = 'raw_material/molded/form/$1';
$route['materia_prima/movimento/apontamento/moldado/frm/(:num)/(:num)'] = 'raw_material/molded/form/$1/$2';
$route['materia_prima/movimento/apontamento/moldado/dlt'] = 'raw_material/molded/delete';

// Apontamento de Refugo de Moldados
$route['materia_prima/movimento/apontamento/moldado/refugo/lst/(:num)/(:num)'] = 'raw_material/molded_refugee/index/$1/$2';
$route['materia_prima/movimento/apontamento/moldado/refugo/frm/(:num)/(:num)'] = 'raw_material/molded_refugee/form/$1/$2';
$route['materia_prima/movimento/apontamento/moldado/refugo/frm/(:num)/(:num)/(:num)'] = 'raw_material/molded_refugee/form/$1/$2/$3';
$route['materia_prima/movimento/apontamento/moldado/refugo/dlt'] = 'raw_material/molded_refugee/delete';

// Parada de Máquinas
$route['materia_prima/movimento/parada/lst'] = 'raw_material/machine_stop';
$route['materia_prima/movimento/parada/frm'] = 'raw_material/machine_stop/form';
$route['materia_prima/movimento/parada/frm/(:num)'] = 'raw_material/machine_stop/form/$1';
$route['materia_prima/movimento/parada/dlt'] = 'raw_material/machine_stop/delete';

// Saída de Blocos
$route['materia_prima/movimento/saida_bloco/lst'] = 'raw_material/block_output/index';
$route['materia_prima/movimento/saida_bloco/lst/(:num)'] = 'raw_material/block_output/index';
$route['materia_prima/movimento/saida_bloco/lst/filtrar']['post'] = 'raw_material/block_output/filter';
$route['materia_prima/movimento/saida_bloco/frm'] = 'raw_material/block_output/form';
$route['materia_prima/movimento/saida_bloco/frm/(:num)'] = 'raw_material/block_output/form/$1';
$route['materia_prima/movimento/saida_bloco/dlt'] = 'raw_material/block_output/delete';
$route['materia_prima/movimento/saida_bloco/frm/pegar_blocos_disponiveis'] = 'raw_material/block_output/get_available_blocks';

// Saída de Moldados
$route['materia_prima/movimento/saida_moldado/lst'] = 'raw_material/molded_output';
$route['materia_prima/movimento/saida_moldado/frm'] = 'raw_material/molded_output/form';
$route['materia_prima/movimento/saida_moldado/frm/(:num)'] = 'raw_material/molded_output/form/$1';
$route['materia_prima/movimento/saida_moldado/dlt'] = 'raw_material/molded_output/delete';

// Invetário de Blocos
$route['materia_prima/movimento/inventario_bloco/lst'] = 'raw_material/block_inventory';
$route['materia_prima/movimento/inventario_bloco/frm'] = 'raw_material/block_inventory/form';
$route['materia_prima/movimento/inventario_bloco/frm/(:num)'] = 'raw_material/block_inventory/form/$1';
$route['materia_prima/movimento/inventario_bloco/dlt'] = 'raw_material/block_inventory/delete';