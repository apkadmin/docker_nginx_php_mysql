<?php
/**
 * Created by PhpStorm.
 * User: turgutsaricam
 * Date: 24/08/16
 * Time: 23:50
 */

namespace WPCCrawler\Objects\Crawling\Bot;


use GuzzleHttp\Psr7\Uri;
use Symfony\Component\DomCrawler\Crawler;
use WPCCrawler\Objects\Crawling\Data\PostData;
use WPCCrawler\PostDetail\PostDetailsService;
use WPCCrawler\Objects\Crawling\Preparers\BotConvenienceFindReplacePreparer;
use WPCCrawler\Objects\Crawling\Preparers\Post\PostCategoryPreparer;
use WPCCrawler\Objects\Crawling\Preparers\Post\PostContentsPreparer;
use WPCCrawler\Objects\Crawling\Preparers\Post\PostCreatedDatePreparer;
use WPCCrawler\Objects\Crawling\Preparers\Post\PostCustomPostMetaPreparer;
use WPCCrawler\Objects\Crawling\Preparers\Post\PostCustomTaxonomyPreparer;
use WPCCrawler\Objects\Crawling\Preparers\Post\PostExcerptPreparer;
use WPCCrawler\Objects\Crawling\Preparers\Post\PostListInfoPreparer;
use WPCCrawler\Objects\Crawling\Preparers\Post\PostMediaPreparer;
use WPCCrawler\Objects\Crawling\Preparers\Post\PostMetaAndTagInfoPreparer;
use WPCCrawler\Objects\Crawling\Preparers\Post\PostPaginationInfoPreparer;
use WPCCrawler\Objects\Crawling\Preparers\Post\PostShortCodeInfoPreparer;
use WPCCrawler\Objects\Crawling\Preparers\Post\PostSlugPreparer;
use WPCCrawler\Objects\Crawling\Preparers\Post\PostTemplatePreparer;
use WPCCrawler\Objects\Crawling\Preparers\Post\PostTitlePreparer;
use WPCCrawler\Objects\Crawling\Preparers\Post\PostTranslationPreparer;
use WPCCrawler\Objects\Traits\ErrorTrait;
use WPCCrawler\Utils;
use WPCCrawler\WPCCrawler;

class PostBot extends AbstractBot {

    use ErrorTrait;

    /** @var Crawler */
    private $crawler;
    
    /** @var PostData */
    private $postData;
    
    /*
     * 
     */

    /** @var array */
    public $combinedListData = [];

    /** @var string */
    private $postUrl = '';

    /** @var null|Uri */
    private $postUri = null;

    /*
     *
     */

    /** @var BotConvenienceFindReplacePreparer|null */
    private $findReplacePreparer = null;

    private $keyLastEmptySelectorEmailDate = '_last_post_empty_selector_email_sent';

