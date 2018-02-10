<?php
// Terrlibrary/Notification
namespace Terrlibrary;

/**
 * Terrlibs Library
 */
if (! class_exists('Notification')) {
    class Notification
    {
        /**
         * Notifications session key
         *
         * @var string
         */
        const SESSION_KEY = 'notifications';

        /**
         * Notifications array
         *
         * @var array
         */
        private static $notifications = array();

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
         * Returns a specific variable from the Notifications array.
         *
         *  <code>
         *      echo Terrlibrary\Notification::get('success');
         *      echo Terrlibrary\Notification::get('errors');
         *  </code>
         *
         * @param  string $key Variable name
         *
         * @return mixed
         */
        public static function get($key)
        {
            // Redefine arguments
            $key = (string) $key;

            // Return specific variable from the Notifications array
            return isset(Notification::$notifications[$key]) ? Notification::$notifications[$key] : null;
        }

        /**
         * Adds specific variable to the Notifications array.
         *
         *  <code>
         *      Terrlibrary\Notification::set('success', 'Data has been saved with success!');
         *      Terrlibrary\Notification::set('errors', 'Data not saved!');
         *  </code>
         *
         * @param string $key   Variable name
         * @param mixed  $value Variable value
         */
        public static function set($key, $value)
        {
            // Redefine arguments
            $key = (string) $key;

            // Save specific variable to the Notifications array
            $_SESSION[Notification::SESSION_KEY][$key] = $value;
        }

        /**
         * Adds specific variable to the Notifications array for current page.
         *
         *  <code>
         *      Terrlibrary\Notification::setNow('success', 'Success!');
         *  </code>
         *
         * @param string $key   Variable name
         * @param mixed  $value Variable value
         */
        public static function setNow($key, $value)
        {
            // Redefine arguments
            $key = (string) $key;

            // Save specific variable for current page only
            Notification::$notifications[$key] = $value;
        }

        /**
         * Clears the Notifications array.
         *
         *  <code>
         *      Terrlibrary\Notification::clean();
         *  </code>
         *
         * Data that previous pages stored will not be deleted, just the data that
         * this page stored itself.
         */
        public static function clean()
        {
            $_SESSION[Notification::SESSION_KEY] = array();
        }

        /**
         * Initializes the Notification service.
         *
         *  <code>
         *      Terrlibrary\Notification::init();
         *  </code>
         *
         * This will read notification/flash data from the $_SESSION variable and load it into
         * the $this->previous array.
         */
        public static function init()
        {
            // Get notification/flash data...

            if (! empty($_SESSION[Notification::SESSION_KEY]) && is_array($_SESSION[Notification::SESSION_KEY])) {
                Notification::$notifications = $_SESSION[Notification::SESSION_KEY];
            }

            self::clean();
        }
    }
}
