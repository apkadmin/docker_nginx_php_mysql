<?php
/**
 * Created by PhpStorm.
 * User: turgutsaricam
 * Date: 26/10/2018
 * Time: 08:34
 */

namespace WPCCrawler\Test\Tests;


use WPCCrawler\Objects\Translation\TextTranslator;
use WPCCrawler\Test\Base\AbstractTest;
use WPCCrawler\Test\Data\TestData;
use WPCCrawler\Utils;

class TranslationTest extends AbstractTest {

    private $message;

    /**
     * Conduct the test and return an array of results.
     *
     * @param TestData $data Information required for the test
     * @return array|string|mixed
     */
    protected function createResults($data) {
        // Here, form item values must be a string and it must contain the test text to be translated.
        if(!$data->getFormItemValues() || is_array($data->getFormItemValues())) return [];

        $text           = $data->getFormItemValues();
        $serviceType    = $data->get("serviceType");
        $from           = $data->get("from");
        $to             = $data->get("to");
        $textTranslator = new TextTranslator([$text]);

        $translated = [];
        $message = '';

        switch($serviceType) {
            case TextTranslator::KEY_GOOGLE_CLOUD_TRANSLATION:
                $projectId  = $data->get("projectId");
                $apiKey     = $data->get("apiKey");

                $translated = $textTranslator->translateWithGoogle($projectId, $apiKey, $to, $from);

                $message = sprintf('<b>%1$s</b>: %2$s, <b>%3$s</b>: %4$s',
                    _wpcc("API Key"), $apiKey, _wpcc("Project ID"), $projectId);

                break;

            case TextTranslator::KEY_MICROSOFT_TRANSLATOR_TEXT:
                $clientSecret = $data->get("clientSecret");

                $translated = $textTranslator->translateWithMicrosoft($clientSecret, $to, $from);

                $message = sprintf('<b>%1$s</b>: %2$s', _wpcc("Client Secret"), $clientSecret);

                break;

            default:
                return [];
        }

        $message = sprintf('<b>%1$s</b>: %2$s, <b>%3$s</b>: %4$s, %5$s',
            _wpcc("From"), ($from == 'detect' ? _wpcc("Detect") : $from), _wpcc("To"), $to, $message);
        $message = _wpcc("Translation test results with") . " " . $message;

        $this->message = $message;

        return $translated;
    }

    /**
     * Create the view of the response
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Exception
     */
    protected function createView() {
        return Utils::view('partials/test-result')
            ->with("results", $this->getResults())
            ->with("message", $this->message);
    }
}