/**
 * Illia Neiman
 *
 * NOTICE OF LICENSE
 *
 * According to LICENCE file you are not allowed to copy, use or recreate this file in any ways.
 * Specially for eCommerce usage.
 *
 * @category Ineiman
 * @package CustomerNickname
 * @copyright Copyright (c) 2021-current Ineiman (https://github.com/illyaneiman)
 * @email kg.illya.ney@gmail.com
 */

define([
    'jquery'
], function ($) {
    'use strict';

    let errorTmplt = '<div id="customer_nickname-error" class="mage-error">This Nickname already in use.</div>';

    return function (config) {
        let id = config.id;
        let validateUrl = config.validateUrl;
        let attributeCode = config.attributeCode;

        $(id).on('change', function (params) {
            $.ajax({
                showLoader: true,
                url: validateUrl,
                data: {
                    'attributeCode': attributeCode,
                    'attributeCodeValue': $(id)[0].value
                },
                type: "POST"
            }).done(function (data) {
                hideError(id)
                if (data['success'] === false) {
                    showError(id)
                }
            });
        })

        function showError(id) {
            $(id).parent().append(errorTmplt);
        }

        function hideError() {
            $(id).parent().find('#customer_nickname-error').remove();
        }
    }
})
