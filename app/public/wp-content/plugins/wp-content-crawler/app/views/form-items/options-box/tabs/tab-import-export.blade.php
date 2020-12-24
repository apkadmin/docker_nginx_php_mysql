<div class="description">
    {{ _wpcc('Import or export options box settings.') }}
</div>

<table class="wcc-settings">

    {{-- IMPORT SETTINGS --}}
    <tr>
        <td>
            @include('form-items/label', [
                'for'   => '_options_box_import_settings',
                'title' => _wpcc('Import Settings'),
                'info'  => _wpcc('Paste the settings exported from another options box to import. <b>Current settings
                    will be overridden.</b>')
            ])
        </td>
        <td>
            @include('form-items/textarea', [
                'name'          =>  '_options_box_import_settings',
                'placeholder'   =>  _wpcc('Paste settings and click the import button. Note: This will override all settings.')
            ])
            @include('form-items.button', [
                'buttonClass' => 'options-box-import',
                'text' => _wpcc("Import")
            ])
        </td>
    </tr>

    {{-- EXPORT SETTINGS --}}
    <tr>
        <td>
            @include('form-items/label', [
                'for'   => '_options_box_export_settings',
                'title' => _wpcc('Export Settings'),
                'info'  => _wpcc('You can copy the settings here and use the copied code to export settings to
                    another options box.')
            ])
        </td>
        <td>
            @include('form-items/textarea', [
                'name'          =>  '_options_box_export_settings',
                'readOnly'      =>  true,
                'noName'        =>  true,
            ])
        </td>
    </tr>

</table>