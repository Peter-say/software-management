<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from travl.dexignlab.com/xhtml/index-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 31 Jul 2024 20:07:20 GMT -->

<head>
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

    <!-- PAGE TITLE HERE -->
    <title>Travl Hotel Admin Dashboard</title>

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('dashboard/images/favicon.png') }}" />
    <!-- Custom Stylesheet -->
    <link href="{{ asset('dashboard/vendor/jquery-smartwizard/dist/css/smart_wizard.min.css ') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/vendor/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/vendor/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"
        rel="stylesheet">
  <!-- Datatable -->
  <link href="{{ asset('dashboard/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <!-- Style css -->
    <link href="{{ asset('dashboard/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>

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
        @include('dashboard.layouts.navigations.sidebar');
        @include('notifications.flash-messages')

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Required vendors -->
    <script src="{{ asset('dashboard/vendor/global/global.min.js') }}"></script>

    <script src="{{ asset('dashboard/vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>

    <!-- Apex Chart -->

    <script src="{{ asset('dashboard/vendor/apexchart/apexchart.js') }}"></script>


    <!-- Chart piety plugin files -->


    <!-- Dashboard 1 -->
    <script src="{{ asset('dashboard/js/dashboard/dashboard-1.js') }}"></script>

    <script src="{{ asset('dashboard/vendor/owl-carousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/bootstrap-datetimepicker/js/moment.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('vendor/global/global.min.js') }}"></script>

    <script src="{{ asset('dashboard/vendor/jquery-steps/build/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <!-- Form validate init -->
    <script src="{{ asset('dashboard/js/plugins-init/jquery.validate-init.js') }}"></script>

     <!-- Datatable -->
     <script src="{{ asset('dashboard/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
     <script src="{{ asset('dashboard/js/plugins-init/datatables.init.js')}}"></script>
 

    <!-- Form Steps -->
    <script src="{{ asset('dashboard/vendor/jquery-smartwizard/dist/js/jquery.smartWizard.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/custom.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/dlabnav-init.js') }}"></script>
    <script src="{{ asset('dashboard/js/demo.js') }}"></script>
    <script src="{{ asset('dashboard/js/styleSwitcher.js') }}"></script>

    <script>
        $(document).ready(function() {
            // SmartWizard initialize
            $('#smartwizard').smartWizard();
        });
    </script>
    <script>
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
    </script>
    <script>
        $(function() {
            $('#datetimepicker').datetimepicker({
                inline: true,
            });
        });

        $(document).ready(function() {
            $(".booking-calender .fa.fa-clock-o").removeClass(this);
            $(".booking-calender .fa.fa-clock-o").addClass('fa-clock');
        });
    </script>
    <script>
        jQuery(document).ready(function() {
            setTimeout(function() {
                dlabSettingsOptions.version = 'dark';
                new dlabSettings(dlabSettingsOptions);
            }, 1500)
        });
    </script>

</body>


</html>
