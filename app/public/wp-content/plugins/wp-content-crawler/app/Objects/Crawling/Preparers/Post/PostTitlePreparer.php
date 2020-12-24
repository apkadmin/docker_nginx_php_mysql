<?php
/**
 * Created by PhpStorm.
 * User: turgutsaricam
 * Date: 02/11/2018
 * Time: 11:14
 */

namespace WPCCrawler\Objects\Crawling\Preparers\Post;


use WPCCrawler\Objects\Crawling\Preparers\Post\Base\AbstractPostBotPreparer;
use WPCCrawler\Utils;

class PostTitlePreparer extends AbstractPostBotPreparer {

    /**
     * Prepare the post bot
     *
     * @return void
     */
    public function prepare() {
        $postTitleSelectors      = $this->bot->getSetting('_post_title_selectors');
        $findAndReplacesForTitle = $this->bot->prepareFindAndReplaces($this->bot->getSetting('_post_find_replace_title'));

        foreach($postTitleSelectors as $selectorData) {
            $selector = Utils::array_get($selectorData, "selector");
            if (!$selector) continue;

            $attr = Utils::array_get($selectorData, "attr");
            if (!$attr) $attr = 'text';

            if($title = $this->bot->extractData($this->bot->getCrawler(), $selector, $attr, false, true, true)) {
                $title = $this->bot->findAndReplace($findAndReplacesForTitle, $title);

                $this->bot->getPostData()->setTitle($title);
                break;
            }
        }

    }

}