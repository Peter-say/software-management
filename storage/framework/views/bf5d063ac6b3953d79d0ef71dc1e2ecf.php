<!DOCTYPE html>
<html lang="en" class="h-100">


<!-- Mirrored from travl.dexignlab.com/xhtml/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 31 Jul 2024 20:08:11 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Travl : Hotel Admin Dashboard " />
    <meta property="og:title" content="Travl : Hotel Admin Dashboard " />
    <meta property="og:description" content="Travl : Hotel Admin Dashboard " />
    <meta property="og:image" content="social-image.png" />
    <meta name="format-detection" content="telephone=no">

    <!-- PAGE TITLE HERE -->
    <title>Hotel Admin Dashboard</title>

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="images/favicon.png" />
    <link href="<?php echo e(asset('dashboard/css/style.css')); ?>" rel="stylesheet">

</head>

<body class="vh-100">

    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                        <a href="index.html"><img src="images/logo-full.png" alt=""></a>
                                    </div>
<?php echo $__env->make('notifications.flash-messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php echo $__env->yieldContent('contents'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="<?php echo e(asset('vendor/global/global.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/custom.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/dlabnav-init.js ')); ?>"></script>
    <script src="<?php echo e(asset('js/styleSwitcher.js ')); ?>"></script>
</body>


</html>
<?php /**PATH /home/swifbayo/public_html/software-management/resources/views/auth/layouts/app.blade.php ENDPATH**/ ?>