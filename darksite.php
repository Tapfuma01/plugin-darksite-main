<?php
/*
* Plugin Name: Darksite Plugin
* Description: This plugin will activate a darksite for your airline website.
* Version: 1.1.2
* Author: Flux Full Circle
* Author URI: http://fluxfullcircle.com
* License: GPL2
*/

function darksite_settings_page()
{
    add_settings_section("section", "Settings", null, "darksite");
    add_settings_section("section-contact", "Contact Details", null, "darksite");

    add_settings_field("darksite-checkbox", "Activate Darksite", "darksite_checkbox_display", "darksite", "section");
    register_setting("section", "darksite-checkbox");

    add_settings_field( 'darksite-statement', 'Statement', 'darksite_statement_display', 'darksite', 'section' );
    register_setting("section", "darksite-statement");

    add_settings_field( 'darksite-flight', 'Flight Number', 'darksite_flight_display', 'darksite', 'section' );
    register_setting("section", "darksite-flight");

    add_settings_field( 'darksite-contact', 'Emergency Contact Number', 'darksite_contact_display', 'darksite', 'section-contact' );
    register_setting("section-contact", "darksite-contact");

    add_settings_field( 'darksite-media', 'Media Call Center', 'darksite_media_display', 'darksite', 'section-contact' );
    register_setting("section-contact", "darksite-media");
}

function darksite_statement_display() {
    $textarea_value = get_option( 'darksite-statement' );
    
    ?>
         <!-- Here we are comparing stored value with 1. Stored value is 1 if user checks the checkbox otherwise empty string. -->
         <textarea id="darksite-statement" name="darksite-statement" rows="5" cols="50"><?php echo esc_textarea( $textarea_value ); ?></textarea>
    <?php
 }

function darksite_checkbox_display() {
   ?>
        <!-- Here we are comparing stored value with 1. Stored value is 1 if user checks the checkbox otherwise empty string. -->
        <input type="checkbox" name="darksite-checkbox" value="1" <?php checked(1, get_option('darksite-checkbox'), true); ?> />
   <?php
}

function darksite_flight_display() {
    ?>
         <input type="text" id="darksite-flight" name="darksite-flight" value="<?php echo get_option('darksite-flight'); ?>" />
    <?php
 }

function darksite_contact_display() {
    ?>
         <!-- Here we are comparing stored value with 1. Stored value is 1 if user checks the checkbox otherwise empty string. -->
         <input type="text" id="darksite-contact" name="darksite-contact" value="<?php echo get_option('darksite-contact') ?>" />
    <?php
 }

 function darksite_media_display() {
    ?>
         <!-- Here we are comparing stored value with 1. Stored value is 1 if user checks the checkbox otherwise empty string. -->
         <input type="text" id="darksite-media" name="darksite-media" value="<?php echo get_option('darksite-media') ?>" />
    <?php
 }

add_action("admin_init", "darksite_settings_page");

function darksite_page() {

// Check if the user has the necessary permissions
if (!current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient permissions to access this page.'));
}

  ?>
      <div class="wrap">
         <h1>Darksite</h1>
 
         <form method="post" action="options.php">
            <?php
               settings_fields("section");
 
               do_settings_sections("darksite");

               do_settings_sections("section-contact");
               
                 
               submit_button();
            ?>
         </form>
      </div>
   <?php
}

function menu_item()
{
  add_submenu_page("options-general.php", "Darksite", "Darksite", "manage_options", "darksite", "darksite_page");
}
 
add_action("admin_menu", "menu_item");


wp_insert_term('darksite', 'category', array(
    'description' => 'Darksite Blogs',
    'slug' => 'darksite'
));

wp_insert_term('press-release', 'category', array(
    'description' => 'Darksite Press Releases',
    'slug' => 'press-release'
));

$activate = get_option('darksite-checkbox');

