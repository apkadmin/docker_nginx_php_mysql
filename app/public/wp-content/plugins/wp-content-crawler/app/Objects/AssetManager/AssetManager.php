<?php
/**
 * Created by PhpStorm.
 * User: turgutsaricam
 * Date: 13/04/16
 * Time: 23:13
 */

namespace WPCCrawler\Objects\AssetManager;


use WPCCrawler\Constants;
use WPCCrawler\PostDetail\PostDetailsService;

class AssetManager extends BaseAssetManager {

    private $scriptUtils            = 'wcc_utils_js';

    private $stylePostSettings      = 'wcc_post_settings_css';
    private $scriptPostSettings     = 'wcc_post_settings_js';

    private $scriptTooltip          = 'tooltipjs';

    private $scriptClipboard        = 'clipboardjs';

    private $scriptPostList         = 'wcc_post_list_js';

    private $styleGeneralSettings   = 'wcc_general_settings_css';

    private $styleSiteTester        = 'wcc_site_tester_css';
    private $scriptSiteTester       = 'wcc_site_tester_js';

    private $styleTools             = 'wcc_tools_css';
    private $scriptTools            = 'wcc_tools_js';

    private $styleDashboard         = 'wcc_dashboard_css';
    private $scriptDashboard        = 'wcc_dashboard_js';

    private $styleDevTools          = 'wcc_dev_tools_css';
    private $scriptDevTools         = 'wcc_dev_tools_js';

    private $styleOptionsBox        = 'wcc_options_box_css';
    private $scriptOptionsBox       = 'wcc_options_box_js';

    private $styleFeatherlight      = 'featherlight_css';
    private $scriptFeatherlight     = 'featherlight_js';
    private $scriptOptimalSelect    = 'optimal_select_js';
    private $scriptJSDetectElementResize = 'js_detect_element_size_js';

    private $scriptNotifyJs         = 'notifyjs_js';
    private $scriptFormSerializer   = 'form_serializer_js';

    private $styleBootstrapGrid     = 'bootstrap_grid_css';

    private $styleAnimate           = 'animate_css';

    /**
     * @return string A string that will be the variable name of the JavaScript localization values. E.g. if this is
     *                'wpcc', localization values defined in {@link getLocalizationValues()} will be available under
     *                'wpcc' variable in the JS window.
     * @since 1.8.0
     */
    protected function getLocalizationName() {
        return 'wpcc';
    }

    /**
     * Get script localization values.
     *
     * @return array
     */
    protected function getLocalizationValues() {
        return [
            'an_error_occurred'                     =>  _wpcc("An error occurred."),
            'press_to_copy'                         =>  _wpcc("Press {0} to copy"),
            'copied'                                =>  _wpcc("Copied!"),
            'no_result'                             =>  _wpcc("No result."),
            'found'                                 =>  _wpcc("Found"),
            'required_for_test'                     =>  _wpcc("This is required to perform the test."),
            'required'                              =>  _wpcc("This is required."),
            'css_selector_found'                    =>  _wpcc("CSS selector found"),
            'delete_all_test_history'               =>  _wpcc("Do you want to delete all test history?"),
            'url_data_not_exist'                    =>  _wpcc("URL data cannot be found."),
            'currently_crawling'                    =>  _wpcc("Currently crawling"),
            'retrieving_urls_from'                  =>  _wpcc("Retrieving URLs from {0}"),
            'pause'                                 =>  _wpcc('Pause'),
            'continue'                              =>  _wpcc('Continue'),
            'test_data_not_retrieved'               =>  _wpcc('Test data could not be retrieved.'),
            'content_retrieval_response_not_valid'  =>  _wpcc("Response of content retrieval process is not valid."),
            'test_data_retrieval_failed'            =>  _wpcc("Test data retrieval failed."),
            'no_urls_found'                         =>  _wpcc("No URLs found."),
            'this_is_not_valid'                     =>  _wpcc("This is not valid."),
            'url_data_not_exist_for_this'           =>  _wpcc("URL data does not exist for this."),
            'this_url_not_crawled_yet'              =>  _wpcc("This URL has not been crawled yet."),
            'url_cannot_be_retrieved'               =>  _wpcc("The URL cannot be retrieved."),
            'cache_invalidated'                     =>  _wpcc("The cache has been invalidated."),
            'cache_could_not_be_invalidated'        =>  _wpcc("The cache could not be invalidated."),
            'all_cache_invalidated'                 =>  _wpcc("All caches have been invalidated."),
            'all_cache_could_not_be_invalidated'    =>  _wpcc("All caches could not be invalidated."),
            'custom_short_code'                     =>  _wpcc("Custom short code"),
            'post_id_not_found'                     =>  _wpcc("Post ID could not be found."),
            'settings_not_retrieved'                =>  _wpcc("Settings could not be retrieved."),
            'settings_saved'                        =>  _wpcc("The settings have been saved."),
            'state_not_parsed'                      =>  _wpcc("The state could not be parsed."),
            'top'                                   =>  _wpcc("Top"),
        ];
    }

    /*
     *
     */

    /**
     * Add post-settings.css, post-settings.js and utils.js, along with the site settings assets of the registered
     * detail factories.
     */
    public function addPostSettings() {
        $this->addSortable();

        $this->addStyle($this->stylePostSettings, Constants::appDir() . '/public/styles/post-settings.css', false);

        $this->addUtils();
        $this->addNotificationJs();

        $this->addjQueryAnimationAssets();

        $this->addScript($this->scriptPostSettings, Constants::appDir() . '/public/dist/post-settings.js', ['jquery', $this->scriptUtils]);
    }

