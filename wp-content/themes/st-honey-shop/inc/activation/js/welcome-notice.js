(function ($) {
    "use strict";

    $(document).on('click', '.st-honey-shop-notice .button-primary', function (e) {

        if ('install-activate' === $(this).data('action') && !$(this).hasClass('init')) {
            var $self = $(this),
                $href = $self.attr('href');

            // Ensure the redirect URL is correct
            if ('true' === $self.data('freemius')) {
                $href = $href.replace('st-honey-shop', 'st-demo-importer');
            }

            $self.addClass('init');
            $self.html('Installing ST Demo Importer <span class="st-honey-shop-dot-flashing"></span>');

            var stDemoImporterData = {
                'action': 'sthoneyshop_install_activate_st_demo_importer',
                'nonce': st_honey_shop_localize.st_demo_importer_nonce
            };

            // Send AJAX request to install and activate ST Demo Importer
            $.post(st_honey_shop_localize.ajax_url, stDemoImporterData, function (response) {
                if (response.success) {
                    console.log('ST Demo Importer installed');

                    setTimeout(function () {
                        $self.html('Redirecting to ST Demo Importer <span class="st-honey-shop-dot-flashing"></span>');

                        setTimeout(function () {
                            window.location.href = $href; // Redirect after successful installation
                        }, 1000);
                    }, 500);
                } else {
                    $self.html('Installation Failed');
                    console.error('ST Demo Importer installation failed:', response);
                }
            }).fail(function () {
                $self.html('Installation Failed');
                console.error('AJAX request failed');
            });

            e.preventDefault();
        }
    });

})(jQuery);
