<div class="description">
    {{ _wpcc('General options. Before applying the options here, the options defined in the find-replace tab will be applied.') }}
</div>

<table class="wcc-settings">
    {{-- TREAT AS JSON --}}
    <tr>
        <td>
            @include('form-items/label', [
                'for'   =>  '_options_box[treat_as_json]',
                'title' =>  _wpcc('Treat as JSON?'),
                'info'  =>  sprintf(_wpcc('If you check this, each item will be tried to be parsed to JSON. You can then
                        use the values from the JSON using <b>[%1$s]</b> short code. When you check this, the item will be
                        removed if it is not a valid JSON.'), \WPCCrawler\Objects\Enums\ShortCodeName::WCC_ITEM) . ' ' . _wpcc_wcc_item_short_code_dot_key_for_json()
            ])
        </td>
        <td>
            @include('form-items/checkbox', [
                'name'  => '_options_box[treat_as_json]'
            ])
        </td>
    </tr>

</table>