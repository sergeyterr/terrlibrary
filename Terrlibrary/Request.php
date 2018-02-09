<?php
// Terrlibrary/Request
namespace Terrlibrary;

/**
 * Terrlibs Library
 */
if (! class_exists('Request')) {
    class Request
    {
        /**
         * Protected constructor since this is a static class.
         *
         * @access  protected
         */
        protected function __construct()
        {
            // Nothing here
        }

        /**
         * Redirects the browser to a page specified by the $url argument.
         *
         *  <code>
         *        Terrlibrary\Request::redirect('test');
         *  </code>
         *
         * @param string  $url    The URL
         * @param integer $status Status
         * @param integer $delay  Delay
         */
        public static function redirect($url, $status = 302, $delay = null)
        {
            // Redefine vars
            $url    = (string) $url;
            $status = (int) $status;

            // Status codes
            $messages      = array();
            $messages[301] = '301 Moved Permanently';
            $messages[302] = '302 Found';

            // Is Headers sent ?
            if (headers_sent()) {
                echo "<script>document.location.href='" . $url . "';</script>\n";

            } else {
                // Redirect headers
                Request::setHeaders('HTTP/1.1 ' . $status . ' ' . Arr::get($messages, $status, 302));

                // Delay execution
                if ($delay !== null) {
                    sleep((int) $delay);
                }

                // Redirect
                Request::setHeaders("Location: $url");

                // Shutdown Request
                Request::shutdown();
            }
        }

        /**
         * Set one or multiple headers.
         *
         *  <code>
         *        Terrlibrary\Request::setHeaders('Location: http://site.com/');
         *  </code>
         *
         * @param mixed $headers String or array with headers to send.
         */
        public static function setHeaders($headers)
        {
            // Loop elements
            foreach ((array) $headers as $header) {
                // Set header
                header((string) $header);
            }
        }

        /**
         * Get
         *
         *  <code>
         *        $action = Terrlibrary\Request::get('action');
         *  </code>
         *
         * @param string $key
         *
         * @return mixed
         */
        public static function get($key)
        {
            return Arr::get($_GET, $key);
        }

        /**
         * Post
         *
         *  <code>
         *        $login = Terrlibrary\Request::post('login');
         *  </code>
         *
         * @param string $key
         *
         * @return mixed
         */
        public static function post($key)
        {
            return Arr::get($_POST, $key);
        }

        /**
         * Returns whether this is an ajax request or not
         *
         *  <code>
         *        if (Terrlibrary\Request::isAjax()) {
         *            // do something...
         *        }
         *  </code>
         *
         * @return boolean
         */
        public static function isAjax()
        {
            return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
        }

        /**
         * Terminate request
         *
         *  <code>
         *        Terrlibrary\Request::shutdown();
         *  </code>
         *
         */
        public static function shutdown()
        {
            exit(0);
        }
    }
}