    /**
     * Crawls a post and prepares the data as array, does not save the post to the db.
     *
     * @param string $postUrl A full URL
     * @return PostData|null
     */
    public function crawlPost($postUrl) {
        $this->clearErrors();

        $this->setPostUrl($postUrl);
        $this->postData = new PostData();

        $findAndReplacesForRawHtml          = $this->getSetting('_post_find_replace_raw_html');
        $findAndReplacesForFirstLoad        = $this->getSetting('_post_find_replace_first_load');
        $postUnnecessaryElementSelectors    = $this->getSetting('_post_unnecessary_element_selectors');
        $notifyWhenEmptySelectors           = $this->getSetting('_post_notify_empty_value_selectors');

        /**
         * Fires just before the source code of a post page is retrieved from the target site.
         *
         * @param int siteId        ID of the site
         * @param string $postUrl   URL of the post
         * @param PostBot $this     The bot itself
         * @since 1.6.3
         */
        do_action('wpcc/post/source-code/before_retrieve', $this->getSiteId(), $postUrl, $this);

        $this->crawler = $this->request($postUrl, "GET", $findAndReplacesForRawHtml);
        if(!$this->crawler) return null;

        /**
         * Fires just after the source code of a post page is retrieved from the target site.
         *
         * @param int siteId        ID of the site
         * @param string $postUrl   URL of the post
         * @param PostBot $this     The bot itself
         * @param Crawler $crawler  Crawler containing raw, unmanipulated source code of the target post
         * @since 1.6.3
         */
        do_action('wpcc/post/source-code/after_retrieve', $this->getSiteId(), $postUrl, $this, $this->crawler);

        /**
         * Modify the raw crawler that contains source code of the target post page
         *
         * @param Crawler $crawler  Crawler containing raw, unmanipulated source code of the target post
         * @param int siteId        ID of the site
         * @param string $postUrl   URL of the post
         * @param PostBot $this     The bot itself
         *
         * @return Crawler          Modified crawler
         * @since 1.6.3
         */
        $this->crawler = apply_filters('wpcc/post/crawler/raw', $this->crawler, $this->getSiteId(), $postUrl, $this);

        // Make initial replacements
        $this->crawler = $this->makeInitialReplacements($this->crawler, $findAndReplacesForFirstLoad, true);

        // Apply HTML manipulations
        $this->applyFindAndReplaceInElementAttributes($this->crawler, '_post_find_replace_element_attributes');
        $this->applyExchangeElementAttributeValues($this->crawler, '_post_exchange_element_attributes');
        $this->applyRemoveElementAttributes($this->crawler, '_post_remove_element_attributes');
        $this->applyFindAndReplaceInElementHTML($this->crawler, '_post_find_replace_element_html');

        // Resolve relative URLs
        $this->resolveRelativeUrls($this->crawler, $this->getPostUrl());

        // Prepare pagination info
        (new PostPaginationInfoPreparer($this))->prepare();

        // Clear the crawler from unnecessary post elements
        $this->removeElementsFromCrawler($this->crawler, $postUnnecessaryElementSelectors);

        /**
         * Modify the prepared crawler that contains source code of the target post page. At this point, the crawler was
         * manipulated. Unnecessary elements were removed, find-and-replace options were applied, etc.
         *
         * @param crawler Crawler   Crawler containing manipulated source code of the target post
         * @param int siteId        ID of the site
         * @param string $postUrl   URL of the post
         * @param PostBot $this     The bot itself
         *
         * @return Crawler          Modified crawler
         * @since 1.6.3
         */
        $this->crawler = apply_filters('wpcc/post/crawler/prepared', $this->crawler, $this->getSiteId(), $postUrl, $this);

        // Get title
        (new PostTitlePreparer($this))->prepare();

        // Get slug
        (new PostSlugPreparer($this))->prepare();

        // Get excerpt
        (new PostExcerptPreparer($this))->prepare();

        // Get contents
        (new PostContentsPreparer($this))->prepare();

        // Get categories
        (new PostCategoryPreparer($this))->prepare();

        // Get the date
        (new PostCreatedDatePreparer($this))->prepare();

        // Get custom short code contents
        (new PostShortCodeInfoPreparer($this))->prepare();

        // Get list items
        (new PostListInfoPreparer($this))->prepare();

        // Get tags and meta info
        (new PostMetaAndTagInfoPreparer($this))->prepare();

        // Get custom post meta
        (new PostCustomPostMetaPreparer($this))->prepare();

        // Get custom post taxonomies
        (new PostCustomTaxonomyPreparer($this))->prepare();

        // Get source URLs of to-be-saved files and thumbnail image URL
        // This removes gallery images from the source code.
        (new PostMediaPreparer($this))->prepare();

        // Prepare the registered post details
        PostDetailsService::getInstance()->preparePostDetails($this);

        /*
         * TEMPLATING
         */

        // Insert main data into template
        (new PostTemplatePreparer($this))->prepare();

        /*
         * TRANSLATE
         */

        // Translate if it is required
        (new PostTranslationPreparer($this))->prepare();

        /*
         *
         */

        /**
         * Modify the prepared PostData object, which stores all the required data retrieved from the target site.
         *
         * @param PostData $postData Prepared PostData object
         * @param int      siteId    ID of the site
         * @param string   $postUrl  URL of the post
         * @param PostBot  $this     The bot itself
         * @param Crawler  $crawler  Crawler containing manipulated source code of the target post
         * @return PostData     Modified PostData
         * @since 1.6.3
         */
        $this->postData = apply_filters('wpcc/post/post-data', $this->postData, $this->getSiteId(), $postUrl, $this, $this->crawler);

        /*
         * NOTIFY
         */

        // Notify if this is not a test.
        if(!WPCCrawler::isDoingTest() && $notifyWhenEmptySelectors)
            $this->notifyUser($postUrl, $this->crawler, $notifyWhenEmptySelectors, $this->keyLastEmptySelectorEmailDate);

        /**
         * Fires just after the post data is prepared according to the settings. All of the necessary changes were made
         * to the post data, such as removal of unnecessary elements and replacements.
         *
         * @param int      siteId    ID of the site
         * @param string   $postUrl  URL of the post
         * @param PostBot  $this     The bot itself
         * @param PostData $postData The data retrieved from the target site by using the settings configured by the user.
         * @param Crawler  $crawler  Crawler containing the target post page's source code. The crawler was manipulated
         *                           according to the settings.
         * @since 1.6.3
         */
        do_action('wpcc/post/data/after_prepared', $this->getSiteId(), $postUrl, $this, $this->postData, $this->crawler);

        return $this->postData;
    }

