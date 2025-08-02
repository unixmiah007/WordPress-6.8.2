// Admin Dashboard Tabs Js //
document.addEventListener("DOMContentLoaded", function() {
    const menuItems = document.querySelectorAll(".stea-menu li");
    const tabs = document.querySelectorAll(".stea-admin-dash-detail-tab");

    menuItems.forEach(item => {
        item.addEventListener("click", function() {
            menuItems.forEach(el => el.classList.remove("active"));
            this.classList.add("active");

            const target = this.querySelector("a").getAttribute("href").substring(1);
            tabs.forEach(tab => {
                tab.classList.remove("active");
                if (tab.id === target) {
                    tab.classList.add("active");
                }
            });
        });
    });
});

// Save Widgets in option to display on editor //
jQuery(document).ready(function($) {
    $('.toggle input').on('change', function() {
        var widgetName = $(this).data('widget'); // Get widget name
        var widgetStatus = $(this).is(':checked') ? 'on' : 'off';

        $.ajax({
            url: stea_admin_ajax.ajaxurl, 
            type: 'POST',
            data: {
                action: 'stea_save_widget_status',
                widget_name: widgetName,
                widget_status: widgetStatus,
                _ajax_nonce: stea_admin_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Settings saved successfully.',
                        icon: 'success',
                        toast: true,
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to save settings.',
                        icon: 'error'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'AJAX request failed.',
                    icon: 'error'
                });
            }
        });
    });
});


jQuery(document).ready(function($) {
    function filterWidgets() {
        var searchText = $('#stea-widget-search').val().toLowerCase();
        var selectedType = $('.filter-btn.active').data('filter');
        var selectedCategory = $('.stea-wid-category-btn.active').data('category');

        $('.stea-wid-mbg-box').each(function() {
            var widgetTitle = $(this).data('title');
            var widgetType = $(this).data('type');
            var widgetCategories = $(this).data('categories').split(',');

            var matchesSearch = widgetTitle.includes(searchText);
            var matchesType = (selectedType === "all" || widgetType === selectedType);
            var matchesCategory = (selectedCategory === "all" || widgetCategories.includes(selectedCategory));

            if (matchesSearch && matchesType && matchesCategory) {
                $(this).fadeIn();
            } else {
                $(this).fadeOut();
            }
        });
    }

    // Type filter buttons click event
    $('.filter-btn').on('click', function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
        filterWidgets();
    });

    // Category filter buttons click event
    $('.stea-wid-category-btn').on('click', function() {
        $('.stea-wid-category-btn').removeClass('active');
        $(this).addClass('active');
        filterWidgets();
    });

    // Search input keyup event
    $('#stea-widget-search').on('keyup', function() {
        filterWidgets();
    });
});
