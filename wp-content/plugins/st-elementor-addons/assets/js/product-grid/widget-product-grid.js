jQuery(document).ready(function ($) {
    $(document).on('click', '.add-to-cart-ajax', function (e) {
        e.preventDefault();

        var button = $(this);
        var productId = button.data('product_id');

        // If the button is already a "View Cart" link, allow redirection
        if (button.hasClass('added-to-cart')) {
            window.location.href = stea_ajax.cart_url;
            return;
        }

        button.addClass('loading');

        $.ajax({
            url: stea_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'add_to_cart',
                product_id: productId,
            },
            success: function (response) {
                if (response.success) {
                    // Update button to 'View Cart' with link to the cart page
                    button.removeClass('loading')
                        .addClass('added-to-cart')
                        .attr('href', stea_ajax.cart_url) // Set the cart page URL
                        .text(stea_ajax.view_cart_text); // Update text to 'View Cart'
                }
            },
            error: function () {
                button.removeClass('loading');
                alert('Something went wrong. Please try again.');
            }
        });
    });
});
