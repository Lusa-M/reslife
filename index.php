<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login / Register - ResLife</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    * {
      margin: 0; padding: 0;
      box-sizing: border-box;
      font-family: 'Arial', sans-serif;
    }

    body {
      background: linear-gradient(to right, #000, #111);
      color: #fff;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-top: 60px;
    }

    .navbar {
      position: fixed;
      top: 0; left: 0;
      width: 100%;
      background: #000;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 10px 0;
      z-index: 1000;
    }

    .navbar img {
      height: 60px;
    }

    .container {
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.08);
      padding: 30px;
      border-radius: 15px;
      width: 90%;
      max-width: 400px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.3);
      margin-top: 30px;
      backdrop-filter: blur(10px);
    }

    .form-title {
      text-align: center;
      font-size: 28px;
      margin-bottom: 25px;
      color: #ffd700;
    }

    .input-group {
      position: relative;
      margin-bottom: 20px;
    }

    .input-group i {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      color: #888;
    }

    .input-group input {
      width: 100%;
      padding: 12px 12px 12px 35px;
      border: none;
      border-radius: 8px;
      background: #222;
      color: #fff;
    }

    .input-group label {
      position: absolute;
      left: 35px;
      top: -10px;
      background: #111;
      padding: 0 5px;
      font-size: 13px;
      color: #bbb;
    }

    .btn {
      width: 100%;
      padding: 12px;
      background: #ffd700;
      color: #000;
      border: none;
      border-radius: 25px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s;
    }

    .btn:hover {
      background: #ff9800;
    }

    .or {
      text-align: center;
      margin: 20px 0;
      color: #aaa;
    }

    .icons {
      display: flex;
      justify-content: center;
      gap: 20px;
    }

    .icons i {
      font-size: 20px;
      cursor: pointer;
      color: #ddd;
    }

    .icons i:hover {
      color: #fff;
    }

    .links {
      text-align: center;
      margin-top: 15px;
    }

    .links button {
      background: none;
      border: none;
      color: #ffd700;
      font-weight: bold;
      cursor: pointer;
    }

    .recover {
      text-align: right;
      font-size: 13px;
      margin-top: -12px;
      margin-bottom: 10px;
    }

    .recover a {
      color: #bbb;
      text-decoration: none;
    }

    .recover a:hover {
      color: #fff;
    }
  </style>
</head>
<body>

  <!-- Navbar Logo -->
  <div class="navbar">
    <img src="img/logo.png" alt="Logo">
  </div>

  <!-- Register Form -->
  <div class="container" id="signup" style="display:none;">
    <h1 class="form-title">Register</h1>
    <form method="post" action="register.php">
      <div class="input-group">
         <i class="fas fa-user"></i>
         <input type="text" name="fName" id="fName" placeholder="First Name" required>
         <label for="fName">First Name</label>
      </div>
      <div class="input-group">
          <i class="fas fa-user"></i>
          <input type="text" name="lName" id="lName" placeholder="Last Name" required>
          <label for="lName">Last Name</label>
      </div>
      <div class="input-group">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" id="email" placeholder="Email" required>
          <label for="email">Email</label>
      </div>
      <div class="input-group">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" id="password" placeholder="Password" required>
          <label for="password">Password</label>
      </div>
      <div class="input-group">
    <i class="fas fa-id-card"></i>
    <input type="text" name="student_number" id="student_number" placeholder="Student Number" required>
    <label for="student_number">Student Number</label>
</div>

<div class="input-group">
    <i class="fas fa-id-card"></i>
    <input type="text" name="student_number" id="student_number" placeholder="Student Number" required>
    <label for="student_number">Student Number</label>
</div>

<div class="input-group">
    <i class="fas fa-school"></i>
    <select name="university" id="university" required>
        <option value="">Select University</option>
        <option value="University of Pretoria">University of Pretoria</option>
        <option value="University of Johannesburg">University of Johannesburg</option>
        <option value="University of Cape Town">University of Cape Town</option>
        <option value="University of the Witwatersrand">University of the Witwatersrand</option>
        <option value="University of KwaZulu-Natal">University of KwaZulu-Natal</option>
        <option value="University of South Africa (UNISA)">University of South Africa (UNISA)</option>
        <option value="University of Limpopo">University of Limpopo</option>
        <option value="University of Venda">University of Venda</option>
        <option value="Stellenbosch University">Stellenbosch University</option>
        <option value="North-West University">North-West University</option>
        <option value="Rhodes University">Rhodes University</option>
        <option value="Nelson Mandela University">Nelson Mandela University</option>
        <option value="University of the Free State">University of the Free State</option>
        <option value="Cape Peninsula University of Technology">Cape Peninsula University of Technology</option>
        <option value="Durban University of Technology">Durban University of Technology</option>
        <option value="Tshwane University of Technology">Tshwane University of Technology</option>
        <option value="Vaal University of Technology">Vaal University of Technology</option>
        <option value="Walter Sisulu University">Walter Sisulu University</option>
        <option value="Mangosuthu University of Technology">Mangosuthu University of Technology</option>
        <option value="Eduvos">Eduvos</option>
    </select>
    <label for="university">University</label>
</div>


     <input type="submit" class="btn" value="Sign Up" name="signUp">
    </form>
    <p class="or">OR</p>
    <div class="icons">
      <i class="fab fa-google"></i>
      <i class="fab fa-facebook"></i>
    </div>
    <div class="links">
      <p>Already have an account?</p>
      <button id="signInButton">Sign In</button>
    </div>
  </div>

  <!-- Login Form -->
  <div class="container" id="signIn">
    <h1 class="form-title">Sign In</h1>
    <form method="post" action="register.php">
      <div class="input-group">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" id="email" placeholder="Email" required>
          <label for="email">Email</label>
      </div>
      <div class="input-group">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" id="password" placeholder="Password" required>
          <label for="password">Password</label>
      </div>
      <p class="recover"><a href="#">Recover Password</a></p>
      <input type="submit" class="btn" value="Sign In" name="signIn">
    </form>
    <p class="or">OR</p>
    <div class="icons">
      <i class="fab fa-google"></i>
      <i class="fab fa-facebook"></i>
    </div>
    <div class="links">
      <p>Don't have an account?</p>
      <button id="signUp">Sign Up</button>
    </div>
  </div>

  <script>
    // Toggle forms
    document.getElementById('signUp').onclick = () => {
      document.getElementById('signIn').style.display = 'none';
      document.getElementById('signup').style.display = 'block';
    };
    document.getElementById('signInButton').onclick = () => {
      document.getElementById('signup').style.display = 'none';
      document.getElementById('signIn').style.display = 'block';
    };
  </script>
</body>
</html>
