<?php
/**
 * Plugin REST Webhook Services Class
 *
 * @since      1.0.0
 * @package    ckexample
 * @subpackage ckexample/classes
 * @author     Curtis Krauter <cortezcreations@gmail.com>
 */

if (class_exists('ckexample_core_class') ) {

    final class ckexample_webhook_services {

        /**
         * Constructor
         *
        */
        public function __construct() {  
        }

         /**
         * Operation Whitelist
         *
         * @access private
         */
        private $operations_whitelist = [
            'add_contact'     => 'ckexample_webhook_functions',
            'delete_contact'  => 'ckexample_webhook_functions',
            'update_contact'  => 'ckexample_webhook_functions',
            'create_password' => 'ckexample_webhook_functions',
            'set_date'        => 'ckexample_webhook_functions',
            'update_keys'     => 'ckexample_webhook_functions',
        ];
        
        /**
         * Registerd Hooks
         * 
         * @access	private
         * @var		string    $registered_hooks    Specific Hook IDs Registered for the active CRM
         */
        private $registered_hooks = [];

        /**
         * Register Routes
         * 
         * @link  /wp-json/ckexample/v1/action
         */
        function register_routes(){
            $ns = ckexample_app()->ns();
            register_rest_route( "{$ns}/v1", '/action/(?P<ckexample_id>[^/]+)', [
                'methods' 			  => ['POST'],
                'callback'			  => [$this, 'manage_request'],
                'permission_callback' => [$this, 'permissions']
            ] );
        }
        
        /**
         * Manage the REST Request
         *
         * @param  WP_REST_Request  $request
         * @return WP_REST_Response
        */
        private function manage_request( WP_REST_Request $request ) {

            $ns        = ckexample_app()->ns();
            $params    = $request->get_params();
            $operation = sanitize_text_field($params['operation']);
            $error     = __( 'operation function does not exist', $ns );
            
            // Check It's a Whitelisted Function
            $whitelist = $this->get_operation_whitelist();
            if( array_key_exists( $operation, $whitelist ) ){
                $class = $whitelist[$operation];
                // Class and Method Exist
                if( class_exists($class) && method_exists($class, $operation) ){
                    $results = call_user_func( [$class, $operation], $params );
                    // TODO - if having filters to load need to ensure there's a response
                    if( is_wp_error($results) ){
                        $data = [ 'error' => $results->get_error_message() ];
                        ckexample_app()->logger( $class, $operation, $data );
                        return $this->error( $data, $results->get_error_code() );
                    }
                    else{
                        ckexample_app()->logger( $class, $operation, $results );
                        return $this->success($results);
                    }
                }
                // Class or Method does not exist
                else {
                    $data = [ 'error' => "{$class} :: {$operation} {$error}" ];
                    ckexample_app()->logger( __CLASS__, $operation, $data );
                    return $this->error( $data );
                }
            }
            // Operation Not Whitelisted
            else {
                $data = [ 'error' => "{$operation} {$error}" ];
                ckexample_app()->logger( __CLASS__, $operation, $data );
                return $this->error( $data );
            }
        }

        /**
         * Check Permissions for the REST Request
         *
         * @param  WP_REST_Request  $request
         * @return mixed ( true || WP_Error )
        */
        function permissions( WP_REST_Request $request ) {
            
            $ns        = ckexample_app()->ns();
            $params    = $request->get_params();
            $operation = ! empty($params['operation']) ? sanitize_text_field($params['operation']) : false;
            if( empty($operation) ){
                ckexample_app()->logger( __CLASS__, __FUNCTION__, $params );
                return new WP_Error( 400, __( "Invalid operation", $ns ), $params );
            }
            else {
                // TODO - Set up and add Request Security Keys for requests w/o Bearer
                // Example for Bearer 
                $auth = $request->get_header( 'authorization' );
                if ( ( substr( $auth, 0, 6 ) === 'Bearer' ) ) {
                    if ( str_replace( "Bearer ", "", $auth ) === $this->access_token ) {
                        return true;
                    }
                }
    
                return new WP_Error( 401, __( "Unauthorized request", $ns ) );
            }
        }

        /**
         * Success Response
         *
         * @param  array  $data       Response Data
         * @param  int    $code       Response Code
         * @return WP_REST_Response
        */
        function success( array $data, int $code = 200 ) : WP_REST_Response {
            return $this->response( $data, $code );
        }

        /**
         * Error Response
         *
         * @param  array  $data       Response Data
         * @param  int    $code       Response Code
         * @return WP_REST_Response
        */
        function error( array $data, int $code = 400 ) : WP_REST_Response {
            return $this->response( $data, $code );
        }

        /**
         * Request Response
         *
         * @param  array  $data       Response Data
         * @param  int    $code       Response Code
         * @return WP_REST_Response
        */
        function response( array $data, int $code ) : WP_REST_Response {
            // Gets the header information to prevent caching
            $headers = [];
            foreach ( wp_get_nocache_headers() as $k => $v ) {
                $headers[ $k ] = $v;
            }
            // Set Response Data, Code, and Headers
            $response = new WP_REST_Response( $data );
            $response->set_status( $code );
            $response->set_headers( $headers );

            return $response;
        }
        
        /**
         * Get Operation Whitelist
         * 
         * @access public
         * @return array of allowed operations arrays ( __CLASS__, __FUNCTION__ )
         */
        private function get_operation_whitelist(){
            return apply_filters( 'ckexample/http/operations/whitelist', $this->operations_whitelist );
        }

        
        private $access_token      = '5FxJzRrNjJSpiX8jNS2tRTakZeCUe3d7Mz9kJPPVdn';

    // End of Class
    }

}