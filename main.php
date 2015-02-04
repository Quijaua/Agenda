<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/**
 * Plugin Name: Quijaua - Eventos
 * Description: Gerenciamento de eventos
 * Version: 0.0.1
 * Author: Eduardo Alencar de Oliveira
 * License: GPL3
 * Depends: Meta Box
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

    register_taxonomy(
        'quijauaagenda_event_type',
        'quijauaagenda_events',
        array(
            'label' => __( 'Tipo de Evento' ),
            'rewrite' => array( 'slug' => 'tipo-evento' ),
            'hierarchical' => true,
        )
    );

}

function quijauaagenda_metaboxes() {

    $prefix = 'evt_';

    $meta_boxes[] = array(
        'id'       => 'event-details',
        'title'    => 'Detalhes do evento',
        'pages'    => array( 'quijauaagenda_events'),
        'context'  => 'normal',
        'priority' => 'high',

        'fields' => array(
            array(
                'name'  => 'Data',
                'desc'  => 'Formato: dd/mm/yy',
                'id'    => $prefix . 'date',
                'type'  => 'date',
                'std'   => '',
                'class' => 'custom-class',
                'clone' => false,
                'js_options' => array(
                    'autoSize'        => true,
                    'buttonText'      => __( 'Select Date', 'meta-box' ),
                    'dateFormat'      => __( 'dd/mm/yy', 'meta-box' ),
                    'showButtonPanel' => true,
                ),
            ),

            array(
                'name'  => 'Hora',
                'desc'  => 'Formato: HH:MM',
                'id'    => $prefix . 'time',
                'type'  => 'time',
                'std'   => '',
                'class' => 'custom-class',
                'clone' => false,
            ),

            array(
                'name'  => 'Link para informações',
                'desc'  => 'Formato: http://www.examplo.com.br',
                'id'    => $prefix . 'details_link',
                'type'  => 'url',
                'std'   => '',
                'class' => 'custom-class',
                'clone' => false,
            ),
        )
    );
    return $meta_boxes;
}

function quijauaagenda_shortcodes() {

}

function quijauaagenda_change_default_title() {
    $screen = get_current_screen();

    // For CPT 1
    if  ( 'quijauaagenda_events' === $screen->post_type ) {
        $title = 'Nome do Evento/Seminário/Curso';
    }
    return $title;
}

function quijauaagenda_init() {
    quijauaagenda_cpts();
    quijauaagenda_taxonomies();
    //quijauaagenda_metaboxes();
    quijauaagenda_shortcodes();
}

// Actions
add_action('init', 'quijauaagenda_init');

// Filters
add_filter( 'rwmb_meta_boxes', 'quijauaagenda_metaboxes' );
add_filter( 'enter_title_here', 'quijauaagenda_change_default_title' );


//

// categoria tipo: eventos internos, atividades especias, eventos externos e diferenciar cor no front

// shortocode para exibição do calendario e form no front

// Exibição das informações no front http://fullcalendar.io/


