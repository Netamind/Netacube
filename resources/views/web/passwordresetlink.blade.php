
<!DOCTYPE html>
<html lang="en">
<head>
    <?php $company = DB::table('appdata')->value('appname'); ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$company}} - Password Reset</title>
</head>
<body>
    <h4>{{$company}}</h4>
    <br>
    <div style="text-align:center; border:1px solid #f0f5f5; background-color:#f0f5f5; padding-left:10px; padding-right:10px">
        <br>
        <h4>Password Reset Request</h4>
        <br>
        <p>If you've lost your password or wish to reset it, please use the link below to get started. <i>Note that this link expires within 24 hours.</i></p>
        <br>
        <?php $token = $data["token"]; $link = Request::root(); ?>
        <p><a href="{{$link}}/reset-password-view?token={{$token}}" style="background-color:blue; color: white; padding: 15px 25px; text-decoration: none">Reset Your Password</a></p>
        <p><br><br>If you didn't request a password reset, you can safely ignore this email. Only someone with access to your email can reset your account password.</p>
        <br><br>
    </div>
</body>
</html>

