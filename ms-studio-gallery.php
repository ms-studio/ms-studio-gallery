<?php
/**
 * MS-Studio Gallery
 * Plugin Name: MS-Studio Gallery
 * Plugin URI: https://github.com/ms-studio/ms-studio-gallery/
 * Description: Helper plugin for ACF Gallery
 * Version: 2018.11.06
 * Author: Manuel Schmalstieg
 * Author URI: https://ms-studio.net
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

/**

 Usage example: 
 
 $gallery = ms_studio_gallery( 'acf_gallery', 'medium' );
 
 if ( !empty( $gallery ) ) {
 
  echo $gallery;
 
 }
 
*/

 /**
 * Image Gallery Output
 *
 * INPUT:
 * @param string $field : the name of your ACF gallery field.
 * @param string $size : a registered image size.
 *
 * OUTPUT:
 * Returns the HTML markup of the image gallery (or single image).
 * 
 */

function ms_studio_gallery( $field = 'acf_gallery', $size = 'medium') {
  
  // Generate gallery with ACF images.
  $img_info = ms_studio_gallery_init( $field, $size );
  
  // In case of a single image: produce an img tag.
  // In case of several images: produce a gallery.

  if ( !empty($img_info) ) {

    if ( count($img_info) == 1 ) {
    
      foreach ($img_info as $key => $item) {

        return '<img src="'.$item["url-medium"].'" style="width: '.$item["width-medium"].'px; height: '.$item["height-medium"].'px;" class="single-gallery-img">';

      }
      
    } else {
   
      $img_id_array = array();

      foreach ($img_info as $key => $item){
          
        // get id
        $img_id_array[] = $item["id"];
            
        // get medium size
        $img_width_array[] = $item["width-medium"];
      }
        
      $img_id_list = implode(",", $img_id_array);
                
      return do_shortcode( '[gallery ids="'.$img_id_list.'" loop="true" keyboard="true" link=file width='.$img_width_array[0].']' );

    }
        
  } // !empty
    
}


/**
 * Image Gallery Init.
 *
 * INPUT:
 * @param string $field : the name of your ACF gallery field.
 * @param string $size : a registered image size.
 *
 * OUTPUT:
 * @return array $img_info : A functional image gallery array (with more custom size URLs than the ACF Gallery Array).
 * 
 */

function ms_studio_gallery_init( $field = 'acf_gallery', $size = 'thumbnail' ) {

  $img_info = array();
  
  if ( function_exists('get_field') ) {
  
    $images = get_field( $field );
    
  }
          
  if ($images) {
  
    // Test if $images[0] > zero.
    // Reason: the field may be present, but empty.

    if ( $images[0] > 0) {
    
      $has_gallery = true;
      $img_info = ms_studio_gallery_toolbox( $images, $size );
    
    }

  }
    
  return $img_info;

}


/**
 * Image Gallery Array Generator.
 *
 *
 * @param array $img_list : The array produced by ACF Gallery Field.
 * @param string $size : a registered image size (thumbnail, medium, large, full...)
 * 
 * @return array $img_gallery_array : A functional image gallery array (with more custom size URLs than the ACF Gallery Array). 
 */

function ms_studio_gallery_toolbox( $img_list = array(), $size = 'thumbnail' ) {
  
  $img_gallery_array = array();
    
  foreach ( $img_list as $image ) {

    // Test for image mime types
    
    $img_mime_types = array("image/jpeg", "image/png", "image/gif");
        
    if ( !empty ($image["mime_type"] )) {
    
      if (in_array($image["mime_type"], $img_mime_types)) {
      
        $img_gallery_array[] = array( 
          "id" => $image["id"],
          "url-custom" => $image["sizes"][$size],
          "width-custom" => $image["sizes"][$size."-width"],
          "height-custom" => $image["sizes"][$size."-height"],
          
          "url-medium" => $image["sizes"]["medium"],
          "width-medium" => $image["sizes"]["medium-width"],
          "height-medium" => $image["sizes"]["medium-height"],
          
          "url-large" => $image["sizes"]["large"],
          "width-large" => $image["sizes"]["large-width"],
          "height-large" => $image["sizes"]["large-height"],
          
          "caption" => $image["caption"],
          "alt" => $image["alt"],
          "title" => $image["title"],
          // "gallery-title" => $gallery_title,
          // "gallery-descr" => $gallery_description,
        );
        
      } // else: wrong mime type

    } // else: field empty

  } // end foreach

  return $img_gallery_array;

}


