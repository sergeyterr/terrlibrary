<?php
// Terrinit/Terrinit
namespace Terrinit;

/**
 * Terrlibs Library
 * version 1.1.2
 */
if (! class_exists('Terrinit')) {
    class Terrinit
    {
        public function __construct($istheme = true)
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
                $istheme = $istheme ? true : false;
                define('TERRLIBSTHEME', $istheme);
            }

            /**
             * Define __DIR__ constant for PHP 5.2.x
             */
            if (! defined('__DIR__')) {
                define('__DIR__', dirname(__FILE__));
            }

            $file_dir    = str_replace('\\', '/', __DIR__);
            $content_dir = untrailingslashit(dirname(dirname(get_stylesheet_directory())));
            $content_dir = str_replace('\\', '/', $content_dir);
            $content_url = untrailingslashit(dirname(dirname(dirname(get_stylesheet_uri()))));
            $file_url    = str_replace($content_dir, $content_url, $file_dir);
            if (! defined('TERRLIBSURL')) {
                define('TERRLIBSURL', $file_url);
            }
            if (! defined('TERRLIBSDIR')) {
                define('TERRLIBSDIR', __DIR__);
            }

            /**
             * Подключаем Air Data Picker
             *
             * http://t1m0n.name/air-datepicker/docs/index-ru.html
             *
             * ver 2.2.3
             */
            add_action('wp_enqueue_scripts', [__CLASS__, 'terrlibAirDataPicker']);
            add_action('admin_enqueue_scripts', [__CLASS__, 'terrlibAirDataPicker']);

            /**
             * Подключаем Fontawesome
             *
             * https://fontawesome.com
             *
             * ver 5.0.6
             */
            add_action('wp_enqueue_scripts', [__CLASS__, 'terrlibFontawesomeScripts']);
            add_action('admin_enqueue_scripts', [__CLASS__, 'terrlibFontawesomeScripts']);
        }

        public static function terrlibAirDataPicker()
        {
            //Подключаем скрипты air-datapicker
            wp_enqueue_script(
                'terrlib-air-data-picker-js',
                TERRLIBSURL . '/AirDataPicker/js/datepicker.min.js',
                array( 'jquery' ),
                123456
            );
            wp_enqueue_style(
                'terrlib-air-data-picker-css',
                TERRLIBSURL . '/AirDataPicker/css/datepicker.min.css'
            );
        }

        public static function terrlibFontawesomeScripts()
        {
            wp_enqueue_script(
                'font-awesome',
                '//use.fontawesome.com/releases/v5.0.6/js/all.js'
            );
        }
    }
}
