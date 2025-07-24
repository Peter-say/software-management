<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from travl.dexignlab.com/xhtml/index-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 31 Jul 2024 20:07:20 GMT -->

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Travl : Hotel Admin Dashboard Bootstrap 5 Template" />
    <meta property="og:title" content="Travl : Hotel Admin Dashboard Bootstrap 5 Template" />
    <meta property="og:description" content="Travl : Hotel Admin Dashboard Bootstrap 5 Template" />
    <meta property="og:image" content="social-image.png" />
    <meta name="format-detection" content="telephone=no">

    <!-- Pass Pusher configuration as JavaScript variables -->

    <!-- PAGE TITLE HERE -->
    <title>Travl Hotel Admin Dashboard</title>

    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('dashboard/images/favicon.png') }}" />
    @vite(['resources/js/app.js', 'resources/js/echo.js'])

    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- jQuery UI (for datepicker) -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Custom Stylesheets -->
    <link href="{{ asset('dashboard/css/style.css') }}" rel="stylesheet">

    <!-- jQuery Smart Wizard -->
    <link href="{{ asset('dashboard/vendor/jquery-smartwizard/dist/css/smart_wizard.min.css') }}" rel="stylesheet">

    <!-- jQuery Nice Select -->
    <link href="{{ asset('dashboard/vendor/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet">

    <!-- Owl Carousel -->
    <link href="{{ asset('dashboard/vendor/owl-carousel/owl.carousel.css') }}" rel="stylesheet">

    <!-- Bootstrap Datetimepicker -->
    <link href="{{ asset('dashboard/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"
        rel="stylesheet">

    <!-- Pickadate (for date picking) -->
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/pickadate/themes/default.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/pickadate/themes/default.date.css') }}">

    <!-- Datatables CSS -->
    <link href="{{ asset('dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">

    <!-- Daterange Picker -->
    <link href="{{ asset('dashboard/vendor/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

    <!-- Clockpicker -->
    <link href="{{ asset('dashboard/vendor/clockpicker/css/bootstrap-clockpicker.min.css') }}" rel="stylesheet">

    <!-- asColorPicker -->
    <link href="{{ asset('dashboard/vendor/jquery-asColorPicker/css/asColorPicker.min.css') }}" rel="stylesheet">

    <!-- Bootstrap Material Datetimepicker -->
    <link
        href="{{ asset('dashboard/vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>


    <script>
        window.storageBaseUrl = @json(url('/'));
        window.environment = @json(app()->environment());
    </script>
</head>
<style>
    /* Add padding and alignment to dropdown items */
    .dropdown-menu-custom {
        padding: 10px;
        /* Add padding inside the dropdown */
        min-width: 200px;
        /* Set a minimum width */
    }

    .dropdown-menu-custom li a {
        display: block;
        /* Ensure items are block-level elements */
        padding: 8px 15px;
        /* Add padding to the links */
        text-align: left;
        /* Align text to the left */
        color: #333;
        /* Text color */
        text-decoration: none;
        /* Remove underline */
    }

    .dropdown-menu-custom li a:hover {
        background-color: #f0f0f0;
        /* Add a hover effect */
        color: #000;
        /* Change text color on hover */
    }

    /* Optional: Add rounded corners to dropdown */
    .dropdown-menu-custom {
        border-radius: 5px;
        border: 1px solid #ddd;
    }
</style>

