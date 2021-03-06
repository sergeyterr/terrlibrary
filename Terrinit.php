<?php
// Terrinit/Terrinit
namespace Terrinit;

/**
 * Terrlibs Library
 * version 1.1.2
 */
if (!class_exists('Terrinit')) {
    class Terrinit
    {
        public function __construct($istheme = true)
        {
            if (!defined('DS')) {
                define('DS', DIRECTORY_SEPARATOR);
            }
            if (!defined('TERRLIBS_DATE_FORMAT')) {
                define('TERRLIBS_DATE_FORMAT', 'Y-m-d / H:i:s');
            }
            /**
             * Здесь задаем - это плагин или тема
             */
            if (!defined('TERRLIBSTHEME')) {
                $istheme = $istheme ? true : false;
                define('TERRLIBSTHEME', $istheme);
            }

            /**
             * Define __DIR__ constant for PHP 5.2.x
             */
            if (!defined('__DIR__')) {
                define('__DIR__', dirname(__FILE__));
            }

            $file_dir    = str_replace('\\', '/', __DIR__);
            $content_dir = untrailingslashit(dirname(dirname(get_stylesheet_directory())));
            $content_dir = str_replace('\\', '/', $content_dir);
            $content_url = untrailingslashit(dirname(dirname(dirname(get_stylesheet_uri()))));
            $file_url    = str_replace($content_dir, $content_url, $file_dir);
            if (!defined('TERRLIBSURL')) {
                define('TERRLIBSURL', $file_url);
            }
            if (!defined('TERRLIBSDIR')) {
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
             * https://fontawesome.com/how-to-use/svg-with-js
             *
             * ver 5.0.6
             */
            add_action('wp_enqueue_scripts', [__CLASS__, 'terrlibFontawesomeScripts']);
            add_action('admin_enqueue_scripts', [__CLASS__, 'terrlibFontawesomeScripts']);

            /**
             * Подключаем Всплывающие окна
             * http://vodkabears.github.io/remodal/
             * https://github.com/VodkaBears/Remodal#closeonconfirm
             *
             * ver 1.1.1
             */
            add_action('wp_enqueue_scripts', [__CLASS__, 'terrlibRemodal']);
            add_action('admin_enqueue_scripts', [__CLASS__, 'terrlibRemodal']);

            /**
             * Поиск в опциях тега select по первым буквам
             *
             * https://harvesthq.github.io/chosen/
             * https://github.com/harvesthq/chosen
             * https://github.com/harvesthq/chosen/releases
             *
             * ver 1.8.3
             *
             * add_action( 'wp_footer', 'terrlib_test' );
             * add_action( 'admin_footer', 'terrlib_test' );
             * function terrlib_test()
             * {
             * ?>
             * <script>
             * jQuery(document).ready(function($){
             *  $(".chosen-select").chosen()
             * });
             * </script>
             * <?php
             * }
             */
            add_action('wp_enqueue_scripts', [__CLASS__, 'terrlibChosen']);
            add_action('admin_enqueue_scripts', [__CLASS__, 'terrlibChosen']);

            /**
             * Красивые всплывающие окна вместо alert
             * https://sweetalert2.github.io/
             * https://github.com/sweetalert2/sweetalert2
             *
             * ver 7.11.0
             */
            add_action('wp_enqueue_scripts', [__CLASS__, 'terrlibSweetalert']);
            add_action('admin_enqueue_scripts', [__CLASS__, 'terrlibSweetalert']);
        }

        public static function terrlibAirDataPicker()
        {
            //Подключаем скрипты air-datapicker
            wp_enqueue_script(
                'terrlib-air-data-picker-js',
                TERRLIBSURL . '/AirDataPicker/js/datepicker.min.js',
                array('jquery'),
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

        public static function terrlibRemodal()
        {
            // Подключаем стили
            wp_enqueue_style(
                'terrlib-remodal-style',
                TERRLIBSURL . '/Remodal/remodal.css'
            );
            wp_enqueue_style(
                'terrlib-remodal-theme-style',
                TERRLIBSURL . '/Remodal/remodal-default-theme.css'
            );

            // Подключаем скрипты
            wp_enqueue_script(
                'terrlib-remodal-js',
                TERRLIBSURL . '/Remodal/remodal.min.js',
                array( 'jquery' ),
                '27653789'
            );
        }

        public static function terrlibChosen()
        {
            // Подключаем стили
            wp_enqueue_style(
                'terrlib-chosen-style',
                TERRLIBSURL . '/Chosen/chosen.min.css'
            );

            // Подключаем скрипты
            wp_enqueue_script(
                'terrlib-chosen-js',
                TERRLIBSURL . '/Chosen/chosen.jquery.min.js',
                array( 'jquery' ),
                '123456765'
            );
        }

        public static function terrlibSweetalert()
        {
            //Подключаем стили и скрипты sweetalert
            wp_enqueue_script(
                'terrlib-sweetalert-all-js',
                TERRLIBSURL . '/Sweetalert2/sweetalert2.all.min.js',
                array('jquery'),
                123456,
                true
            );
            wp_enqueue_script(
                'terrlib-polyfill-sweetalert-js',
                'https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js',
                array( 'terrlib-sweetalert-js' ),
                123456
            );
            /*wp_enqueue_script(
                'terrlib-sweetalert-js',
                TERRLIBSURL . '/Sweetalert2/sweetalert2.min.js',
                array( 'jquery' ),
                '123456765'
            );
            wp_enqueue_style(
                'decor-market-sweetalert-admin-css',
                TERRLIBSURL . '/Sweetalert2/sweetalert2.min.css'
            );*/
        }
    }
}
