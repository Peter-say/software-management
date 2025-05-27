<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        h1 {
            font-size: 24px;
            margin: 0 0 20px;
        }
        p {
            margin: 0 0 10px;
        }
        .card {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Hey, you got a new email from a user</p>
        <br>
        <h3>Contact Details</h3>
        <div class="card">
            <p><strong>Name:</strong> <?php echo e($notificationData['name']); ?></p>
            <p><strong>Email:</strong> <?php echo e($notificationData['email']); ?></p>

            <?php if(!empty($notificationData['subject'])): ?>
                <p><strong>Subject:</strong> <?php echo e($notificationData['subject']); ?></p>
            <?php endif; ?>

            <hr>

            <p><strong>Message:</strong></p>
            <p><?php echo e($notificationData['message']); ?></p>
        </div>
    </div>
</body>
</html>
<?php /**PATH /home/swifbayo/public_html/software-management/resources/views/emails/contact-form-info.blade.php ENDPATH**/ ?>