<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>注册确认连接</title>
</head>
<body>
  <h1>感谢您在SAMPLE网站进行注册！</h1>
  <p>
  <a href="{{route('confirm_email', $user->activation_token)}}">
    {{route('confirm_email', $user->activation_token)}}</a>
  </p>
  <p>
    如果不是您本人操作，请忽略此邮件。
  </p>
</body>
</html>
