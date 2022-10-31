<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Easyco | API</title>
</head>
<style>
  :root {
    --primary-color: hsl(196, 78%, 61%);
    --secondary-color: hsl(217, 15%, 83%);
    --success-color: hsl(165, 58%, 55%);
    --info-color: hsl(214, 79%, 65%);
    --warning-color: hsl(43, 100%, 66%);
    --danger-color: hsl(354, 81%, 63%);
    --primary-color-darker: hsl(196, 68%, 54%);
    --secondary-color-darker: hsl(215, 13%, 70%);
    --success-color-darker: hsl(165, 55%, 48%);
    --info-color-darker: hsl(214, 68%, 58%);
    --warning-color-darker: hsl(39, 97%, 62%);
    --danger-color-darker: hsl(354, 67%, 56%);
    --primary-color-lighter: hsl(196, 78%, 81%);
    --secondary-color-lighter: hsl(214, 16%, 92%);
    --success-color-lighter: hsl(165, 58%, 75%);
    --info-color-lighter: hsl(214, 79%, 85%);
    --warning-color-lighter: hsl(43, 100%, 86%);
    --danger-color-lighter: hsl(354, 81%, 83%);
    --secondary-color-darkest: hsl(215, 11%, 30%);
    --secondary-color-lightest: hsl(220, 1%, 98%);
    --ease-in-quad: cubic-bezier(0.55, 0.085, 0.68, 0.53);
    --ease-in-cubic: cubic-bezier(0.55, 0.055, 0.675, 0.19);
    --ease-in-quart: cubic-bezier(0.895, 0.03, 0.685, 0.22);
    --ease-in-quint: cubic-bezier(0.755, 0.05, 0.855, 0.06);
    --ease-in-expo: cubic-bezier(0.95, 0.05, 0.795, 0.035);
    --ease-in-circ: cubic-bezier(0.6, 0.04, 0.98, 0.335);
    --ease-out-quad: cubic-bezier(0.25, 0.46, 0.45, 0.94);
    --ease-out-cubic: cubic-bezier(0.215, 0.61, 0.355, 1);
    --ease-out-quart: cubic-bezier(0.165, 0.84, 0.44, 1);
    --ease-out-quint: cubic-bezier(0.23, 1, 0.32, 1);
    --ease-out-expo: cubic-bezier(0.19, 1, 0.22, 1);
    --ease-out-circ: cubic-bezier(0.075, 0.82, 0.165, 1);
    --ease-in-out-quad: cubic-bezier(0.455, 0.03, 0.515, 0.955);
    --ease-in-out-cubic: cubic-bezier(0.645, 0.045, 0.355, 1);
    --ease-in-out-quart: cubic-bezier(0.77, 0, 0.175, 1);
    --ease-in-out-quint: cubic-bezier(0.86, 0, 0.07, 1);
    --ease-in-out-expo: cubic-bezier(1, 0, 0, 1);
    --ease-in-out-circ: cubic-bezier(0.785, 0.135, 0.15, 0.86);
  }

  body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: radial-gradient(ellipse at bottom, #0d1d31 0%, #0c0d13 100%);
    overflow: hidden;
  }

  .stars {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 120%;
    transform: rotate(-45deg);
  }

  .star {
    --star-color: var(--primary-color);
    --star-tail-length: 6em;
    --star-tail-height: 2px;
    --star-width: calc(var(--star-tail-length) / 6);
    --fall-duration: 9s;
    --tail-fade-duration: var(--fall-duration);
    position: absolute;
    top: var(--top-offset);
    left: 0;
    width: var(--star-tail-length);
    height: var(--star-tail-height);
    color: var(--star-color);
    background: linear-gradient(45deg, currentColor, transparent);
    border-radius: 50%;
    filter: drop-shadow(0 0 6px currentColor);
    transform: translate3d(104em, 0, 0);
    animation: fall var(--fall-duration) var(--fall-delay) linear infinite, tail-fade var(--tail-fade-duration) var(--fall-delay) ease-out infinite;
  }

  @media screen and (max-width: 750px) {
    .star {
      animation: fall var(--fall-duration) var(--fall-delay) linear infinite;
    }
  }

  .star:nth-child(1) {
    --star-tail-length: 7.16em;
    --top-offset: 38.42vh;
    --fall-duration: 10.934s;
    --fall-delay: 8.313s;
  }

  .star:nth-child(2) {
    --star-tail-length: 6.22em;
    --top-offset: 57.55vh;
    --fall-duration: 7.684s;
    --fall-delay: 7.428s;
  }

  .star:nth-child(3) {
    --star-tail-length: 5.15em;
    --top-offset: 22.34vh;
    --fall-duration: 6.611s;
    --fall-delay: 5.999s;
  }

  .star:nth-child(4) {
    --star-tail-length: 6.93em;
    --top-offset: 71.83vh;
    --fall-duration: 6.001s;
    --fall-delay: 5.965s;
  }

  .star:nth-child(5) {
    --star-tail-length: 5.56em;
    --top-offset: 55.6vh;
    --fall-duration: 7.821s;
    --fall-delay: 0.942s;
  }

  .star:nth-child(6) {
    --star-tail-length: 5.03em;
    --top-offset: 78.38vh;
    --fall-duration: 6.047s;
    --fall-delay: 2.024s;
  }

  .star:nth-child(7) {
    --star-tail-length: 5.16em;
    --top-offset: 82.97vh;
    --fall-duration: 11.583s;
    --fall-delay: 1.859s;
  }

  .star:nth-child(8) {
    --star-tail-length: 7.02em;
    --top-offset: 30.13vh;
    --fall-duration: 6.196s;
    --fall-delay: 9.398s;
  }

  .star:nth-child(9) {
    --star-tail-length: 6.17em;
    --top-offset: 70.96vh;
    --fall-duration: 8.501s;
    --fall-delay: 3.503s;
  }

  .star:nth-child(10) {
    --star-tail-length: 6.28em;
    --top-offset: 24.05vh;
    --fall-duration: 11.168s;
    --fall-delay: 3.213s;
  }

  .star:nth-child(11) {
    --star-tail-length: 6.49em;
    --top-offset: 15.37vh;
    --fall-duration: 11.785s;
    --fall-delay: 7.101s;
  }

  .star:nth-child(12) {
    --star-tail-length: 5.79em;
    --top-offset: 56.99vh;
    --fall-duration: 10.023s;
    --fall-delay: 6.088s;
  }

  .star:nth-child(13) {
    --star-tail-length: 6.32em;
    --top-offset: 23.26vh;
    --fall-duration: 11.273s;
    --fall-delay: 1.488s;
  }

  .star:nth-child(14) {
    --star-tail-length: 5.43em;
    --top-offset: 27.69vh;
    --fall-duration: 8.914s;
    --fall-delay: 1.038s;
  }

  .star:nth-child(15) {
    --star-tail-length: 6.56em;
    --top-offset: 67.68vh;
    --fall-duration: 9.876s;
    --fall-delay: 9.072s;
  }

  .star:nth-child(16) {
    --star-tail-length: 7.4em;
    --top-offset: 10.45vh;
    --fall-duration: 6.117s;
    --fall-delay: 1.496s;
  }

  .star:nth-child(17) {
    --star-tail-length: 6.92em;
    --top-offset: 39.16vh;
    --fall-duration: 6.013s;
    --fall-delay: 7.772s;
  }

  .star:nth-child(18) {
    --star-tail-length: 6.24em;
    --top-offset: 53.89vh;
    --fall-duration: 7.675s;
    --fall-delay: 0.353s;
  }

  .star:nth-child(19) {
    --star-tail-length: 6.27em;
    --top-offset: 21.01vh;
    --fall-duration: 6.948s;
    --fall-delay: 1.483s;
  }

  .star:nth-child(20) {
    --star-tail-length: 6.74em;
    --top-offset: 18.6vh;
    --fall-duration: 9.18s;
    --fall-delay: 6.636s;
  }

  .star:nth-child(21) {
    --star-tail-length: 7.32em;
    --top-offset: 24.95vh;
    --fall-duration: 6.281s;
    --fall-delay: 6.124s;
  }

  .star:nth-child(22) {
    --star-tail-length: 7.12em;
    --top-offset: 29.52vh;
    --fall-duration: 11.762s;
    --fall-delay: 1.613s;
  }

  .star:nth-child(23) {
    --star-tail-length: 6.75em;
    --top-offset: 91.43vh;
    --fall-duration: 8.76s;
    --fall-delay: 5.417s;
  }

  .star:nth-child(24) {
    --star-tail-length: 5em;
    --top-offset: 42.99vh;
    --fall-duration: 11.109s;
    --fall-delay: 1.493s;
  }

  .star:nth-child(25) {
    --star-tail-length: 5.55em;
    --top-offset: 25.71vh;
    --fall-duration: 9.354s;
    --fall-delay: 1.634s;
  }

  .star:nth-child(26) {
    --star-tail-length: 5.82em;
    --top-offset: 35.07vh;
    --fall-duration: 7.767s;
    --fall-delay: 9.961s;
  }

  .star:nth-child(27) {
    --star-tail-length: 5.64em;
    --top-offset: 10.45vh;
    --fall-duration: 7.943s;
    --fall-delay: 2.863s;
  }

  .star:nth-child(28) {
    --star-tail-length: 5.54em;
    --top-offset: 54.62vh;
    --fall-duration: 7.109s;
    --fall-delay: 1.429s;
  }

  .star:nth-child(29) {
    --star-tail-length: 6.31em;
    --top-offset: 51.45vh;
    --fall-duration: 9.135s;
    --fall-delay: 5.427s;
  }

  .star:nth-child(30) {
    --star-tail-length: 7.25em;
    --top-offset: 61.38vh;
    --fall-duration: 9.244s;
    --fall-delay: 2.274s;
  }

  .star:nth-child(31) {
    --star-tail-length: 5.13em;
    --top-offset: 41.22vh;
    --fall-duration: 11.357s;
    --fall-delay: 6.35s;
  }

  .star:nth-child(32) {
    --star-tail-length: 7.11em;
    --top-offset: 84.22vh;
    --fall-duration: 6.871s;
    --fall-delay: 2.638s;
  }

  .star:nth-child(33) {
    --star-tail-length: 7.39em;
    --top-offset: 95.81vh;
    --fall-duration: 7.944s;
    --fall-delay: 1.906s;
  }

  .star:nth-child(34) {
    --star-tail-length: 6.98em;
    --top-offset: 57.12vh;
    --fall-duration: 6.947s;
    --fall-delay: 1.759s;
  }

  .star:nth-child(35) {
    --star-tail-length: 5.87em;
    --top-offset: 3.07vh;
    --fall-duration: 11.307s;
    --fall-delay: 1.651s;
  }

  .star:nth-child(36) {
    --star-tail-length: 6.59em;
    --top-offset: 89.36vh;
    --fall-duration: 7.72s;
    --fall-delay: 3.598s;
  }

  .star:nth-child(37) {
    --star-tail-length: 5.02em;
    --top-offset: 56.02vh;
    --fall-duration: 9.347s;
    --fall-delay: 0.824s;
  }

  .star:nth-child(38) {
    --star-tail-length: 6.37em;
    --top-offset: 86.23vh;
    --fall-duration: 7.077s;
    --fall-delay: 1.126s;
  }

  .star:nth-child(39) {
    --star-tail-length: 5.51em;
    --top-offset: 25.14vh;
    --fall-duration: 9.348s;
    --fall-delay: 5.847s;
  }

  .star:nth-child(40) {
    --star-tail-length: 5.8em;
    --top-offset: 60.24vh;
    --fall-duration: 6.114s;
    --fall-delay: 3.173s;
  }

  .star:nth-child(41) {
    --star-tail-length: 7.4em;
    --top-offset: 62.09vh;
    --fall-duration: 9.406s;
    --fall-delay: 9.438s;
  }

  .star:nth-child(42) {
    --star-tail-length: 6.73em;
    --top-offset: 93.27vh;
    --fall-duration: 8.037s;
    --fall-delay: 6.731s;
  }

  .star:nth-child(43) {
    --star-tail-length: 6.77em;
    --top-offset: 96.43vh;
    --fall-duration: 6.516s;
    --fall-delay: 5.143s;
  }

  .star:nth-child(44) {
    --star-tail-length: 6.59em;
    --top-offset: 18.59vh;
    --fall-duration: 6.775s;
    --fall-delay: 7.967s;
  }

  .star:nth-child(45) {
    --star-tail-length: 7.32em;
    --top-offset: 60.07vh;
    --fall-duration: 7.168s;
    --fall-delay: 9.653s;
  }

  .star:nth-child(46) {
    --star-tail-length: 6.39em;
    --top-offset: 66.89vh;
    --fall-duration: 6.089s;
    --fall-delay: 7.784s;
  }

  .star:nth-child(47) {
    --star-tail-length: 5.93em;
    --top-offset: 66.99vh;
    --fall-duration: 7.334s;
    --fall-delay: 4.075s;
  }

  .star:nth-child(48) {
    --star-tail-length: 7.2em;
    --top-offset: 12.3vh;
    --fall-duration: 10.612s;
    --fall-delay: 6.567s;
  }

  .star:nth-child(49) {
    --star-tail-length: 7.38em;
    --top-offset: 91.5vh;
    --fall-duration: 10.161s;
    --fall-delay: 0.634s;
  }

  .star:nth-child(50) {
    --star-tail-length: 5.7em;
    --top-offset: 41.46vh;
    --fall-duration: 10.952s;
    --fall-delay: 8.661s;
  }

  .star::before,
  .star::after {
    position: absolute;
    content: "";
    top: 0;
    left: calc(var(--star-width) / -2);
    width: var(--star-width);
    height: 100%;
    background: linear-gradient(45deg, transparent, currentColor, transparent);
    border-radius: inherit;
    animation: blink 2s linear infinite;
  }

  .star::before {
    transform: rotate(45deg);
  }

  .star::after {
    transform: rotate(-45deg);
  }

  @keyframes fall {
    to {
      transform: translate3d(-30em, 0, 0);
    }
  }

  @keyframes tail-fade {

    0%,
    50% {
      width: var(--star-tail-length);
      opacity: 1;
    }

    70%,
    80% {
      width: 0;
      opacity: 0.4;
    }

    100% {
      width: 0;
      opacity: 0;
    }
  }

  @keyframes blink {
    50% {
      opacity: 0.6;
    }
  }
