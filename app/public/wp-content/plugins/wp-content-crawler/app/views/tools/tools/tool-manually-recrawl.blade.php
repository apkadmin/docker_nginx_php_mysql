@extends('tools.base.tool-container')

@section('title')
    {{ _wpcc('Manually recrawl (update) a post') }}
@overwrite

@section('content')
    <form action="" class="tool-form">
        {{--{!! wp_nonce_field('wcc-tools', \WPCCrawler\Constants::$NONCE_NAME) !!}--}}

        @include('partials.form-nonce-and-action')

        <input type="hidden" name="tool_type" value="recrawl_post">

        <div class="panel-wrap wcc-settings-meta-box">

            <table class="wcc-settings">
                {{-- SITE --}}
                <tr>
                    <td>
                        @include('form-items/label', [
                            'for'   =>  '_wpcc_tools_recrawl_post_id',
                            'title' =>  _wpcc('Post ID'),
                            'info'  =>  _wpcc('Write the ID of the post you want to update.'),
                        ])
                    </td>
                    <td>
                        @include('form-items/text', [
                            'name'          =>  '_wpcc_tools_recrawl_post_id',
                            'type'          =>  'number',
                            'min'           =>  0,
                            'placeholder'   => _wpcc('Post ID...')
                        ])
                    </td>
                </tr>

            </table>

            @include('form-items/submit-button', [
                'text'  =>  _wpcc('Recrawl')
            ])

            @include('partials/test-result-container')
        </div>
    </form>
@overwrite