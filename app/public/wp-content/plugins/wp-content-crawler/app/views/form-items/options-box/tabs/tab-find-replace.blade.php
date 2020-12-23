<div class="description">
    {{ _wpcc("Find and replace in each item. These options will be applied before any changes are made to the current item.") }} {!! _wpcc_trans_regex() !!}
</div>

<table class="wcc-settings">
    <tr>
        <td>
            @include('form-items/multiple', [
                'include'       =>  'form-items/find-replace',
                'name'          =>  '_options_box[find_replace]',
                'addKeys'       =>  true,
                'remove'        =>  true,
                'addon'         =>  'dashicons dashicons-search',
                'data'          =>  [
                    'testType'  =>  \WPCCrawler\Test\Test::$TEST_TYPE_FIND_REPLACE,
                    'extra'     =>  $dataExtra
                ],
                'test'          => true,
                'addonClasses'  => 'wcc-test-find-replace'
            ])
            @include('partials/test-result-container')</td>
    </tr>

</table>