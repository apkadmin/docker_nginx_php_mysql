<?php
/**
 * Created by PhpStorm.
 * User: turgutsaricam
 * Date: 24/08/16
 * Time: 12:16
 */

namespace WPCCrawler\Test;


use WPCCrawler\Test\Base\AbstractGeneralTest;
use WPCCrawler\Test\Base\AbstractTest;
use WPCCrawler\Test\Tests\CalculationTest;
use WPCCrawler\Test\Data\GeneralTestData;
use WPCCrawler\Test\Data\TestData;
use WPCCrawler\Test\Tests\ExchangeElementAttributesTest;
use WPCCrawler\Test\Tests\FileCopyTest;
use WPCCrawler\Test\Tests\FileFindReplaceTest;
use WPCCrawler\Test\Tests\FileMoveTest;
use WPCCrawler\Test\Tests\FileTemplateTest;
use WPCCrawler\Test\Tests\FindReplaceInCustomMetaOrShortCodeTest;
use WPCCrawler\Test\Tests\FindReplaceInElementAttributesTest;
use WPCCrawler\Test\Tests\FindReplaceInElementHtmlTest;
use WPCCrawler\Test\Tests\FindReplaceInRawHtmlTest;
use WPCCrawler\Test\Tests\FindReplaceTest;
use WPCCrawler\Test\General\GeneralCategoryTest;
use WPCCrawler\Test\General\GeneralPostTest;
use WPCCrawler\Test\Tests\ProxyTest;
use WPCCrawler\Test\Tests\RemoveElementAttributesTest;
use WPCCrawler\Test\Tests\SelectorTest;
use WPCCrawler\Test\Tests\SourceCodeTest;
use WPCCrawler\Test\Tests\TemplateTest;
use WPCCrawler\Test\Tests\TranslationTest;

class Test {

    public static $TEST_TYPE_HREF                               = 'test_type_selector_href';
    public static $TEST_TYPE_TEXT                               = 'test_type_selector_text';
    public static $TEST_TYPE_HTML                               = 'test_type_selector_html';
    public static $TEST_TYPE_SRC                                = 'test_type_selector_src';
    public static $TEST_TYPE_FIRST_POSITION                     = 'test_type_selector_first_position';
    public static $TEST_TYPE_FIND_REPLACE                       = 'test_type_find_replace';
    public static $TEST_TYPE_FIND_REPLACE_IN_RAW_HTML           = 'test_type_find_replace_raw_html';
    public static $TEST_TYPE_SELECTOR_ATTRIBUTE                 = 'test_type_selector_attribute';
    public static $TEST_TYPE_SOURCE_CODE                        = 'test_type_source_code';
    public static $TEST_TYPE_PROXY                              = 'test_type_proxy';
    public static $TEST_TYPE_FIND_REPLACE_IN_ELEMENT_ATTRIBUTES = 'test_type_find_replace_in_element_attributes';
    public static $TEST_TYPE_EXCHANGE_ELEMENT_ATTRIBUTES        = 'test_type_exchange_element_attributes';
    public static $TEST_TYPE_REMOVE_ELEMENT_ATTRIBUTES          = 'test_type_remove_element_attributes';
    public static $TEST_TYPE_FIND_REPLACE_IN_ELEMENT_HTML       = 'test_type_find_replace_in_element_html';
    public static $TEST_TYPE_FIND_REPLACE_IN_CUSTOM_META        = 'test_type_find_replace_in_custom_meta';
    public static $TEST_TYPE_FIND_REPLACE_IN_CUSTOM_SHORT_CODE  = 'test_type_find_replace_in_custom_short_code';
    public static $TEST_TYPE_TRANSLATION                        = 'test_type_translation';
    public static $TEST_TYPE_TEMPLATE                           = 'test_type_template';
    public static $TEST_TYPE_CALCULATION                        = 'test_type_calculation';

    public static $TEST_TYPE_FILE_FIND_REPLACE                  = 'test_type_file_find_replace';
    public static $TEST_TYPE_FILE_MOVE                          = 'test_type_file_move';
    public static $TEST_TYPE_FILE_COPY                          = 'test_type_file_copy';
    public static $TEST_TYPE_FILE_TEMPLATE                      = 'test_type_file_template';

    /**
     * @param int $postId           The ID of the site
     * @param string $testType      One of the values of the array TestService::$GENERAL_TESTS
     * @param string $testUrlPart   The URL
     *
     * @return string A response including rendered blade view which can be directly appended to an HTML element, and data
     * @throws \Exception
     */
    public static function respondToGeneralTestRequest($postId, $testType, $testUrlPart) {
        $data = new GeneralTestData($postId, $testType, $testUrlPart);

        /** @var AbstractGeneralTest $test */
        $test = null;
        switch($data->getTestType()) {
            case "test_category":
                $test = new GeneralCategoryTest($data);
                break;

            case "test_post":
                $test = new GeneralPostTest($data);
                break;
        }

        return $test ? $test->run()->getResponse() : null;
    }

    /**
     * Respond to AJAX requests made for testing things.
     *
     * @param array $data  Test data
     * @return null|string If request could not be handled, null. Otherwise, JSON.
     * @throws \Exception
     */
    public static function respondToTestRequest($data) {
        $tests = [
            static::$TEST_TYPE_FIND_REPLACE                       => FindReplaceTest::class,
            static::$TEST_TYPE_SOURCE_CODE                        => SourceCodeTest::class,
            static::$TEST_TYPE_PROXY                              => ProxyTest::class,
            static::$TEST_TYPE_FIND_REPLACE_IN_RAW_HTML           => FindReplaceInRawHtmlTest::class,
            static::$TEST_TYPE_FIND_REPLACE_IN_ELEMENT_ATTRIBUTES => FindReplaceInElementAttributesTest::class,
            static::$TEST_TYPE_EXCHANGE_ELEMENT_ATTRIBUTES        => ExchangeElementAttributesTest::class,
            static::$TEST_TYPE_REMOVE_ELEMENT_ATTRIBUTES          => RemoveElementAttributesTest::class,
            static::$TEST_TYPE_FIND_REPLACE_IN_ELEMENT_HTML       => FindReplaceInElementHtmlTest::class,
            static::$TEST_TYPE_FIND_REPLACE_IN_CUSTOM_META        => FindReplaceInCustomMetaOrShortCodeTest::class,
            static::$TEST_TYPE_FIND_REPLACE_IN_CUSTOM_SHORT_CODE  => FindReplaceInCustomMetaOrShortCodeTest::class,
            static::$TEST_TYPE_TRANSLATION                        => TranslationTest::class,
            static::$TEST_TYPE_TEMPLATE                           => TemplateTest::class,
            static::$TEST_TYPE_CALCULATION                        => CalculationTest::class,

            static::$TEST_TYPE_FILE_FIND_REPLACE                  => FileFindReplaceTest::class,
            static::$TEST_TYPE_FILE_MOVE                          => FileMoveTest::class,
            static::$TEST_TYPE_FILE_COPY                          => FileCopyTest::class,
            static::$TEST_TYPE_FILE_TEMPLATE                      => FileTemplateTest::class,
        ];

        $testData = new TestData($data);

        // Get the test class according to the test type
        if (isset($tests[$testData->getTestType()])) {
            $testClass = $tests[$testData->getTestType()];

        } else {
            // If the test class does not exist, then we assume that it is a selector test.
            // There must exist form item values. Otherwise, return null.
            if(!$testData->getFormItemValues()) return null;

            $testClass = SelectorTest::class;
        }

        /** @var AbstractTest $test */
        $test = new $testClass($testData);

        return $test->run()->getResponse();
    }
    
}