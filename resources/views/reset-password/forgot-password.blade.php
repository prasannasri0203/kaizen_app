<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Css link -->
   <link rel="icon" type="image/x-icon" href="{{asset('images/fevi.png')}}">
  <link rel="stylesheet" type="text/css" href="js/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <!-- responsive link -->
  <link rel="stylesheet" type="text/css" href="css/responsive.css">

</head>
<body>
  <div class="page-wrapper">   
    <!-- main section --> 
    <main class="page-cont">
      <div class="main">
        <div class="login-sec">         
          <img  class="logo-set" src="images/kaizen-logo 1.png" alt="login img">
          <h1>Forgot Password</h1>
           
          <form class="form-group" action="{{route('forgot-otp-post')}}" method="POST">
            @csrf 
            <div class="login-bx">
              <span class="us"><img src="images/user.png" alt="user"></span>                  
              <input type="email" placeholder="Email Address" class="form-control  @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email')}}"  >
              @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div> 
              <button class="for-btn" style="color: #fff; text-align: center;  font-style: normal;  font-weight: 700;  font-size: 18px; line-height: 22px;"> Submit </button> 

            <div style="margin-top:20px;">
                <center> <label class="login_float_center"><a href="{{route('admin-login')}}">Back to login</a> </label></center>
            </div>
          </form>
        </div>
      </div>
    </main>
  </div>

  <!-- Bootstrap link --> 
  <script  src="js/bootstrap.min.js"></script>
  <script  src="js/popper.min.js"></script>
  <script  src="js/slim.min.js"></script>
  <!-- js link -->
  <script  src="js/custom.js" type="text/javascript"></script>
  <script>$('.menu-ico-g').click(function(){
    $('.page-wrapper').toggleClass('hide')
  })</script>

  <script>
    $(".toggle-password").click(function() {

      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $($(this).attr("toggle"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });
  </script>
</body>
</html>