<body>

    <!--*******************
  Preloader start
 ********************-->
    {{-- <div id="preloader">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
    </div> --}}
    <!--*******************
  Preloader end
 ********************-->

    <!--**********************************
  Main wrapper start
 ***********************************-->

    <div id="main-wrapper">
        @include('dashboard.layouts.navigations.top-nav')
        @include('dashboard.layouts.navigations.sidebar')
        @include('notifications.flash-messages')
        @include('dashboard.general.modal.item-description-modal')
        @include('dashboard.hotel.restaurant-item.upload-modal')
        @include('dashboard.hotel.bar-items.upload-modal')
        @include('dashboard.hotel.bar-items.truncate-modal')
        @include('dashboard.general.modal.ai-chat.modal', [
            'chat_histories' => $chat_histories ?? [],
            'conversation_id' => $conversation_id ?? '',
            'prompt' => $prompt ?? '',
        ])
        @include('dashboard.general.form-preloader')
        @yield('contents')



        <!--**********************************
   Footer start
  ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="https://dexignlab.com/"
                        target="_blank">DexignLab</a> 2021
                </p>
            </div>
        </div>
        <script>
            // Helper function to format date
            function formatDate(dateString) {
                const date = new Date(dateString);
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based
                const day = String(date.getDate()).padStart(2, '0');
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                const seconds = String(date.getSeconds()).padStart(2, '0');

                return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
            }

            $(document).ready(function() {
                $('#downloadSample').on('click', function(event) {
                    event.preventDefault(); // Prevent default link behavior
                    console.log('clicked');

                    var currentUrl = $('#currentUrl').val();
                    console.log(currentUrl);

                    $.ajax({
                        url: "{{ route('dashboard.download.sample') }}", // Ensure this is a valid route
                        type: 'GET',
                        data: {
                            current_url: currentUrl
                        },
                        xhrFields: {
                            responseType: 'blob'
                        }, // Important for handling binary data
                        success: function(response, status, xhr) {
                            var filename = "restaurant_item_sample.csv"; // Default filename

                            var disposition = xhr.getResponseHeader('Content-Disposition');
                            if (disposition && disposition.indexOf('attachment') !== -1) {
                                var matches = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/.exec(
                                    disposition);
                                if (matches != null && matches[1]) {
                                    filename = matches[1].replace(/['"]/g, '');
                                }
                            }

                            var blob = new Blob([response], {
                                type: xhr.getResponseHeader('Content-Type')
                            });
                            var url = window.URL.createObjectURL(blob);
                            var link = document.createElement('a');
                            link.href = url;
                            link.download = filename;
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                            window.URL.revokeObjectURL(url);

                            Toastify({
                                text: 'Download started.',
                                duration: 5000,
                                gravity: 'top',
                                position: 'right',
                                backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)',
                            }).showToast();
                        },
                        error: function(xhr) {
                            var errorMessage = (xhr.responseJSON && xhr.responseJSON.message) ||
                                'An error occurred while downloading the file.';
                            Toastify({
                                text: errorMessage,
                                duration: 5000,
                                gravity: 'top',
                                position: 'right',
                                backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                            }).showToast();
                        }
                    });
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var stateId = '{{ old('state_id', $guest->state_id ?? '') }}';

                $('#country_id').on('change', function() {
                    var countryId = $(this).val();
                    var stateDropdown = $('#state_id');
                    stateDropdown.empty();

                    if (countryId) {
                        $.ajax({
                            url: '{{ route('get-states-by-country') }}',
                            type: 'GET',
                            data: {
                                country_id: countryId
                            },
                            success: function(response) {
                                stateDropdown.append(
                                    '<option value="">Select State</option>'); // Add placeholder
                                $.each(response.states, function(key, state) {
                                    var selected = (state.id == stateId) ? 'selected' : '';
                                    stateDropdown.append('<option value="' + state.id +
                                        '" ' + selected + '>' + state.name + '</option>'
                                    );
                                });
                            },
                            error: function() {
                                alert('Error fetching states');
                            }
                        });
                    } else {
                        stateDropdown.append('<option value="">Select State</option>');
                    }
                });

                // Trigger change event on page load to populate states if country is pre-selected
                $('#country_id').trigger('change');
            });
            // Initialize Bootstrap tooltips
            document.addEventListener('DOMContentLoaded', function() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        </script>

        <!--**********************************
   Footer end
  ***********************************-->

        <!--**********************************
  Support ticket button start
  ***********************************-->

        <!--**********************************
  Support ticket button end
  ***********************************-->


    </div>
    <!--**********************************
  Main wrapper end
 ***********************************-->

    <!--**********************************
  Scripts
 ***********************************-->
    <!-- jQuery (only include once) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    @include('dashboard.general.modal.ai-chat.script', ['chat_histories' => $chat_histories ?? []])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Moment.js (required for date/time handling) -->
    <script src="{{ asset('dashboard/vendor/moment/moment.min.js') }}"></script>

    <!-- Bootstrap Daterangepicker -->
    <script src="{{ asset('dashboard/vendor/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <!-- Global Scripts (only include once) -->
    <script src="{{ asset('dashboard/vendor/global/global.min.js') }}"></script>

    <!-- jQuery UI (for Datepicker functionality) -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- Toastify JS (for notifications) -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- ApexCharts -->
    <script src="{{ asset('dashboard/vendor/apexchart/apexchart.js') }}"></script>

    <!-- Chart ChartJS plugin files -->
    <script src="{{ asset('dashboard/vendor/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/plugins-init/chartjs-init.js') }}"></script>

    <!-- jQuery Nice Select (only include once) -->
    <script src="{{ asset('dashboard/vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>

    <!-- Dashboard 1 Scripts -->
    <script src="{{ asset('dashboard/js/dashboard/dashboard-1.js') }}"></script>

    <!-- Owl Carousel -->
    <script src="{{ asset('dashboard/vendor/owl-carousel/owl.carousel.js') }}"></script>

    <!-- Bootstrap Datetime Picker -->
    <script src="{{ asset('dashboard/vendor/bootstrap-datetimepicker/js/moment.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>

    <!-- jQuery Steps & Validation -->
    <script src="{{ asset('dashboard/vendor/jquery-steps/build/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/plugins-init/jquery.validate-init.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('dashboard/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/plugins-init/datatables.init.js') }}"></script>

    <!-- SmartWizard -->
    <script src="{{ asset('dashboard/vendor/jquery-smartwizard/dist/js/jquery.smartWizard.js') }}"></script>

    <!-- Custom Scripts -->
    <script src="{{ asset('dashboard/js/custom.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/dlabnav-init.js') }}"></script>
    <script src="{{ asset('dashboard/js/demo.js') }}"></script>
    <script src="{{ asset('dashboard/js/styleSwitcher.js') }}"></script>

    <!-- Pickadate (for date/time picking functionality) -->
    {{-- <script src="{{ asset('dashboard/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/pickadate/picker.date.js') }}"></script> --}}

    <!-- Daterangepicker Initialization -->
    <script src="{{ asset('dashboard/js/plugins-init/bs-daterange-picker-init.js') }}"></script>

    <!-- Clockpicker Initialization -->
    <script src="{{ asset('dashboard/js/plugins-init/clock-picker-init.js') }}"></script>

    <!-- asColorPicker Styles -->
    <link href="{{ asset('dashboard/vendor/jquery-asColorPicker/css/asColorPicker.min.css') }}" rel="stylesheet">

    <!-- Material Color Picker Initialization -->
    <script src="{{ asset('dashboard/js/plugins-init/material-date-picker-init.js') }}"></script>

    <!-- Pickadate Initialization -->
    <script src="{{ asset('dashboard/js/plugins-init/pickadate-init.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $(document).ready(function() {
                // SmartWizard initialize
                $('#smartwizard').smartWizard();
            });

            function TravlCarousel() {

                /*  testimonial one function by = owl.carousel.js */
                jQuery('.front-view-slider').owlCarousel({
                    loop: false,
                    margin: 15,
                    nav: true,
                    autoplaySpeed: 3000,
                    navSpeed: 3000,
                    paginationSpeed: 3000,
                    slideSpeed: 3000,
                    smartSpeed: 3000,
                    autoplay: false,
                    animateOut: 'fadeOut',
                    dots: true,
                    navText: ['<i class="fas fa-arrow-left"></i>', '<i class="fas fa-arrow-right"></i>'],
                    responsive: {
                        0: {
                            items: 1
                        },

                        768: {
                            items: 2
                        },

                        1400: {
                            items: 2
                        },
                        1600: {
                            items: 3
                        },
                        1750: {
                            items: 3
                        }
                    }
                })
            }

            jQuery(window).on('load', function() {
                setTimeout(function() {
                    TravlCarousel();
                }, 1000);
            });

            // $(function() {
            //     $('#datetimepicker').datetimepicker({
            //         inline: true,
            //     });
            // });

            $(document).ready(function() {
                $(".booking-calender .fa.fa-clock-o").removeClass(this);
                $(".booking-calender .fa.fa-clock-o").addClass('fa-clock');
            });

            jQuery(document).ready(function() {
                setTimeout(function() {
                    dlabSettingsOptions.version = 'dark';
                    new dlabSettings(dlabSettingsOptions);
                }, 1500)
            });
        });
    </script>

</body>


</html>
