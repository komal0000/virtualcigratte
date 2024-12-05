<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Cigarette Interface</title>
    <link rel="stylesheet" href="{{ asset('asset/front/index.css') }}">
</head>

<body>
    <div class="container">
        <div class="box">
            <div class="info">
                <h2> User ID</h2>
                <span>12345</span>
            </div>
            <div class="info">
                <h2>The total number of cigarette sold today</h2>
                <span>10</span>
            </div>
            <button class="btn" id="buy-btn">Buy Cigarette</button>
        </div>
    </div>

    <div class="popup" id="popup">
        <div class="popup-content">
            <span class="close-btn" id="close-btn">&times;</span>
            <img src="https://via.placeholder.com/200" alt="Cigarette Image">
            <h3>Buy Cigarette</h3>
            <p>Enjoy your purchase responsibly!</p>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const buyBtn = document.getElementById('buy-btn');
        const popup = document.getElementById('popup');
        const closeBtn = document.getElementById('close-btn');

        // Show pop-up
        buyBtn.addEventListener('click', () => {
            popup.style.display = 'flex';
        });

        // Close pop-up
        closeBtn.addEventListener('click', () => {
            popup.style.display = 'none';
        });

        // Close pop-up when clicking outside
        window.addEventListener('click', (event) => {
            if (event.target === popup) {
                popup.style.display = 'none';
            }
        });
    });
</script>
