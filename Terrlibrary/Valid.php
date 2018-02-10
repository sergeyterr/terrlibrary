<?php
// Terrlibrary/Valid
namespace Terrlibrary;

/**
 * Terrlibs Library
 */
if (! class_exists('Valid')) {
    class Valid
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
         * Check an ip address for correct format.
         *
         *    <code>
         *        if (Terrlibrary\Valid::ip('127.0.0.1') || Terrlibrary\Valid::ip('0:0:0:0:0:0:7f00:1')) {
         *            // Do something...
         *    }
         *    </code>
         *
         * @param  string $ip ip address
         *
         * @return boolean
         */
        public static function ip($ip)
        {
            return (bool) filter_var((string) $ip, FILTER_VALIDATE_IP);
        }

        /**
         * Check an credit card for correct format.
         *
         *    <code>
         *        if (Terrlibrary\Valid::creditCard(7711111111111111, 'Visa')) {
         *            // Do something...
         *    }
         *    </code>
         *
         * @param integer $num      Credit card num
         * @param string  $type     Credit card type:
         *                          American - American Express
         *                          Dinners - Diner's Club
         *                          Discover - Discover Card
         *                          Master - Mastercard
         *                          Visa - Visa
         *
         * @return boolean
         */
        public static function creditCard($num, $type)
        {
            // Redefine vars
            $num  = (int) $num;
            $type = (string) $type;

            switch ($type) {
                case "American":
                    return (bool) preg_match("/^([34|37]{2})([0-9]{13})$/", $num);
                case "Dinners":
                    return (bool) preg_match("/^([30|36|38]{2})([0-9]{12})$/", $num);
                case "Discover":
                    return (bool) preg_match("/^([6011]{4})([0-9]{12})$/", $num);
                case "Master":
                    return (bool) preg_match("/^([51|52|53|54|55]{2})([0-9]{14})$/", $num);
                case "Visa":
                    return (bool) preg_match("/^([4]{1})([0-9]{12,15})$/", $num);
            }
            return false;
        }

        /**
         * Check an phone number for correct format.
         *
         *    <code>
         *        if (Terrlibrary\Valid::phone(0661111117)) {
         *            // Do something...
         *    }
         *    </code>
         *
         * @param  string $num Phone number
         *
         * @return boolean
         */
        public static function phone($num)
        {
            return (bool) preg_match("/^([0-9\(\)\/\+ \-]*)$/", (string) $num);
        }

        /**
         * Check an url for correct format.
         *
         *    <code>
         *        if (Terrlibrary\Valid::url('http://site.com/')) {
         *            // Do something...
         *    }
         *    </code>
         *
         * @param  string $url Url
         *
         * @return boolean
         */
        public static function url($url)
        {
            return (bool)filter_var((string) $url, FILTER_VALIDATE_URL);
        }

        /**
         * Check an date for correct format.
         *
         *    <code>
         *        if (Terrlibrary\Valid::date('12/12/12')) {
         *            // Do something...
         *    }
         *    </code>
         *
         * @param  string $str Date
         *
         * @return boolean
         */
        public static function date($str)
        {
            return (strtotime($str) !== false);
        }

        /**
         * Checks whether a string consists of digits only (no dots or dashes).
         *
         *    <code>
         *        if (Terrlibrary\Valid::digit('12')) {
         *            // Do something...
         *    }
         *    </code>
         *
         * @param  string $str String
         *
         * @return boolean
         */
        public static function digit($str)
        {
            return (bool) preg_match("/[^0-9]/", $str);
        }

        /**
         * Checks whether a string is a valid number (negative and decimal numbers allowed).
         *
         *    <code>
         *        if (Terrlibrary\Valid::numeric('3.14')) {
         *            // Do something...
         *    }
         *    </code>
         *
         * Uses {@link http://www.php.net/manual/en/function.localeconv.php locale conversion}
         * to allow decimal point to be locale specific.
         *
         * @param  string $str String
         *
         * @return boolean
         */
        public static function numeric($str)
        {
            $locale = localeconv();

            return (bool) preg_match('/^-?[0-9' . $locale['decimal_point'] . ']++$/D', (string) $str);
        }

        /**
         * Checks if the given regex statement is valid.
         *
         * @param  string $regexp The value to validate.
         *
         * @return boolean
         */
        public static function regexp($regexp)
        {
            // dummy string
            $dummy = 'Gelato is a PHP5 library for kickass Web Applications.';

            // validate
            return (@preg_match((string) $regexp, $dummy) !== false);
        }


        /** ----------------------------------------------------------------------- */
        /** Мои функции */
        /** https://wp-kama.ru/functions/functions-db?filter=validate */
        /** https://wp-kama.ru/functions/functions-db?filter=is_ */

        /**
         * Проверяет, является ли переданная строка e-mail адресом.
         *
         * Check an email address for correct format.
         *
         *    <code>
         *        if (Terrlibrary\Valid::email('test@test.com')) {
         *            // Do something...
         *    }
         *    </code>
         *
         * @param  string $email email address
         *
         * @return boolean
         */
        public static function email($email)
        {
            return is_email($email);
        }

        /**
         * Проверяет существование пользователя по переданному имени (username).
         *
         * Возвращает
         * ID пользователя, если пользователь найден и null, если пользователь не существует.
         *
         * @param $username
         *
         * @return false|int
         */
        public static function usernameExists($username)
        {
            return username_exists($username);
        }

        /**
         * Проверяет существует ли указанный email адрес среди зарегистрированных пользователей.
         *
         * Возвращает
         * Число/false.
         * ID пользователя - если email уже существует.
         * false - если такого email еще нет в базе данных.
         *
         * @param $email
         *
         * @return false|int
         */
        public static function emailExists($email)
        {
            return email_exists($email);
        }

        /**
         * Проверяет зарегистрирован ли указанный шоткод.
         *
         * Возвращает
         * true или false, в зависимости от того существует шоткод или нет.
         *
         * @param $tag
         *
         * @return bool
         */
        public static function shortcodeExists($tag)
        {
            return shortcode_exists($tag);
        }

        /**
         * Проверяет зарегистрирован ли указанный тип записи.
         *
         * Возвращает
         * True/false. true - если тип записи есть, false - в противном случае.
         *
         * @param $post_type
         *
         * @return bool
         */
        public static function postTypeExists($post_type)
        {
            return post_type_exists($post_type);
        }

        /**
         * Проверяет существует ли указанная таксономия.
         *
         * Это, так называемый, условный тег, логическая функция, которая возвращает "правду" (true) или "ложь" (false),
         * в зависимости от того, выполняется условие или нет.
         *
         * @param $taxonomy
         *
         * @return bool
         */
        public static function taxonomyExists($taxonomy)
        {
            return taxonomy_exists($taxonomy);
        }

        /**
         * Проверяет существует ли указанный элемент таксономии (раздел).
         * Если существует, возвращает ID или массив идентификаторов этого элемента.
         *
         *  Возвращает
         *  null/число/массив
         *
         *  $term(строка/число) (обязательный)
         *    Элемент, который нужно проверить. Можно указывать название, альтернативное название или ID.
         *    По умолчанию: нет
         *  $taxonomy(строка)
         *    Название таксономии с которой будет работать функция. Указывать не обязательно.
         *    По умолчанию: ''
         *  $parent(строка/число)
         *    ID родительского раздела, под которым предполагается искать указанный элемент таксономии.
         *    По умолчанию: ''
         *
         * @param        $term
         * @param string $taxonomy
         * @param string $parent
         *
         * @return mixed
         */
        public static function termExists($term, $taxonomy = '', $parent = '')
        {
            return term_exists($term, $taxonomy, $parent);
        }

        /**
         * Check whether a post tag with a given name exists.
         *
         * Возвращает
         * mixed
         *
         * @param $tag_name
         *
         * @return mixed
         */
        public static function tagExists($tag_name)
        {
            return tag_exists($tag_name);
        }

        /**
         * Проверяет существует ли уже запись (пост) с указанным заголовком (post_title).
         * Для проверки, в дополнении к обязательному заголовку можно указать еще: post_content и post_date.
         *
         * Возвращает
         * Число. ID записи, если она найдена или 0.
         *
         * $title(строка) (обязательный)
         *    Заголовок записи. Не путайте с ярлыком (слагом, post_name).
         * $content(строка)
         *    Контент записи для сравнивания.
         *    По умолчанию: ''
         * $date(строка)
         *    Дата записи для сравнивания, в MySQL формате.
         *    По умолчанию: ''
         *
         * @param        $title
         * @param string $content
         * @param string $date
         *
         * @return int
         */
        public static function postExists($title, $content = '', $date = '')
        {
            return post_exists($title, $content, $date);
        }

        /**
         * Check whether a category exists.
         *
         * $cat_name(int|string) (required)
         *    Category name.
         * $parent(int)
         *      Optional. ID of parent term.
         *    Default: null
         *
         * @param      $cat_name
         * @param null $parent
         *
         * @return mixed
         */
        public static function categoryExists($cat_name, $parent = null)
        {
            return category_exists($cat_name, $parent);
        }

        /**
         * Проверяет переданный тип переменной, убеждается что он логический,
         * если нужно переводит его в логический и возвращает обратно.
         *
         * Возвращает
         * Логические true или false.
         *
         * @param $var
         *
         * @return bool
         */
        public static function validateBoolean($var)
        {
            return wp_validate_boolean($var);
        }

        /**
         * Проверяет URL-адрес для безопасного использования в HTTP API.
         *
         * Возвращает
         * false|строка URL или false при ошибке.
         *
         * @param $url
         *
         * @return false|string
         */
        public static function validateUrl($url)
        {
            return wp_http_validate_url($url);
        }
    }
}
