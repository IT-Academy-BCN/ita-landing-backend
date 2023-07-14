<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .container {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #00f, #f0f);
            max-width: 600px;
            padding: 20px;
            text-align: center;
            color: #fff;
        }
        .code {
            font-size: 24px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Use this code at the moment to register. Do not share, it only works once.</p>
        <div class="code">Code: {{ $code }}</div>
    </div>
</body>
</html>
