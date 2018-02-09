<?php
// Terrlibrary/Init
namespace Terrlibrary;

/**
 * Terrlibs Library
 */
if (! class_exists('Dir')) {
    class Terrinit
    {
        protected function __construct()
        {
            // Silens gold
        }
        public static function init()
        {
            if (! defined('DS')) {
                define('DS', DIRECTORY_SEPARATOR);
            }
            if (! defined('TERRLIBS_DATE_FORMAT')) {
                define('TERRLIBS_DATE_FORMAT', 'Y-m-d / H:i:s');
            }
        }
    }
}
Terrinit::init();
