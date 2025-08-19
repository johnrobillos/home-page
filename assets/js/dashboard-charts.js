// Dashboard Charts - AngularJS + Highcharts
var app = angular.module('pcesChartsApp', ['highcharts-ng']);

app.controller('ChartsController', function($scope) {
    
    // Pie Chart Configuration - Active Job Posts
    $scope.pieChartConfig = {
        options: {
            chart: {
                type: 'pie',
                backgroundColor: 'transparent'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: false
                }
            }
        },
        series: [{
            name: 'Job Posts',
            colorByPoint: true,
            data: [
                {
                    name: 'IT',
                    y: 33.3,
                    color: '#1D57A5'
                }, 
                {
                    name: 'Business',
                    y: 22.2,
                    color: '#F57D51'
                }, 
                {
                    name: 'Agriculture',
                    y: 22.2,
                    color: '#4D960E'
                }, 
                {
                    name: 'Misc.',
                    y: 22.3,
                    color: '#F5BC53'
                }
            ]
        }],
        title: {
            text: null
        },
        credits: {
            enabled: false
        },
        size: {
            height: 300
        }
    };

    // Bar Chart Configuration - Registered Users
    $scope.barChartConfig = {
        options: {
            chart: {
                type: 'column',
                backgroundColor: 'transparent'
            },
            plotOptions: {
                column: {
                    borderRadius: 4,
                    colorByPoint: true,
                    colors: ['#1D57A5', '#2E6BB8', '#4A7FCA', '#6693DD']
                }
            },
            legend: {
                enabled: false
            }
        },
        series: [{
            name: 'Registered Users',
            data: [400, 750, 950, 1000],
            showInLegend: false
        }],
        xAxis: {
            categories: ['May', 'Jun', 'Jul', 'Aug'],
            labels: {
                style: {
                    color: '#666'
                }
            }
        },
        yAxis: {
            title: {
                text: null
            },
            labels: {
                style: {
                    color: '#666'
                }
            }
        },
        title: {
            text: null
        },
        credits: {
            enabled: false
        }
    };

    // Line Chart Configuration - Visitor Hits
    $scope.lineChartConfig = {
        options: {
            chart: {
                type: 'line',
                backgroundColor: 'transparent'
            },
            tooltip: {
                valueSuffix: ' hits'
            },
            plotOptions: {
                line: {
                    color: '#1D57A5',
                    lineWidth: 3,
                    marker: {
                        fillColor: '#1D57A5',
                        lineWidth: 2,
                        lineColor: '#ffffff'
                    }
                }
            }
        },
        series: [{
            name: 'Visitor Hits',
            data: [100, 125, 140, 120, 95, 110, 130, 115],
            showInLegend: false
        }],
        xAxis: {
            categories: ['1', '2', '3', '4', '5', '6', '7', '8'],
            labels: {
                style: {
                    color: '#666'
                }
            }
        },
        yAxis: {
            title: {
                text: null
            },
            labels: {
                style: {
                    color: '#666'
                }
            }
        },
        title: {
            text: null
        },
        credits: {
            enabled: false
        }
    };

    // Filter buttons functionality for pie chart
    $scope.filterData = function(category) {
        // This could be expanded to actually filter data
        console.log('Filter clicked:', category);
    };
});