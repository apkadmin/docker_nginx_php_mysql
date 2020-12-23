/*!
 * Variation Swatches for WooCommerce - Pro v1.0.55 
 * 
 * Author: Emran Ahmed ( emran.bd.08@gmail.com ) 
 * Date: 7/12/2020, 7:25:01 PM
 * Released under the GPLv3 license.
 */
/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 5);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */,
/* 1 */,
/* 2 */,
/* 3 */,
/* 4 */,
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(6);


/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

jQuery(function ($) {
    Promise.resolve().then(function () {
        return __webpack_require__(7);
    }).then(function () {
        // Init on Ajax Popup :)
        $(document).on('wc_variation_form.wvs', '.variations_form', function () {
            $(this).WooVariationSwatchesPro();
        });
    });
}); // end of jquery main wrapper

/***/ }),
/* 7 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

// ================================================================
// WooCommerce Variation Change
/*global wc_add_to_cart_variation_params, woo_variation_swatches_options */
// ================================================================

var WooVariationSwatchesPro = function ($) {

    var Default = {};

    var WooVariationSwatchesPro = function () {
        function WooVariationSwatchesPro(element, config) {
            _classCallCheck(this, WooVariationSwatchesPro);

            // Assign
            this._el = element;
            this._element = $(element);
            this._config = $.extend({}, Default, config);
            this._generated = {};
            this.product_variations = this._element.data('product_variations');
            this.is_ajax_variation = !this.product_variations;
            this.is_loop = this._element.hasClass('wvs-archive-variation-wrapper');
            this._attributeFields = this._element.find('.variations select');
            // this._wrapper           = this._element.closest('.wvs-pro-product');
            this._wrapper = this._element.closest(woo_variation_swatches_options.archive_product_wrapper);
            this._cart_button = this._wrapper.find('.wvs_add_to_cart_button');
            this._cart_button_ajax = this._wrapper.find('.wvs_ajax_add_to_cart');
            this._cart_button_html = this._cart_button.clone().html();
            // this._image             = this._wrapper.find('.wp-post-image');
            this._image = this._wrapper.find(woo_variation_swatches_options.archive_image_selector);
            this._price = this._wrapper.find('.price');
            this._price_html = this._price.clone().html();
            this._product_id = this._cart_button.data('product_id');
            this._variation_shown = false;

            if ($.trim(woo_variation_swatches_options.archive_add_to_cart_button_selector)) {
                this._cart_button = this._wrapper.find(woo_variation_swatches_options.archive_add_to_cart_button_selector);
                this._cart_button_ajax = this._wrapper.find(woo_variation_swatches_options.archive_add_to_cart_button_selector);
            }

            // Call
            this.init(this.is_ajax_variation, this.is_loop);
            this.onVariationShownHide();
            this.addToCartButton(this.is_ajax_variation);

            if (this.is_loop) {
                this.foundVariation();
                // Archive Page Also
                if (woo_variation_swatches_options.enable_single_variation_preview_archive && woo_variation_swatches_options.enable_single_variation_preview && woo_variation_swatches_options.single_variation_preview_attribute) {
                    this._attributeFieldSingle = this._element.find('.variations select#' + woo_variation_swatches_options.single_variation_preview_attribute);
                    this.changeImages();
                }
            } else {

                if (woo_variation_swatches_options.enable_single_variation_preview && woo_variation_swatches_options.single_variation_preview_attribute) {
                    this._attributeFieldSingle = this._element.find('.variations select#' + woo_variation_swatches_options.single_variation_preview_attribute);
                    this.changeImages();
                }

                if (woo_variation_swatches_options.enable_linkable_variation_url) {
                    this.generateVariationURL();
                }
            }

            $(document).trigger('woo_variation_swatches_pro', [this._element]);
        }

        _createClass(WooVariationSwatchesPro, [{
            key: 'generateVariationURL',
            value: function generateVariationURL() {
                var _this2 = this;

                var url = new URL(window.location.toString());
                var search = url.searchParams.toString();

                var originalUrl = url.origin + url.pathname;

                this._element.on('check_variations.wc-variation-form', function (event) {

                    var attributes = void 0;

                    if (woo_variation_swatches_options.wc_bundles_enabled) {
                        url = new URL(window.location.toString());
                        search = url.searchParams.toString();
                        attributes = _this2.getChosenAttributesBundleSupport();
                    } else {
                        attributes = _this2.getChosenAttributes();
                    }

                    var attributesObject = Object.keys(attributes).reduce(function (attrs, current) {

                        if (attributes[current]) {
                            attrs[current] = attributes[current];
                        }
                        return attrs;
                    }, {});

                    var searchObject = [].concat(_toConsumableArray(new URLSearchParams(search).keys())).reduce(function (attrs, current) {
                        attrs[current] = new URLSearchParams(search).get(current);
                        return attrs;
                    }, {});

                    var data = _extends({}, searchObject, attributesObject);

                    var params = $.param(data);

                    window.history.pushState({}, '', _this2.addQueryArg(originalUrl, params));
                });
            }
        }, {
            key: 'setDefaultImages',
            value: function setDefaultImages() {
                var _this3 = this;

                _.delay(function () {
                    var _this = _this3;
                    var product_variations = _this3._element.data('product_variations');
                    var selectedIndex = void 0;

                    _this3._element.find('ul.variable-items-wrapper.wvs-catalog-variable-wrapper > li:not(.disabled):not(.woo-variation-swatches-variable-item-more)').each(function (i, el) {

                        $(this).off('wvs-selected-item.catalog-image-hover');
                        $(this).off('wvs-selected-item.catalog-image-click');
                        $(this).off('mouseenter.catalog-image-hover');
                        $(this).off('mouseleave.catalog-image-hover');

                        if ($(this).hasClass('selected')) {
                            selectedIndex = i;
                        }

                        if (woo_variation_swatches_options.catalog_mode_event === 'hover') {

                            $(this).on('mouseenter.catalog-image-hover', function (event) {
                                event.stopPropagation();

                                $(this).trigger('click').trigger('focusin');
                                var is_mobile = $('body').hasClass('woo-variation-swatches-on-mobile');

                                if (is_mobile) {
                                    $(this).trigger('touchstart');
                                }
                            });
                        }
                    });
                }, 2);
            }
        }, {
            key: 'onVariationShownHide',
            value: function onVariationShownHide() {
                var _this4 = this;

                this._element.on('show_variation', { variationForm: this._element }, function (event) {
                    _this4._variation_shown = true;
                });

                this._element.on('hide_variation', { variationForm: this._element }, function (event) {
                    _this4._variation_shown = false;
                    _this4.setDefaultImages();

                    if (_this4.is_loop) {
                        _this4.shopResetDisplayedVariation();
                    }
                });
            }
        }, {
            key: 'init',
            value: function init(is_ajax, is_loop) {
                var _this5 = this;

                this.setDefaultImages();
                _.delay(function () {
                    _this5._element.trigger('woo_variation_swatches_pro_init', [_this5, _this5.product_variations]);
                    $(document).trigger('woo_variation_swatches_pro_loaded', [_this5._element, _this5.product_variations]);
                }, 2);
            }
        }, {
            key: 'foundVariation',
            value: function foundVariation() {
                var _this6 = this;

                this._element.on('found_variation.wvs-variation-form', { variationForm: this._element }, function (event, variation) {

                    event.stopPropagation();
                    _this6.variationsImageUpdate(variation);

                    var template = false,
                        $template_html = '',
                        $view_cart_button = _this6._wrapper.find('.added_to_cart'),
                        $view_cart_button2 = _this6._wrapper.find('.added_to_cart_button'),
                        $price = _this6._wrapper.find('.price');

                    if (!variation.variation_is_visible) {
                        template = wp.template('unavailable-variation-template');
                    } else {
                        template = wp.template('wvs-variation-template');
                    }

                    $template_html = template({
                        variation: variation,
                        price_html: $(variation.price_html).unwrap().html() || _this6._price_html
                    });

                    $template_html = $template_html.replace('/*<![CDATA[*/', '');
                    $template_html = $template_html.replace('/*]]>*/', '');

                    $price.html($template_html);

                    _this6._cart_button.data('variation_id', variation.variation_id);
                    _this6._cart_button.data('variation', _this6.getChosenAttributes());

                    // If not catalog mode
                    if (!woo_variation_swatches_options.enable_catalog_mode) {

                        // Cart Text
                        if (woo_variation_swatches_options.archive_add_to_cart_text) {
                            _this6._cart_button.html(woo_variation_swatches_options.archive_add_to_cart_text);
                        } else {
                            if (wc_add_to_cart_variation_params.i18n_add_to_cart.trim()) {
                                _this6._cart_button.text(wc_add_to_cart_variation_params.i18n_add_to_cart);
                            }
                        }

                        // Ajax Add to cart
                        if ('no' === wc_add_to_cart_variation_params.enable_ajax_add_to_cart) {
                            var params = $.param(_extends({}, _this6.getChosenAttributes(), { 'add-to-cart': _this6._product_id, variation_id: variation.variation_id }));

                            // console.log(params)
                            _this6._cart_button.prop('href', _this6.addQueryArg(_this6._cart_button.data('add_to_cart_url'), params));
                        }
                    }

                    // Resetting Buttons
                    _this6._cart_button.removeClass('added');

                    if ($view_cart_button.length > 0) {
                        $view_cart_button.remove();
                    }
                    if ($view_cart_button2.length > 0) {
                        $view_cart_button2.remove();
                    }
                });

                this._element.on('reset_image.wvs-variation-form', { variationForm: this._element }, function (event) {
                    _this6.variationsImageUpdate(false);
                });

                this._element.on('reset_data.wvs-variation-form', { variationForm: this._element }, function (event) {
                    _this6.shopResetDisplayedVariation();
                });
            }
        }, {
            key: 'shopResetDisplayedVariation',
            value: function shopResetDisplayedVariation() {
                var $price = this._wrapper.find('.price'),
                    $view_cart_button = this._wrapper.find('.added_to_cart'),
                    $view_cart_button2 = this._wrapper.find('.added_to_cart_button');

                $price.html(this._price_html);

                this._cart_button.data('variation_id', '');
                this._cart_button.data('variation', '');

                //  If not catalog mode
                if (!woo_variation_swatches_options.enable_catalog_mode) {
                    //
                    if (woo_variation_swatches_options.archive_add_to_cart_select_options) {
                        this._cart_button.html(woo_variation_swatches_options.archive_add_to_cart_select_options);
                    } else {
                        if (wc_add_to_cart_variation_params.i18n_select_options.trim()) {
                            this._cart_button.text(wc_add_to_cart_variation_params.i18n_select_options);
                        }
                    }

                    if ('no' === wc_add_to_cart_variation_params.enable_ajax_add_to_cart) {
                        this._cart_button.prop('href', this._cart_button.data('product_permalink'));
                    }
                }

                // Resetting Buttons
                this._cart_button.removeClass('added');

                if ($view_cart_button.length > 0) {
                    $view_cart_button.remove();
                }
                if ($view_cart_button2.length > 0) {
                    $view_cart_button2.remove();
                }
            }
        }, {
            key: 'variationsImageUpdate',
            value: function variationsImageUpdate(variation) {

                this._image.addClass('wvs-pro-image-load').one('webkitAnimationEnd oanimationend msAnimationEnd animationend webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
                    $(this).removeClass('wvs-pro-image-load');
                });

                if (variation && variation.image && variation.image.thumb_src && variation.image.thumb_src.length > 1) {
                    this._image.wc_set_variation_attr('src', variation.image.thumb_src);
                    this._image.wc_set_variation_attr('height', variation.image.thumb_src_h);
                    this._image.wc_set_variation_attr('width', variation.image.thumb_src_w);
                    this._image.wc_set_variation_attr('srcset', variation.image.thumb_srcset);
                    this._image.wc_set_variation_attr('sizes', variation.image.thumb_sizes);
                    this._image.wc_set_variation_attr('title', variation.image.title);
                    this._image.wc_set_variation_attr('alt', variation.image.alt);
                } else {
                    this._image.wc_reset_variation_attr('src');
                    this._image.wc_reset_variation_attr('width');
                    this._image.wc_reset_variation_attr('height');
                    this._image.wc_reset_variation_attr('srcset');
                    this._image.wc_reset_variation_attr('sizes');
                    this._image.wc_reset_variation_attr('title');
                    this._image.wc_reset_variation_attr('alt');
                }
            }
        }, {
            key: 'addToCartButton',
            value: function addToCartButton() {
                this._cart_button_ajax.off('click.wvs-pro-archive-add-to-cart');
                this._cart_button_ajax.on('click.wvs-pro-archive-add-to-cart', function (event) {

                    var $button = $(this);

                    if (woo_variation_swatches_options.enable_catalog_mode) {
                        return true;
                    }

                    if (!$button.data('variation_id')) {
                        return true;
                    }

                    event.preventDefault(); // Don't move it
                    event.stopPropagation(); // Don't move it

                    $button.removeClass('added');
                    $button.addClass('loading');

                    var data = {
                        action: "wvs_add_variation_to_cart"
                    };

                    $.each($button.data(), function (key, value) {
                        data[key] = value;
                    });

                    // Trigger event.
                    $(document.body).trigger('adding_to_cart', [$button, data]);

                    // Ajax action.
                    $.post(wc_add_to_cart_variation_params.ajax_url.toString(), data, function (response) {
                        if (!response) {
                            return;
                        }

                        if (response.error && response.product_url) {
                            window.location = response.product_url;
                            return;
                        }

                        // Redirect to cart option
                        if (wc_add_to_cart_params.cart_redirect_after_add === 'yes') {
                            window.location = wc_add_to_cart_params.cart_url;
                            return;
                        }

                        // Trigger event so themes can refresh other areas.
                        $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $button]);
                    });
                });
            }
        }, {
            key: 'getChosenAttributesBundleSupport',
            value: function getChosenAttributesBundleSupport() {
                var data = {};
                var count = 0;
                var chosen = 0;

                this._attributeFields.each(function () {
                    var attribute_name = $(this).attr('name');
                    var value = $(this).val() || '';

                    if (value.length > 0) {
                        chosen++;
                    }

                    count++;
                    data[attribute_name] = value;
                });

                return data;
            }
        }, {
            key: 'getChosenAttributes',
            value: function getChosenAttributes() {
                var data = {};
                var count = 0;
                var chosen = 0;

                this._attributeFields.each(function () {
                    var attribute_name = $(this).data('attribute_name') || $(this).attr('name');
                    var value = $(this).val() || '';

                    if (value.length > 0) {
                        chosen++;
                    }

                    count++;
                    data[attribute_name] = value;
                });

                return data;
            }
        }, {
            key: 'addQueryArg',
            value: function addQueryArg(url, query) {
                if (query) {
                    // remove optional leading symbols
                    query = query.trim().replace(/^(\?|#|&)/, '').replace(/(\?|#|&)$/, '');

                    // don't append empty query
                    query = query ? '?' + query : query;

                    var parts = url.split(/[\?\#]/);
                    var start = parts[0];
                    if (query && /\:\/\/[^\/]*$/.test(start)) {
                        // e.g. http://foo.com -> http://foo.com/
                        start = start + '/';
                    }
                    var match = url.match(/(\#.*)$/);
                    url = start + query;
                    if (match) {
                        // add hash back in
                        url = url + match[0];
                    }
                }
                return url;
            }
        }, {
            key: 'onResetDisplayedVariation',
            value: function onResetDisplayedVariation(event) {

                this._element.closest('.product').find('.product_meta').find('.sku').wc_reset_content();
                this._element.closest('.product').find('.product_weight').wc_reset_content();
                this._element.closest('.product').find('.product_dimensions').wc_reset_content();
                this._element.trigger('reset_image');
                this._element.find('.single_variation').slideUp(200).trigger('hide_variation');
            }

            // Single Attribute Change Image

        }, {
            key: 'changeImages',
            value: function changeImages() {
                var _this7 = this;

                // console.log( $._data(this._element[0], 'events') )
                // let events = this._element.data('events');
                var events = $._data(this._element[0], 'events');

                // console.log(events);

                var reset_data_fn = jQuery.extend(true, {}, events.reset_data);

                this._element.on('check_variations.wc-variation-form', function (event) {

                    var variationData = _this7._element.data('product_variations');

                    var allAttributes = _this7.getChosenAttributesAll(),
                        allCurrentAttributes = allAttributes.data,
                        attributes = _this7.getChosenAttributesSingle(),
                        currentAttributes = attributes.data;

                    //  allAttributes.count !== allAttributes.chosenCount && attributes.count === attributes.chosenCount

                    if (attributes.count > 0) {

                        if (allAttributes.count !== allAttributes.chosenCount && attributes.count === attributes.chosenCount) {
                            // this._element.off('reset_data');
                            _this7._element.off('reset_data');
                        } else {

                            _this7._element.off('reset_data');
                            // Reattach Unbinded Event functions
                            for (var key in reset_data_fn) {

                                if (reset_data_fn.hasOwnProperty(key)) {
                                    var fn = reset_data_fn[key];
                                    var namespace = fn.namespace ? '.' + fn.namespace : '';
                                    var data = fn.data ? fn.data : {};
                                    var handler = fn.handler ? fn.handler : function () {};
                                    _this7._element.on('reset_data' + namespace, data, handler);
                                }
                            }

                            // this._element.off('reset_data');
                            /*  this._element.on('reset_data', (event) => {
                                  // this.onResetDisplayedVariation();
                              });
                              this._element.on('reset_data.wvs-variation-form', (event) => {
                                  // this.shopResetDisplayedVariation();
                              });*/
                        }
                    }

                    if (attributes.count > 0 && allAttributes.count !== allAttributes.chosenCount && attributes.count === attributes.chosenCount) {

                        _this7._element.trigger('update_variation_values');

                        var matching_variations = _this7.findMatchingVariations(variationData, currentAttributes),
                            variation = matching_variations.shift();

                        if (variation) {

                            _.delay(function () {

                                _this7._element.trigger('found_variation', [variation]);
                                _this7._element.trigger('hide_variation');

                                // Note: if we trigger "found_variation" client can click add to cart without select
                                /*if (woo_variation_swatches_options.using_custom_gallery_script) {
                                    this._element.trigger('found_variation', [variation]);
                                    this._element.trigger('hide_variation');
                                }
                                else {
                                    if (is_loop) {
                                        this.variationsImageUpdate(variation);
                                    }
                                     this._element.wc_variations_image_update(variation);
                                    this._element.trigger('show_variation', [variation]);
                                }*/
                                _this7._element.trigger('wvs_pro_single_preview_found_variation', [_this7, variation]);
                            }, 50);
                        } else {
                            attributes.chosenCount = 0;

                            _this7._element.trigger('update_variation_values');
                            _this7._element.trigger('reset_data');
                        }
                    }
                });
            }
        }, {
            key: 'getChosenAttributesAll',
            value: function getChosenAttributesAll() {
                var data = {};
                var count = 0;
                var chosen = 0;

                this._attributeFields.each(function () {
                    var attribute_name = $(this).data('attribute_name') || $(this).attr('name');
                    var value = $(this).val() || '';

                    if (value.length > 0) {
                        chosen++;
                    }

                    count++;
                    data[attribute_name] = value;
                });

                return {
                    'count': count,
                    'chosenCount': chosen,
                    'data': data
                };
            }
        }, {
            key: 'getChosenAttributesSingle',
            value: function getChosenAttributesSingle() {
                var data = {};
                var count = 0;
                var chosen = 0;

                this._attributeFieldSingle.each(function () {
                    var attribute_name = $(this).data('attribute_name') || $(this).attr('name');
                    var value = $(this).val() || '';

                    if (value.length > 0) {
                        chosen++;
                    }

                    count++;
                    data[attribute_name] = value;
                });

                return {
                    'count': count,
                    'chosenCount': chosen,
                    'data': data
                };
            }
        }, {
            key: 'findMatchingVariations',
            value: function findMatchingVariations(variations, attributes) {
                var matching = [];
                for (var i = 0; i < variations.length; i++) {
                    var variation = variations[i];

                    if (this.isMatch(variation.attributes, attributes)) {
                        matching.push(variation);
                    }
                }
                return matching;
            }
        }, {
            key: 'isMatch',
            value: function isMatch(variation_attributes, attributes) {
                var match = true;
                for (var attr_name in variation_attributes) {
                    if (variation_attributes.hasOwnProperty(attr_name)) {
                        var val1 = variation_attributes[attr_name];
                        var val2 = attributes[attr_name];
                        if (val1 !== undefined && val2 !== undefined && val1.length !== 0 && val2.length !== 0 && val1 !== val2) {
                            match = false;
                        }
                    }
                }
                return match;
            }
        }], [{
            key: '_jQueryInterface',
            value: function _jQueryInterface(config) {
                return this.each(function () {
                    new WooVariationSwatchesPro(this, config);
                });
            }
        }]);

        return WooVariationSwatchesPro;
    }();

    /**
     * ------------------------------------------------------------------------
     * jQuery
     * ------------------------------------------------------------------------
     */

    $.fn['WooVariationSwatchesPro'] = WooVariationSwatchesPro._jQueryInterface;
    $.fn['WooVariationSwatchesPro'].Constructor = WooVariationSwatchesPro;
    $.fn['WooVariationSwatchesPro'].noConflict = function () {
        $.fn['WooVariationSwatchesPro'] = $.fn['WooVariationSwatchesPro'];
        return WooVariationSwatchesPro._jQueryInterface;
    };

    return WooVariationSwatchesPro;
}(jQuery);

/* harmony default export */ __webpack_exports__["default"] = (WooVariationSwatchesPro);

/***/ })
/******/ ]);