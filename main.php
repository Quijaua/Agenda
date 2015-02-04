<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/**
 * Plugin Name: Quijaua - Eventos
 * Description: Gerenciamento de eventos
 * Version: 0.0.1
 * Author: Eduardo Alencar de Oliveira
 * License: GPL3
 */
//Metabox custom fields http://metabox.io/docs/getting-started/
// Plugin constants

//

function quijauaagenda_cpts() {

    $labels = array(
        'name'                  =>   __( 'Eventos', '' ),
        'singular_name'         =>   __( 'Evento', '' ),
        'add_new_item'          =>   __( 'Adicionar evento', '' ),
        'all_items'             =>   __( 'Todos evento', '' ),
        'edit_item'             =>   __( 'Editar evento', '' ),
        'new_item'              =>   __( 'Novo evento', '' ),
        'view_item'             =>   __( 'Ver evento', '' ),
        'not_found'             =>   __( 'Nenhum evento cadastrada', '' ),
        'not_found_in_trash'    =>   __( 'Nenhum evento na lixeira', '' )
    );

    $supports = array('title', 'editor', 'thumbnail');

    $args = array(
        'label'         =>   __( 'Eventos', '' ),
        'labels'        =>   $labels,
        'description'   =>   __( 'Eventos', '' ),
        'public'        =>   true,
        'show_in_menu'  =>   true,
        //'menu_icon'     =>   IMAGES . 'event.svg',
        'has_archive'   =>   true,
        'rewrite'       =>   'eventos',
        'supports'      =>   $supports
    );

    register_post_type( 'quijauaagenda_events', $args );

}

function quijauaagenda_taxonomies() {

}

function quijauaagenda_shortcodes() {

}

function quijauaagenda_init() {
    quijauaagenda_cpts();
    quijauaagenda_taxonomies();
    quijauaagenda_shortcodes();
}

add_action('init', 'quijauaagenda_init');

// Cpt: Eventos Nome do Evento
/**
 * - Nome do Evento/Seminário/Curso
- Data
- Horário
- Local
- Descrição
- Link para informações
 */


//

// categoria tipo: eventos internos, atividades especias, eventos externos e diferenciar cor no front

// shortocode para exibição do calendario e form no front

// Exibição das informações no front http://fullcalendar.io/


