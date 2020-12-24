<?php /** @var \WPCCrawler\Objects\File\MediaFile $item */ ?>
<div class="attachment-item">
    {{-- ITEM --}}
    <div>
        @if($item->isGalleryImage())
            <span class="name">{{ _wpcc("Gallery Item") }}</span>
        @endif
        <span><a href="{{ $item->getLocalUrl() }}" target="_blank"
           @if(isset($tooltip) && $tooltip)
             data-html="true" data-toggle="tooltip" title="<img src='{{ $item->getLocalUrl() }}'>"
           @endif>
            {{ $item->getLocalUrl() }}
        </a></span>
    </div>

    {{-- TITLE --}}
    @include('site-tester.partial.attachment-item-info', [
        'name' => _wpcc('Title'),
        'info' => $item->getMediaTitle()
    ])

    {{-- DESCRIPTION --}}
    @include('site-tester.partial.attachment-item-info', [
        'name' => _wpcc('Description'),
        'info' => $item->getMediaDescription()
    ])

    {{-- CAPTION --}}
    @include('site-tester.partial.attachment-item-info', [
        'name' => _wpcc('Caption'),
        'info' => $item->getMediaCaption()
    ])

    {{-- ALT --}}
    @include('site-tester.partial.attachment-item-info', [
        'name' => _wpcc('Alternate text'),
        'info' => $item->getMediaAlt()
    ])

    {{-- COPY FILES --}}
    @if($item->getCopyFileUrls())
        <div>
            <span class="name">{{ _wpcc('Copy file URLs') }}</span>
            <ol>
                @foreach($item->getCopyFileUrls() as $copyFileUrl)
                    <li>
                        <a href="{{ $copyFileUrl }}" target="_blank"
                        @if(isset($tooltip) && $tooltip)
                            data-html="true" data-toggle="tooltip" title="<img src='{{ $item->getLocalUrl() }}'>"
                        @endif>
                            {{ $copyFileUrl }}</a>
                    </li>
                @endforeach
            </ol>
        </div>
    @endif
</div>