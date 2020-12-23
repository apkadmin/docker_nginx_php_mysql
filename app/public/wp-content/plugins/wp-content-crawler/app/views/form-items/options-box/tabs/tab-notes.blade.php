<div class="description">
    {{ _wpcc('You can take notes about the options you configured, or anything. This tab is just for taking notes.') }}
</div>

<table class="wcc-settings">
    <tr>
        <td>
            @include('form-items/textarea', [
                'name'          => '_options_box[note]',
                'rows'          => 6,
                'showButtons'   => false,
                'placeholder'   =>  _wpcc('Notes...'),
            ])
        </td>
    </tr>

</table>