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
            <div class="info details-container">
                <h2>YOUR ID: {{ Auth::id() }}</h2>
                <button class="btn-details" id="details-btn">Details</button>
            </div>
            <div class="info">
                <h2>TOTAL CIGARETTE TODAY</h2>
                <span id="cigarette-count">{{ $count }}</span>
                <hr style="margin:10px 0px;">
                <span style="color:#282828;font-weight:500;cursor: pointer;" onclick="updateCigaretteCount()">Refresh Data</span>
            </div>
            <button class="btn" id="buy-btn" style="width: 100% ; margin-top: 10px;">Buy Cigarette</button>
        </div>
    </div>

    <div class="popup" id="details-popup">
        <div class="popup-content">
            <span class="close-btn" id="close-details-btn">&times;</span>
            <h3>User Details</h3>
            <p>Your User ID: {{ Auth::id() }}</p>
            <p>Total Cigarettes Today: <span id="details-cigarette-count">{{ $count }}</span></p>
        </div>
    </div>


    <div class="popup" id="buy-popup">
        <div class="popup-content">
            <span class="close-btn" id="close-buy-btn">&times;</span>
            <img src="https://via.placeholder.com/200" alt="Cigarette Image">
            <h3>Buy Cigarette</h3>
            <p>Enjoy your purchase responsibly!</p>
        </div>
    </div>

    <script>
        const cigaretteCount = document.getElementById('cigarette-count');
        const detailsCigaretteCount = document.getElementById('details-cigarette-count');

        const updateCigaretteCount = () => {
            cigaretteCount.textContent = "FETCHING INFO";

            fetch("{{ route('count') }}", {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json"
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then(data => {
                    cigaretteCount.textContent = data;
                    detailsCigaretteCount.textContent = data;
                })
                .catch(error => {
                    console.error("Error fetching cigarette count:", error);
                    alert("Error fetching cigarette count.");
                });
        };

        document.addEventListener('DOMContentLoaded', () => {
            const detailsBtn = document.getElementById('details-btn');
            const buyBtn = document.getElementById('buy-btn');

            const detailsPopup = document.getElementById('details-popup');
            const buyPopup = document.getElementById('buy-popup');

            const closeDetailsBtn = document.getElementById('close-details-btn');
            const closeBuyBtn = document.getElementById('close-buy-btn');

            detailsBtn.addEventListener('click', () => {
                detailsPopup.style.display = 'flex';
                updateCigaretteCount();
            });

            buyBtn.addEventListener('click', () => {
                buyPopup.style.display = 'flex';
            });

            closeDetailsBtn.addEventListener('click', () => {
                detailsPopup.style.display = 'none';
            });

            closeBuyBtn.addEventListener('click', () => {
                buyPopup.style.display = 'none';
            });

            window.addEventListener('click', (e) => {
                if (e.target === detailsPopup) {
                    detailsPopup.style.display = 'none';
                }
                if (e.target === buyPopup) {
                    buyPopup.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>