    /**
     * Add tooltip.js
     */
    public function addTooltip() {
        $this->addScript($this->scriptTooltip, Constants::appDir() . '/public/scripts/tooltip.min.js', ['jquery'], '3.3.6');
    }

    /**
     * Add clipboard.js
     */
    public function addClipboard() {
        $this->addScript($this->scriptClipboard, Constants::appDir() . '/public/scripts/clipboard.min.js', false, '1.5.9');
    }

    /**
     * Add post-list.js and utils.js
     */
    public function addPostList() {
        $this->addUtils();
        $this->addScript($this->scriptPostList, Constants::appDir() . '/public/scripts/post-list.js',
            ['jquery', $this->scriptUtils], false);
    }

    /**
     * Add general-settings.css
     */
    public function addGeneralSettings() {
        $this->addStyle($this->styleGeneralSettings, Constants::appDir() . '/public/styles/general-settings.css', false);
    }

    /**
     * Add site-tester.css, site-tester.js and utils.js, along with the site tester assets of the registered
     * detail factories.
     */
    public function addSiteTester() {
        $this->addStyle($this->styleSiteTester, Constants::appDir() . '/public/styles/site-tester.css', false);
        $this->addUtils();
        $this->addjQueryAnimationAssets();

        $this->addScript($this->scriptSiteTester, Constants::appDir() . '/public/dist/site-tester.js', ['jquery', $this->scriptUtils]);

        // Add tester assets of the registered factories
        PostDetailsService::getInstance()->addSiteTesterAssets();
    }

    /**
     * Add tools.css, tools.js and utils.js
     */
    public function addTools() {
        $this->addStyle($this->styleTools, Constants::appDir() . '/public/styles/tools.css', false);
        $this->addUtils();
        $this->addTooltip();
        $this->addFormSerializer();

        $this->addScript($this->scriptTools, Constants::appDir() . '/public/dist/tools.js', ['jquery', $this->scriptUtils]);
    }

    /**
     * Add dashboard.css
     */
    public function addDashboard() {
        $this->addStyle($this->styleDashboard, Constants::appDir() . '/public/styles/dashboard.css', false);

        $this->addjQueryAnimationAssets();

        $this->addScript($this->scriptDashboard, Constants::appDir() . '/public/scripts/dashboard.js', 'jquery');
    }

    /**
     * Add dev-tools.js and dev-tools.css
     */
    public function addDevTools() {
        $this->addStyle($this->styleDevTools, Constants::appDir() . '/public/styles/dev-tools.css', false);

        // Add the lightbox library after the dev-tools style so that we can override the styles of the library.
        // Also, the lib should be added before the dev-tools script so that we can refer to the lib's script.
        $this->addFeatherlight();

        $this->addScript($this->scriptOptimalSelect, Constants::appDir() . '/public/node_modules/optimal-select/dist/optimal-select.js');
        $this->addScript($this->scriptJSDetectElementResize, Constants::appDir() . '/public/bower_components/javascript-detect-element-resize/jquery.resize.js', ['jquery']);

        $this->addScript($this->scriptDevTools . "-dev-tools", Constants::appDir() . '/public/dist/dev-tools.js', ['jquery']);

    }

    /**
     * Add options-box.js and options-box.css
     */
    public function addOptionsBox() {
        $this->addStyle($this->styleOptionsBox, Constants::appDir() . '/public/styles/options-box.css', false);

        $this->addFormSerializer();

        $this->addScript($this->scriptOptionsBox . "-options-box", Constants::appDir() . '/public/dist/options-box.js', ['jquery']);
    }

    /**
     * Add featherlight.css and featherlight.js
     */
    public function addFeatherlight() {
        $this->addStyle($this->styleFeatherlight, Constants::appDir() . '/public/bower_components/featherlight/src/featherlight.css', false);
        $this->addScript($this->scriptFeatherlight, Constants::appDir() . '/public/bower_components/featherlight/src/featherlight.js', ['jquery']);
    }

    /**
     * Add utils.js
     */
    public function addUtils() {
        $this->addScript($this->scriptUtils, Constants::appDir() . '/public/scripts/utils.js', ['jquery']);
    }

    /**
     * Adds bootstrap-grid.css
     */
    public function addBootstrapGrid() {
        $this->addStyle($this->styleBootstrapGrid, Constants::appDir() . '/public/styles/bootstrap-grid.css', false);
    }

    /**
     * Adds WordPress' default jquery UI sortable library
     */
    public function addSortable() {
        $this->addScript('jquery-ui-sortable');
    }

    /**
     * Adds notification library
     */
    public function addNotificationJs() {
        $this->addScript($this->scriptNotifyJs, Constants::appDir() . '/public/bower_components/notifyjs/dist/notify.js');
    }

    /**
     * Adds jquery.serialize-object.min.js
     */
    public function addFormSerializer() {
        $this->addScript($this->scriptFormSerializer, Constants::appDir() . '/public/node_modules/form-serializer/dist/jquery.serialize-object.min.js', ['jquery']);
    }

    /**
     * Adds animate.min.css
     * @since 1.8.0
     */
    public function addAnimate() {
        $this->addStyle($this->styleAnimate, Constants::appDir() . '/public/node_modules/animate.css/animate.min.css');
    }

    /*
     *
     */

    /**
     * @return string URL of info.css
     */
    public function getInformationStyleUrl() {
        $src = Constants::appDir() . '/public/styles/info.css';
        $ver = $this->getLastModifiedTime($src);
        return rtrim(get_site_url(), '/') . $src . "?ver={$ver}";
    }

    /*
     * PRIVATE HELPERS
     */

    private function addjQueryAnimationAssets() {
        // These are required for using animate feature of jQuery.
        $this->addScript('jquery-ui-core');
        $this->addScript('jquery-color');
    }
}