<?php
// Terrlibrary/Debug
namespace Terrlibrary;

/**
 * Terrlibs Library
 */
if (! class_exists('Url')) {
    class Url
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
         * Takes a long url and uses the TinyURL API to return a shortened version.
         *
         *  <code>
         *      echo Terrlibrary\Url::tiny('http:://sitename.com');
         *  </code>
         *
         * @param  string $url Long url
         *
         * @return string
         */
        public static function tiny($url)
        {
            return file_get_contents('http://tinyurl.com/api-create.php?url=' . (string) $url);
        }

        /**
         * Check is url exists
         *
         *  <code>
         *      if (Terrlibrary\Url::exists('http:://sitename.com')) {
         *      // Do something...
         *    }
         *  </code>
         *
         * @param  string $url Url
         *
         * @return boolean
         */
        public static function exists($url)
        {
            $a_url = parse_url($url);
            if (! isset($a_url['port'])) {
                $a_url['port'] = 80;
            }
            $errno   = 0;
            $errstr  = '';
            $timeout = 30;
            if (isset($a_url['host']) && $a_url['host'] != gethostbyname($a_url['host'])) {
                $fid = fsockopen($a_url['host'], $a_url['port'], $errno, $errstr, $timeout);
                if (! $fid) {
                    return false;
                }
                $page = isset($a_url['path']) ? $a_url['path'] : '';
                $page .= isset($a_url['query']) ? '?' . $a_url['query'] : '';
                fputs($fid, 'HEAD ' . $page . ' HTTP/1.0' . "\r\n" . 'Host: ' . $a_url['host'] . "\r\n\r\n");
                $head = fread($fid, 4096);
                fclose($fid);

                return preg_match('#^HTTP/.*\s+[200|302]+\s#i', $head);
            } else {
                return false;
            }
        }

        /**
         * Gets the base URL
         *
         *  <code>
         *      echo Terrlibrary\Url::base();
         *  </code>
         *
         * @return string
         */
        public static function base()
        {
            $https = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? 'https://' : 'http://';

            return $https . rtrim(rtrim($_SERVER['HTTP_HOST'], '\\/') . dirname($_SERVER['PHP_SELF']), '\\/');
        }

        /**
         * Gets current URL
         *
         *  <code>
         *      echo Terrlibrary\Url::current();
         *  </code>
         *
         * @return string
         */
        public static function current()
        {
            return (! empty($_SERVER['HTTPS'])) ? "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] : "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        }
    }
}
