jQuery(document).ready(function($) {
    // Wishlist click handler with SweetAlert2 popup
    $(document).on('click', '.stea-add-to-wishlist', function(e) {
        e.preventDefault();
        
        var button = $(this);
        var productId = button.data('product-id');
        
        // Check if user is logged in
        if (typeof steaWishlist.is_user_logged_in !== 'undefined' && !steaWishlist.is_user_logged_in) {
            Swal.fire({
                title: steaWishlist.i18n.login_required,
                text: steaWishlist.i18n.login_for_wishlist,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: steaWishlist.i18n.login_button,
                cancelButtonText: steaWishlist.i18n.cancel_button,
                customClass: {
                    confirmButton: 'stea-swal-confirm',
                    cancelButton: 'stea-swal-cancel'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = steaWishlist.login_url + '?redirect_to=' + encodeURIComponent(window.location.href);
                }
            });
            return;
        }
        
        // AJAX request to update wishlist
        $.ajax({
            url: steaWishlist.ajax_url,
            type: 'POST',
            data: {
                action: 'stea_update_wishlist',
                product_id: productId,
                security: steaWishlist.nonce
            },
            beforeSend: function() {
                button.addClass('loading');
            },
            success: function(response) {
                if (response.success) {
                    button.toggleClass('added');
                    button.find('i').toggleClass('fa-heart fa-heart-o');
                    
                    // Show success toast
                    Swal.fire({
                        title: response.data.message,
                        icon: 'success',
                        toast: true,
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    Swal.fire({
                        title: steaWishlist.i18n.error,
                        text: response.data.message,
                        icon: 'error'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: steaWishlist.i18n.error,
                    text: steaWishlist.i18n.request_failed,
                    icon: 'error'
                });
            },
            complete: function() {
                button.removeClass('loading');
            }
        });
    });
});