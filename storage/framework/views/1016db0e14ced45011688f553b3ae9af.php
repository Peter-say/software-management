

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const purchasesChartData = <?php echo json_encode($purchases_chart_data, 15, 512) ?>;
        const totalPurchases = purchasesChartData.chart_data['total_purchases_amount'];
        const totalPaidPurchases = purchasesChartData.chart_data['total_paid_purchases_amount'];
        const totalUnpaidPurchases = purchasesChartData.chart_data['total_unpaid_purchases_amount'];
        const chartLebels = purchasesChartData.chart_data['data_labels'];
        const currencySymbol = <?php echo json_encode(currencySymbol(), 15, 512) ?>;
        
        var purchaseChart = function() {
            //dual line chart
            if (jQuery('#purchaseChart').length > 0) {
                const lineChart_3 = document.getElementById("purchaseChart").getContext('2d');
                //generate gradient
                const lineChart_3gradientStroke1 = lineChart_3.createLinearGradient(500, 0, 100, 0);
                lineChart_3gradientStroke1.addColorStop(0, "rgba(249, 58, 11, 1)");
                lineChart_3gradientStroke1.addColorStop(1, "rgba(249, 58, 11, 0.5)");

                const lineChart_3gradientStroke2 = lineChart_3.createLinearGradient(500, 0, 100, 0);
                lineChart_3gradientStroke2.addColorStop(0, "rgba(255, 92, 0, 1)");
                lineChart_3gradientStroke2.addColorStop(1, "rgba(255, 92, 0, 1)");

                var draw = Chart.controllers.line.prototype.draw;
                Chart.controllers.line = Chart.controllers.line.extend({
                    draw: function() {
                        draw.apply(this, arguments);
                        let nk = this.chart.chart.ctx;
                        let _stroke = nk.stroke;
                        nk.stroke = function() {
                            nk.save();
                            nk.shadowColor = 'rgba(0, 0, 0, 0)';
                            nk.shadowBlur = 10;
                            nk.shadowOffsetX = 0;
                            nk.shadowOffsetY = 10;
                            _stroke.apply(this, arguments)
                            nk.restore();
                        }
                    }
                });
                const lineChart_3gradientStroke3 = lineChart_3.createLinearGradient(500, 0, 100, 0);
                lineChart_3gradientStroke3.addColorStop(0, "rgba(0, 123, 255, 1)");
                lineChart_3gradientStroke3.addColorStop(1, "rgba(0, 123, 255, 0.5)");

                const lineChart_3gradientStroke4 = lineChart_3.createLinearGradient(500, 0, 100, 0);
                lineChart_3gradientStroke4.addColorStop(0, "rgba(40, 167, 69, 1)");
                lineChart_3gradientStroke4.addColorStop(1, "rgba(40, 167, 69, 0.5)");

                new Chart(lineChart_3, {
                    type: 'line',
                    data: {
                        defaultFontFamily: 'Poppins',
                        labels: chartLebels,
                        datasets: [{
                            label: "Total Expenses",
                            data: totalPurchases,
                            borderColor: lineChart_3gradientStroke1,
                            borderWidth: "2",
                            backgroundColor: 'transparent',
                            pointBackgroundColor: 'rgba(249, 58, 11, 0.5)'
                        }, {
                            label: "Paid Expenses",
                            data: totalPaidPurchases ,
                            borderColor: lineChart_3gradientStroke2,
                            borderWidth: "2",
                            backgroundColor: 'transparent',
                            pointBackgroundColor: 'rgba(254, 176, 25, 1)'
                        }, {
                            label: "Unpaid Expenses",
                            data: totalUnpaidPurchases,
                            borderColor: lineChart_3gradientStroke3,
                            borderWidth: "2",
                            backgroundColor: 'transparent',
                            pointBackgroundColor: 'rgba(0, 123, 255, 0.5)'
                        }]
                    },
                    options: {
                        legend: {
                            display: true
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    callback: function(value, index, values) {
                                        return currencySymbol + value.toLocaleString();
                                    },
                                    beginAtZero: true,
                                    max: Math.max(...totalPurchases, ...totalPaidPurchases, ...totalUnpaidPurchases) + 1000,
                                    min: 0,
                                    stepSize: Math.ceil(Math.max(...totalPurchases, ...totalPaidPurchases, ...totalUnpaidPurchases) / 5),
                                    padding: 10
                                }
                            }],
                            xAxes: [{
                                ticks: {
                                    
                                    padding: 5
                                }
                            }]
                        }
                    }
                });
                lineChart_3.height = 100;
               
            }
        };

        var load = function() {
            purchaseChart();
            jQuery(document).ready(function() {});

            // jQuery(window).on('load', function() {
            //     if (typeof dlabSparkLine !== 'undefined' && dlabSparkLine) {
            //         dlabSparkLine.load();
            //     }
            // });

            // jQuery(window).on('resize', function() {
            //         if (typeof dlabSparkLine !== 'undefined') {
            //             dlabSparkLine.resize();
            //         }
            //     setTimeout(function() {
            //         dlabSparkLine.resize();
            //     }, 1000);
            // });

        };
        load();
    });
   	
</script>
<?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views\dashboard\chart\purchases\general.blade.php ENDPATH**/ ?>