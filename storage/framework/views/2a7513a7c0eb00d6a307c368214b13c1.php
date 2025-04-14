<script>
    document.addEventListener('DOMContentLoaded', function() {
        const reservationData = <?php echo json_encode($reservation_data, 15, 512) ?>;
        const reservationcheckedins = reservationData.data['checked_ins'];
        const reservationCheckedouts = reservationData.data['checked_outs'];
        const reservationLebels = reservationData.data['data_labels'];
         
        (function($) {
            /* "use strict" */

            var dlabChartlist = (function() {
                var screenWidth = $(window).width();
                var chartBar = function() {
                    var options = {
                        series: [{
                                name: "Checked In",
                                data: reservationcheckedins,
                                //radius: 12,
                            },
                            {
                                name: "Checked Out",
                                data: reservationCheckedouts,
                            },
                        ],
                        chart: {
                            type: "bar",
                            height: 350,
                            toolbar: {
                                show: false,
                            },
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: "35%",
                                endingShape: "rounded",
                            },
                        },
                        colors: ["var(--secondary)", "var(--primary)"],
                        dataLabels: {
                            enabled: false,
                        },
                        markers: {
                            shape: "circle",
                        },

                        legend: {
                            show: false,
                            fontSize: "12px",
                            labels: {
                                colors: "#000000",
                            },
                            markers: {
                                width: 18,
                                height: 18,
                                strokeWidth: 0,
                                strokeColor: "#fff",
                                fillColors: undefined,
                                radius: 12,
                            },
                        },
                        stroke: {
                            show: true,
                            width: 1,
                            colors: ["transparent"],
                        },
                        grid: {
                            borderColor: "#eee",
                        },
                        xaxis: {
                            categories: reservationLebels,
                            labels: {
                                style: {
                                    colors: "#787878",
                                    fontSize: "13px",
                                    fontFamily: "poppins",
                                    fontWeight: 100,
                                    cssClass: "apexcharts-xaxis-label",
                                },
                            },
                            crosshairs: {
                                show: false,
                            },
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    colors: "#787878",
                                    fontSize: "13px",
                                    fontFamily: "poppins",
                                    fontWeight: 100,
                                    cssClass: "apexcharts-xaxis-label",
                                },
                            },
                        },
                        fill: {
                            opacity: 1,
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return val + " tens";
                                },
                            },
                        },
                    };

                    var chartBar1 = new ApexCharts(
                        document.querySelector("#chartBar"),
                        options
                    );
                    chartBar1.render();
                };


                /* Function ============ */
                return {
                    init: function() {},

                    load: function() {
                        chartBar();

                    },

                    resize: function() {},
                };
            })();

            jQuery(window).on("load", function() {
                setTimeout(function() {
                    dlabChartlist.load();
                }, 1000);
            });
        })(jQuery);


    });
</script>
<?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views/dashboard/chart/reservation/check-in-out.blade.php ENDPATH**/ ?>