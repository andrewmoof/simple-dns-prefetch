<?php

/*
Plugin Name: Simple DNS Prefetch
Plugin URI: https://wordpress.org/plugins/simple-dns-prefetch/
Description: This plugin controls the DNS prefetch settings.
Version: 0.4.2
Author: andrewmoof
Author URI: http://moofmedia.com/
*/


if(!class_exists("Simple_DNS_Prefetch")) {
    
    class Simple_DNS_Prefetch {

        public function __construct() {

            if (is_admin) {
                // Hook for adding admin menus
                add_action('admin_init', array($this, 'fnsdp_setting_init'));
                add_action('admin_menu', array($this, 'fnsdp_add_pages'));
            }

            if (get_option('sdp_is_dns_disable')) {
                remove_action('wp_head', 'wp_resource_hints', 2);
            } else {
                add_action('wp_head', array($this, 'fn_add_prefetch'), 1);
            }

        }
        
        // add prefetch header
        function fn_add_prefetch(){
            echo "<!-- Simple DNS Prefetch -->\n";
            
            foreach (get_option('sdp_prefetch_host_list') as $host) {
                echo "<link rel='dns-prefetch' href='//$host' />\n";
            }
            
        }


        // admin setting init
        function fnsdp_setting_init(){
            
            if(false == get_option('sdp_is_dns_disable')) {
                add_option('sdp_is_dns_disable', FALSE);
            }
            
            if(false == get_option('sdp_prefetch_host_list')) {
                add_option('sdp_prefetch_host_list', '');
            }
            
            register_setting('simple_dns_prefetch', 'sdp_is_dns_disable');
            register_setting('simple_dns_prefetch', 'sdp_prefetch_host_list', array($this, 'fn_sanitize_host_list'));

        }
        
        // return HOST from string
        function get_host($url) { 
            $output = parse_url(trim($url)); 
            return trim($output['host'] ? $output['host'] : array_shift(explode('/', $output['path'], 2))); 
        } 

        // callback add hosts
        function fn_sanitize_host_list($hosts = array()){
            if(empty($_POST['sdp_prefetch_host_list'])) {
                return $hosts;
            }
            
            $hosts = explode("\n", $_POST['sdp_prefetch_host_list']);
            
            $output = array();
            foreach ($hosts as $url){
                $host = $this->get_host(esc_url_raw($url));
                if ($host != '') $output[] = $host;
            }
               
            return $output;           
        }

        // action function for hook
        function fnsdp_add_pages() {
            // add a new submenu under Options
            add_options_page('Simple DNS Prefetch', 'Simple DNS Prefetch', 'manage_options', 'menu_simplednsprefetch', array($this, 'fnsdp_options_page'));
        }

        // fnsdp_options_page() displays the page content for the options submenu
        function fnsdp_options_page() {
            echo '<h1>Simple DNS Prefetch</h1>';
            
            $prefetch_host_list = implode("\n", get_option('sdp_prefetch_host_list'));

            ?>
               
		<div class="wrap">
                    <form method="post" action="options.php">
                    <?php settings_fields('simple_dns_prefetch'); ?>    
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row"><label for="sdp_is_dns_disable">Disable all DNS prefech</label></th>
                            <td>
                                <input onclick="show_textarea()" type="checkbox" name="sdp_is_dns_disable" id="sdp_is_dns_disable" value="1" <?php checked('1', get_option('sdp_is_dns_disable')); ?> /> 
                            </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">
                                    <div>Prefech host list:</div>
                                    <br />
                                    <div style="font-weight:normal;">Type the domains you want to be prefetched by visitors browsers. One domain per line.</div>
                                </th>
                            <td>
                                <textarea rows="6" cols="40" name="sdp_prefetch_host_list" id="sdp_prefetch_host_list"><?php echo $prefetch_host_list; ?></textarea>
                                <br />
                                Tip: don't use more than 5 prefetch domains.
                            </td>
                            </tr>
                        </table>
                        <?php submit_button();?>
                    </form>
                </div>

                <script type="text/javascript">
 
                    function show_textarea() {

                        if (document.getElementById('sdp_is_dns_disable').checked ) {
                            document.getElementById('sdp_prefetch_host_list').readOnly = true;
                        } else {
                            document.getElementById('sdp_prefetch_host_list').readOnly = false;
                        }
                    }

                    show_textarea();

                </script>
                
            <?php

       }


    }

    
}

new Simple_DNS_Prefetch;

?>
