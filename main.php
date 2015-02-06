<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/**
 * Plugin Name: Quijaua - Eventos
 * Description: Gerenciamento de eventos
 * Version: 0.0.1
 * Author: Eduardo Alencar de Oliveira
 * License: GPL3
 * Depends: Meta Box
 */
if ( ! defined( 'QUIJAUAAGENDA_URL' ) ) {
    define( 'QUIJAUAAGENDA_URL', plugin_dir_url( __FILE__ ) );
}

define( 'QUIJAUAAGENDA_JS_URL', trailingslashit( QUIJAUAAGENDA_URL . 'assets/scripts' ) );
define( 'QUIJAUAAGENDA_CSS_URL', trailingslashit( QUIJAUAAGENDA_URL . 'assets/styles' ) );


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
                'name'  => 'Horário',
                'desc'  => 'Formato: HH:MM',
                'id'    => $prefix . 'time',
                'type'  => 'time',
                'std'   => '',
                'class' => 'custom-class',
                'clone' => false,
            ),

            array(
                'name'  => 'Local',
                'desc'  => '',
                'id'    => $prefix . 'place',
                'type'  => 'text',
                'std'   => '',
                'class' => 'custom-class',
                'clone' => false,
            ),
        )
    );
    return $meta_boxes;
}

function quijauaagenda_shortcode() {
    ob_start();
?>
    <div id="pass-in-a-template" class="cal2"></div>
    <h1>Agenda</h1>
    <form method="post" id="frm-agenda">
        <input type="text" name="title" id="title" data-rule-required="true" data-msg-required="Campo NOME DO EVENTO/SEMINÁRIO/CURSO é obrigatório" placeholder="NOME DO EVENTO/SEMINÁRIO/CURSO" />
        <br />
        <input type="text" name="evt_date" id="evt_date" data-rule-required="true" data-msg-required="Campo DATA é obrigatório" placeholder="DATA" />
        <input type="text" name="evt_time" id="evt_time" data-rule-required="true" data-msg-required="Campo HORÁRIO é obrigatório" placeholder="HORÁRIO" />
        <input type="text" name="evt_place" id="evt_place" data-rule-required="true" data-msg-required="Campo LOCAL é obrigatório" placeholder="LOCAL" />
        <input type="text" name="description" id="description" data-rule-required="true" data-msg-required="Campo DESCRIÇÃO é obrigatório" placeholder="DESCRIÇÃO" />
        <br />
        <input type="submit" value="ENVIAR" id="btn-send-frm-agenda" />
    </form>
    <script id="mini-clndr-template" type="text/template">

        <div class="controls">
            <div class="clndr-previous-button">&lsaquo;</div><div class="month"><%= month %></div><div class="clndr-next-button">&rsaquo;</div>
        </div>

        <div class="days-container">
            <div class="days">
                <div class="headers">
                    <% _.each(daysOfTheWeek, function(day) { %><div class="day-header"><%= day %></div><% }); %>
                </div>
                <% _.each(days, function(day) { %><div class="<%= day.classes %>" id="<%= day.id %>"><%= day.day %></div><% }); %>
            </div>
            <div class="events">
                <div class="headers">
                    <div class="x-button">x</div>
                    <div class="event-header">EVENTS</div>
                </div>
                <div class="events-list">
                    <% _.each(eventsThisMonth, function(event) { %>
                    <div class="event">
                        <a href="<%= event.url %>"><%= moment(event.date).format('MMMM Do') %>: <%= event.title %></a>
                    </div>
                    <% }); %>
                </div>
            </div>
        </div>

    </script>
    <script type="text/template" id="clndr-template">
        <div class="clndr-controls">
            <div class="clndr-previous-button">&lsaquo;</div>
            <div class="month"><%= month %></div>
            <div class="clndr-next-button">&rsaquo;</div>
        </div>
        <div class="clndr-grid">
            <div class="days-of-the-week">
                <% _.each(daysOfTheWeek, function(day) { %>
                <div class="header-day"><%= day %></div>
                <% }); %>
                <div class="days">
                    <% _.each(days, function(day) { %>
                    <div class="<%= day.classes %>"><%= day.day %></div>
                    <% }); %>
                </div>
            </div>
        </div>
        <div class="clndr-today-button">Today</div>
    </script>
<?php
    return ob_get_clean();
}

