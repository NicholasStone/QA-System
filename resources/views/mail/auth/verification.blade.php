<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>验证您的邮件</title>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            border: 0 none;
            list-style: none outside none;
            text-decoration: none;
            font-family: Helvetica, Tahoma, Arial, STXihei, "华文细黑", Heiti, "黑体", "Microsoft YaHei", "微软雅黑", SimSun, "宋体", sans-serif;
        }
        p{
            margin: 10px 0;
        }
        .header {
            height: 100px;
            background-color: #21759b;
            line-height: 100px;
            text-align: center;
            color: white;
        }
        .container{
            margin-top: 100px;
            height: 70vh;
            padding: 0 20%;
        }
        .main{
            text-align: center;
        }
        .button {
            vertical-align: center;
            text-align: center;
            padding: 30px 20px;
            color: white;
            line-height: 100px;
            background: #00acee;
        }
        .sub{
            margin-top: 50px;
            word-break: break-all;
        }
    </style>
</head>
<body>
<header class="header">
    <h1>请验证您的邮件</h1>
</header>
<main class="container">
    <div class="main">
        <a class="button" href="{{ $url }}">请点击此处以验证您的邮件</a>
    </div>
    <div class="sub">
        <p><b>请不要回复此邮件</b></p>
        <p><small>或将此链接复制到浏览器地址栏中以完成验证</small></p>
        <p><small>{{ $url }}</small></p>
    </div>
</main>
<footer>

</footer>
</body>
</html>