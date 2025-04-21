<?php
session_start();
//ini_set('display_errors', 'Off');
include 'track_visitor.php';
//print_r($_SESSION);
// Embed session data into JavaScript variables
// Extract session data into PHP variables
$userId = json_encode($_SESSION['localuserId'] ?? null); // Default to null
$phone = json_encode($_SESSION['phone'] ?? null);       // Default to null
$loggedIn = json_encode($_SESSION['loggedIn'] ?? false); // Default to false


?>
<!doctype html>
<html lang="en" data-bs-theme="blue-theme">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta content="" name="keywords">
  <meta name="description" content="">
  <meta name="author"
    content="Powered By Marius Boncia is the worlds leader Automated Betting System And Sport Exchange Revolution">

  <title>Marius Boncica | Betting System</title>

  <!-- Bootstrap core CSS -->
  <link rel="manifest" href="/manifest.json">

  <link rel="canonical" href="https://daniel-boncica.com/" />
  <meta property="og:locale" content="en_US" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="Unibet- Enable FREE access to most advanced Betting System. " />
  <meta property="og:url" content="https://daniel-boncica.com/" />
  <meta property="og:site_name" content="UnicoBetis a premier Automated Betting System" />
  <meta property="article:modified_time" content="2024-12-191T07:27:37+00:00" />
  <meta property="og:image" content="LogoUnicoin.png" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />
  <meta property="og:image:type" content="image/png" />
  <meta property="og:image:type" content="image/jpg" />
  <meta name="twitter:image" property="og:image" content="LogoUnicoin.png" />
  <!-- invalid, but expected -->
  <link property="image" href="LogoUnicoin.png" />
  <meta name="twitter:card" content="summary_large_image" />
  <link rel="icon" href="LogoUnicoin.png" sizes="32x32" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="icon" href="LogoUnicoin.png" sizes="32x32" />
  <link rel="icon" href="LogoUnicoin.png" sizes="192x192" />
  <link rel="apple-touch-icon" href="LogoUnicoin.png">
  <link rel="icon" href="LogoUnicoin.png" type="image/png">
  <!-- loader-->

  <!-- loader-->
  <link href="vertical-menu/assets/css/pace.min.css" rel="stylesheet">
  <script src="vertical-menu/assets/js/pace.min.js"></script>

  <!--plugins-->
  <link href="vertical-menu/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="vertical-menu/assets/plugins/metismenu/metisMenu.min.css">
  <link rel="stylesheet" type="text/css" href="vertical-menu/assets/plugins/metismenu/mm-vertical.css">
  <link rel="stylesheet" type="text/css" href="vertical-menu/assets/plugins/simplebar/css/simplebar.css">
  <!--bootstrap css-->
  <link href="vertical-menu/assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
  <!--main css-->
  <link href="vertical-menu/assets/css/bootstrap-extended.css" rel="stylesheet">
  <link href="vertical-menu/sass/main.css" rel="stylesheet">
  <link href="vertical-menu/sass/dark-theme.css" rel="stylesheet">
  <link href="vertical-menu/sass/blue-theme.css" rel="stylesheet">
  <link href="vertical-menu/sass/semi-dark.css" rel="stylesheet">
  <link href="vertical-menu/sass/bordered-theme.css" rel="stylesheet">
  <link href="vertical-menu/sass/responsive.css" rel="stylesheet">
  <link rel="stylesheet" href="strategy/css/jquery.fancybox.min.css">
  <link rel="stylesheet" href="strategy/css/aos.css">
  <link rel="stylesheet" href="strategy/css/jquery.fancybox.min.css">
  <link rel="stylesheet" href="strategy/css/owl.carousel.min.css">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/web3@1.5.3/dist/web3.min.js"></script> <!-- Web3.js -->


  <style>
    .laptop {
      margin: 20px auto;
      max-width: 90%;
      perspective: 1500px;
    }

    .laptop__screen {
      padding: 3%;
      border-radius: 1rem;
      background: linear-gradient(270deg, rgb(1, 2, 22), transparent, transparent);
      animation: animate1 1s linear infinite;
      box-shadow: 0 0 5px rgb(10, 133, 233),
        0 0 1px rgb(10, 133, 233),
        0 0 1px rgb(10, 133, 233),
        0 0 200px rgb(10, 133, 233);
      border: 2px solid #ccc;
      transform: rotateX(50deg);
      transition: transform 0.5s ease, box-shadow 0.5s ease;
      /* Added transition */
    }

    .laptop__screen:hover {
      padding: 3%;
      border-radius: 1rem;
      background: linear-gradient(270deg, rgb(2, 77, 206), transparent, transparent);
      animation: animate1 1s linear infinite;
      box-shadow: 0 0 5px rgb(10, 133, 233),
        0 0 1px rgb(10, 133, 233),
        0 0 1px rgb(10, 133, 233),
        0 0 200px rgb(10, 133, 233);
      border: 2px solid #ccc;
      transform: rotateX(10deg);
      transition: transform 0.5s ease, box-shadow 0.5s ease;
      /* Added transition */
    }


    .session {
      padding: 20px;
      margin: 10px;
      background: black;
      border-radius: 10px;
      box-shadow: inset 0 0 35px 5px rgba(3, 18, 70, 0.45), inset 0 2px 1px 1px rgba(255, 255, 255, 1), inset 0 -2px 1px 0 rgba(0, 0, 0, 1) color: black;
    }

    .logs {
      height: 200px;
      overflow-y: scroll;
      background-color: #000;
      color: #fff;
      border: 1px solid #ddd;
      padding: 10px;
      font-size: 0.9em;
      margin-bottom: 10px;
    }


    .popup {
      display: none;
      position: fixed;
      top: 10%;
      left: 2%;
      bottom: 0%;
      background-color: #225f69;
      backdrop-filter: blur(5px);
      border: 1px solid #ccc;
      padding: 20px;
      max-width: 95%;
      max-height: 90%;
      z-index: 99999999999999;
      overflow-y: scroll !important;


    }

    .popup-content {
      text-align: center;


    }

    .popup button {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
    }

    .cookie-popup {
      position: fixed;
      bottom: 0;
      left: 2%;
      width: 95%;
      background-color: rgba(0, 0, 0, 0.2);
      backdrop-filter: blur(30px);
      color: #fff;
      padding: 10px;
      text-align: center;
      z-index: 99999999999;
    }

    .cookie-popup button {


      border: none;
      padding: 5px 10px;
      margin-left: 10px;
      cursor: pointer;
    }

    .loadinggames {
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
      right: 0;
      width: 100%;
      height: 100%;
      background-image: url('https://i.pinimg.com/originals/5f/00/32/5f0032f29fcde316f9e0ac455a7b924b.gif');
      background-size: cover;
      background-repeat: no-repeat;
      z-index: 999999999;
      opacity: 0.5;
    }

    .responsive-iframe-container {
      position: relative;
      top: 10%;
      left: -20%;
      width: 150% !important;
      padding-bottom: 56.25%;
      /* Aspect ratio: 16:9 (9 divided by 16 equals 0.5625 or 56.25%) */
      height: 0;

    }

    .responsive-iframe-container iframe {
      position: absolute;
      width: 150% !important;
      height: 100%;
      border: 0;

    }

    body,
    html {
      overflow-x: hidden !important;
    }

    @media (max-width: 430px) {
      .responsive-iframe-container iframe {
        position: absolute;
        width: 150% !important;
        height: 500% !important;
        border: 0;
      }

      body {
        max-width: 100% !important;
        overflow-x: hidden !important;
      }

      main {
        margin-left: 5%;
      }

      .main-wrapper {
        width: 100% !important;
        margin-left: 5% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
      }

      .main-content {
        width: 100% !important;
        margin-left: 5% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
      }

      .top-header {
        margin-right: 5% !important;
      }
    }

    @media (max-width: 1274px) {
      .responsive-iframe-container iframe {
        position: absolute;
        width: 150% !important;
        height: 260% !important;
        border: 0;
      }
    }

    @media (max-width: 474px) {
      .responsive-iframe-container iframe {
        position: absolute;
        width: 150% !important;
        height: 400% !important;
        border: 0;
      }
    }

    @media (max-width: 840px) {
      .responsive-iframe-container iframe {
        position: absolute;
        width: 150% !important;
        height: 550% !important;
        border: 0;
      }
    }

    /* Custom Scrollbar Styling */
    ::-webkit-scrollbar {
      width: 10px;
      /* Width of the scrollbar */
      height: 10px;
      /* Height of the scrollbar (for horizontal scrollbars) */
    }

    ::-webkit-scrollbar-track {
      background: rgb(1, 1, 15);
      /* Dark blue track */
      border-radius: 10px;
      /* Rounded corners */
    }

    ::-webkit-scrollbar-thumb {
      background: rgb(0, 6, 10);
      /* Cyan thumb */
      border-radius: 10px;
      /* Rounded corners */
      border: 2px solidrgb(2, 15, 29);
      /* Adds padding effect */
    }

    ::-webkit-scrollbar-thumb:hover {
      background: rgb(0, 1, 4);
      /* Darker cyan on hover */
    }

    /* Optional: Style for Firefox */
    * {
      scrollbar-width: thin;
      /* Thin scrollbar */
      scrollbar-color: rgb(1, 6, 31) #001f3f;
      /* Cyan thumb, dark blue track */
    }


    #drag-container,
    #spin-container {
      position: relative;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      margin: auto;
      -webkit-transform-style: preserve-3d;
      transform-style: preserve-3d;
      -webkit-transform: rotateX(-10deg);
      transform: rotateX(-10deg);
    }

    #drag-container img,
    #drag-container video {
      -webkit-transform-style: preserve-3d;
      transform-style: preserve-3d;
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      line-height: 200px;
      font-size: 50px;
      text-align: center;
      -webkit-box-shadow: 0 0 8px #fff;
      box-shadow: 0 0 8px #fff;
      -webkit-box-reflect: below 10px linear-gradient(transparent, transparent, #0005);
    }

    #drag-container img:hover,
    #drag-container video:hover {
      -webkit-box-shadow: 0 0 15px #fffd;
      box-shadow: 0 0 15px #fffd;
      -webkit-box-reflect: below 10px linear-gradient(transparent, transparent, #0007);
    }

    #drag-container p {
      font-family: Serif;
      position: absolute;
      top: 100%;
      left: 50%;
      -webkit-transform: translate(-50%, -50%) rotateX(90deg);
      transform: translate(-50%, -50%) rotateX(90deg);
      color: #fff;
    }

    #ground {
      width: 900px;
      height: 900px;
      position: absolute;
      top: 100%;
      left: 50%;
      -webkit-transform: translate(-50%, -50%) rotateX(90deg);
      transform: translate(-50%, -50%) rotateX(90deg);
      background: -webkit-radial-gradient(center center, farthest-side, #9993, transparent);
    }

    #music-container {
      position: absolute;
      top: 0;
      left: 0;
      display: none;
    }

    @-webkit-keyframes spin {
      from {
        -webkit-transform: rotateY(0deg);
        transform: rotateY(0deg);
      }

      to {
        -webkit-transform: rotateY(360deg);
        transform: rotateY(360deg);
      }
    }

    @keyframes spin {
      from {
        -webkit-transform: rotateY(0deg);
        transform: rotateY(0deg);
      }

      to {
        -webkit-transform: rotateY(360deg);
        transform: rotateY(360deg);
      }
    }

    @-webkit-keyframes spinRevert {
      from {
        -webkit-transform: rotateY(360deg);
        transform: rotateY(360deg);
      }

      to {
        -webkit-transform: rotateY(0deg);
        transform: rotateY(0deg);
      }
    }

    @keyframes spinRevert {
      from {
        -webkit-transform: rotateY(360deg);
        transform: rotateY(360deg);
      }

      to {
        -webkit-transform: rotateY(0deg);
        transform: rotateY(0deg);
      }
    }

    #image-container {
      width: 100%;
      height: 100vh;
      /* Full height of the viewport */
      position: relative;
      background-size: cover;
      background-position: center;
      transition: background-image 0.3s ease-in-out;
      overflow-y: scroll;
      /* Make the container scrollable */
      overflow-x: hidden;
      /* Make the container scrollable */
    }

    .floating-image {
      width: 180px;
      /* Set size for all images */
      animation: float 4s ease-in-out infinite;
      /* Apply the floating animation */
    }

    @keyframes float {

      0%,
      100% {
        transform: translateY(0);
        /* Original position */
      }

      50% {
        transform: translateY(-20px);
        /* Float up */
      }
    }

    .hologram-effect {
      background: rgba(255, 255, 255, 0);
      /* Fully transparent inside */
      border: 3px solid rgba(4, 13, 44, 0.7);
      /* Glowing border with cyan color */
      border-radius: 15px;
      /* Rounded corners for the border */
      padding: 20px;
      /* Padding inside the container */
      position: relative;
      /* For correct positioning of content */
      z-index: 1;
      /* Ensures the hologram stays above other content */
      box-shadow: 0 0 15px rgba(172, 204, 243, 0.7);
      /* Optional: Soft glowing effect around the container */
    }

    body,
    html {
      overflow-x: hidden !important;



    }

    body {
      cursor: url('assets/LogoUnicoin.png'), auto;
      /* Adjust the path to your coin image */
      overflow-x: hidden !important;

    }

    #installButton {
      position: fixed;
      bottom: 20px;
      right: 20px;
      padding: 10px;
      background: linear-gradient(80.92deg, rgba(241, 97, 207, 0.7) -7.62%, rgba(63, 147, 225, 0.77) 105.55%);
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      z-index: 99999999999999999;
    }

    #installButton:hover {
      background: linear-gradient(80.92deg, rgba(26, 84, 176, 0.82) -7.62%, rgba(209, 115, 240, 0.81) 105.55%);
    }
  </style>
