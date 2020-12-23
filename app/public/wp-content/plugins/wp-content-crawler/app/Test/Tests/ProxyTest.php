<?php
/**
 * Created by PhpStorm.
 * User: turgutsaricam
 * Date: 25/10/2018
 * Time: 17:39
 */

namespace WPCCrawler\Test\Tests;


use WPCCrawler\Objects\Crawling\Bot\DummyBot;
use WPCCrawler\Test\Base\AbstractTest;
use WPCCrawler\Test\Data\TestData;
use WPCCrawler\Utils;

class ProxyTest extends AbstractTest {

    private $message;

    /**
     * Conduct the test and return an array of results.
     *
     * @param TestData $data Information required for the test
     * @return array|string|mixed
     */
    protected function createResults($data) {
        // Here, form item values must be a string and it must contain the proxies.
        if(!$data->getFormItemValues() || is_array($data->getFormItemValues())) return null;

        $proxies = $data->getFormItemValues();
        $testUrl = $data->get("url");

        // Create a dummy bot by making sure it will consider the proxies.
        // By this way, we can retrieve the prepared proxy lists from the bot.
        $dummyBot = new DummyBot([
            '_do_not_use_general_settings' => 1,
            '_wpcc_use_proxy' => 1,
            '_wpcc_proxies'   => $proxies,
        ] + $data->getPostSettings());

        $protocol = starts_with($testUrl, "https") ? "https" : "http";

        // Get proxy list for this protocol
        $proxyList = $dummyBot->preparedProxyList;

        $results = [];

        if($testUrl) {
            foreach($proxyList as $proxyUrl) {
                try {
                    // If there is a proxy, create a new client with the proxy settings.
                    $dummyBot->createClient($proxyUrl, $protocol);

                    $crawler = $dummyBot->getClient()->request("GET", $testUrl);

                    // Get the response
                    $response = $dummyBot->getClient()->getInternalResponse();

                    // If the response is not OK, this proxy is failed.
                    if($response->getStatus() != 200) {
                        $results[] = _wpcc("Fail") . ": " . $proxyUrl;
                        continue;
                    }

                    // Try to get the HTML content. If this causes an error, we'll catch it and return null.
                    $crawler->html();

                    $results[] = _wpcc("Success") . ": " . $proxyUrl;

                    // If the connection failed, mark this proxy as failed.
                } catch(\GuzzleHttp\Exception\ConnectException $e) {
                    $results[] = _wpcc("Fail") . ": " . $proxyUrl;

                    // Catch other request exceptions
                } catch(\GuzzleHttp\Exception\RequestException $e) {
                    $results[] = _wpcc("Error") . ": " . $e->getMessage();

                    // Catch all errors
                } catch(\Exception $e) {
                    $results[] = _wpcc("Error") . ": " . $e->getMessage();
                    error_log("Content Crawler - Exception for '{$testUrl}': " . $e->getMessage());
                    break;
                }
            }
        }

        $this->message = sprintf(
            _wpcc('Test results for %1$s:'),
            "<span class='highlight url'>" . $testUrl . "</span>"
        );

        return $results;
    }

    /**
     * Create the view of the response
     *
     * @return \Illuminate\Contracts\View\View|null
     * @throws \Exception
     */
    protected function createView() {
        return Utils::view('partials/test-result')
            ->with("results", $this->getResults())
            ->with("message", $this->message);
    }
}