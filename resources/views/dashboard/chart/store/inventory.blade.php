

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const storeInventoryChartData = @json($store_item_chart_data);
        const totalIncoming = storeInventoryChartData.chart_data['total_incoming_store_items'];
        const totalOutgoing = storeInventoryChartData.chart_data['total_outgoing_store_items'];
        const chartLebels = storeInventoryChartData.chart_data['data_labels'];
        console.log(storeInventoryChartData);
        
        var inventoryChart = function() {
            //dual line chart
            if (jQuery('#inventoryChart').length > 0) {
                const lineChart_3 = document.getElementById("inventoryChart").getContext('2d');
                //generate gradient
                const lineChart_3gradientStroke1 = lineChart_3.createLinearGradient(500, 0, 100, 0);
                lineChart_3gradientStroke1.addColorStop(0, "rgba(0, 0, 255, 1)");
                lineChart_3gradientStroke1.addColorStop(1, "rgba(0, 0, 255, 1)");

                const lineChart_3gradientStroke2 = lineChart_3.createLinearGradient(500, 0, 100, 0);
                lineChart_3gradientStroke2.addColorStop(0, "rgba(255, 0, 0, 1)");
                lineChart_3gradientStroke2.addColorStop(1, "rgba(255, 0, 0, 1)");

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
                lineChart_3gradientStroke3.addColorStop(0, "rgba(0, 0, 255, 1)");
                lineChart_3gradientStroke3.addColorStop(1, "rgba(0, 0, 255, 1)");

                const lineChart_3gradientStroke4 = lineChart_3.createLinearGradient(500, 0, 100, 0);
                lineChart_3gradientStroke4.addColorStop(0, "rgba(255, 0, 0, 1)");
                lineChart_3gradientStroke4.addColorStop(1, "rgba(255, 0, 0, 1)");

                new Chart(lineChart_3, {
                    type: 'line',
                    data: {
                        defaultFontFamily: 'Poppins',
                        labels: chartLebels,
                        datasets: [{
                            label: "Incoming Inventory",
                            data: totalIncoming,
                            borderColor: lineChart_3gradientStroke1,
                            borderWidth: "2",
                            backgroundColor: 'transparent',
                            pointBackgroundColor: 'rgba(249, 58, 11, 0.5)'
                        }, {
                            label: "Outgoing Inventory",
                            data: totalOutgoing ,
                            borderColor: lineChart_3gradientStroke2,
                            borderWidth: "2",
                            backgroundColor: 'transparent',
                            pointBackgroundColor: 'rgba(254, 176, 25, 1)'
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
                                        return value.toLocaleString();
                                    },
                                    beginAtZero: true,
                                    max: Math.max(...totalIncoming, ...totalOutgoing) + 10,
                                    min: 0,
                                    stepSize: Math.ceil(Math.max(...totalIncoming, ...totalOutgoing)),
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
            inventoryChart();
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
