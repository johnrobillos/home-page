# PCES Homepage Plugin Installation Guide

## Quick Start

1. **Plugin is already installed** in the correct WordPress directory:
   ```
   /wp-content/plugins/pces-homepage/
   ```

2. **Activate the plugin**:
   - Go to WordPress Admin → Plugins
   - Find "PCES Homepage" in the list
   - Click "Activate"

3. **Use the shortcodes** in any page or post:
   ```
   [pces_hero]
   [pces_services]
   ```

## Testing the Plugin

### Method 1: Create a Test Page
1. Go to WordPress Admin → Pages → Add New
2. Title: "PCES Homepage Test"
3. Add this content:
   ```
   [pces_hero]
   [pces_services]
   ```
4. Publish and view the page

### Method 2: View Test HTML File
- Open: `/wp-content/plugins/pces-homepage/test-shortcodes.html`
- This shows how the shortcodes will look when rendered

## Available Shortcodes

### Hero Section
```
[pces_hero]
```
- Displays company name, tagline, and call-to-action button
- Blue gradient background
- Responsive design

### Services Section  
```
[pces_services]
```
- Shows 6 services in a responsive grid
- Font Awesome icons
- Hover effects

## Updating Content

To modify the content (company name, services, etc.):

1. Open: `/wp-content/plugins/pces-homepage/pces-homepage.php`
2. Find the shortcode function you want to edit
3. Modify the PHP arrays with your content
4. Save the file

### Example: Updating Hero Section
```php
// Find this in pces_hero_shortcode() function:
$company_name = "Philippines Central Engagement Services Inc.";
$tagline = "Created by Filipinos for the Filipinos";
$cta_text = "Learn More";
$cta_link = "#services";
```

### Example: Adding/Removing Services
```php
// Find this in pces_services_shortcode() function:
$services = array(
    array(
        'icon' => 'fas fa-users',
        'title' => 'HR Services',
        'description' => 'Comprehensive human resource solutions...'
    ),
    // Add more services by copying this array structure
);
```

## Troubleshooting

### Plugin Not Showing in Admin
- Check file permissions
- Ensure main plugin file exists: `pces-homepage.php`

### Shortcodes Not Working
- Verify plugin is activated
- Check for PHP errors in WordPress debug log
- Ensure shortcode names are correct: `[pces_hero]` not `[pces-hero]`

### Styling Issues
- Clear browser cache
- Clear WordPress cache (if using caching plugin)
- Check if Bootstrap CSS is loading

### Assets Not Loading
- Check file permissions on assets folder
- Verify CSS/JS files exist in assets directories
- Check browser developer tools for 404 errors

## File Structure
```
pces-homepage/
├── pces-homepage.php          (Main plugin file)
├── README.txt                 (WordPress plugin info)
├── INSTALLATION.md           (This file)
├── test-shortcodes.html      (Test file)
└── assets/
    ├── css/
    │   └── pces-homepage.css (Custom styles)
    └── js/
        └── pces-homepage.js  (Custom JavaScript)
```

## Requirements
- WordPress 5.0 or higher
- PHP 7.4 or higher
- Modern web browser with CSS3 support

## Support
For issues or questions, contact the PCES development team.