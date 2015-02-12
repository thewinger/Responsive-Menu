<?php

class RM_Transient {
    
    /**
     * Function to get named cached transient menu
     *
     * @param  string  $name
     * @return string
     * @added 2.3
     */
    
    static function getTransientMenu( $name ) {

        $cachedKey = $name . '_' . get_current_blog_id();
        $cachedMenu = get_transient( $cachedKey );

        if( $cachedMenu === false ) :

            $cachedMenu = self::createTransientMenu( $name );

        
            set_transient( $cachedKey, $cachedMenu );
        
        endif;
        
        return $cachedMenu;
        
    }
    
     /**
     * Function to create named cached transient menu
     *
     * @param  string  $name
     * @return array
     * @added 2.3
     */
    
    static function createTransientMenu( $name ) {
        
        $walker = ResponsiveMenu::getOption( 'RMWalker' );
        
        $cachedMenu = wp_nav_menu( array(
                'menu' => $name,
                'menu_class' => 'responsive-menu',
            
                /* Add by Mkdgs */
                'walker' => ( !empty( $walker ) ) ? new $walker : '',
            
                'echo' => false 
                )
            );
        
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