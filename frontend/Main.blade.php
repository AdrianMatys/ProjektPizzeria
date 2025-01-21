<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pyszna Pizza</title>
  <link rel="icon" type="image/x-icon" href="/assets/pizza_icon.png">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  <style>
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: Arial, sans-serif;
    }
    .main {
      position: relative;
      min-height: 100vh;
      overflow: hidden;
    }
    .background {
      position: absolute;
      inset: 0;
      z-index: 0;
    }
    .background img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: brightness(75%);
      animation: zoomBackground 20s infinite alternate;
    }
    @keyframes zoomBackground {
      0% {
        transform: scale(1);
      }
      100% {
        transform: scale(1.1);
      }
    }
    .content {
      position: relative;
      z-index: 10;
    }
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 1rem;
      padding-top: 2rem;
    }
    .title {
      font-family: 'Bebas Neue', cursive;
      font-size: 3rem;
      font-weight: bold;
      text-align: center;
      margin-bottom: 3rem;
      background: linear-gradient(45deg, #f97316, #fbbf24, #f97316);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      background-size: 200% 200%;
      animation: textGradient 5s ease infinite, fadeInDown 1.5s ease-out;
    }
    @keyframes fadeInDown {
      0% {
        opacity: 0;
        transform: translateY(-20px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }
    @keyframes textGradient {
      0% {
        background-position: 0% 50%;
      }
      50% {
        background-position: 100% 50%;
      }
      100% {
        background-position: 0% 50%;
      }
    }
    .card {
      max-width: 28rem;
      margin: 0 auto;
      background-color: rgba(41, 37, 36, 0.8);
      border-radius: 1.5rem;
      padding: 2rem;
      text-align: center;
      backdrop-filter: blur(4px);
    }
    .icon-wrapper {
      display: flex;
      justify-content: center;
      margin-bottom: 1rem;
    }
    .icon-bg {
      background-color: #f97316;
      padding: 0.75rem;
      border-radius: 50%;
    }
    .icon {
      width: 32px;
      height: 32px;
      color: white;
    }
    .card-title {
      font-size: 1.875rem;
      font-weight: bold;
      color: white;
      margin-bottom: 0.25rem;
      animation: textWave 2s ease-in-out infinite;
    }
    .card-subtitle {
      font-size: 1.25rem;
      color: rgba(255, 255, 255, 0.9);
      margin-bottom: 1.75rem;
      animation: textFade 3s ease-in-out infinite;
    }
    @keyframes textWave {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-5px);
      }
    }
    @keyframes textFade {
      0%, 100% {
        opacity: 1;
      }
      50% {
        opacity: 0.7;
      }
    }
    .button {
      background-color: #f97316;
      color: white;
      padding: 1rem 1.5rem;
      font-size: 1.2rem;
      font-weight: bold;
      text-transform: uppercase;
      border-radius: 8rem;
      text-decoration: none;
      display: inline-block;
      position: relative;
      overflow: hidden;
      transition: all 0.3s ease;
      box-shadow: 0 4px 6px rgba(249, 115, 22, 0.25);
    }
    .button:before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(
        120deg,
        transparent,
        rgba(255, 255, 255, 0.3),
        transparent
      );
      transition: all 0.6s;
    }
    .button:hover {
      background-color: #ea580c;
      transform: translateY(-3px);
      box-shadow: 0 6px 8px rgba(249, 115, 22, 0.3);
    }
    .button:hover:before {
      left: 100%;
    }
    .button:active {
      transform: translateY(-1px);
      box-shadow: 0 3px 4px rgba(249, 115, 22, 0.2);
    }
    @media (min-width: 768px) {
      .title {
        font-size: 4.5rem;
      }
    }
    @keyframes pulse {
      0% {
        box-shadow: 0 0 0 0 rgba(249, 115, 22, 0.7);
      }
      70% {
        box-shadow: 0 0 0 10px rgba(249, 115, 22, 0);
      }
      100% {
        box-shadow: 0 0 0 0 rgba(249, 115, 22, 0);
      }
    }
    .button {
      animation: pulse 2s infinite;
    }
  </style>
</head>
<body>
  <main class="main">
    <div class="background">
      <img
        src="/assets/pablo-pacheco-D3Mag4BKqns-unsplash.jpg"
        alt="Pizza background"
      />
    </div>
    
    <div class="content">
      <div class="container">
        <h1 class="title">
          PYSZNA PIZZA, NIEZAPOMNIANE CHWILE!
          {{__('navbar.pizzas')}}
        </h1>
        
        <div class="card">
          <div class="icon-wrapper">
            <div class="icon-bg">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                <path d="M15 11h.01"></path>
                <path d="M11 15h.01"></path>
                <path d="M16 16h.01"></path>
                <path d="m2 16 20 6-6-20A20 20 0 0 0 2 16"></path>
                <path d="M5.71 17.11a17.04 17.04 0 0 1 11.4-11.4"></path>
              </svg>
            </div>
          </div>
          <h2 class="card-title">
            Witamy w Pizzerii
          </h2>
          <p class="card-subtitle">
            Najlepsza w Twoim mieście
          </p>
          <a href="{{route('client.menu.index')}}" class="button">
            Zamów
          </a>
        </div>
      </div>
    </div>
  </main>
</body>
</html>















