<?php
/**
 * Created by PhpStorm.
 * User: turgutsaricam
 * Date: 02/11/2018
 * Time: 11:28
 */

namespace WPCCrawler\Objects\Crawling\Preparers\Post;


use WPCCrawler\Objects\Crawling\Preparers\Post\Base\AbstractPostBotPreparer;
use WPCCrawler\Utils;

class PostExcerptPreparer extends AbstractPostBotPreparer {

    /**
     * Prepare the post bot
     *
     * @return void
     */
    public function prepare() {
        $postExcerptSelectors      = $this->bot->getSetting('_post_excerpt_selectors');
        $findAndReplacesForExcerpt = $this->bot->prepareFindAndReplaces($this->bot->getSetting('_post_find_replace_excerpt'));

        foreach($postExcerptSelectors as $selectorData) {
            $selector = Utils::array_get($selectorData, "selector");
            if (!$selector) continue;

            $attr = Utils::array_get($selectorData, "attr");
            if (!$attr) $attr = 'html';

            if($excerpt = $this->bot->extractData($this->bot->getCrawler(), $selector, $attr, "excerpt", true, true)) {
                $excerpt["data"] = trim($this->bot->findAndReplace($findAndReplacesForExcerpt, $excerpt["data"]));
                $this->bot->getPostData()->setExcerpt($excerpt);

                break;
            }

        }

    }
}