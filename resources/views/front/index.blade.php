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
                <button class="btn-details" id="details-btn" onClick="loadDetail();">Details</button>
            </div>
            <div class="info">
                <h2>TOTAL CIGARETTE TODAY</h2>
                <span id="cigarette-count">{{ $count }}</span>
                <hr style="margin:10px 0px;">
                <span style="color:#282828;font-weight:500;cursor: pointer;" onclick="updateCigaretteCount()">Refresh
                    Data</span>
            </div>
            <div class="info">
                <h2>Winning Token</h2>
                <span id="winning_token"></span>
            </div>
            <button class="btn" id="buy-btn" style="width: 100%; margin-top: 10px;" onclick="showbuypopup()">Buy
                Cigarette</button>
        </div>
    </div>

    <!-- Details Popup -->
    <div class="popup" id="details-popup">
        <div class="popup-content">
            <span class="close-btn" onclick="document.getElementById('details-popup').style.display='none';">&times;</span>
            <h3>User Details</h3>
            <p>Your Token: <span id="user_token"></span></p>
        </div>
    </div>

    <!-- Buy Popup -->
    <div class="popup" id="buy-popup">
        <div class="popup-content">
            <span class="close-btn" onclick="document.getElementById('buy-popup').style.display='none';">&times;</span>
            <img id="qrImage" src="https://via.placeholder.com/200" alt="Cigarette Image">
            <h3>Buy Cigarette</h3>
            <p>Enjoy your purchase responsibly!</p>
        </div>
    </div>

    <script>
        const cigaretteCount = document.getElementById('cigarette-count');
        const detailsCigaretteCount = document.getElementById('user_token');
        const winningTokenElement = document.getElementById('winning_token');
        const qrImageElement = document.getElementById('qrImage'); // Added this line to define qrImageElement

        const detailsPopup = document.getElementById('details-popup');
        const buyPopup = document.getElementById('buy-popup');

        window.onload = function() {
            winnerToken();
            fetchQrImageUrl(); // Call the function to fetch QR image URL when the page loads
        };

        function showbuypopup() {
            buyPopup.style.display = "flex";
        }

        function loadDetail() {
            fetch("{{ route('info') }}", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.text())
            .then(data => {
                detailsCigaretteCount.textContent = data;
                detailsPopup.style.display = "flex";
            })
            .catch(error => {
                console.error("Error fetching cigarette count:", error);
            });
        }

        function winnerToken() {
            fetch("{{ route('win_token') }}", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.text())
            .then(data => {
                if (data) {
                    winningTokenElement.textContent = data;
                } else {
                    winningTokenElement.textContent = "No winning token today.";
                }
            })
            .catch(error => {
                console.error("Error fetching winning token:", error);
            });
        }

        function fetchQrImageUrl() {
            fetch("{{ route('admin.qrimage.fetch') }}")
            .then(response => response.json())
            .then(data => {
                if (data.image_url) {
                    qrImageElement.src = data.image_url;
                } else {
                    qrImageElement.src = "https://via.placeholder.com/200";
                }
            })
            .catch(error => {
                console.error("Error fetching QR image:", error);
            });
        }

        function updateCigaretteCount() {
            cigaretteCount.textContent = "FETCHING INFO";

            fetch("{{ route('count') }}", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.text())
            .then(data => {
                cigaretteCount.textContent = data;
            })
            .catch(error => {
                console.error("Error fetching cigarette count:", error);
                alert("Error fetching cigarette count.");
            });
        }
    </script>
</body>

</html>
