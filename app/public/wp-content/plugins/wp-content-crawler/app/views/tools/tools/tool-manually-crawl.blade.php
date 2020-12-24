<?php

$transFullUrl = _wpcc('Make sure you entered full URLs. In other words, they should start with "http" or "https".');

?>

@extends('tools.base.tool-container', [
    'id' => 'tool-manual-crawl'
])

@section('title')
    {{ _wpcc('Manually crawl posts by entering their URLs') }}
@overwrite

@section('content')
    <form action="" class="tool-form tool-manual-crawl">
        @include('partials.form-nonce-and-action')

        <input type="hidden" name="tool_type" value="save_post">

        <div class="panel-wrap wcc-settings-meta-box">

            <table class="wcc-settings">
                {{-- SITE --}}
                <tr>
                    <td>
                        @include('form-items/label', [
                            'for'   =>  '_wpcc_tools_site_id',
                            'title' =>  _wpcc('Site'),
                            'info'  =>  _wpcc('Select the site for the post you want to save.'),
                        ])
                    </td>
                    <td>
                        @include('form-items/select', [
                            'name'      =>  '_wpcc_tools_site_id',
                            'options'   =>  $sites,
                        ])
                    </td>
                </tr>

                {{-- CATEGORY --}}
                <tr>
                    <td>
                        @include('form-items/label', [
                            'for'   =>  '_wpcc_tools_category_id',
                            'title' =>  _wpcc('Category'),
                            'info'  =>  _wpcc('Select the category in which you want the post saved.'),
                        ])
                    </td>
                    <td>
                        @include('form-items/category-select', [
                            'name'          =>  '_wpcc_tools_category_id',
                            'categories'    =>  $categories,
                        ])
                    </td>
                </tr>

                {{-- POST URLS--}}
                <tr>
                    <td>
                        @include('form-items/label', [
                            'for'   =>  '_post_urls',
                            'title' =>  _wpcc('Post URLs'),
                            'info'  =>  _wpcc('Enter post URLs. You can add multiple post URLs by writing each of them
                                        in a new line.') . ' ' . $transFullUrl
                        ])
                    </td>
                    <td>
                        @include('form-items/textarea', [
                            'name'          => '_post_urls',
                            'placeholder'   => _wpcc('New line separated post URLs...'),
                            'addKeys'       => true,
                            'showButtons'   => false,
                            'rows'          => 8
                        ])
                    </td>
                </tr>

                {{-- POST AND FEATURED IMAGE URL --}}
                <tr>
                    <td>
                        @include('form-items/label', [
                            'for'   =>  '_post_and_featured_image_urls',
                            'title' =>  _wpcc('Post and Featured Image URLs'),
                            'info'  =>  _wpcc('Enter post URLs and, if exist, their featured image URLs.') . ' ' . $transFullUrl,
                        ])
                    </td>
                    <td>
                        @include('form-items/multiple', [
                            'include'       => 'form-items/post-and-image-url',
                            'name'          => '_post_and_featured_image_urls',
                            'addKeys'       => true,
                        ])
                    </td>
                </tr>

                {{-- RETRIEVE POST URLS FROM CATEGORY URLS --}}
                <tr>
                    <td>
                        @include('form-items/label', [
                            'for'   =>  '_category_urls',
                            'title' =>  _wpcc('Retrieve post URLs from these category URLs'),
                            'info'  =>  _wpcc('Enter category URLs from which the post URLs should be retrieved.'),
                        ])
                    </td>
                    <td>
                        @include('form-items/multiple', [
                            'include'       => 'form-items/text',
                            'name'          => '_category_urls',
                            'addKeys'       => true,
                            'placeholder'   => _wpcc('Category URL...'),
                        ])
                    </td>
                </tr>

                {{-- MAX POSTS TO BE CRAWLED --}}
                <tr>
                    <td>
                        @include('form-items/label', [
                            'for'   =>  '_max_posts_to_be_crawled',
                            'title' =>  _wpcc('Pause after crawling this number of posts'),
                            'info'  =>  _wpcc('How many posts at max you want to be crawled. The crawling will be paused
                                    when the number of URLs that have been crawled reaches this number. This option is
                                    valid only when crawling now. Entering 0 or leaving this empty means unlimited posts.')
                        ])
                    </td>
                    <td>
                        @include('form-items/text', [
                            'name'          => '_max_posts_to_be_crawled',
                            'placeholder'   => _wpcc('Number of posts to be crawled before pausing...'),
                            'type'          => 'number',
                            'min'           => 0
                        ])
                    </td>
                </tr>

                {{-- MAX PARALLEL CRAWLING COUNT --}}
                <tr>
                    <td>
                        @include('form-items/label', [
                            'for'   =>  '_max_parallel_crawling_count',
                            'title' =>  _wpcc('Maximum parallel crawling count'),
                            'info'  =>  sprintf(_wpcc('How many posts can be crawled at the same time? Increasing this number
                                will put additional load onto your server. Default: %1$s'), 1)
                        ])
                    </td>
                    <td>
                        @include('form-items/text', [
                            'name'          => '_max_parallel_crawling_count',
                            'placeholder'   => _wpcc('Max parallel crawling count...'),
                            'type'          => 'number',
                            'min'           => 1
                        ])
                    </td>
                </tr>

                {{-- CLEAR ENTERED URLS WHEN I HIT SUBMIT --}}
                <tr>
                    <td>
                        @include('form-items/label', [
                            'for'   =>  '_manual_crawling_tool_clear_after_submit',
                            'title' =>  _wpcc('Clear entered URLs after I click submit button'),
                            'info'  =>  _wpcc('When you check this, the URLs you have entered into the inputs will be cleared after you
                                    click one of the submit buttons.'),
                        ])
                    </td>
                    <td>
                        @include('form-items/checkbox', [
                            'name' => '_manual_crawling_tool_clear_after_submit',
                        ])
                    </td>
                </tr>

            </table>

            {{-- BUTTONS --}}
            <div class="button-container">
                {{-- CRAWL NOW BUTTON --}}
                @include('form-items/submit-button', [
                    'text'  =>  _wpcc('Crawl now'),
                    'class' => 'crawl-now',
                    'title' => _wpcc('The URLs you entered will be crawled one by one, as soon as you click this. Your browser needs to stay open until all URLs are finished being crawled.'),
                ])

                {{-- ADD TO DATABASE BUTTON --}}
                @include('form-items/submit-button', [
                    'text'  =>  _wpcc('Add to the database'),
                    'class' => 'add-to-database',
                    'title' => _wpcc('The URLs you entered will be added to the database. They will be crawled using your scheduling settings.'),
                ])
            </div>

            @include('partials/test-result-container')

        </div>
    </form>
@overwrite