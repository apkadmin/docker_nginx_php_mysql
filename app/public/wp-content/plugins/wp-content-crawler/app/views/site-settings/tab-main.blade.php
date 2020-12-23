<div class="wcc-settings-title">
    <h3>{{ _wpcc('Main Settings') }}</h3>
    <span>{{ _wpcc('Set main page URL, scheduling options, duplicate post checking, cookies...') }}</span>
</div>

{{-- SECTION NAVIGATION --}}
@include('partials.tab-section-navigation')

<table class="wcc-settings">
    {{-- SITE URL --}}
    <tr>
        <td>
            @include('form-items/label', [
                'for'   => '_main_page_url',
                'title' => _wpcc('Site URL'),
                'info'  => _wpcc('Main URL of the site. E.g. <span class="highlight url">http://wordpress.org</span>.
                    You must fill this field.')
            ])
        </td>
        <td>@include('form-items/text', ['name' => '_main_page_url', 'type' => 'url'])</td>
    </tr>

    {{-- ACTIVE SCHEDULING --}}
    <tr>
        <td>
            @include('form-items/label', [
                'for'   =>  '_active',
                'title' =>  _wpcc('Active for scheduling?'),
                'info'  =>  _wpcc('If you want to activate this site for crawling, check this. If you do not check this,
                    the site will not be crawled, no posts will be saved.')
            ])
        </td>
        <td>
            <div class="inputs">
                @include('form-items/checkbox', [
                    'name'          => '_active'
                ])
            </div>
        </td>
    </tr>

    {{-- ACTIVE RECRAWLING --}}
    <tr>
        <td>
            @include('form-items/label', [
                'for'   =>  '_active_recrawling',
                'class' =>  'label-recrawl',
                'title' =>  _wpcc('Active for recrawling?'),
                'info'  =>  _wpcc('If you want to activate this site for post recrawling, check this. If you do not check this,
                    the posts will not be recrawled.')
            ])
        </td>
        <td>
            <div class="inputs">
                @include('form-items/checkbox', [
                    'name'          => '_active_recrawling'
                ])
            </div>
        </td>

    {{-- ACTIVE POST DELETING --}}
    <tr>
        <td>
            @include('form-items/label', [
                'for'   =>  '_active_post_deleting',
                'class' =>  'label-post-deleting',
                'title' =>  _wpcc('Active for post deleting?'),
                'info'  =>  _wpcc('If you want to activate this site for post deleting, check this. If you do not check
                    this, the posts will not be deleted.')
            ])
        </td>
        <td>
            <div class="inputs">
                @include('form-items/checkbox', [
                    'name'          => '_active_post_deleting'
                ])
            </div>
        </td>
    </tr>

    {{-- ACTIVE TRANSLATION --}}
    <tr>
        <td>
            @include('form-items/label', [
                'for'   =>  '_active_translation',
                'class' =>  'label-post-translation',
                'title' =>  _wpcc('Active for post translation?'),
                'info'  =>  _wpcc('If you want to activate this site for post translation, check this. If you do not check
                    this, the posts will not be translated.')
            ])
        </td>
        <td>
            <div class="inputs">
                @include('form-items/checkbox', [
                    'name'          => '_active_translation'
                ])
            </div>
        </td>
    </tr>

    {{-- DUPLICATE CHECKING --}}
    <tr>
        <td>
            @include('form-items/label', [
                'for'   =>  '_duplicate_check_types',
                'title' =>  _wpcc('Check duplicate posts via'),
                'info'  =>  _wpcc('Set how to decide whether a post is duplicate or not. Duplicate checking will be
                    performed in this order: URL, title, content. If one of them is found, the post is considered as
                    duplicate.')
            ])
        </td>
        <td>
            <div class="inputs">
                <?php
                    $duplicatePostCheckTypes = \WPCCrawler\Objects\Crawling\Savers\PostSaver::getDuplicateCheckOptionsForSelect($settings);
                    $duplicatePostViewOptions = [
                        'name' => '_duplicate_check_types',
                        'options' => $duplicatePostCheckTypes["values"],
                    ];

                    // Set the default values if this is a new site that is being created right now. Otherwise, we'll
                    // use the settings saved previously.
                    if(!isset($_GET["post"]) || !$_GET["post"]) {
                        $duplicatePostViewOptions['value'] = $duplicatePostCheckTypes["defaults"];
                    }

                ?>
                @include('form-items/multi-checkbox', $duplicatePostViewOptions)
            </div>
        </td>
    </tr>

    {{-- USE CUSTOM GENERAL SETTINGS --}}
    <tr>
        <td>
            @include('form-items/label', [
                'for'   =>  '_do_not_use_general_settings',
                'title' =>  _wpcc('Use custom general settings?'),
                'info'  =>  _wpcc('If you want to specify different settings for this site (not use general settings),
                    check this. When you check this, settings tabs will appear.')
            ])
        </td>
        <td>
            <div class="inputs">
                @include('form-items/checkbox', [
                    'name'          => '_do_not_use_general_settings',
                    'dependants'    => '["[data-tab=\'#tab-general-settings\']"]',
                ])
            </div>
        </td>
    </tr>

    {{-- COOKIES --}}
    <tr>
        <td>
            @include('form-items/label', [
                'for'   => '_cookies',
                'title' => _wpcc('Cookies'),
                'info'  => _wpcc('You can provide cookies that will be attached to every request. For example, you can
                    provide a session cookie to crawl a site by a logged-in user.')
            ])
        </td>
        <td>
            @include('form-items/multiple', [
                'include'           => 'form-items/key-value',
                'name'              => '_cookies',
                'addKeys'           => true,
                'keyPlaceholder'    => _wpcc('Cookie name'),
                'valuePlaceholder'  => _wpcc('Cookie content'),
            ])
            @include('partials/test-result-container')
        </td>
    </tr>

    {{-- SECTION: SETTINGS PAGE --}}
    @include('partials.table-section-title', ['title' => _wpcc("Settings Page")])

    {{-- USE CACHE FOR TEST URLS --}}
    @include('form-items.combined.checkbox-with-label', [
        'name' => '_cache_test_url_responses',
        'title' => _wpcc('Use cache for test URLs'),
        'info' => _wpcc('Check this if you want the plugin to cache the responses retrieved from the test URLs. By this
            way, you can test faster and send less number of requests to the target site. Caching will only be done for
            the tests done here in site settings.'),
    ])

    {{-- FIX TABS --}}
    @include('form-items.combined.checkbox-with-label', [
        'name' => '_fix_tabs',
        'title' => _wpcc('Fix tabs when page is scrolled down'),
        'info' => _wpcc('Check this if you want to fix the tabs at the top of the page when the page is scrolled down.'),
    ])

    {{-- FIX CONTENT NAVIGATION --}}
    @include('form-items.combined.checkbox-with-label', [
        'name' => '_fix_content_navigation',
        'title' => _wpcc('Fix content navigation when page is scrolled down'),
        'info' => _wpcc('Check this if you want to fix the content navigation at the top of the page when the page is
            scrolled down.'),
    ])

    <?php

    /**
     * Fires before closing table tag in main tab of site settings page.
     *
     * @param array $settings   Existing settings and their values saved by user before
     * @param int $postId       ID of the site
     * @since 1.6.3
     */
    do_action('wpcc/view/site-settings/tab/main', $settings, $postId);

    ?>

</table>