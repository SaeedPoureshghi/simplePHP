<?php
class Route{

        private $routes = [];
        private static $instance;
        private static $_auth = false;
        private static $_admin = false;

        public static function add($expression,$method) {

            if (is_null(self::$instance)) {
                self::$instance = new self();
            }

            array_push(self::$instance->routes,Array(
                'expression' => $expression,
                'method' => $method,
                'auth' => self::$_auth,
                'admin' => self::$_admin
              ));

              return self::$instance;
            

        }

        public static function run(){
            $parsed_url = parse_url($_SERVER['REQUEST_URI']);

            if(isset($parsed_url['path'])){
              $path = $parsed_url['path'];
            }else{
              $path = '/';
            }
            $method = $_SERVER['REQUEST_METHOD'];
            $method=strtolower($method);
            $path_found = false;
            $route_found = false;

            if ($method === 'post' && substr($path,0,7)!='/payBTC' && substr($path,0,7) != '/notify') {
                @$_token = $_SESSION['_token'];
                @$user_token = $_POST['_token'];
                if (!isset($user_token)){
                    die('Not Authorized.');
                }
                if ($_token != $user_token){
                    die('Auth. Fail!'.$_token);

                }

            }

            foreach(self::$instance->routes as $route){
                $route['expression'] = '^'.$route['expression'].'$';
                if (preg_match('#'.$route['expression'].'#',$path,$matches)) {
                    $path_found = true;
                    if ($method == strtolower($route['method'])){
                        $route_found = true;
                        if ($route['admin']) {
                            @$admin = $_SESSION['admin'];
                            if (!$admin) {
                                http_response_code(403);
                                header('HTTP/1.0 403 Forbidden');
                                page::render('system/403');
                                die;
                            }
                        }

                        if ($route['auth']) {
                            @$login = $_SESSION['login'];
                            if (!isset($login)) {
                                http_response_code(403);
                                header('HTTP/1.0 403 Forbidden');
                                page::render('system/403');
                                die;
                            }
                        }
                        // echo $path.' => '.$method;
                        // echo ($route['auth'])? 'AUTH':'ALL';
                        $func = self::_function($path);
                        // echo $func;
                        if ($func == '/'){$func='Index';}
                        if (function_exists($func)) {
                            call_user_func_array($func, $matches);
                        }else{
                            !defined('_DEVMODE') or die("$func() not implemented!");
                            http_response_code(404);
                            header("HTTP/1.0 404 Not Found");  
                            page::render('system/404'); 
                        }
                        break;
                    }
                }
                
            }
            if (!$route_found){
                if ($path_found) {
                    http_response_code(405);
                    header("HTTP/1.0 405 Method Not Allowed");
                    page::render('system/405');

                }else{
                    http_response_code(404);
                    header("HTTP/1.0 404 Not Found");  
                    page::render('system/404');

                }
            }
        }

        protected static function _function($str) {
            return preg_replace_callback("~[/](\w)~", function($m) { return strtoupper($m[1]); }, $str);
        }


        public static function auth(){

            self::$_auth = true;
      
        }

        public static function admin(){

            self::$_admin = true;
      
        }

        public static function all(){
            self::$_auth = false;

        }

        public static function getRoutes(){
            return self::$instance->routes;
        }

        public static function getFunction($str){
            $func = self::_function($str);
            if ($func == '/') {$func="Index";}
            return function_exists($func);
        }
    }

?>