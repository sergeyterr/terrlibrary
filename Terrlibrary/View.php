<?php
// Terrlibrary/View
namespace Terrlibrary;

/**
 * Terrlibs Library
 */
if (!class_exists('View')) {
    class View
    {
        /**
         * Path to view file.
         *
         * @var string
         */
        protected $view_file;

        /**
         * View variables.
         *
         * @var array
         */
        protected $vars = array();

        /**
         * Global view variables.
         *
         * @var array
         */
        protected static $global_vars = array();

        /**
         * The output.
         *
         * @var string
         */
        protected $output;

        /**
         * Create a new view object.
         *
         *  <code>
         *      // Create new view object
         *      $view = new Terrlibrary\View('blog/views/backend/index');
         *
         *      // Assign some new variables
         *      $view->assign('msg', 'Some message...');
         *
         *      // Get view
         *      $output = $view->render();
         *
         *      // Display view
         *      echo $output;
         *  </code>
         *
         * @param string $view      Name of the view file
         * @param array  $variables Array of view variables
         */
        public function __construct($view, array $variables = array())
        {
            // Set view file
            // From current theme folder or from plugin folder

            if (TERRLIBSTHEME) {
                $this->view_file = get_stylesheet_directory() . DS . 'templates' . DS . $view . '.view.php';
            } else {
                $plugin_dir      = dirname(dirname(dirname(dirname(__FILE__))));
                $this->view_file = $plugin_dir . DS . 'templates' . DS . $view . '.view.php';
            }

            // Is view file exists ?
            if (file_exists($this->view_file) === false) {
                throw new \RuntimeException(vsprintf("%s(): The '%s' view does not exist.", array(
                    __METHOD__,
                    $view,
                )));
            }

            // Set view variables
            $this->vars = $variables;
        }

        /**
         * View factory
         *
         *  <code>
         *      // Create new view object, assign some variables
         *      // and displays the rendered view in the browser.
         *      Terrlibrary\View::factory('blog/views/backend/index')
         *          ->assign('msg', 'Some message...')
         *          ->display();
         *  </code>
         *
         * @param  string $view      Name of the view file
         * @param  array  $variables Array of view variables
         *
         * @return View
         */
        public static function factory($view, array $variables = array())
        {
            return new View($view, $variables);
        }

        /**
         * Assign a view variable.
         *
         *  <code>
         *      $view->assign('msg', 'Some message...');
         *  </code>
         *
         * @param  string  $key    Variable name
         * @param  mixed   $value  Variable value
         * @param  boolean $global Set variable available in all views
         *
         * @return View
         */
        public function assign($key, $value, $global = false)
        {
            // Assign a new view variable (global or locale)
            if ($global === false) {
                $this->vars[$key] = $value;
            } else {
                View::$global_vars[$key] = $value;
            }

            return $this;
        }

        /**
         * Include the view file and extracts the view variables before returning the generated output.
         *
         *  <code>
         *      // Get view
         *      $output = $view->render();
         *
         *      // Display output
         *      echo $output;
         *  </code>
         *
         * @param  string $filter Callback function used to filter output
         *
         * @return string
         */
        public function render($filter = null)
        {
            // Is output empty ?
            if (empty($this->output)) {
                // Extract variables as references
                extract(array_merge($this->vars, View::$global_vars), EXTR_REFS);

                // Turn on output buffering
                ob_start();

                // Include view file
                include($this->view_file);

                // Output...
                $this->output = ob_get_clean();
            }

            // Filter output ?
            if ($filter !== null) {
                $this->output = call_user_func($filter, $this->output);
            }

            // Return output
            return $this->output;
        }

        /**
         * Displays the rendered view in the browser.
         *
         *  <code>
         *      $view->display();
         *  </code>
         *
         */
        public function display()
        {
            echo $this->render();
        }

        /**
         * Magic setter method that assigns a view variable.
         *
         * @param string $key   Variable name
         * @param mixed  $value Variable value
         */
        public function __set($key, $value)
        {
            $this->vars[$key] = $value;
        }

        /**
         * Magic getter method that returns a view variable.
         *
         * @param  string $key Variable name
         *
         * @return mixed
         */
        public function __get($key)
        {
            if (isset($this->vars[$key])) {
                return $this->vars[$key];
            }

            return false;
        }

        /**
         * Magic isset method that checks if a view variable is set.
         *
         * @param  string $key Variable name
         *
         * @return boolean
         */
        public function __isset($key)
        {
            return isset($this->vars[$key]);
        }

        /**
         * Magic unset method that unsets a view variable.
         *
         * @param string $key Variable name
         */
        public function __unset($key)
        {
            unset($this->vars[$key]);
        }

        /**
         * Method that magically converts the view object into a string.
         *
         * @return string
         */
        public function __toString()
        {
            return $this->render();
        }
    }
}
