<?php
// Section content - easy to edit
$section_title = 'Backed by Measurable Growth';
$pie_chart_title = 'Active Job Posts';
$bar_chart_title = 'Registered Users';
$line_chart_title = 'Visitor Hits this Month';
?>

<!-- Highcharts Dashboard Section -->
<div class="container-fluid py-5" ng-app="pcesChartsApp" ng-controller="ChartsController">
    <h2 class="text-center mb-5"><?php echo esc_html($section_title); ?></h2>
    
    <div class="row">
        <!-- Left side - Large pie chart -->
        <div class="col-md-7">
            <div class="chart-card p-4 h-100">
                <h4 class="chart-title"><?php echo esc_html($pie_chart_title); ?></h4>
                <highcharts-ng config="pieChartConfig"></highcharts-ng>
                
                <!-- Filter buttons -->
                <div class="d-flex justify-content-around mt-3 flex-wrap">
                    <button class="btn btn-outline-primary btn-sm m-1" ng-click="filterData('all')">All</button>
                    <button class="btn btn-outline-primary btn-sm m-1" ng-click="filterData('it')">IT</button>
                    <button class="btn btn-outline-primary btn-sm m-1" ng-click="filterData('business')">Business</button>
                    <button class="btn btn-outline-primary btn-sm m-1" ng-click="filterData('agriculture')">Agriculture</button>
                    <button class="btn btn-outline-primary btn-sm m-1" ng-click="filterData('misc')">Misc.</button>
                </div>
            </div>
        </div>
        
        <!-- Right side - Two smaller charts stacked -->
        <div class="col-md-5">
            <!-- Bar chart -->
            <div class="chart-card p-4 mb-3">
                <h4 class="chart-title"><?php echo esc_html($bar_chart_title); ?></h4>
                <highcharts-ng config="barChartConfig"></highcharts-ng>
            </div>
            
            <!-- Line chart -->
            <div class="chart-card p-4">
                <h4 class="chart-title"><?php echo esc_html($line_chart_title); ?></h4>
                <highcharts-ng config="lineChartConfig"></highcharts-ng>
            </div>
        </div>
    </div>
</div>
<style>
/* Highcharts Dashboard Styling */
.container-fluid[ng-app="pcesChartsApp"] {
    background-color: #e8f4f8;
    min-height: 500px;
    margin-bottom: 0;
    padding-bottom: 60px !important;
}

.container-fluid[ng-app="pcesChartsApp"] h2 {
    color: #2c3e50;
    font-weight: bold;
    font-size: 2.5rem;
    margin-bottom: 50px;
}

.chart-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    height: 100%;
    min-height: 250px;
}

.chart-title {
    color: #2c3e50;
    font-weight: 600;
    font-size: 1.3rem;
    margin-bottom: 20px;
    text-align: center;
}

/* Filter buttons styling */
.btn-outline-primary {
    border-color: #1D57A5;
    color: #1D57A5;
    font-size: 0.875rem;
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover,
.btn-outline-primary:focus,
.btn-outline-primary.active {
    background-color: #1D57A5;
    border-color: #1D57A5;
    color: white;
}

/* Highcharts container adjustments */
.highcharts-container {
    margin: 0 auto;
}

/* Large chart specific styling */
.col-md-7 .chart-card {
    min-height: 400px;
    max-height: 450px;
}

/* Small charts specific styling */
.col-md-5 .chart-card {
    min-height: 180px;
    max-height: 200px;
}

/* Ensure proper spacing and no overflow */
.chart-card .highcharts-container {
    overflow: visible !important;
}

/* Fix any potential z-index issues */
.container-fluid[ng-app="pcesChartsApp"] {
    position: relative;
    z-index: 1;
}

/* Responsive adjustments */
@media (max-width: 991px) {
    .container-fluid[ng-app="pcesChartsApp"] h2 {
        font-size: 2rem;
    }
    
    .chart-card {
        margin-bottom: 30px;
        min-height: 300px;
    }
    
    .col-md-7 .chart-card,
    .col-md-5 .chart-card {
        min-height: 300px;
    }
}

@media (max-width: 576px) {
    .container-fluid[ng-app="pcesChartsApp"] {
        padding: 40px 15px;
    }
    
    .container-fluid[ng-app="pcesChartsApp"] h2 {
        font-size: 1.8rem;
        margin-bottom: 30px;
    }
    
    .chart-title {
        font-size: 1.1rem;
    }
    
    .chart-card {
        padding: 20px !important;
    }
    
    .btn-outline-primary {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
}

/* AngularJS specific fixes */
[ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
    display: none !important;
}

/* Loading state */
.chart-card .highcharts-loading {
    background-color: rgba(255, 255, 255, 0.8);
}
</style>