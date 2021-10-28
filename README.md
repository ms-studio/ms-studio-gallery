# MS-Studio Gallery

A WordPress helper plugin for ACF Galleries.

 Usage example: 
 
 ```php
 $gallery = ms_studio_gallery( 'acf_gallery', 'medium' );
 
 if ( !empty( $gallery ) ) {
 
	echo $gallery;
 
 }
```

## Required parameters

As you see in this example, you need to provide two parameters:

- `acf_gallery` is the ACF Field name. Change it according to how you named it in your ACF settings.
- `medium` is the image size that you want to display. It can be any registered image size, such as  thumbnail (150 x 150), medium (300 x 300), medium_large (768px), large (1024px x 1024px).

## FAQ

### Q: How is the output generated?

A: The gallery markup is generated via the WordPress "Gallery" Shortcode.

### Q: I want to generate the markup myself, is this plugin useful for me?

A: Yes, you can do the following:

```php
// Generate gallery with ACF images.
  $img_info = ms_studio_gallery_init( $field, $size );
```

This will provide an array with extended information that you can use to produce your markup.

## Documentation

ACF Gallery field documentation: 
https://www.advancedcustomfields.com/resources/gallery/

WordPress default image sizes:
https://developer.wordpress.org/reference/functions/add_image_size/

The Gallery Shortcode:
https://codex.wordpress.org/Gallery_Shortcode