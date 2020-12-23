<?php
/**
 * Created by PhpStorm.
 * User: turgutsaricam
 * Date: 24/08/16
 * Time: 14:58
 */

namespace WPCCrawler\Controllers;


use WPCCrawler\Constants;
use WPCCrawler\Factory;
use WPCCrawler\Objects\Page\AbstractMenuPage;
use WPCCrawler\Test\General\GeneralTestHistoryManager;
use WPCCrawler\Test\Test;
use WPCCrawler\Utils;

class TestController extends AbstractMenuPage {

    private static $GENERAL_TESTS;

    /** @var null|array An array of sites */
    private $sites = null;

    /**
     * @return string Menu title for the page
     */
    public function getMenuTitle() {
        return _wpcc('Tester');
    }

    /**
     * @return string Page title
     */
    public function getPageTitle() {
        return _wpcc('Tester');
    }

    /**
     * @return string Slug for the page
     */
    public function getPageSlug() {
        return 'site-tester';
    }

    /**
     * Get view for the page.
     *
     * @return mixed Not-rendered blade view for the page
     */
    public function getView() {
        /*
         * TESTS:
         * TODO: Remove this.
         */

        /*
         *
         */

        // Register assets
        Factory::assetManager()->addTooltip();
        Factory::assetManager()->addBootstrapGrid();
        Factory::assetManager()->addSiteTester();

        // Get available sites
        $sites = $this->getSites();

        return Utils::view('site-tester/main')->with([
            'sites' => $sites,
            'testHistory' => (new GeneralTestHistoryManager())->getTestHistory()
        ]);
    }

    public function handleAJAX() {
        $data = parent::handleAJAX();

        // If the data has 'cmd', handle it.
        $cmd = Utils::array_get($data, 'cmd', null);
        if ($cmd) {
            switch ($cmd) {
                // Delete the history item
                case 'delete_history_item':
                    // Get the item data.
                    $itemData = Utils::array_get($data, 'item');

                    // If there is no item data, return null.
                    if(!$itemData) return null;

                    $siteId  = Utils::array_get($itemData, 'siteId');
                    $testKey = Utils::array_get($itemData, 'testKey');
                    $testUrl = Utils::array_get($itemData, 'testUrl');

                    // All information must exist.
                    if (!$siteId || !$testKey || !$testUrl) return null;

                    // Remove the item from history
                    $historyHandler = new GeneralTestHistoryManager();
                    $historyHandler->removeItemFromHistory($siteId, $testKey, $testUrl);

                    // Create test history view
                    $testHistoryView = Utils::view('site-tester.test-history')
                        ->with('testHistory', $historyHandler->getTestHistory());

                    echo json_encode([
                        'view' => $testHistoryView->render()
                    ]);

                    return;

                case 'delete_all_test_history':
                    // Clear the history
                    $historyHandler = new GeneralTestHistoryManager();
                    $historyHandler->clearTestHistory();

                    // Create test history view
                    $testHistoryView = Utils::view('site-tester.test-history')
                        ->with('testHistory', $historyHandler->getTestHistory());

                    echo json_encode([
                        'view' => $testHistoryView->render()
                    ]);

                    return;

                default:
                    // We could not find the command. Return null.
                    return null;
            }
        }

        // Show the test results
        echo Test::respondToGeneralTestRequest($data["site_id"], $data["test_type"], $data["test_url_part"]);
        return;
    }

    /*
     * HELPERS
     */

    /**
     * Get published sites.
     *
     * @return array See {@link get_posts}.
     * @uses get_posts
     * @since 1.8.0
     */
    public function getSites() {
        if (!$this->sites) {
            $this->sites = get_posts(['post_type' => Constants::$POST_TYPE, 'numberposts' => -1]);
        }

        return $this->sites;
    }

    /**
     * Get general test types. This method exists, because translations are not ready before the page renders.
     *
     * @return array General test types as title,value pair
     */
    public function getGeneralTestTypes() {
        if(!static::$GENERAL_TESTS) static::$GENERAL_TESTS = [
            _wpcc('Post Page')          =>  'test_post',
            _wpcc('Category Page')      =>  'test_category',
        ];

        return static::$GENERAL_TESTS;
    }
}