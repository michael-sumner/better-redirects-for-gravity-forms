/**
 * @output wp-includes/js/wplink.js
 */

/* global wpLink */

(function ($, wpLinkL10n, wp) {

    // on load if values exist.
    if (
        $('#betterRedirectsGf-field-value-post-id').length &&
        $('#betterRedirectsGf-field-value-post-url').length
    ) {

        function hideResults() {
            $('.js-c-betterRedirectsGf-result').addClass('gform-visually-hidden');
            showButton();
        }

        function showResults() {
            $('.js-c-betterRedirectsGf-result').removeClass('gform-visually-hidden');
            hideButton();
        }

        function hideButton() {
            $('.js-c-betterRedirectsGf-button-selectLink').addClass('gform-visually-hidden').prop('disabled', true);
        }

        function showButton() {
            $('.js-c-betterRedirectsGf-button-selectLink').removeClass('gform-visually-hidden').prop('disabled', false);
        }

        function updateGFormSettingValues(postId, url) {
            $('#betterRedirectsGf-field-value-post-id').val(postId);
            $('#betterRedirectsGf-field-value-post-url').val(url);
        }

        // check gform setting values, exist.
        if ($('#betterRedirectsGf-field-value-post-id').val()) {
            showResults();
        } else {
            hideResults();
        }
        if ($('#betterRedirectsGf-field-value-post-url').val()) {
            showResults();
        } else {
            hideResults();
        }

        $(document.body).on('click', '.js-c-betterRedirectsGf-button-selectLink, .js-c-betterRedirectsGf-result', function () {
            wpLink.open('c-betterRedirectsGf-mce-dummy');
        });
        $(document.body).on('click', '.js-c-betterRedirectsGf-result-remove', function (event) {
            hideResults();
            updateGFormSettingValues('', '');
            event.stopPropagation();
        });

        $(document.body).on('click', '#wp-link-submit', function () {

            // get url from wpLink
            var url, params;
            url = wpLink.getAttrs().href;

            params = {};

            if (url) {
                params.url = url;
            }

            getPostIdFromUrl($(this), params);

            function getPostIdFromUrl(element, params) {

                formData = {
                    'post_url': params.url,
                    'action': 'better_redirects_gf',
                    '_ajax_nonce': better_redirects_gf.nonce,
                };

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: better_redirects_gf.ajax_url,
                    data: formData,
                    beforeSend: function () {
                        element.addClass('button-disabled').prop('disabled', true);
                    },
                    success: function (response) {
                        if (response.success) {
                            var postId;
                            postId = response.data.post_id;

                            // update gform setting values.
                            $('#betterRedirectsGf-field-value-post-id').val(postId);
                            $('#betterRedirectsGf-field-value-post-url').val(url);

                            // update the [name=_gform_setting_url]
                            $('[name=_gform_setting_url]').val(url);

                            // update .js-c-betterRedirectsGf-result html
                            $('.js-c-betterRedirectsGf-result-id').html(postId);
                            $('.js-c-betterRedirectsGf-result-url').attr('href', url).html(url);


                            showResults();
                        }
                    },
                    complete: function () {
                        element.removeClass('button-disabled').prop('disabled', false);
                    }
                });
            }
        });
    }
})(jQuery, window.wpLinkL10n, window.wp);