# Growth Metrics Section Guide

## Overview
The `[pces_metrics]` shortcode displays interactive Highcharts in a professional 2-column layout that automatically stacks on mobile devices. This section uses AngularJS + Highcharts for dynamic, interactive data visualization.

## Usage
Simply add the shortcode to any WordPress page or post:
```
[pces_metrics]
```

## Interactive Charts Included

1. **Pie Chart** - Active Job Posts by category (left column)
   - Interactive tooltips showing percentages
   - Color-coded segments for IT, Business, Agriculture, Misc.
   - Filter buttons for future functionality

2. **Bar Chart** - Registered Users growth (top right)
   - Monthly progression data
   - Hover effects with exact values

3. **Line Chart** - Visitor Hits tracking (bottom right)
   - Daily visitor statistics
   - Smooth line visualization

## How to Update Content

### Changing Chart Data
Edit the file: `/assets/js/dashboard-charts.js`

**Pie Chart Data:**
```javascript
data: [
    { name: 'IT', y: 33.3, color: '#1D57A5' },
    { name: 'Business', y: 22.2, color: '#F57D51' },
    { name: 'Agriculture', y: 22.2, color: '#4D960E' },
    { name: 'Misc.', y: 22.3, color: '#F5BC53' }
]
```

**Bar Chart Data:**
```javascript
data: [400, 750, 950, 1000], // Monthly values
categories: ['May', 'Jun', 'Jul', 'Aug'] // Month labels
```

**Line Chart Data:**
```javascript
data: [100, 125, 140, 120, 95, 110, 130, 115], // Daily values
categories: ['1', '2', '3', '4', '5', '6', '7', '8'] // Day labels
```

### Changing Section Title
Edit the file: `/sections/pces_metrics_shortcode.php`
```php
$section_title = 'Your New Title Here';
```

### Changing Chart Titles
In the same file, update:
```php
$pie_chart_title = 'Your Pie Chart Title';
$bar_chart_title = 'Your Bar Chart Title';
$line_chart_title = 'Your Line Chart Title';
```

## Technical Implementation

### Dependencies
The shortcode automatically loads these libraries when used:
- **AngularJS 1.6.9** - For data binding and interactivity
- **Highcharts 11.0.0** - For chart rendering
- **Highcharts-NG** - Angular directive for Highcharts integration

### Layout Features

#### Desktop Layout
- Large pie chart (70% width) on left
- Two smaller charts (30% width) stacked on right
- Interactive hover effects and tooltips
- Professional styling with white cards and shadows

#### Mobile Layout
- Single column layout
- Charts stack vertically
- Responsive sizing maintains readability
- Touch-friendly interactions

## Styling
The section uses these CSS classes:
- `.container-fluid[ng-app="pcesChartsApp"]` - Main section container
- `.chart-card` - Individual chart containers with white background
- `.chart-title` - Chart title styling
- `.btn-outline-primary` - Filter button styling

## Troubleshooting

### Charts Not Loading
1. Check browser console for JavaScript errors
2. Ensure AngularJS and Highcharts are loading properly
3. Verify the shortcode is used correctly: `[pces_metrics]`
4. Clear browser and WordPress cache

### Layout Issues
1. Check for CSS conflicts with theme
2. Ensure Bootstrap 5 is loaded
3. Verify responsive breakpoints are working
4. Check for z-index conflicts with other elements

### Data Not Updating
1. Clear browser cache after editing `/assets/js/dashboard-charts.js`
2. Check JavaScript console for syntax errors
3. Ensure JSON data format is correct

## Performance Notes
- Charts only load when the shortcode is present on the page
- Libraries are loaded from CDN for optimal performance
- AngularJS app is scoped to prevent conflicts

## Requirements Met
- ✅ 5.1: Creates `[pces_metrics]` shortcode for interactive chart display
- ✅ 5.2: Sets up responsive 2-column layout with 3 charts
- ✅ 5.3: Uses Highcharts for professional data visualization
- ✅ 5.4: Implements interactive features (tooltips, hover effects)
- ✅ 5.5: Tests responsive stacking on mobile devices
- ✅ 5.6: Provides easy data update mechanism

## Example Output
The shortcode generates interactive AngularJS application:
```html
<div class="container-fluid py-5" ng-app="pcesChartsApp" ng-controller="ChartsController">
    <h2 class="text-center mb-5">Backed by Measurable Growth</h2>
    <div class="row">
        <div class="col-md-7">
            <div class="chart-card p-4 h-100">
                <h4 class="chart-title">Active Job Posts</h4>
                <highcharts-ng config="pieChartConfig"></highcharts-ng>
                <!-- Filter buttons -->
            </div>
        </div>
        <div class="col-md-5">
            <!-- Bar and Line charts -->
        </div>
    </div>
</div>
```