if($activate == 1) {

function dl_enqueue_assets () {
    wp_enqueue_style( 'functionality-styles', plugin_dir_url( __FILE__ ) . 'styling/style.css' );
    wp_enqueue_script( 'functionality-scripts', plugin_dir_url( __FILE__ ) . 'styling/script.js', array('jquery') );
}
add_action ("wp_enqueue_scripts", "dl_enqueue_assets");

// action fixed button
function pop_up (){
    $textarea_value = get_option( 'darksite-statement' );
    $contact_value = get_option( 'darksite-contact' );
    $media_value = get_option( 'darksite-media' );

    ?>
    <div id="darksitePopUp" class="darksite_pop-up">
        <div class="darksite_content">
            <span id="darksiteCloseBtn" class="darksite_close-btn">
                Continue to fedair.com
            </span>
            <img class="darksite_content-logo" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/fedair-logo.svg
            '; ?>" />
            <div class="tabs">
                <ul id="tabs-nav">
                    <li><a href="#tab1">Home</a></li>
                    <li><a href="#tab2">Latest Updates</a></li>
                    <li><a href="#tab3">Press Releases</a></li>
                </ul> <!-- END tabs-nav -->
                <div id="tabs-content">
                    <div id="tab1" class="tab-content">
                        <div class="darksite_contain">
                            <div class="darksite_content-wrap">
                                <div class="darksite_content-header">
                                        <h1>
                                            Our Statement
                                        </h1>
                                        <p>
                                            <?php echo esc_textarea( $textarea_value ); ?>
                                        </p>
                                </div>
                                <div class="darksite_content-posts">

                                    <?php
                                        $flight = get_option('darksite-flight');
                                        $args = array(
                                        'post_type'=> 'post',
                                        'orderby'    => 'ID',
                                        'category_name' => 'darksite',
                                        'post_status' => 'publish',
                                        'order'    => 'DESC',
                                        'posts_per_page' => 3 // this will retrive all the post that is published 
                                        );
                                        $result = new WP_Query( $args );
                                        if ( $result-> have_posts() ) : ?>
                                        <h1>
                                            Latest Updates
                                        </h1>
                                            <?php if ( $flight ) : ?>
                                            <div class="darksite_post-section">
                                                <span>Updates of Fastjet Flight <?php echo $flight ?></span>
                                            </div>
                                            <?php endif; ?>
                                        <?php while ( $result->have_posts() ) : $result->the_post(); ?>
                                        <div class="darksite_post">
                                            <a href="<?php the_permalink(); ?>">
                                                <span class="darksite_post-date"><b>Last Updated:</b> <?php the_time( 'j F y, g:i a' ) ?></span>
                                                <p><?php echo wp_trim_words( get_the_content(), 15, '...' ); ?></p>
                                                <span class="darksite_post-btn">Read More</span>
                                            </a>
                                        </div> 
                                        <?php endwhile; ?>
                                        <?php endif; wp_reset_postdata(); ?>
                                </div>
                            </div>
                            <div class="darksite_sidebar-wrap">
                                <img class="darksite_content-ribbon" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/black-ribbon.png'; ?>" />
                                <span class="darksite_sidebar-title">
                                    Emergency Call Centre
                                </span>
                                <span class="darksite_sidebar-content">
                                    Tel:<?php echo $contact_value ?>
                                </span>
                                <span class="darksite_sidebar-title">
                                    Media Call Centre
                                </span>
                                <span class="darksite_sidebar-content">
                                    Tel:<?php echo $media_value ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div id="tab2" class="tab-content">
                        <div class="darksite_contain">
                                <div class="darksite_content-wrap">
                                    <div class="darksite_content-posts">
                                        <h1>
                                            Latest Updates
                                        </h1>

                                        <?php
                                            $flight = get_option('darksite-flight');
                                            $args = array(
                                            'post_type'=> 'post',
                                            'orderby'    => 'ID',
                                            'category_name' => 'darksite',
                                            'post_status' => 'publish',
                                            'order'    => 'DESC',
                                            'posts_per_page' => -1 // this will retrive all the post that is published 
                                            );
                                            $result = new WP_Query( $args );
                                            if ( $result-> have_posts() ) : ?>
                                                <?php if ( $flight ) : ?>
                                                    <div class="darksite_post-section">
                                                        <span>Updates of Fedair Flight <?php echo $flight ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            <?php while ( $result->have_posts() ) : $result->the_post(); ?>
                                            <div class="darksite_post">
                                                <a href="<?php the_permalink(); ?>">
                                                    <span class="darksite_post-date"><b>Last Updated:</b> <?php the_time( 'j F y, g:i a' ) ?></span>
                                                    <p><?php echo wp_trim_words( get_the_content(), 15, '...' ); ?></p>
                                                    <span class="darksite_post-btn">Read More</span>
                                                </a>
                                            </div> 
                                            <?php endwhile; ?>
                                            <?php endif; wp_reset_postdata(); ?>
                                    </div>
                                </div>
                                <div class="darksite_sidebar-wrap">
                                    <img class="darksite_content-ribbon" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/black-ribbon.png'; ?>" />
                                    <span class="darksite_sidebar-title">
                                        Emergency Call Centre
                                    </span>
                                    <span class="darksite_sidebar-content">
                                        Tel:<?php echo $contact_value ?>
                                    </span>
                                    <span class="darksite_sidebar-title">
                                        Media Call Centre
                                    </span>
                                    <span class="darksite_sidebar-content">
                                        Tel:<?php echo $media_value ?>
                                    </span>
                                </div>
                        </div>
                    </div>
                    <div id="tab3" class="tab-content">
                    <div class="darksite_contain">
                                <div class="darksite_content-wrap">
                                    <div class="darksite_content-posts">
                                        <h1>
                                            Press Releases
                                        </h1>

                                        <?php
                                            $flight = get_option('darksite-flight');
                                            $args = array(
                                            'post_type'=> 'post',
                                            'orderby'    => 'ID',
                                            'category_name' => 'press-release',
                                            'post_status' => 'publish',
                                            'order'    => 'DESC',
                                            'posts_per_page' => -1 // this will retrive all the post that is published 
                                            );
                                            $result = new WP_Query( $args );
                                            if ( $result-> have_posts() ) : ?>
                                                 <?php if ( $flight ) : ?>
                                                    <div class="darksite_post-section">
                                                        <span>Press Releases for Fastjet Flight <?php echo $flight ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            <?php while ( $result->have_posts() ) : $result->the_post(); ?>
                                            <div class="darksite_post">
                                                <a href="<?php the_permalink(); ?>">
                                                    <span class="darksite_post-date"><b>Last Updated:</b> <?php the_time( 'j F y, g:i a' ) ?></span>
                                                    <p><?php echo wp_trim_words( get_the_content(), 15, '...' ); ?></p>
                                                    <span class="darksite_post-btn">Read More</span>
                                                </a>
                                            </div> 
                                            <?php endwhile; ?>
                                            <?php endif; wp_reset_postdata(); ?>
                                    </div>
                                </div>
                                <div class="darksite_sidebar-wrap">
                                    <img class="darksite_content-ribbon" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/black-ribbon.png'; ?>" />
                                    <span class="darksite_sidebar-title">
                                        Emergency Call Centre
                                    </span>
                                    <span class="darksite_sidebar-content">
                                        Tel:<?php echo $contact_value ?>
                                    </span>
                                    <span class="darksite_sidebar-title">
                                        Media Call Centre
                                    </span>
                                    <span class="darksite_sidebar-content">
                                        Tel:<?php echo $media_value ?>
                                    </span>
                                </div>
                        </div>
                    </div>
                </div> <!-- END tabs-content -->
            </div> <!-- END tabs -->
        </div>
    </div>
    <div id="darksitePopUpReopen" class="darksite-reopen" style="display:none;">
        <div class="darksite-reopen__content">
            <span id="darksitePopupReopenBtn" class="darksite-reopen__btn">
                Open Popup
            </span>
        </div>
    </div>
<?php
}
add_action ("wp_body_open","pop_up");
} else {

}