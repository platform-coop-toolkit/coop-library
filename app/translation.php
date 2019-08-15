<?php

namespace App;

if (class_exists('Polylang_Theme_Translation')) {

    class Translation extends \Polylang_Theme_Translation
    {
        /**
         * Constructor.
         */
        public function __construct()
        {
            parent::__construct();
            $this->runSageThemeScanner();
        }

        /**
         * Find strings in /theme/app folder.
         */
        protected function runSageThemeScanner()
        {
            $themes = wp_get_themes();

            if (!empty($themes)) {
                foreach ($themes as $name => $theme) {
                    if ($name === 'learning-commons/resources') {
                        $theme_path = $theme->theme_root . DIRECTORY_SEPARATOR . $name;
                        $app_path = str_replace('resources', 'app', $theme_path);
                        $app_controllers_path = "{$app_path}/Controllers";

                        $app_files = $this->get_files_from_dir($app_path);
                        $app_controllers_files = $this->get_files_from_dir($app_controllers_path);

                        $app_strings = $this->file_scanner($app_files);
                        $app_controllers_strings = $this->file_scanner($app_controllers_files);

                        $strings = array_merge($app_strings, $app_controllers_strings);

                        $this->add_to_polylang_register($strings, $name);
                    }
                }
            }
        }
    }
}
