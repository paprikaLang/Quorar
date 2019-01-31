<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404 not found</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .glitch {
            position: relative;
            width: 100%;
            height: 100vh;
            background: url('https://paprika-dev.b0.upaiyun.com/Lpyx2fePqWnwRYPtDxvwA89K70tD54ywzMydiN2e.jpeg');
            background-size: cover;
        }

        .glitch:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://paprika-dev.b0.upaiyun.com/Lpyx2fePqWnwRYPtDxvwA89K70tD54ywzMydiN2e.jpeg');
            background-size: cover;
            opacity: 0.5;
            /*mix-blend-mode: hard-light;*/

        }

        .glitch:hover:before {
            animation: animate .2s infinite;
        }

        @keyframes animate {
            0% {
                background-position: 0 0;
                filter: hue-rotate(0deg);
            }
            10% {
                background-position: 4px 0;
            }
            20% {
                background-position: -4px 0;
            }
            30% {
                background-position: 12px 0;
            }
            40% {
                background-position: -16px 0;
            }
            50% {
                background-position: -24px 0;
            }
            60% {
                background-position: -52px 0;
            }
            70% {
                background-position: 0 22px;
            }
            80% {
                background-position: -40px -10px;
            }
            100% {
                background-position: 0 0;
                filter: hue-rotate(360deg);
            }
        }
    </style>
</head>
<body>

<div class="glitch"></div>
<a href="/" style="z-index: 100; font-size: 30px; text-decoration: none; position: fixed; right:450px;
    bottom:130px; color: white;">GO HOME</a>
</body>
</html>