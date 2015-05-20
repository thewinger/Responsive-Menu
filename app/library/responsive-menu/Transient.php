<?php

class RM_Transient {
    
    /**
     * Function to get named cached transient menu
     *
     * @param  array  $options 
     * @return string
     * @added 2.3
     * @edited 2.4 - Added option to use transient caching
     * @edited 2.5 - change Mkdgs: first argument is the entire array of options
     */
    static function getTransientMenu($options) {
        $Transient = ResponsiveMenu::getOption('RMUseTran');
        $cachedMenu = false;
        
        if ($Transient) :
            $cachedKey = $name . '_' . get_current_blog_id();
            $cachedMenu = get_transient($cachedKey);
            
        endif;
        
        if ($cachedMenu === false) :
            $cachedMenu = self::createTransientMenu($options);
            if ($Transient)
                set_transient($cachedKey, $cachedMenu);

        endif;

        return $cachedMenu;
    }
    
    /**
     * Function to create named cached transient menu
     *
     * @param  array  $options 
     * @return array
     * @added 2.3
     * @edited 2.5 - change Mkdgs: first argument is the entire array of options
     */
    static function createTransientMenu($options) {       
        $menu_options = array(
            'theme_location' => $options['RMThemeLocation'], 
            'menu' => $options['RM'],
            'menu_class' => 'responsive-menu',
            'walker' => (!empty($options['RMWalker']) ) ? new $options['RMWalker'] : '', // Add by Mkdgs
            'echo' => false
        );   
        $cachedMenu = wp_nav_menu($menu_options);
        return $cachedMenu;
    }
    
    /**
     * Function to clear all transient menus
     *
     * @return null
     * @added 2.3
     */
    
    static function clearTransientMenus() {
        
        if( ResponsiveMenu::hasMenus() ) :

            foreach( ResponsiveMenu::getMenus() as $menu ) :

                delete_transient( $menu->slug . '_' . get_current_blog_id() );

            endforeach;

        endif;
        
    }
    
}