    /**
     * Sets {@link $postUrl}
     *
     * @param string $postUrl
     * @since 1.8.0
     */
    private function setPostUrl($postUrl) {
        $this->postUrl = $postUrl;
        $this->postUri = null;
    }

    /*
     * PUBLIC HELPERS
     */

    /**
     * Prepare find-and-replaces by adding config to the supplied find-and-replace array, such as link removal config.
     *
     * @param array $findAndReplaces An array of find and replace options. See
     *                               {@link FindAndReplaceTrait::findAndReplace} to learn more about this array.
     * @return array
     * @uses BotConvenienceFindReplacePreparer::prepare()
     */
    public function prepareFindAndReplaces($findAndReplaces) {
        // If the supplied parameter is not an array, stop and return it.
        if (!is_array($findAndReplaces)) return $findAndReplaces;

        // If the preparer does not exist, create it.
        if (!$this->findReplacePreparer) {
            $this->findReplacePreparer = new BotConvenienceFindReplacePreparer($this);
        }

        // Add the config to the given array.
        return array_merge($findAndReplaces, $this->findReplacePreparer->prepare());
    }

    /*
     * PUBLIC GETTERS AND SETTERS
     */

    /**
     * @return Crawler
     */
    public function getCrawler() {
        return $this->crawler;
    }

    /**
     * @return PostData
     */
    public function getPostData() {
        return $this->postData;
    }

    /**
     * @param PostData $postData
     */
    public function setPostData($postData) {
        $this->postData = $postData;
    }

    /**
     * Get the URL of latest crawled or being crawled post.
     *
     * @return string
     */
    public function getPostUrl() {
        return $this->postUrl;
    }

    /**
     * Resolves a URL by considering {@link $postUrl} as base URL.
     *
     * @param string $relativeUrl Relative or full URL that will be resolved against the current post URL.
     * @return string The given URL that is resolved using {@link $postUrl}
     * @see   PostBot::getPostUrl()
     * @see   Utils::resolveUrl()
     * @since 1.8.0
     * @throws \Exception If post URL that will be used to resolve the given URL does not exist.
     */
    public function resolveUrl($relativeUrl) {
        if (!$this->postUrl) {
            throw new \Exception("Post URL does not exist.");
        }

        // If there is no post URI, create it.
        if ($this->postUri === null) {
            $this->postUri = new Uri($this->postUrl);
        }

        return Utils::resolveUrl($this->postUri, $relativeUrl);
    }
}