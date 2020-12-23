<?php
/**
 * Created by PhpStorm.
 * User: turgutsaricam
 * Date: 02/11/2018
 * Time: 11:31
 */

namespace WPCCrawler\Objects\Crawling\Preparers\Post;


use WPCCrawler\Objects\Crawling\Preparers\Post\Base\AbstractPostBotPreparer;
use WPCCrawler\Utils;

class PostContentsPreparer extends AbstractPostBotPreparer {

    /**
     * Prepare the post bot
     *
     * @return void
     */
    public function prepare() {
        $postContentSelectors = $this->bot->getSetting('_post_content_selectors');

        $allContents = [];
        foreach($postContentSelectors as $selectorData) {
            $selector = Utils::array_get($selectorData, "selector");
            if (!$selector) continue;

            $attr = Utils::array_get($selectorData, "attr");
            if (!$attr) $attr = 'html';

            if($contents = $this->bot->extractData($this->bot->getCrawler(), $selector, $attr, "content", false, true)) {
                $contents = Utils::array_msort($contents, ['start' => SORT_ASC]);

                $allContents = array_merge($allContents, $contents);
            }
        }

        $this->bot->getPostData()->setContents($allContents);
    }
}