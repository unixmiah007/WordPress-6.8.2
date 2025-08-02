// jQuery(document).ready(function ($) {
//     var currentPage = 1;
//     var currentCategory = '';
//     var postsPerPage = $('.stea-product-grid').data('posts-per-page') || stea_ajax_filter.posts_per_page;
//     var currentProCat = $('.stea-current-product-category').data('current-product-category');

//     // Handle category change
//     $('#stea-product-category-filter-select').on('change', function () {
//         currentCategory = $(this).val();
//         currentPage = 1;
//         fetchProducts(currentCategory, currentPage, true, null);
//     });

//     // Handle Load More button click
//     $(document).on('click', '#load-more-products', function () {
//         currentPage++;
//         fetchProducts(currentCategory, currentPage, false, $(this));
//     });

//     function fetchProducts(category, page, replaceGrid, button) {
//         // Fetch latest button icon and title
//         var $categoryElement = $('.stea-current-product-category');
//         var buttonTitle = $categoryElement.data('button-title');

//         var buttonIconRaw = $categoryElement.attr('data-button-icon');
//         var buttonIcon;
//         try {
//             buttonIcon = JSON.parse(buttonIconRaw);
//         } catch (e) {
//             buttonIcon = buttonIconRaw;
//         }

//         var data = {
//             action: 'stea_filter_products',
//             security: stea_ajax_filter.nonce,
//             category: category,
//             paged: page,
//             posts_per_page: postsPerPage,
//             current_pro_cat: currentProCat,
//             button_title: buttonTitle,
//             button_icon: JSON.stringify(buttonIcon)
//         };

//         $.ajax({
//             url: stea_ajax_filter.ajax_url,
//             type: 'POST',
//             data: data,
//             beforeSend: function () {
//                 if (replaceGrid) {
//                     $('.stea-product-grid').addClass('loading');
//                 } else if (button) {
//                     button.text('Loading...').prop('disabled', true);
//                 }
//             },
//             success: function (response) {
//                 if (response.success) {
//                     if (replaceGrid) {
//                         $('.stea-product-grid').removeClass('loading').html(response.data.html);
//                         $('.stea-product-grid-load-more-wrap').html(response.data.load_more_html);
//                     } else {
//                         $('.stea-product-grid').append(response.data.html);
//                         $('.stea-product-grid-load-more-wrap').html(response.data.load_more_html);
//                     }
//                 } else {
//                     $('.stea-product-grid').removeClass('loading');
//                     alert(response.data || 'No more products found.');
//                 }
//             },
//             error: function () {
//                 alert('An error occurred while fetching the products.');
//                 if (button) {
//                     button.text('Load More').prop('disabled', false);
//                 }
//             }
//         });
//     }
// });
