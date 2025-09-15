# Client Logos Section Guide

## How to Add Client Logos

The `[pces_clients]` shortcode displays client logos in a responsive 4-column grid layout with grayscale effects and hover transitions.

### Step 1: Upload Logo Images to WordPress Media Library

1. Go to WordPress Admin → Media → Add New
2. Upload your client logo images (PNG, JPG, or SVG formats recommended)
3. Make sure images are optimized for web (recommended size: 200x100px or similar aspect ratio)
4. Note the filename of each uploaded image

### Step 2: Update the Logo Filenames Array

Edit the `pces_clients_shortcode()` function in `pces-homepage.php`:

```php
$client_logos = array(
    'client-logo-1.png',    // Replace with actual filename
    'client-logo-2.png',    // Replace with actual filename
    'client-logo-3.png',    // Replace with actual filename
    'client-logo-4.png',    // Replace with actual filename
    'client-logo-5.png',    // Add more as needed
    'client-logo-6.png',
    'client-logo-7.png',
    'client-logo-8.png'
);
```

### Step 3: Use the Shortcode

Add `[pces_clients]` to any WordPress page or post where you want the client logos to appear.

## Features

- **Responsive Layout**: 4 columns on desktop, 2 columns on mobile
- **Grayscale Effect**: Logos appear in grayscale by default
- **Hover Animation**: Logos become full color and slightly scale up on hover
- **Automatic URLs**: The shortcode automatically finds images in the WordPress Media Library
- **Easy Updates**: Just change the filenames in the PHP array to update logos

## Logo Requirements

- **Format**: PNG, JPG, or SVG
- **Size**: Recommended 200x100px (2:1 aspect ratio)
- **Background**: Transparent or white background works best
- **Quality**: High resolution for crisp display on all devices

## Troubleshooting

If logos don't appear:

1. Check that the filename in the array matches exactly with the uploaded file
2. Ensure the image is uploaded to the WordPress Media Library
3. Verify the image file is not corrupted
4. Clear any caching plugins

## Customization

To modify the appearance:

1. Edit the CSS in `assets/css/pces-homepage.css`
2. Look for the `.pces-clients` section
3. Adjust colors, sizes, or effects as needed

The grayscale effect and hover transitions are controlled by these CSS properties:

```css
.client-logo {
    filter: grayscale(100%);  /* Makes logos grayscale */
    opacity: 0.7;             /* Makes logos slightly transparent */
}

.client-logo-wrapper:hover .client-logo {
    filter: grayscale(0%);    /* Removes grayscale on hover */
    opacity: 1;               /* Makes logos fully opaque on hover */
    transform: scale(1.05);   /* Slightly enlarges logos on hover */
}
```