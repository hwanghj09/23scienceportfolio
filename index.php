<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .main-content {
            text-align: center;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        #slider-btn {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .slider {
            display: none;
            position: fixed;
            top: 0;
            right: 0;
            background-color: #f1f1f1;
            padding: 20px;
            width: 200px;
            text-align: right;
        }

        .slider button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            background: none;
            border: none;
            cursor: pointer;
        }

        #close-btn {
            color: red;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
    <title>Your Website</title>
</head>
<body>

    <div class="main-content">
        <h1>Click to Start!</h1>
        <button id="slider-btn">&#x2630; Menu</button>
    </div>

    <div class="slider">
        <button onclick="openPage('login')">Login</button>
        <button onclick="openPage('signup')">Sign Up</button>
        <button onclick="openPage('settings')">Settings</button>
        <button onclick="openPage('ranking')">Ranking</button>
        <button onclick="openPage('delete')">Delete Account</button>
        <button id="close-btn">&times; Close</button>
    </div>

    <script>
        document.getElementById('slider-btn').addEventListener('click', function() {
            document.querySelector('.slider').style.display = 'block';
        });

        document.getElementById('close-btn').addEventListener('click', function() {
            document.querySelector('.slider').style.display = 'none';
        });

        function openPage(page) {
            // You can add logic to handle different pages here
            console.log('Opening ' + page + ' page');
            // For now, let's just close the slider
            document.querySelector('.slider').style.display = 'none';
        }
    </script>

</body>
</html>
