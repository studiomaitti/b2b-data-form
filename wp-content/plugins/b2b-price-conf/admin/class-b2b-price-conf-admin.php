<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    B2b_price_conf
 * @subpackage B2b_price_conf/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    B2b_price_conf
 * @subpackage B2b_price_conf/admin
 * @author     Giorgio Maitti <gmaitti@iltrovatore>
 */
class B2b_price_conf_Admin
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * List of post_type to activate
     *
     * @since    1.0.0
     * @access   private
     * @var      array $post_types The list o post-type to create.
     */
    private $post_types;

    /**
     * List of taxonomies to activate
     *
     * @since    1.0.0
     * @access   private
     * @var      array $taxonomies The list o post-type to create.
     */
    private $taxonomies;

    private $is_staging;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->post_types = array(
            array(
                'slug' => 'b2b-contact',
                'args' => array(
                    'labels' => array(
                        'name' => _x('Contacts', 'post type general name', 'b2b-price-conf'),
                        'singular_name' => _x('Contact', 'post type singular name', 'b2b-price-conf'),
                        'menu_name' => _x('Contact', 'admin menu', 'b2b-price-conf'),
                        'name_admin_bar' => _x('Contact', 'add new on admin bar', 'b2b-price-conf'),
                        'add_new' => _x('Add new', 'evento', 'b2b-price-conf'),
                        'add_new_item' => __('Add New Event', 'b2b-price-conf'),
                        'new_item' => __('New Event', 'b2b-price-conf'),
                        'edit_item' => __('Edit Contact', 'b2b-price-conf'),
                        'view_item' => __('View Contact', 'b2b-price-conf'),
                        'all_items' => __('All Contacts', 'b2b-price-conf'),
                        'search_items' => __('Search Contacts', 'b2b-price-conf'),
                        'parent_item_colon' => __('Parent Contacts:', 'b2b-price-conf'),
                        'not_found' => __('No events found.', 'b2b-price-conf'),
                        'not_found_in_trash' => __('No events found in Trash.', 'b2b-price-conf')
                    ),
                    'description' => __('Description.', 'b2b-price-conf'),
                    'public' => false,
                    'publicly_queryable' => true,
                    'show_ui' => true,
                    'show_in_menu' => true,
                    'query_var' => true,
                    'rewrite' => array('slug' => 'b2b-contact'),
                    'capability_type' => 'post',
                    'has_archive' => true,
                    'hierarchical' => false,
                    'menu_position' => 2,
                    'menu_icon' => 'dashicons-format-chat',
                    'supports' => array(),
                ),
                'extra-field' => array()
            )
        );

        $this->is_staging = (strpos($_SERVER["HTTP_HOST"], 'dev2') === false)?false:true;

    }

    /**
     * Wordpress Hook Function: admin notice
     */
    public function admin_notice()
    {
        //Show message
        $this->printMessageToshow();
    }

    /**
     * Setup all post-types
     */
    public function setup_post_types()
    {
        foreach ($this->post_types as $p) {
            register_post_type($p['slug'], $p['args']);
        }
    }

    /**
     * Setup Taxonomies
     */
    public function setup_taxonomies()
    {
        foreach ($this->taxonomies as $t) {
            register_taxonomy($t['slug'], $t['post-type'], $t['args']);
        }
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/b2b-price-conf-admin.js', array('jquery'), $this->version, false);
    }

    /**
     * Add Error Message
     *
     * @param $message
     * @param int $post_id
     */
    public function addErrorMessage($message, $post_id = 0)
    {
        $this->addMessage($message, $post_id);
    }

    /**
     * Add Success Message
     *
     * @param $message
     * @param int $post_id
     */
    public function addSuccessMessage($message, $post_id = 0)
    {
        $this->addMessage($message, $post_id, 'updated');
    }

    /**
     * Add message to system
     *
     * @param $message
     * @param string $type error | update
     */
    public function addMessage($message, $post_id = 0, $type = 'error')
    {
        $user_id = get_current_user_id();
        $blog_id = get_current_blog_id();

        $key_transient = $this->plugin_name . '_message_' . $blog_id . '_' . $user_id;

        $aMessage = get_transient($key_transient);

        if (!$aMessage || !is_array($aMessage) || count($aMessage) == 0) {
            $aMessage = array();
        }

        $aMessage[] = array(
            'type' => $type,
            'message' => $message
        );
        set_transient($key_transient, $aMessage, 120);


    }

    /**
     * Print messagge as Wordpress Standard Message
     */
    public function printMessageToshow()
    {
        global $post;
        $post_id = ($post) ? $post->ID : 0;
        $user_id = get_current_user_id();
        $blog_id = get_current_blog_id();
        $key_transient = $this->plugin_name . '_message_' . $blog_id . '_' . $user_id;
        $aMessage = get_transient($key_transient);

        if ($aMessage && is_array($aMessage) && count($aMessage)) {
            foreach ($aMessage as $message) {
                $type = $message['type'];
                $msg = $message['message'];
                ?>
                <div class="<?php echo $type ?>">
                    <p><?php echo $msg; ?></p>
                </div>
                <?php
            }
            delete_transient($key_transient);
        }
    }

    /**
     *
     */
    public function add_network_pages()
    {
        add_menu_page(
            __( 'B2B Price Conf', 'b2b-price-conf' ),
            __( 'B2B Price Conf', 'b2b-price-conf' ),
            'manage_options',
            'b2b-price-conf-admin',
            array($this, 'pagina_admin'),
            'dashicons-chart-pie',
            6
        );
    }

    /**
     *
     */
    public function pagina_admin()
    {
        include(plugin_dir_path( __FILE__ ).'partials/b2b-price-conf-admin.php');
    }
}
