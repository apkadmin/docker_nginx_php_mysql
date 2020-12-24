<div class="description">
    {!! sprintf(
        _wpcc('You can add calculation options for the current value. If the item is a number, the formula you enter
        will be applied to the number. Write %1$s for the current value. For example, if the current value is %2$s and
        you want to multiply it by %3$s, then you can write %4$s. You can use parenthesis to group the expressions. For
        example, %5$s will result in %6$s. Please make sure your mathematical expressions work by using the test button
        next to each option. Note that options created in the find-replace and general tabs will be applied first. If you enter more
        than one formula, a random one will be used. Operators you can use: %7$s'),
            '<b>X</b>',
            '<b>50</b>',
            '<b>2</b>',
            '<b>X * 2</b>',
            '<b>((5 * 7 + 1) / 4^2 - 2) * 10 / X</b>',
            '<b>0.05</b>',
            '<b>+, -, *, /, ^</b>'
        )
    !!}

    {!! sprintf(
        _wpcc('In case of treating the item as JSON, do not use X in the formula. Use <b>[%1$s]</b> short code with a dot key to get the values from JSON.'),
        \WPCCrawler\Objects\Enums\ShortCodeName::WCC_ITEM
    ) !!}
</div>

<table class="wcc-settings">
    {{-- DECIMAL SEPARATOR AFTER --}}
    <tr>
        <td>
            @include('form-items/label', [
                'for'   =>  '_options_box[decimal_separator_after]',
                'title' =>  _wpcc('Decimal separator for result'),
                'info'  =>  _wpcc('Define the decimal separator for the number that will be shown in your site.')
            ])
        </td>
        <td>
            @include('form-items/select', [
                'name'  => '_options_box[decimal_separator_after]',
                'options' => [
                    'dot'   => _wpcc('Dot') . ' (.)',
                    'comma' => _wpcc('Comma') . ' (,)',
                ]
            ])
        </td>
    </tr>

    {{-- USE THOUSANDS SEPARATOR --}}
    <tr>
        <td>
            @include('form-items/label', [
                'for'   =>  '_options_box[use_thousands_separator]',
                'title' =>  _wpcc('Use thousands separator in the result?'),
                'info'  =>  _wpcc('Check this if you want to use thousands separator in the result.')
            ])
        </td>
        <td>
            @include('form-items/checkbox', [
                'name'  => '_options_box[use_thousands_separator]'
            ])
        </td>
    </tr>

    {{-- REMOVE IF NOT NUMERIC --}}
    <tr>
        <td>
            @include('form-items/label', [
                'for'   =>  '_options_box[remove_if_not_numeric]',
                'title' =>  _wpcc('Remove item if it is not numeric?'),
                'info'  =>  _wpcc('Check this if you want to remove the item when its value is not numeric.')
            ])
        </td>
        <td>
            @include('form-items/checkbox', [
                'name'  => '_options_box[remove_if_not_numeric]'
            ])
        </td>
    </tr>

    {{-- PRECISION --}}
    <tr>
        <td>
            @include('form-items/label', [
                'for'   =>  '_options_box[precision]',
                'title' =>  _wpcc('Precision'),
                'info'  =>  _wpcc('How many digits at max there can be after the decimal separator.')
            ])
        </td>
        <td>
            @include('form-items/text', [
                'name'  => '_options_box[precision]',
                'value' => 0,
                'type'  => 'number'
            ])
        </td>
    </tr>

    {{-- FORMULAS --}}
    <tr>
        <td>
            @include('form-items/label', [
                'for'   =>  '_options_box[formulas]',
                'title' =>  _wpcc('Formulas'),
                'info'  =>  _wpcc('Enter the formulas. If you enter more than one, a random one will be used.')
            ])
        </td>
        <td>
            @include('form-items/multiple', [
                'include'       =>  'form-items/text',
                'name'          =>  '_options_box[formulas]',
                'inputKey'      =>  'formula',
                'placeholder'   =>  _wpcc('Formula'),
                'addKeys'       =>  true,
                'remove'        =>  true,
                'addon'         =>  'dashicons dashicons-search',
                'data'          =>  [
                    'testType'  =>  \WPCCrawler\Test\Test::$TEST_TYPE_CALCULATION,
                    'extra'     =>  $dataExtra
                ],
                'test'          =>  true,
                'addonClasses'  => 'wcc-test-calculation',
            ])
            @include('partials/test-result-container')</td>
    </tr>

</table>