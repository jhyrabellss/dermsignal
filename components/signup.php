<script src="../jquery/jquery.js"></script>
<script src="../scripts/sweetalert.js"></script>

<div class="form-popup" id="myFormSignUp">
            <form class="form-container" action="../backend/user/signup.php" method="POST">
                <div class="close-popup-cont">
                    <div class="close-popup" onclick="closeForm('myFormSignUp')">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" height="10px" width="10px" version="1.1" id="Capa_1" viewBox="0 0 460.775 460.775" xml:space="preserve">
                        <path d="M285.08,230.397L456.218,59.27c6.076-6.077,6.076-15.911,0-21.986L423.511,4.565c-2.913-2.911-6.866-4.55-10.992-4.55  c-4.127,0-8.08,1.639-10.993,4.55l-171.138,171.14L59.25,4.565c-2.913-2.911-6.866-4.55-10.993-4.55  c-4.126,0-8.08,1.639-10.992,4.55L4.558,37.284c-6.077,6.075-6.077,15.909,0,21.986l171.138,171.128L4.575,401.505  c-6.074,6.077-6.074,15.911,0,21.986l32.709,32.719c2.911,2.911,6.865,4.55,10.992,4.55c4.127,0,8.08-1.639,10.994-4.55  l171.117-171.12l171.118,171.12c2.913,2.911,6.866,4.55,10.993,4.55c4.128,0,8.081-1.639,10.992-4.55l32.709-32.719  c6.074-6.075,6.074-15.909,0-21.986L285.08,230.397z"/>
                    </svg>
                    </div>
                </div>
                <div class="log-in-text">
                    <h1>
                        Sign Up
                    </h1>
                </div>
                <div><input type="text" placeholder="First Name" name="fname" id="fname" required></div>
                <div><input type="text" placeholder="Middle Name" name="mname" id="mname" required></div>
                <div><input type="text" placeholder="Last Name" name="lname" id="lname" required></div>
                <div><input type="text" placeholder="Username" name="username" id="username" required></div>
                <div><input type="email" placeholder="Email" name="email" id="email" required></div>
                <div><input type="password" placeholder="Password" name="password" id="password"  required></div>
                <div><input type="password" placeholder="Confirm Password" name="password" id="confirmPass"  style="margin-top: 10px;"></div>
                <div class="log-in-btn" ><button type="submit" class="button">Sign up</button></div>
                <div class="acc-status" >Already have an account? <span onclick="openForm('myFormLogIn')">Log in</span> </div>
            </form>
  </div>
  <script src="../jquery/signup.js"></script>