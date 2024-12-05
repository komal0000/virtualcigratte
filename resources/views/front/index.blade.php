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
            <div class="info text-start" style="text-align: left !important;">
                <h2>YOUR ID : {{ Auth::id() }}</h2>
            </div>
            <div class="info">
                <h2>TOTAL CIGARETTE TODAY</h2>
                <span  id="cigarette-count" >
                    FETCHING INFO
                </span>
                <hr style="margin:10px 0px;">
                <span style="color:#282828;font-weight:500;cursor: pointer;" onclick="updateCigaretteCount()">Refresh Data</span>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const cigaretteCount = document.getElementById('cigarette-count');
        const updateCigaretteCount = () => {
            cigaretteCount.textContent="FETCHING INFO"
            $.ajax({
                url: "{{ route('count') }}",
                method: "GET",
                success: function(response) {
                    cigaretteCount.textContent = response;

                },
                error: function() {
                    alert('Error fetching cigarette count.');
                }
            });
        };
        document.addEventListener('DOMContentLoaded', () => {
            const buyBtn = document.getElementById('buy-btn');
            const popup = document.getElementById('popup');
            const closeBtn = document.getElementById('close-btn');
            buyBtn.addEventListener('click', () => {
                popup.style.display = 'flex';
                updateCigaretteCount();
            });
            closeBtn.addEventListener('click', () => {
                popup.style.display = 'none';
            });
            window.addEventListener('click', (e) => {
                if (e.target === popup) {
                    popup.style.display = 'none';
                }
            });
            updateCigaretteCount();
        });
    </script>

</body>

</html>
