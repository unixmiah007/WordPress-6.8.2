jQuery(document).ready(function ($) {
    var currentPage = 1;
    var currentCategory = '';
    var postsPerPage = $('.stea-product-grid').data('posts-per-page') || stea_ajax_filter.posts_per_page;
    var currentProCat = $('.stea-current-product-category').data('current-product-category');
    var paginationType = $('.stea-product-grid').data('pagination-type');
    var productcard = $('.stea-product-grid').data('product-card');
    var isLoading = false;

    var buttonTitle = $('.stea-current-product-category').data('button-title');
    var filterBy = $('.stea-product-grid').data('filter-by');
    var currentQueryVars = $('.stea-archive-product-page').data('currentQueryTerm');

    var relatedProIds = [];
    var relatedProIdsRaw = $('.stea-single-product-page').attr('data-related-pro-ids');
    if (relatedProIdsRaw) {
        try {
            relatedProIds = JSON.parse(relatedProIdsRaw);
        } catch (e) {
            console.warn('Invalid JSON in data-related-pro-ids:', relatedProIdsRaw);
        }
    }

    var buttonIconRaw = $('.stea-current-product-category').attr('data-button-icon');
    var buttonIcon;
    try {
        buttonIcon = JSON.parse(buttonIconRaw);
    } catch (e) {
        buttonIcon = buttonIconRaw;
    }

    // Select Category filter
    $('#stea-product-category-filter-select').on('change', function () {
        if (isLoading) return;
        currentCategory = $(this).val();
        currentPage = 1;
        fetchProducts(currentCategory, currentPage, true, null);
    });
    
    // Checkbox filter
    $(document).on('change', '.stea-category-filter', function() {
        if (isLoading) return;
        
        // Get all checked category slugs (excluding "All" if others are checked)
        var selectedCategories = [];
        $('.stea-category-filter:checked').each(function() {
            if ($(this).val() !== "" || $('.stea-category-filter:checked').length === 1) {
                selectedCategories.push($(this).val());
            }
        });
        
        // Determine currentCategory value
        if (selectedCategories.length === 0 || (selectedCategories.length === 1 && selectedCategories[0] === "")) {
            currentCategory = ""; // Show all categories
        } else {
            currentCategory = selectedCategories.filter(function(cat) { return cat !== ""; }).join(',');
        }
        
        // Handle "All Categories" checkbox behavior
        if ($(this).val() === "" && $(this).is(':checked')) {
            $('.stea-category-filter').not(this).prop('checked', false);
        } else if ($(this).val() !== "" && $(this).is(':checked')) {
            $('#stea-category-all').prop('checked', false);
        }
        
        currentPage = 1;
        fetchProducts(currentCategory, currentPage, true, null);
    });

    // Numbered pagination
    $(document).on('click', '.pagination-button', function () {
        if (isLoading) return;
        var page = $(this).data('page');
        currentPage = page;
        fetchProducts(currentCategory, currentPage, true, null);
    });

    // Load more - Modified this part
    $(document).on('click', '#load-more-products', function () {
        if (isLoading) return;
        var nextPage = currentPage + 1; // Always increment current page by 1
        fetchProducts(currentCategory, nextPage, false, $(this));
    });

    function fetchProducts(category, page, replaceGrid, button) {
        isLoading = true;
        currentPage = page; // Update currentPage to the page we're fetching

        var data = {
            action: 'stea_numbered_pagination',
            security: stea_ajax_filter.nonce,
            category: category,
            paged: page,
            posts_per_page: postsPerPage,
            current_pro_cat: currentProCat,
            button_title: buttonTitle,
            button_icon: JSON.stringify(buttonIcon),
            product_filter_by: filterBy,
            current_query_vars: currentQueryVars,
            related_pro_ids: relatedProIds,
            pagination_type: paginationType,
            product_card: productcard,
        };

        $.ajax({
            url: stea_ajax_filter.ajax_url,
            type: 'POST',
            data: data,
            beforeSend: function () {
                if (replaceGrid) {
                    $('.stea-product-grid').addClass('loading');
                } else if (button) {
                    button.text('Loading...').prop('disabled', true);
                }
            },
            success: function (response) {
                if (response.success && response.data.html) {
                    if (replaceGrid) {
                        $('.stea-product-grid').removeClass('loading').html(response.data.html);
                        $('.stea-pagination').html(response.data.pagination_html || '');
                    } else {
                        $('.stea-product-grid').append(response.data.html);
                    }
            
                    // 🔥 Handle load more button - always reset the wrapper
                    if (paginationType === 'load_more') {
                        // First, remove any existing wrapper
                        $('.stea-product-grid-load-more-wrap').remove();
            
                        // Then re-add if available
                        if (response.data.load_more_html && $.trim(response.data.load_more_html) !== '') {
                            $('.stea-product-grid').after(response.data.load_more_html);
                        }
                    }
            
                    updateUrl(category, page);
                } else {
                    $('.stea-product-grid-load-more-wrap').remove();
                }
            },
            error: function () {
                handleError('An error occurred while fetching the products.', button, page, replaceGrid);
            },
            complete: function () {
                isLoading = false;
                if (button) {
                    button.text('Load More').prop('disabled', false);
                }
            }
        });
    }

    function updateUrl(category, page) {
        if (paginationType !== 'page_numbers') return;
        var url = new URL(window.location.href);
        if (category) {
            url.searchParams.set('category', category);
        } else {
            url.searchParams.delete('category');
        }
        url.searchParams.set('page', page);
        window.history.pushState({}, '', url);
    }

    function handleError(message, button, page, replaceGrid) {
        $('.stea-product-grid').removeClass('loading');
        alert(message);
        if (button) {
            button.text('Load More').prop('disabled', false);
        }
        if (!replaceGrid && page > 1) {
            currentPage--;
        }
    }
});