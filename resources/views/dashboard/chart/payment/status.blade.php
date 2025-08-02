<script>
    document.addEventListener('DOMContentLoaded', function() {
        let statusChart, distChart;

        // ✅ Global Currency Symbol from Laravel
        const currencySymbol = @json(currencySymbol());

        // ✅ Helper to safely sum array values or return number
        function sumData(data) {
            if (!data) return 0;
            if (Array.isArray(data)) {
                return data.reduce((a, b) => a + (parseFloat(b) || 0), 0);
            }
            return parseFloat(data) || 0;
        }

        // Safe defaults fallback
        const initialStatusData = @json($payment_stats['data']['status_data'] ?? []);
        const initialDistData = @json($payment_stats['data']['distribution_data'] ?? []);

        // ✅ Show "No data available" message
        function showNoDataMessage(containerId) {
            document.getElementById(containerId).innerHTML =
                '<div class="text-center text-muted p-3">No data available for this period</div>';
        }

        // ✅ Initialize both charts
        function initCharts(statusData = {}, distData = {}) {
            // Clear old charts
            if (statusChart) statusChart.destroy();
            if (distChart) distChart.destroy();

            const statusValues = [
                sumData(statusData.pending),
                sumData(statusData.completed),
                sumData(statusData.refunded),
                sumData(statusData.failed)
            ];

            const distValues = [
                sumData(distData.bar_orders),
                sumData(distData.restaurant_orders),
                sumData(distData.guest_payments),
                sumData(distData.room_reservations)
            ];

            // ✅ If no data, show message instead of chart
            if (statusValues.every(v => v === 0)) {
                showNoDataMessage('status-chart-container');
            } else {
                const ctxStatus = document.getElementById("paymentStatusPieChart").getContext('2d');
                statusChart = new Chart(ctxStatus, {
                    type: 'pie',
                    data: {
                        labels: ["Pending", "Completed", "Refunded", "Failed"],
                        datasets: [{
                            data: statusValues,
                            backgroundColor: [
                                'rgba(255, 206, 86, 0.8)',
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(255, 99, 132, 0.8)',
                                'rgba(75, 192, 192, 0.8)'
                            ],
                            borderColor: '#fff',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            datalabels: {
                                color: '#000',
                                formatter: function(value, context) {
                                    const dataset = context.chart.data.datasets[0];
                                    const total = dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total ? ((value / total) * 100).toFixed(1) :
                                        0;
                                    return `${value.toLocaleString()} (${percentage}%)`;
                                },
                                font: {
                                    weight: 'bold',
                                    size: 14
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });
            }

            if (distValues.every(v => v === 0)) {
                showNoDataMessage('distribution-chart-container');
            } else {
                const ctxDist = document.getElementById("paymentDistributionPieChart").getContext('2d');
                distChart = new Chart(ctxDist, {
                    type: 'pie',
                    data: {
                        labels: ["Bar Orders", "Restaurant Orders", "Guests", "Room Reservations"],
                        datasets: [{
                            data: distValues,
                            backgroundColor: [
                                'rgba(255, 159, 64, 0.8)',
                                'rgba(153, 102, 255, 0.8)',
                                'rgba(255, 205, 86, 0.8)',
                                'rgba(75, 192, 192, 0.8)'
                            ],
                            borderColor: '#fff',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            datalabels: {
                                color: '#000',
                                formatter: function(value, context) {
                                    const dataset = context.chart.data.datasets[0];
                                    const total = dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total ? ((value / total) * 100).toFixed(1) :
                                        0;
                                    return `${currencySymbol}${value.toLocaleString()} (${percentage}%)`;
                                },
                                font: {
                                    weight: 'bold',
                                    size: 14
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });
            }
        }

        // ✅ Initial chart load
        initCharts(initialStatusData, initialDistData);

        document.querySelectorAll('.dropdown-menu .dropdown-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault(); // prevent default link behavior
                const period = this.getAttribute('data-period');
                const form = this.closest('form');
                form.querySelector('#chart-selected-period').value = period;
                form.submit(); // Submit the form automatically
            });
        });

    });
</script>