function quijauaagenda_change_default_title() {
    $screen = get_current_screen();

    if  ( 'quijauaagenda_events' === $screen->post_type ) {
        $title = 'Nome do Evento/Seminário/Curso';
    }
    return $title;
}

function quijauaagenda_scripts() {
     global $post;
    wp_enqueue_style( 'quijauaagenda-main', QUIJAUAAGENDA_CSS_URL . 'main.css' );
    wp_enqueue_style( 'quijauaagenda-sweetalert-css', QUIJAUAAGENDA_CSS_URL . 'sweet-alert.css' );
    wp_enqueue_style( 'quijauaagenda-clndr-css', QUIJAUAAGENDA_CSS_URL . 'clndr.css' );
    wp_enqueue_script( 'quijauaagenda-plugins', QUIJAUAAGENDA_JS_URL . 'plugins.js', array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'quijauaagenda-sweetalert', QUIJAUAAGENDA_JS_URL . 'sweetalert/lib/sweet-alert.min.js', array(), '1.0.0', true );
    wp_enqueue_script( 'quijauaagenda-json2', QUIJAUAAGENDA_JS_URL . 'CLNDR/example/json2.js', array(), '1.0.0', true );
    wp_enqueue_script( 'quijauaagenda-underscore', 'http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js', array(), '1.0.0', true );
    wp_enqueue_script( 'quijauaagenda-moment2', QUIJAUAAGENDA_JS_URL . 'CLNDR/example/moment.js', array(), '1.0.0', true );
    wp_enqueue_script( 'quijauaagenda-clndr', QUIJAUAAGENDA_JS_URL . 'CLNDR/src/clndr.js', array(), '1.0.0', true );

    wp_enqueue_script( 'quijauaagenda-main', QUIJAUAAGENDA_JS_URL . 'main.js', array('jquery'), '1.0.0', true );

    $events = array();
    $args = array( 'posts_per_page' => -1, 'post_type'=> 'quijauaagenda_events', 'post_status' => 'publish');

    $events_posts = get_posts($args);

    foreach($events_posts as $event_post)
    {

        setup_postdata($event_post);
        $event = new stdClass;
        $event->id = $event_post->ID;
        $event->date = get_post_meta( $event_post->ID, 'evt_date', true);
        $event->time = get_post_meta( $event_post->ID, 'evt_time', true);
        $event->title = get_the_title();
        $event->description = get_the_content();
        $event->place = get_post_meta( $event_post->ID, 'evt_place', true);

        $events[] = $event;
    }
    wp_reset_postdata();

    wp_localize_script( 'quijauaagenda-main', 'quijauaagenda_ajax',
        array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'events'   => $events
        )
    );
}

function quijauaagenda_save_event_callback() {
    // Create post object
    $event_post = array(
        'post_title'    => sanitize_text_field($_POST['title']),
        'post_content'  => sanitize_text_field($_POST['description']),
        'post_status'   => 'draft',
        'post_type'     => 'quijauaagenda_events',
    );

    $event_post_id = wp_insert_post( $event_post );

    if( $event_post_id ) {

        add_post_meta( $event_post_id, 'evt_date', implode("-",array_reverse(explode("/",$_POST['evt_date']))) );
        add_post_meta( $event_post_id, 'evt_time', $_POST['evt_time'] );
        add_post_meta( $event_post_id, 'evt_place', sanitize_text_field($_POST['evt_place']) );
        $result = array(
            'status' => 1
        );
        echo json_encode($result);
        wp_die();

    }

    $result = array(
        'status' => 0
    );
    echo json_encode($result);
    wp_die();

}

function quijauaagenda_init() {
    quijauaagenda_cpts();
    quijauaagenda_taxonomies();
}

// Actions
add_action( 'init', 'quijauaagenda_init' );
add_shortcode( 'agenda', 'quijauaagenda_shortcode' );
add_action( 'wp_enqueue_scripts', 'quijauaagenda_scripts' );
add_action( 'wp_ajax_quijauaagenda_save_event', 'quijauaagenda_save_event_callback' );

// Filters
add_filter( 'rwmb_meta_boxes', 'quijauaagenda_metaboxes' );
add_filter( 'enter_title_here', 'quijauaagenda_change_default_title' );
