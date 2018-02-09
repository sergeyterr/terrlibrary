<?php
// Terrlibrary/Debug
namespace Terrlibrary;
/**
 * Terrlibs Library
 */
if (! class_exists('Debug')) {
    class Debug
    {
        /**
         * Time
         *
         * @var array
         */
        protected static $time = array();

        /**
         * Memory
         *
         * @var array
         */
        protected static $memory = array();

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
         * Print the variable $data and exit if exit = true
         *
         * <code>
         *  Debug::printr($data);
         * </code>
         *
         * @param mixed   $data Data
         * @param boolean $exit Exit
         */
        public static function printr($data, $exit = false)
        {
            echo "<pre>dump \n---------------------- \n\n" . print_r($data, true) . "\n----------------------</pre>";
            if ($exit) {
                wp_die();
            }
        }

        /**
         * Print the variable $data and exit if exit = true
         *
         * <code>
         *  Debug::dump($data);
         * </code>
         *
         * @param null $mixed
         * @param bool $die
         *
         * @return string
         */
        public static function dump($mixed = null, $die = true)
        {
            ob_start();
            var_dump($mixed);
            $content = "<pre>dump \n---------------------- \n\n";
            $content .= ob_get_contents();
            $content .= "\n----------------------</pre>";
            ob_end_clean();

            if ($die) {
                wp_die($content);
            }

            return $content;
        }
    }
}
