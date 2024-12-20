<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Cigarette Interface</title>
    <link rel="stylesheet" href="{{ asset('asset/front/index.css') }}">
    <style>
        h5 {
            color: black;

        }

        h5 span {
            color: black;
        }
    </style>
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
                <div class="head" style="display:flex;justify-content: space-between;margin-bottom: 10px">
                    <h2>Winning Token</h2>
                    <button class="btn btn-primary" onclick="winnerToken();">
                        Show
                    </button>
                </div>
                <div id="winning_token"></div>
            </div>
            <button class="btn" id="buy-btn" style="width: 100%; margin-top: 10px;" onclick="showbuypopup()">Buy
                Cigarette</button>
        </div>
    </div>

    <!-- Details Popup -->
    <div class="popup" id="details-popup">
        <div class="popup-content">
            <span class="close-btn"
                onclick="document.getElementById('details-popup').style.display='none';">&times;</span>
            <h3>User Details</h3>
            <p>Your Token: <span id="user_token"></span></p>
        </div>
    </div>

    <!-- Buy Popup -->
    <div class="popup" id="buy-popup">
        <div class="popup-content">
            <span class="close-btn" onclick="document.getElementById('buy-popup').style.display='none';">&times;</span>
            <img src="{{ asset($imageURL) }}" alt="Random Image" style="max-width: 500px; border: 2px solid #ccc;">
            <h3>Buy Cigarette</h3>
            <p>Enjoy your purchase responsibly!</p>
        </div>
    </div>

    <script>
        const cigaretteCount = document.getElementById('cigarette-count');
        const detailsCigaretteCount = document.getElementById('user_token');
        const winningTokenElement = document.getElementById('winning_token');
        const detailsPopup = document.getElementById('details-popup');
        const buyPopup = document.getElementById('buy-popup');


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
            fetch(`{{ route('win_token') }}`, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json"
                    }
                })
                .then(response => response.text())
                .then(data => {
                    winningTokenElement.innerHTML = data;
                })
                .catch(error => {
                    console.error("Error fetching winning token:", error);
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

        function generateCode() {
            const code = getRandomCode();

            fetch("{{ route('getOTP') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        randomCode: code
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('cashoutBtn').style.display = 'none';
                    const otpElement = document.getElementById('otpElement');
                    if (otpElement) {
                        otpElement.textContent = "This is Your OTP: " + data;
                    }
                })
                .catch(error => {
                    console.error("Error fetching OTP:", error);
                    alert("Error fetching OTP.");
                });
        }

        function getRandomCode() {
            const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            const codeLength = 8;
            let randomCode = '';
            for (let i = 0; i < codeLength; i++) {
                randomCode += chars[Math.floor(Math.random() * chars.length)];
            }
            return randomCode;
        }
    </script>
</body>

</html>
