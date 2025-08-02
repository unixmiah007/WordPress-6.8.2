<div id="nav-panel" class="">
    <?php
    // show top navigation and mobile menu
         $TmOrgan = new TmOrgan();
        global $organ_Options;
        echo tmOrgan_mobile_search();
        if(isset($organ_Options['theme_layout']) && $organ_Options['theme_layout']=='version2')
        {
        echo '<div class="menu-wrap">';
      
        echo tmOrgan_mobile_menu_left().'</div>';
        echo '<div class="menu-wrap">';
      
        echo tmOrgan_mobile_menu_right().'</div>';
        } else {
        echo '<div class="menu-wrap">';
      
        echo tmOrgan_mobile_menu().'</div>';
	}
   
        echo '<div class="menu-wrap">'.tmOrgan_mobile_top_navigation().'</div>';
    ?>
</div>