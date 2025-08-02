jQuery(document).ready(function($) {
    $('.stea-product-grid-filter-checkbox').each(function() {
        var $container = $(this);
        var initialShow = parseInt($container.data('initial-show')) || 1;
        var showMoreEnabled = $container.data('show-more') === true || $container.data('show-more') === 'true';
        var isShowingAll = false;
        var isSearching = false;

        var $showMoreBtn = $container.find('.stea-show-more-checkbox-btn');
        var $categoryItems = $container.find('.stea-product-category-filter-checkbox .category-item');
        var $searchInput = $container.find('.stea-filter-search');

        function updateVisibility() {
            var searchText = $searchInput.length ? $searchInput.val().toLowerCase() : '';
            var visibleCount = 0;

            if (searchText === '') {
                isSearching = false;

                $categoryItems.each(function(index) {
                    var $item = $(this);
                    if (!showMoreEnabled || isShowingAll || index < initialShow) {
                        $item.css('display', 'flex').removeClass('stea-hidden-category');
                        visibleCount++;
                    } else {
                        $item.css('display', 'none').addClass('stea-hidden-category');
                    }
                });

                if (showMoreEnabled && $showMoreBtn.length && $categoryItems.length > initialShow) {
                    var remaining = $categoryItems.length - initialShow;
                    $showMoreBtn.show().text(isShowingAll ? 'Show Less' : 'Show More (+' + remaining + ')');
                } else {
                    $showMoreBtn.hide();
                }

            } else {
                isSearching = true;

                $categoryItems.each(function() {
                    var $item = $(this);
                    if ($item.data('search-term').includes(searchText)) {
                        $item.css('display', 'flex').removeClass('stea-hidden-category');
                        visibleCount++;
                    } else {
                        $item.css('display', 'none').addClass('stea-hidden-category');
                    }
                });

                if (showMoreEnabled && visibleCount > initialShow) {
                    $showMoreBtn.show().text('Show Less');
                } else {
                    $showMoreBtn.hide();
                }
            }
        }

        if (showMoreEnabled && $showMoreBtn.length) {
            $showMoreBtn.on('click', function() {
                if (isSearching) return;
                isShowingAll = !isShowingAll;
                updateVisibility();
            });
        }

        if ($searchInput.length) {
            $searchInput.on('keyup', function() {
                updateVisibility();
            });
        }

        updateVisibility();
    });
});
