<?php
// Chart image filenames - easy to edit by modifying these variables
$pie_chart_filename = 'active-job-posts-chart.png';
$bar_chart_filename = 'registered-users-chart.png';
$line_chart_filename = 'visitor-hits-chart.png';

// Section content - easy to edit
$section_title = 'Backed by Measurable Growth';
$pie_chart_title = 'Active Job Posts';
$bar_chart_title = 'Registered Users';
$line_chart_title = 'Visitor Hits this Month';

// Get chart URLs from Media Library
$pie_chart_url = pces_get_media_url($pie_chart_filename);
$bar_chart_url = pces_get_media_url($bar_chart_filename);
$line_chart_url = pces_get_media_url($line_chart_filename);
?>

<section class="pces-metrics py-5">
    <div class="container">
        <h2 class="text-center mb-5"><?php echo esc_html($section_title); ?></h2>
        <div class="row justify-content-center">
            <!-- Left side - Large pie chart -->
            <?php if ($pie_chart_url): ?>
                <div class="col-lg-6 mb-4">
                    <div class="metrics-chart large-chart">
                        <h4 class="mb-3"><?php echo esc_html($pie_chart_title); ?></h4>
                        <img src="<?php echo esc_url($pie_chart_url); ?>" 
                             alt="<?php echo esc_attr($pie_chart_title); ?>" 
                             class="chart-image img-fluid">
                    </div>
                </div>
            <?php endif; ?>

            <!-- Right side - Two smaller charts stacked -->
            <div class="col-lg-6">
                <?php if ($bar_chart_url): ?>
                    <div class="mb-4">
                        <div class="metrics-chart small-chart">
                            <h4 class="mb-3"><?php echo esc_html($bar_chart_title); ?></h4>
                            <img src="<?php echo esc_url($bar_chart_url); ?>" 
                                 alt="<?php echo esc_attr($bar_chart_title); ?>" 
                                 class="chart-image img-fluid">
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($line_chart_url): ?>
                    <div class="mb-4">
                        <div class="metrics-chart small-chart">
                            <h4 class="mb-3"><?php echo esc_html($line_chart_title); ?></h4>
                            <img src="<?php echo esc_url($line_chart_url); ?>" 
                                 alt="<?php echo esc_attr($line_chart_title); ?>" 
                                 class="chart-image img-fluid">
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Error message if charts not found -->
            <?php if (!$pie_chart_url && !$bar_chart_url && !$line_chart_url): ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <p class="mb-0">
                            Chart images not found. Please upload these files to the WordPress Media Library:
                            <br>"<?php echo esc_html($pie_chart_filename); ?>"
                            <br>"<?php echo esc_html($bar_chart_filename); ?>"
                            <br>"<?php echo esc_html($line_chart_filename); ?>"
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<style>

/* Metrics Section Styling */
.pces-metrics {
    background-color: #e8f4f8;
    padding: 60px 0;
}

.pces-metrics h2 {
    color: #2c3e50;
    font-weight: bold;
    font-size: 2.5rem;
    margin-bottom: 50px;
}

.metrics-chart {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    text-align: center;
    height: 100%;
}

.metrics-chart h4 {
    color: #2c3e50;
    font-weight: 600;
    font-size: 1.3rem;
    margin-bottom: 20px;
}

.large-chart {
    min-height: 400px;
}

.small-chart {
    min-height: 180px;
}

.chart-image {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
}

/* Responsive adjustments */
@media (max-width: 991px) {
    .pces-metrics h2 {
        font-size: 2rem;
    }
    
    .large-chart,
    .small-chart {
        min-height: auto;
        margin-bottom: 30px;
    }
    
    .metrics-chart {
        padding: 20px;
    }
}

@media (max-width: 576px) {
    .pces-metrics {
        padding: 40px 0;
    }
    
    .pces-metrics h2 {
        font-size: 1.8rem;
        margin-bottom: 30px;
    }
    
    .metrics-chart h4 {
        font-size: 1.1rem;
    }
}
</style>