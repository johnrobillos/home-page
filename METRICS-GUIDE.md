# Growth Metrics Section Guide

## Overview
The `[pces_metrics]` shortcode displays growth charts in a professional 2-column layout that automatically stacks on mobile devices.

## Usage
Simply add the shortcode to any WordPress page or post:
```
[pces_metrics]
```

## Required Images
Upload these images to your WordPress Media Library:

1. **growth-pie-chart.png** - For the pie chart (left column)
2. **growth-bar-chart.png** - For the bar chart (right column)

## How to Update Content

### Changing Chart Images
1. Upload new chart images to WordPress Media Library
2. Edit the plugin file: `pces-homepage.php`
3. Find the `pces_metrics_shortcode` function
4. Update these variables:
   ```php
   $pie_chart_filename = 'your-new-pie-chart.png';
   $bar_chart_filename = 'your-new-bar-chart.png';
   ```

### Changing Section Title
In the same function, update:
```php
$section_title = 'Your New Title Here';
```

### Changing Chart Titles
Update these variables:
```php
$pie_chart_title = 'Your Pie Chart Title';
$bar_chart_title = 'Your Bar Chart Title';
```

## Layout Features

### Desktop Layout
- 2-column layout (50% width each)
- Charts display side by side
- Hover effects on chart images

### Mobile Layout
- Single column layout
- Charts stack vertically
- Responsive image sizing

## Styling
The section uses these CSS classes:
- `.pces-metrics` - Main section container
- `.metrics-chart` - Individual chart container
- `.chart-image` - Chart image styling

## Troubleshooting

### Charts Not Showing
1. Check that images are uploaded to Media Library
2. Verify image filenames match the variables in the code
3. Ensure images are publicly accessible

### Layout Issues
1. Clear browser cache
2. Clear WordPress cache
3. Check for CSS conflicts with theme

## Requirements Met
- ✅ 5.1: Creates `[pces_metrics]` shortcode for chart display
- ✅ 5.2: Sets up 2-column layout for pie chart and bar chart images  
- ✅ 5.3: Adds chart image references with Media Library URLs
- ✅ 5.5: Tests responsive stacking on mobile devices

## Example Output
The shortcode generates clean HTML with Bootstrap classes:
```html
<section class="pces-metrics py-5">
    <div class="container">
        <h2 class="text-center mb-5">Backed by Measurable Growth</h2>
        <div class="row justify-content-center">
            <div class="col-md-6 mb-4">
                <div class="metrics-chart text-center">
                    <h4 class="mb-3">Revenue Growth</h4>
                    <img src="[media-library-url]" alt="Revenue Growth" class="chart-image img-fluid">
                </div>
            </div>
            <!-- Second chart column -->
        </div>
    </div>
</section>
```