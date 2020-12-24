<div class="input-group post-and-image-url {{ isset($remove) ? 'remove' : '' }}"
     @if(isset($dataKey)) data-key="{{ $dataKey }}" @endif>

    <div class="input-container">
        <input type="text" name="{{ $name . '[postUrl]' }}" id="{{ $name . '[postUrl]' }}" placeholder="{{ _wpcc('Post URL...') }}"
               value="{{ isset($value['postUrl']) ? $value['postUrl'] : '' }}"
               class="post-url"
                tabindex="0">

        <input type="text" name="{{ $name . '[imageUrl]' }}" id="{{ $name . '[imageUrl]' }}" placeholder="{{ _wpcc('Featured image URL...') }}"
               value="{{ isset($value['imageUrl']) ? $value['imageUrl'] : '' }}"
               class="image-url"
                tabindex="0">
    </div>
    @if(isset($remove))
        @include('form-items/remove-button')
    @endif
</div>