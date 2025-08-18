<?php
// Chart image filenames - easy to edit by modifying these variables
$pie_chart_filename = 'growth-pie-chart.png';
$bar_chart_filename = 'growth-bar-chart.png';

// Section content - easy to edit
$section_title = 'Backed by Measurable Growth';
$pie_chart_title = 'Revenue Growth';
$bar_chart_title = 'Client Satisfaction';

// Get chart URLs from Media Library
$pie_chart_url = pces_get_media_url($pie_chart_filename);
$bar_chart_url = pces_get_media_url($bar_chart_filename);
?>

<section class="pces-metrics py-5">
    <div class="container">
        <h2 class="text-center mb-5"><?php echo esc_html($section_title); ?></h2>
        <div class="row justify-content-center">
            <?php if ($pie_chart_url): ?>
                <div class="col-md-6 mb-4">
                    <div class="metrics-chart text-center">
                        <h4 class="mb-3"><?php echo esc_html($pie_chart_title); ?></h4>
                        <img src="<?php echo esc_url($pie_chart_url); ?>" 
                             alt="<?php echo esc_attr($pie_chart_title); ?>" 
                             class="chart-image img-fluid">
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($bar_chart_url): ?>
                <div class="col-md-6 mb-4">
                    <div class="metrics-chart text-center">
                        <h4 class="mb-3"><?php echo esc_html($bar_chart_title); ?></h4>
                        <img src="<?php echo esc_url($bar_chart_url); ?>" 
                             alt="<?php echo esc_attr($bar_chart_title); ?>" 
                             class="chart-image img-fluid">
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!$pie_chart_url && !$bar_chart_url): ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <p class="mb-0">
                            Chart images not found. Please upload 
                            "<?php echo esc_html($pie_chart_filename); ?>" and 
                            "<?php echo esc_html($bar_chart_filename); ?>" 
                            to the WordPress Media Library.
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>