</style>

<body>
  <div class="stars">
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
  </div>
  <div class="glitch-wrap">
    <h1 class="glitch" data-text="KIS">KIS</h1>
  </div>
</body>
<style>
  @import url("https://fonts.googleapis.com/css?family=Montserrat:100");

  html,
  body,
  h1 {
    padding: 0;
    margin: 0;
    font-family: "Montserrat", sans-serif;
  }

  .glitch-wrap {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100;
    height: 100%;
  }

  .glitch {
    position: relative;
    color: white;
    font-size: 50PX;
    letter-spacing: 0.5em;
    /* Animation provies a slight random skew. Check bottom of doc
  for more information on how to random skew. */
    animation: glitch-skew 1s infinite linear alternate-reverse;
  }

  .glitch::before {
    content: attr(data-text);
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    left: 2px;
    text-shadow: -2px 0 #ff00c1;
    /* Creates an initial clip for our glitch. This works in
  a typical top,right,bottom,left fashion and creates a mask
  to only show a certain part of the glitch at a time. */
    clip: rect(44px, 450px, 56px, 0);
    /* Runs our glitch-anim defined below to run in a 5s loop, infinitely,
  with an alternating animation to keep things fresh. */
    animation: glitch-anim 5s infinite linear alternate-reverse;
  }

  .glitch::after {
    content: attr(data-text);
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    left: -2px;
    text-shadow: -2px 0 #00fff9, 2px 2px #ff00c1;
    animation: glitch-anim2 1s infinite linear alternate-reverse;
  }

  /* Creates an animation with 20 steaps. For each step, it calculates 
a percentage for the specific step. It then generates a random clip
box to be used for the random glitch effect. Also adds a very subtle
skew to change the 'thickness' of the glitch.*/
  @keyframes glitch-anim {
    0% {
      clip: rect(22px, 9999px, 88px, 0);
      transform: skew(0.95deg);
    }

    5% {
      clip: rect(67px, 9999px, 72px, 0);
      transform: skew(0.4deg);
    }

    10% {
      clip: rect(64px, 9999px, 59px, 0);
      transform: skew(0.59deg);
    }

    15% {
      clip: rect(24px, 9999px, 27px, 0);
      transform: skew(0.36deg);
    }

    20% {
      clip: rect(89px, 9999px, 27px, 0);
      transform: skew(0.27deg);
    }

    25% {
      clip: rect(8px, 9999px, 61px, 0);
      transform: skew(0.88deg);
    }

    30% {
      clip: rect(68px, 9999px, 37px, 0);
      transform: skew(0.14deg);
    }

    35% {
      clip: rect(3px, 9999px, 26px, 0);
      transform: skew(0.35deg);
    }

    40% {
      clip: rect(32px, 9999px, 25px, 0);
      transform: skew(0.76deg);
    }

    45% {
      clip: rect(38px, 9999px, 71px, 0);
      transform: skew(0.97deg);
    }

    50% {
      clip: rect(62px, 9999px, 93px, 0);
      transform: skew(0.84deg);
    }

    55% {
      clip: rect(77px, 9999px, 53px, 0);
      transform: skew(0.56deg);
    }

    60% {
      clip: rect(24px, 9999px, 55px, 0);
      transform: skew(0.71deg);
    }

    65% {
      clip: rect(49px, 9999px, 12px, 0);
      transform: skew(0.04deg);
    }

    70% {
      clip: rect(51px, 9999px, 14px, 0);
      transform: skew(0.58deg);
    }

    75% {
      clip: rect(33px, 9999px, 100px, 0);
      transform: skew(0.37deg);
    }

    80% {
      clip: rect(59px, 9999px, 38px, 0);
      transform: skew(0.08deg);
    }

    85% {
      clip: rect(22px, 9999px, 49px, 0);
      transform: skew(0.74deg);
    }

    90% {
      clip: rect(77px, 9999px, 82px, 0);
      transform: skew(0.48deg);
    }

    95% {
      clip: rect(24px, 9999px, 81px, 0);
      transform: skew(0.32deg);
    }

    100% {
      clip: rect(16px, 9999px, 56px, 0);
      transform: skew(0.2deg);
    }
  }

  @keyframes glitch-anim2 {
    0% {
      clip: rect(35px, 9999px, 73px, 0);
      transform: skew(0.74deg);
    }

    5% {
      clip: rect(77px, 9999px, 17px, 0);
      transform: skew(0.99deg);
    }

    10% {
      clip: rect(33px, 9999px, 61px, 0);
      transform: skew(0.72deg);
    }

    15% {
      clip: rect(53px, 9999px, 93px, 0);
      transform: skew(0.96deg);
    }

    20% {
      clip: rect(6px, 9999px, 78px, 0);
      transform: skew(0.56deg);
    }

    25% {
      clip: rect(3px, 9999px, 64px, 0);
      transform: skew(0.11deg);
    }

    30% {
      clip: rect(93px, 9999px, 15px, 0);
      transform: skew(0.27deg);
    }

    35% {
      clip: rect(49px, 9999px, 32px, 0);
      transform: skew(0.98deg);
    }

    40% {
      clip: rect(67px, 9999px, 72px, 0);
      transform: skew(0.79deg);
    }

    45% {
      clip: rect(46px, 9999px, 30px, 0);
      transform: skew(0.35deg);
    }

    50% {
      clip: rect(29px, 9999px, 72px, 0);
      transform: skew(0.86deg);
    }

    55% {
      clip: rect(98px, 9999px, 99px, 0);
      transform: skew(0.8deg);
    }

    60% {
      clip: rect(29px, 9999px, 31px, 0);
      transform: skew(0.27deg);
    }

    65% {
      clip: rect(9px, 9999px, 7px, 0);
      transform: skew(0.81deg);
    }

    70% {
      clip: rect(10px, 9999px, 78px, 0);
      transform: skew(0.74deg);
    }

    75% {
      clip: rect(8px, 9999px, 61px, 0);
      transform: skew(0.93deg);
    }

    80% {
      clip: rect(4px, 9999px, 22px, 0);
      transform: skew(0.92deg);
    }

    85% {
      clip: rect(94px, 9999px, 99px, 0);
      transform: skew(0.16deg);
    }

    90% {
      clip: rect(11px, 9999px, 21px, 0);
      transform: skew(0.44deg);
    }

    95% {
      clip: rect(62px, 9999px, 83px, 0);
      transform: skew(0.21deg);
    }

    100% {
      clip: rect(39px, 9999px, 60px, 0);
      transform: skew(0.33deg);
    }
  }

  @keyframes glitch-skew {
    0% {
      transform: skew(-3deg);
    }

    10% {
      transform: skew(-1deg);
    }

    20% {
      transform: skew(-4deg);
    }

    30% {
      transform: skew(-4deg);
    }

    40% {
      transform: skew(3deg);
    }

    50% {
      transform: skew(5deg);
    }

    60% {
      transform: skew(1deg);
    }

    70% {
      transform: skew(1deg);
    }

    80% {
      transform: skew(-1deg);
    }

    90% {
      transform: skew(5deg);
    }

    100% {
      transform: skew(4deg);
    }
  }
</style>

</html>