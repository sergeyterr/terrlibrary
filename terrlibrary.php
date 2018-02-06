<?php
/**
 * Plugin Name: TerrLibrary
 * Plugin URI: https://aterweb.ru/
 * Description: Library for all
 * Version: 1.0.0
 * Author: Sergey Terr
 * Author URI: https://aterweb.ru/
 * Requires at least: 4.9
 * Tested up to: 4.9.2
 *
 * Text Domain: terrlibrary
 * Domain Path: /lang/
 *
 */

require_once('Terrlibrary/Html.php');
echo Terrlibrary\Html::arrow('right');
wp_die();