</head>

<body>
  <div style="display:none" id="userId"></div>
  <div style="display:none" id="phone"></div>
  <button id="installButton" style="display:none;"><i class="fas fa-mobile-alt"></i> Install App
  </button>
  <script>
    let installPromptEvent = null;

    // Listen for the beforeinstallprompt event to show the "Install" button
    window.addEventListener('beforeinstallprompt', (event) => {
      // Prevent the default installation prompt from showing automatically
      event.preventDefault();
      installPromptEvent = event;

      // Show the install button
      const installButton = document.getElementById('installButton');
      installButton.style.display = 'block'; // Make the button visible

      // Add a click event to the button to trigger the installation
      installButton.addEventListener('click', () => {
        // Show the install prompt
        installPromptEvent.prompt();

        // Wait for the user to either accept or dismiss the prompt
        installPromptEvent.userChoice.then((choiceResult) => {
          if (choiceResult.outcome === 'accepted') {
            console.log('User accepted the install prompt');
          } else {
            console.log('User dismissed the install prompt');
          }
          // Reset the event after the prompt
          installPromptEvent = null;
          installButton.style.display = 'none'; // Optionally hide the button after the prompt
        });
      });
    });

    // Optionally, you can listen to the appinstalled event to know when the app was installed
    window.addEventListener('appinstalled', () => {
      console.log('PWA was installed');
    });

  </script>
  <script>
    // Set session data in localStorage
    localStorage.setItem('userId', <?php echo $userId; ?>);
    localStorage.setItem('phone', <?php echo $phone; ?>);
    localStorage.setItem('loggedIn', <?php echo $loggedIn; ?>);
  </script>
  <script>

    document.addEventListener("DOMContentLoaded", function () {
      // Retrieve user details from localStorage
      const userId = localStorage.getItem("userId");
      const phone = localStorage.getItem("phone");

      // Display user details on the page
      document.getElementById("userId").textContent = userId;
      document.getElementById("phone").textContent = phone;
    });

  </script>
  <!--start header-->
  <header class="top-header" style="width:100% !important;margin-left:-200px !important;padding-left: 0 !important;">
    <nav class="navbar navbar-expand align-items-center" style="margin-left:-100px !important">



      <ul class="navbar-nav gap-4 nav-right-links align-items-center" style="margin-left:30%;">


        <li class="nav-item dropdown position-static d-md-flex" style="display:none !important;">
          <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-auto-close="outside"
            data-bs-toggle="dropdown" href="javascript:;"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26"
              fill="currentColor" class="bi bi-chat" viewBox="0 0 16 16">
              <path
                d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105" />
            </svg></a>
          <div class="dropdown-menu dropdown-menu-end mega-menu shadow-lg p-4 p-lg-5">
            <div class="mega-menu-widgets"
              style="max-width:90% !important;max-height:400px !important;margin-left:20% !important;overflow:hidden !important">
              <div class="chat-wrapper" style="max-height: 400px !important;">
                <div class="chat-sidebar">
                  <div class="chat-sidebar-header">
                    <div class="d-flex align-items-center">
                      <div class="chat-user-online">
                        <img src="assets/daniel.jpg" width="45" height="45" class="rounded-circle" alt="" />
                      </div>
                      <div class="flex-grow-1 ms-2">
                        <p class="mb-0">Unico User</p>
                      </div>

                    </div>

                  </div>
                  <div class="chat-sidebar-content">
                    <div class="tab-content" id="pills-tabContent">
                      <div class="tab-pane fade show active" id="pills-Chats">

                        <div class="chat-list">
                          <div class="list-group list-group-flush">

                            <a href="javascript:;" class="list-group-item">
                              <div class="d-flex">
                                <div class="chat-user-online">
                                  <img src="assets/chatbot.jpg" width="42" height="42" class="rounded-circle" alt="" />
                                </div>
                                <div class="flex-grow-1 ms-2">
                                  <h6 class="mb-0 chat-title">Unico AI Chat Bot</h6>
                                  <p class="mb-0 chat-msg">Hello..</p>
                                </div>
                                <div class="chat-time"></div>
                              </div>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="chat-header d-flex align-items-center">
                  <div class="chat-toggle-btn"><i class='bx bx-menu-alt-left'></i>
                  </div>
                  <div>
                    <h4 class="mb-1 font-weight-bold">Unico AI Chat Bot</h4>

                  </div>

                </div>
                <div class="chat-content" id="chatBox"
                  style="max-height: 300px !important;overflow-y: scroll !important">
                  <div class="chat-content-leftside">
                    <div class="d-flex">
                      <img src="assets/chatbot.jpg" width="48" height="48" class="rounded-circle" alt="" />
                      <div class="flex-grow-1 ms-2">
                        <p class="mb-0 chat-time">Unico Chat Bot,</p>
                        <p class="chat-left-msg">Hello!</p>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="card-footer text-center bg-transparent">
                  <div class="chat-footer d-flex align-items-center">
                    <div class="flex-grow-1 pe-2">
                      <div class="input-group"><span class="input-group-text"><i class='bx bx-smile'></i></span>
                        <input type="text" class="form-control" id="userMessage" placeholder="Type a message">
                        <button class="btn btn-grd btn-grd-primary d-flex gap-2 px-3 border-0" id="sendButton">

                          <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                            class="bi bi-telegram" viewBox="0 0 16 16">
                            <path
                              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.287 5.906q-1.168.486-4.666 2.01-.567.225-.595.442c-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294q.39.01.868-.32 3.269-2.206 3.374-2.23c.05-.012.12-.026.166.016s.042.12.037.141c-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8 8 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629q.14.092.27.187c.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.4 1.4 0 0 0-.013-.315.34.34 0 0 0-.114-.217.53.53 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09" />
                          </svg>Send</button>
                      </div>
                    </div>

                  </div>
                </div>
                <!--start chat overlay-->
                <div class="overlay chat-toggle-btn-mobile"></div>
                <!--end chat overlay-->
              </div>
            </div>

          </div>
        </li>

        <script>
          document.getElementById('sendButton').onclick = function () {
            const userMessage = document.getElementById('userMessage').value.trim();
            if (!userMessage) return;

            // Display user message
            displayMessage(userMessage, 'user');
            document.getElementById('userMessage').value = '';

            // Send message to backend
            fetch('chatbot.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
              },
              body: 'message=' + encodeURIComponent(userMessage),
            })
              .then((response) => response.json())
              .then((data) => {
                if (data.response) {
                  displayMessage(data.response, 'bot');
                }
              })
              .catch((error) => console.error('Error:', error));
          };

          function displayMessage(message, type) {
            const chatBox = document.getElementById('chatBox');
            const messageDiv = document.createElement('div');
            messageDiv.classList.add(type === 'user' ? 'chat-content-rightside' : 'chat-content-leftside');

            const currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            messageDiv.innerHTML = `
     <div class="d-flex ${type === 'user' ? 'ms-auto' : ''}">
       ${type === 'bot' ? `<img src="assets/chatbot.jpg" width="48" height="48" class="rounded-circle" alt="" />` : '<img src="assets/daniel.jpg" width="48" height="48" class="rounded-circle" alt="" /'}
       <div class="flex-grow-1 ${type === 'user' ? 'me-2' : 'ms-2'}">
         <p class="mb-0 chat-time ${type === 'user' ? 'text-end' : ''}">${type === 'user' ? 'You' : 'Unico AI Bot'}, ${currentTime}</p>
         <p class="${type === 'user' ? 'chat-right-msg' : 'chat-left-msg'}">${message}</p>
       </div>
     </div>
   `;

            chatBox.appendChild(messageDiv);
            chatBox.scrollTop = chatBox.scrollHeight; // Auto-scroll to the bottom
          }

        </script>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-auto-close="outside"
            data-bs-toggle="dropdown" href="javascript:;"><i class="material-icons-outlined">apps</i></a>
          <div class="dropdown-menu dropdown-menu-end dropdown-apps shadow-lg p-3"
            style="max-width:300px;margin-left:0px;">
            <div class="border rounded-4 overflow-hidden">
              <div class="row row-cols-3 g-0 border-bottom">
                <div class="col border-end">
                  <div class="app-wrapper d-flex flex-column gap-2 text-center">
                    <div class="app-icon">
                      <a href="mailto: info@unicoais.com"> <img src="vertical-menu/assets/images/apps/01.png" width="36"
                          alt=""></a>
                    </div>
                    <div class="app-name">
                      <a href="mailto: info@unicoais.com" style="color:white">
                        <p class="mb-0">Gmail</p>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col border-end">
                  <div class="app-wrapper d-flex flex-column gap-2 text-center">
                    <div class="app-icon">
                      <a href="https://www.youtube.com/channel/UCzr68CwoBmPAbLFA0hs8Qdg"><img
                          src="vertical-menu/assets/images/apps/04.png" width="36" alt=""></a>
                    </div>
                    <div class="app-name">
                      <a href="https://www.youtube.com/channel/UCzr68CwoBmPAbLFA0hs8Qdg" style="color:white">
                        <p class="mb-0">YouTube</p>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col border-end">
                  <div class="app-wrapper d-flex flex-column gap-2 text-center">
                    <div class="app-icon">
                      <a href="whitehat/bot/delta.php"> <img src="assets/crypto.webp" height="46" alt=""></a>
                    </div>
                    <div class="app-name">
                      <a href="whitehat/bot/delta.php" style="color:white">
                        <p class="mb-0">BOT</p>
                      </a>
                    </div>
                  </div>
                </div>
              </div><!--end row-->






            </div>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" data-bs-auto-close="outside"
            data-bs-toggle="dropdown" href="javascript:;"><i class="material-icons-outlined">notifications</i>
            <span class="badge-notify">1</span>
          </a>
          <div class="dropdown-menu dropdown-notify dropdown-menu-end shadow" style="max-width:280px;">

            <h2 class="text-center">Delta Bot</h2>

            <div class="col" data-aos="fade-up" data-aos-delay="300" style="margin-top:-10px;">

              <div class="card rounded-4">
                <div class="row g-0 align-items-center">
                  <div class="col-md-4 border-end" style="margin-top:-100px;">

                    <div class="p-3 align-self-center">
                      <img src="assets/LogoUnicoin.png" class="w-100 rounded-start" alt="..." style="width:100px;">
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="card-body">
                      <h5 class="card-title">Delta Bot</h5>
                      <p class="card-text">Get FREE Access to Betting Bot.</p>


                    </div>

                    <div class="mt-4 d-flex align-items-center justify-content-between">
                      <a href="whitehat/bot/delta.php" class="btn btn-grd btn-grd-primary d-flex gap-2 px-3 border-0"><i
                          class="material-icons-outlined">shopping_basket</i>Start Now</a>
                      <div class="d-flex gap-1" style="display:none !important;">

                        <div class="dropdown position-relative">
                          <a href="javascript:;" class="sharelink dropdown-toggle dropdown-toggle-nocaret"
                            data-bs-auto-close="outside" data-bs-toggle="dropdown"><i
                              class="material-icons-outlined">share</i></a>
                          <div class="dropdown-menu dropdown-menu-end dropdown-menu-share shadow-lg border-0 p-3">
                            <div class="input-group">
                              <input type="text" class="form-control ps-5" value="https://www.unicobet.co.uk"
                                placeholder="Enter Url">
                              <span
                                class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50">link</span>
                              <span class="input-group-text gap-1"><i
                                  class="material-icons-outlined fs-6">content_copy</i>Copy link</span>
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </li>



        <li class="nav-item dropdown " id="profile">

          <script>
            // Check user's login status
            fetch('check_login_status.php')
              .then(response => response.json())
              .then(data => {
                if (data.loggedIn) {
                  // User is logged in, display account options
                  document.getElementById("profile").innerHTML = `
                  <a href="javascrpt:;" class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
             <img src="assets/daniel.jpg" class="rounded-circle p-1 border" width="45" height="45" alt="">
          </a>
          
          <div class="dropdown-menu dropdown-user dropdown-menu-end shadow" style="max-width:280px;">
            <a class="dropdown-item  gap-2 py-2" href="whitehat/bot/">
              <div class="text-center">
                <img src="assets/daniel.jpg" class="rounded-circle p-1 shadow mb-3" width="50" height="50"
                  alt="">
                <p class="user-name mb-0 fw-bold">Welcome Back</p>
              </div>
            </a>
            <hr class="dropdown-divider">

 <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="whitehat/bot/wallet.php"><i
              class="material-icons-outlined">account_balance_wallet</i>Wallet</a>

            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="whitehat/bot/delta.php"><i
              class="material-icons-outlined">local_bar</i>AI Sport Bots</a>
           

<a class="dropdown-item d-flex align-items-center gap-2 py-2" href="games/football/">
    <i class="material-icons-outlined">sports_soccer</i> Sport Exchange
</a>

            
            <hr class="dropdown-divider">
            <a class="dropdown-item d-flex align-items-center gap-2 py-2" onclick="logout()"><i
            class="material-icons-outlined">power_settings_new</i>Logout</a>
          </div>
                `;
                } else {
                  // User is not logged in, display login and sign up options
                  document.getElementById("profile").innerHTML = `
                   <a href="javascrpt:;" class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
            <button class="btn btn-grd btn-grd-secondary"> <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
  <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
</svg>  Join Us</button>
          </a>
          
          <div class="dropdown-menu dropdown-user dropdown-menu-end shadow" style="max-width:280px;">
            <a class="dropdown-item  gap-2 py-2" href="javascript:;">
              <div class="text-center">
                 
                <h5 class="user-name mb-0 fw-bold">Welcome!</h5>
              </div>
            </a>
            <hr class="dropdown-divider">
            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="login/"><i
              class="material-icons-outlined">person_outline</i>
              Join Us</a>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="login/"><i
              class="material-icons-outlined">local_bar</i>Register</a>
            
             
           
          </div>
                   
                `;
                }
              })
              .catch(error => console.error('Error:', error));

            // Function to logout
            function logout() {
              // Perform logout operations if needed
              // Redirect the user to the logout endpoint or clear session data
              window.location.href = 'logout.php';
            }
          </script>



        </li>



      </ul>

    </nav>
  </header>
  <!--end top header-->



  <!--start main wrapper-->
  <main class="main-wrapper" style="margin:0 !important">
    <div class="main-content" style="background:transparent !important;">
      <!--breadcrumb-->
      <div>


        <!--end breadcrumb-->
        <div id="botsmessageContainer" class="alert alert-warning border-0 bg-grd-warning alert-dismissible fade show"
          style="display:none;position:fixed; top:10px; right:10px;z-index:999999999">

          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <div class="row" style="margin-top:-200px !important">
          <div class="col d-flex align-items-stretch" style="background:transparent !important">

            <div class="card w-100 overflow-hidden rounded-4" style="background:transparent !important">
              <div class="card-body position-relative p-4" style="background:transparent !important">
                <div class="row" style="background:transparent !important">

                  <div class="particlehead"></div>




                  <!-- <div class="container"> -->
                  <div class="site-blocks-cover" style="margin-top:-15% !important;">
                    <div class="container">
                      <div class="row align-items-center justify-content-center text-center">

                        <div class="col-md-12" data-aos="fade-up" data-aos-delay="400">

                          <div class="row" style="margin-top:-50px !important;opacity:0.7">
                            <div class="col d-flex align-items-stretch">
                              <div class="card w-100 overflow-hidden rounded-4">
                                <div class="card-body position-relative p-4">
                                  <h1>I supercharge Web to craft cutting-edge <span class="typed-words" style=" font-size: 2rem; /* Adjust size as needed */
                  font-weight: bold; /* Optional: Make the text bold */
                  background: linear-gradient(to right,  #7928ca, cyan, #e0d504); /* Gradient from blue to cyan */
                  -webkit-background-clip: text; /* Apply gradient to text only */
                  -webkit-text-fill-color: transparent; /* Make the text transparent to show gradient */
                  background-clip: text; /* Fallback for other browsers */
                  color: transparent; /* Fallback for other browsers */"></span></h1>
                                  <p class="lead mb-5">Powered By <img src="LogoUnicoin.png" alt="" width="60px">Unico
                                    for
                                    Automated Daily Tasks. </p>





                                  <div>
                                    <a data-fancybox data-ratio="2"
                                      href="https://youtu.be/EyuO_MKKREA?si=JQcQ2CeMEVnffMgn"
                                      class="btn btn-grd btn-grd-primary">
                                      Watch Video
                                    </a>
                                  </div>


                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>



                  <div class="row">
                    <div class="col mx-auto">
                      <div data-aos="fade-left" data-aos-delay="300">

                        <div id="drag-container">
                          <div id="spin-container">
                            <!-- Add your images (or video) here -->
                            <img
                              src="assets/nobackground/buy-removebg-preview.png?auto=compress&cs=tinysrgb&dpr=1&w=500"
                              alt="">
                            <img
                              src="assets/nobackground/aicode2-removebg-preview.png?auto=compress&cs=tinysrgb&dpr=1&w=500"
                              alt="">
                            <img
                              src="assets/nobackground/bitcoinsicons-removebg-preview.png?auto=compress&cs=tinysrgb&dpr=1&w=500"
                              alt="">
                            <img
                              src="assets/nobackground/cryptobot-removebg-preview.png?auto=compress&cs=tinysrgb&dpr=1&w=500"
                              alt="">
                            <img
                              src="assets/nobackground/exchange-removebg-preview.png?auto=compress&cs=tinysrgb&dpr=1&w=500"
                              alt="">
                            <img src="LogoUnicoin.png?auto=compress&cs=tinysrgb&dpr=1&w=500" alt="">
                            <img
                              src="assets/nobackground/wallet-removebg-preview.png?auto=compress&cs=tinysrgb&dpr=1&w=500"
                              alt="">
                            <!-- Example image with link
    <a class="btn btn-grd-primary"  href="login/">
      <img src="assets/nobackground/wallet-removebg-preview.png?auto=compress&cs=tinysrgb&dpr=1&w=500" alt="">
     
    </a>  -->

                            <!-- Example add video  
    <video controls autoplay="autoplay" loop>
      <source src="https://youtu.be/FQm7AWLSj2I?si=StxyihhvwD2fOhay?auto=compress&cs=tinysrgb&dpr=1&w=500" type="video/mp4">
    </video>
    -->

                            <!-- Text at center of ground -->
                            <p>Unico AI Revolution</p>
                          </div>
                          <div id="ground"
                            style="background-image: url('LogoUnicoin.png'); background-size:cover; background-repeat: no-repeat;">
                          </div>
                        </div>

                        <div id="music-container"></div>
                        <script src="3dcarousel/script.js"></script>
                        <!-- <div class="col">
                          <h6 class="mb-0 text-uppercase"></h6>
                          <hr>
                          <div class="card">
                            <div class="card-body">
                              <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                                <ol class="carousel-indicators">
                                  <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active">
                                  </li>
                                  <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></li>
                                  <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner">
                                  <div class="carousel-item active">
                                    <img src="assets/unico3d.jpg" class="d-block w-100" alt="..." height="400px"
                                      width="400px">
                                    <div class="carousel-caption  d-md-block" style="background:black;opacity:0.8;">

                                      <h5>Unico Web Development</h5>
                                      <p>Futuristic Web 3 Development never been made more easier.</p>
                                    </div>
                                  </div>

                                  <div class="carousel-item">
                                    <img src="assets/rocket.webp" class="d-block w-100" alt="..." height="400px"
                                      width="400px">
                                    <div class="carousel-caption  d-md-block" style="background:black;opacity:0.8;">
                                      <h5>Unico Token Generator Released</h5>
                                      <p>AI Powered Unico Software to deploy ERC-20 Ethereum Blockchain</p>
                                    </div>
                                  </div>
                                  <div class="carousel-item">
                                  

                                    <img src="assets/stakehand.webp" class="d-block w-100" alt="..." height="400px"
                                      width="400px">
                                    <div class="carousel-caption d-md-block" style="background:black;opacity:0.8;">
                                      <h5>Unicoin Staking Has Started! </h5>
     
                                    Unlock the full potential of your Unicoins by staking them today!</p>
                                    </div>
                                  </div>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button"
                                  data-bs-slide="prev"> <span class="carousel-control-prev-icon"
                                    aria-hidden="true"></span>
                                  <span class="visually-hidden">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleCaptions" role="button"
                                  data-bs-slide="next"> <span class="carousel-control-next-icon"
                                    aria-hidden="true"></span>
                                  <span class="visually-hidden">Next</span>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div> -->
                        <div class="card-body p-4" style="margin-top:50px !important" data-aos="fade-in"
                          data-aos-delay="300">

                          <h3 class="">Why Us?</h3>

                          <p>

                          </p>


                          <p>Transforming the betting experience with UniBot, the ultimate AI-powered betting assistant!
                          </p>
                          <p>Unico revolutionizes the betting experience with its advanced AI-powered betting system,
                            delivering precision, efficiency, and unparalleled opportunities for bettors worldwide.</p>
                          <!-- START UNIBOT ANNOUNCEMENT    -->
                          <div class="mt-5">



                            <!-- Unibot end announcement   -->

                            <div class="mt-5">
                              <div class="text-center" id="services">
                                <h5 class="mb-3"><i class="material-icons-outlined">campaign</i> Unico Bot: Launched!
                                </h5>
                                <div class="alert alert-warning border-0 bg-grd-primary" role="alert"
                                  style="color:white; background-image: url('assets/airdrop.webp') !important; background-size: cover; background-position: center;">
                                  <div class="hologram-effect" style="background-color:black;opacity:0.8;">
                                    <h4 class="title">Don't Miss Out!</h4>
                                    <p>Unico <strong>Betting Bot</strong> is <strong>Live!</strong> </p>
                                    <p>🎁 Register now to be part of betting revolution! </p>
                                    <p><strong>Why register?</strong></p>
                                    <p>Get FREE Access!</p>
                                    <p>Exclusive early access to new features!</p>


                                    <p>
                                      <img src="assets/LogoUnicoin.png" class="floating-image">
                                    </p>

                                    <a href="login/" class="btn btn-grd-danger">Register Now</a>
                                    <br />
                                    <br />
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!--  Tokenomics -->




                          </div>
                        </div>
                        <!--CARD BUY -->
                        <Section>
                          <div class="row">
                            <h2 class="text-center">Pricing</h2>

                            <h2 class="text-center text-success">"Get Them All FREE – Start Unico Bot Today!"</h2>
                            <div class="col-12 col-xl-4" data-aos="fade-right" data-aos-delay="300">
                              <div class="card border-top border-4 border-primary">
                                <div class="card-body p-4">
                                  <div
                                    class="px-2 py-1 fw-medium bg-primary bg-opacity-10 text-primary text-uppercase w-100 text-center rounded">
                                    Basic</div>
                                  <div class="my-4">
                                    <h3 class="mb-2">BasicPack 2025</h3>
                                    <p class="mb-0">Limited to 1 Bot</p>
                                  </div>
                                  <div class="pricing-content d-flex flex-column gap-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                      <p class="mb-0 fs-6">£1000.00 Minimum Balance</p>
                                      <p class="mb-0 fw-medium fs-6">yes</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                      <p class="mb-0 fs-6">Self running Bot</p>
                                      <p class="mb-0 fw-medium fs-6">yes</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                      <p class="mb-0 fs-6">Stop Loss</p>
                                      <p class="mb-0 fw-medium fs-6">yes</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                      <p class="mb-0 fs-6">Recovery Mode Enabled</p>
                                      <p class="mb-0 fw-medium fs-6">Yes</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                      <p class="mb-0 fs-6">Support</p>
                                      <p class="mb-0 fw-medium fs-6">Only Mail</p>
                                    </div>
                                  </div>
                                  <div class="price-tag d-flex align-items-center justify-content-center gap-2 my-5">
                                    <h5 class="mb-0 align-self-end text-primary">£</h5>
                                    <h1 class="mb-0 lh-1 price-amount text-primary text-decoration-line-through">69.99
                                    </h1>
                                    <h5 class="mb-0 align-self-end text-primary">/month</h5>
                                  </div>


                                  <div class="d-grid">
                                    <a href="whitehat/bot/delta.php" class="btn btn-lg btn-primary">Get Started</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-xl-4" data-aos="fade-up" data-aos-delay="300">
                              <div class="card border-top border-4 border-success">
                                <div class="card-body p-4">
                                  <div
                                    class="px-2 py-1 fw-medium bg-success bg-opacity-10 text-success text-uppercase w-100 text-center rounded">
                                    Standard</div>
                                  <div class="my-4">
                                    <h3 class="mb-2">Silver Pack 2025</h3>
                                    <p class="mb-0">Made for AI Bots Access</p>
                                  </div>
                                  <div class="pricing-content d-flex flex-column gap-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                      <p class="mb-0 fs-6">AI Bots Access</p>
                                      <p class="mb-0 fw-medium fs-6">Yes</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                      <p class="mb-0 fs-6">£5000.00 Minimum Balance</p>
                                      <p class="mb-0 fw-medium fs-6">Yes</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                      <p class="mb-0 fs-6">Automated Sport switch</p>
                                      <p class="mb-0 fw-medium fs-6">Yes</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                      <p class="mb-0 fs-6">Recovery Mode</p>
                                      <p class="mb-0 fw-medium fs-6">yes</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                      <p class="mb-0 fs-6">Support</p>
                                      <p class="mb-0 fw-medium fs-6">Only Mail</p>
                                    </div>
                                  </div>
                                  <div class="price-tag d-flex align-items-center justify-content-center gap-2 my-5">
                                    <h5 class="mb-0 align-self-end text-success">£</h5>
                                    <h1 class="mb-0 lh-1 price-amount text-success text-decoration-line-through">199.9
                                    </h1>
                                    <h5 class="mb-0 align-self-end text-success">/month</h5>
                                  </div>
                                  <div class="d-grid">
                                    <a href="whitehat/bot/delta.php" class="btn btn-lg btn-success">Get Started</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-xl-4" data-aos="fade-left" data-aos-delay="300">
                              <div class="card border-top border-4 border-danger">
                                <div class="card-body p-4">
                                  <div
                                    class="px-2 py-1 fw-medium bg-danger bg-opacity-10 text-danger text-uppercase w-100 text-center rounded">
                                    Premium</div>
                                  <div class="my-4">
                                    <h3 class="mb-2">Gold Pack 2025</h3>
                                    <p class="mb-0">£20K Balance</p>
                                  </div>
                                  <div class="pricing-content d-flex flex-column gap-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                      <p class="mb-0 fs-6">Back And Lay Strategies</p>
                                      <p class="mb-0 fw-medium fs-6">Yes</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                      <p class="mb-0 fs-6">Recovery Mode</p>
                                      <p class="mb-0 fw-medium fs-6">Yes</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                      <p class="mb-0 fs-6">Stop Loss</p>
                                      <p class="mb-0 fw-medium fs-6">Yes</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                      <p class="mb-0 fs-6"> AI Bots Running</p>
                                      <p class="mb-0 fw-medium fs-6">1000</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                      <p class="mb-0 fs-6">Support</p>
                                      <p class="mb-0 fw-medium fs-6">Only Mail</p>
                                    </div>
                                  </div>
                                  <div class="price-tag d-flex align-items-center justify-content-center gap-2 my-5">
                                    <h5 class="mb-0 align-self-end text-danger">£</h5>
                                    <h1 class="mb-0 lh-1 price-amount text-danger text-decoration-line-through">399.99
                                    </h1>
                                    <h5 class="mb-0 align-self-end text-danger">/month</h5>
                                  </div>
                                  <div class="d-grid">
                                    <a href="whitehat/bot/delta.php" class="btn btn-lg btn-danger">Get Started</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div><!--end row-->

                        </Section>




                      </div>
                    </div>
                  </div>
                </div>



                <!--  TIMELINE   -->



                <div class="row">
                  <div class="col w-100">

                    <div class="card rounded-4" style="margin-top:100px !important;width:100%;" data-aos="fade-up"
                      data-aos-delay="200">
                      <div class="card-body p-4">
                        <div class="position-relative mb-5">

                          <div class="profile-avatar position-absolute top-100 start-50 translate-middle">
                            <img src="assets/danielb.jpg" class="img-fluid rounded-circle p-1 bg-grd-danger shadow"
                              width="170" height="170" alt="">
                          </div>
                        </div>
                        <div class="profile-info pt-5 d-flex align-items-center justify-content-between">
                          <div class="">
                            <h3>Marius Boncica</h3>
                            <p class="mb-0">CEO UNICO GROUP<br>
                              Burnley, United Kingdom</p>
                          </div>
                          <div class="">
                            <a href="https://wa.me/+447588201201" class="btn btn-grd-primary rounded-5 px-4"><i
                                class="bi bi-chat me-2"></i>Send Message</a>
                          </div>
                        </div>
                        <div class="kewords d-flex align-items-center gap-3 mt-4 overflow-x-auto">
                          <button type="button" class="btn btn-sm btn-light rounded-5 px-4">Web Developer</button>

                          <button type="button" class="btn btn-sm btn-light rounded-5 px-4">Backend Developer</button>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>



  </main>
  <!--end main wrapper-->
  

  <div id="cookieBanner" class="cookie-banner">
    <p>
      We use cookies to enhance your experience, analyze site traffic, and serve tailored ads. By continuing to browse
      or by clicking “Accept All,” you agree to our
      <a href="terms.php" target="_blank" class="cookie-link">Terms</a> and
      <a href="terms.php" target="_blank" class="cookie-link">Privacy Policy</a>.
    </p>
    <div class="cookie-actions">
      <button id="acceptCookies" class="btn btn-grd-primary">Accept All</button>
      <button id="declineCookies" class="btn btn-grd-info">Decline</button>
    </div>
  </div>
  <style>
    .cookie-banner {
      position: fixed;
      bottom: 0;
      width: 100%;
      background-color: black;
      opacity: 0.8;
      color: white;
      padding: 15px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 9999;
      box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.2);
      font-family: Arial, sans-serif;
    }

    .cookie-banner p {
      margin: 0;
      font-size: 14px;
      flex: 1;
    }

    .cookie-link {
      color: #1abc9c;
      text-decoration: underline;
    }

    .cookie-actions {
      display: flex;
      gap: 10px;
    }
  </style>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const cookieBanner = document.getElementById("cookieBanner");
      const acceptCookies = document.getElementById("acceptCookies");
      const declineCookies = document.getElementById("declineCookies");

      // Check if cookies have already been accepted
      if (localStorage.getItem("cookiesAccepted") === "true") {
        cookieBanner.style.display = "none";
      }

      // Handle Accept button click
      acceptCookies.addEventListener("click", () => {
        localStorage.setItem("cookiesAccepted", "true");
        cookieBanner.style.display = "none";
      });

      // Handle Decline button click
      declineCookies.addEventListener("click", () => {
        botsdisplayMessage("You have declined cookies. Some features might not work as intended.");
        cookieBanner.style.display = "none";
      });
    });

  </script>

  <!--start overlay-->
  <div class="overlay btn-toggle"></div>
  <!--end overlay-->


  <!--start footer-->


  <div class="text-center"
    style="margin-top: -5px; width:100%; margin-bottom: -2px; background: rgba(1, 4, 19, 0.813) !important; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;color:white">

    <!-- Logo Image -->

    <!-- Copyright Text -->
    <div style="font-size: 14px; color: white; background-color: rgba(1, 4, 19, 0.813) ">
      <img src="assets/LogoUnicoin.png" class="img-fluid" width="40px" alt="Logo">
      Copyright Marius Boncica © 2025.
    </div>
  </div>


  <!--end footer-->




  <!--bootstrap js-->
  <script src="vertical-menu/assets/js/bootstrap.bundle.min.js"></script>

  <!--plugins-->
  <script src="vertical-menu/assets/js/jquery.min.js"></script>
  <!--plugins-->
  <script src="vertical-menu/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
  <script src="vertical-menu/assets/plugins/metismenu/metisMenu.min.js"></script>
  <script src="vertical-menu/assets/plugins/apexchart/apexcharts.min.js"></script>
  <script src="vertical-menu/assets/plugins/simplebar/js/simplebar.min.js"></script>
  <script src="vertical-menu/assets/plugins/peity/jquery.peity.min.js"></script>
  <script>
    $(".data-attributes span").peity("donut")
  </script>
  <script src="vertical-menu/assets/js/main.js"></script>
  <script src="vertical-menu/assets/js/dashboard1.js"></script>
  <script>
    new PerfectScrollbar(".user-list")
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              entry.target.classList.add("in-view");
            } else {
              entry.target.classList.remove("in-view");
            }
          });
        },
        { threshold: 0.1 } // Trigger when 10% of the element is in view
      );

      const cardBodies = document.querySelectorAll(".card-body");
      cardBodies.forEach((cardBody) => observer.observe(cardBody));
    });

  </script>


  <script src="strategy/js/jquery-3.3.1.min.js"></script>


  <script src="strategy/js/modernizr.min.js"></script>
  <script src="strategy/js/three.min.js"></script>
  <script src="strategy/js/TweenMax.min.js"></script>
  <script src="strategy/js/OBJLoader.js"></script>
  <script src="strategy/js/ParticleHead.js"></script>

  <script src="strategy/js/jquery.easing.1.3.js"></script>
  <script src="strategy/js/aos.js"></script>

  <script src="strategy/js/jquery.fancybox.min.js"></script>
  <script src="strategy/js/jarallax.min.js"></script>
  <script src="strategy/js/jarallax-element.min.js"></script>
  <script src="strategy/js/lozad.min.js"></script>

  <script src="strategy/js/typed.js"></script>
  <script>
    var typed = new Typed('.typed-words', {
      strings: [" AI BOTS", " Betting BOTS", " Sport Exchanges", " Web Aps", " Games"," Mobile Apps", " Web Dapps"],
      typeSpeed: 80,
      backSpeed: 80,
      backDelay: 4000,
      startDelay: 1000,
      loop: true,
      showCursor: true
    });
  </script>

  <script src="strategy/js/main.js"></script>

  <script src="app.js"></script>
</body>

</html>