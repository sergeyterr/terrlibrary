<?php
// Terrlibrary/Terrinit
namespace Terrlibrary;

/**
 * Terrlibs Library
 * version 1.1.2
 */
if (! class_exists('Terrinit')) {
    class Terrinit
    {
        public function __construct()
        {
            if (! defined('DS')) {
                define('DS', DIRECTORY_SEPARATOR);
            }
            if (! defined('TERRLIBS_DATE_FORMAT')) {
                define('TERRLIBS_DATE_FORMAT', 'Y-m-d / H:i:s');
            }
            /**
             * Здесь задаем - это плагин или тема
             */
            if (! defined('TERRLIBSTHEME')) {
                define('TERRLIBSTHEME', false);
            }
        }
    }
}
