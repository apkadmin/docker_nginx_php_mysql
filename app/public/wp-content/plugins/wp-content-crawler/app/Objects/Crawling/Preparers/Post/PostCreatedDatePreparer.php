<?php
/**
 * Created by PhpStorm.
 * User: turgutsaricam
 * Date: 02/11/2018
 * Time: 11:36
 */

namespace WPCCrawler\Objects\Crawling\Preparers\Post;


use DateTime;
use WPCCrawler\Constants;
use WPCCrawler\Objects\Crawling\Preparers\Post\Base\AbstractPostBotPreparer;
use WPCCrawler\Objects\Informing\Informer;

class PostCreatedDatePreparer extends AbstractPostBotPreparer {

    /**
     * Prepare the post bot
     *
     * @return void
     */
    public function prepare() {
        $dateSelectors          = $this->bot->getSetting('_post_date_selectors');
        $findAndReplacesForDate = $this->bot->getSetting('_post_find_replace_date');
        $minutesToAdd           = $this->bot->getSetting('_post_date_add_minutes');

        $finalDate = current_time('mysql');

        if($dateSelectors) {
            foreach($dateSelectors as $dateSelector) {
                $attr = isset($dateSelector["attr"]) && $dateSelector["attr"] ? $dateSelector["attr"] : "content";
                if($date = $this->bot->extractData($this->bot->getCrawler(), $dateSelector["selector"], $attr, false, true, true)) {
                    // Apply find-and-replaces
                    $date = $this->bot->findAndReplace($findAndReplacesForDate, $date);

                    // Get the timestamp. If there is a valid timestamp, prepare the date and assign it
                    // to postData
                    if($timestamp = strtotime($date)) {
                        // Get the date in MySQL date format.
                        $finalDate = date(Constants::$MYSQL_DATE_FORMAT, $timestamp);

                        // No need to continue. One match is enough.
                        break;

                    } else {
                        // Notify the user.
                        Informer::addInfo(sprintf(_wpcc('Date %1$s could not be parsed.'), $date))
                            ->addAsLog();
                    }
                }
            }
        }

        // Create a DateTime object for the date so that we can manipulate it as we please.
        $dt = new DateTime($finalDate);

        // Now, manipulate the date if the user defined how many minutes should be added to the date.
        if($minutesToAdd) {
            // Minutes can be comma-separated. Get each minute by making sure they are integers.
            $minutes = array_map(function ($m) {
                return (int) trim($m);
            }, explode(",", $minutesToAdd));

            // If there are minutes, get a random one and add it to the date.
            if($minutes) {
                $dt->modify($minutes[array_rand($minutes)] . " minute");
            }
        }

        // Set the date in postData after formatting it by MySQL date format
        $this->bot->getPostData()->setDateCreated($dt->format(Constants::$MYSQL_DATE_FORMAT));
    }
}