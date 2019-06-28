<!--completed by anuragz.v@gmail.com-->   
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Confrence Task - SaasLabs</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./css/index.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <script src="./js/validationfunction.js"></script>

</head>
<body>

<div class="container">
  <center><h2>Welcome to SaasConfrence</h2>
  <small>powered by:</small><br/>
  <img src='./images/logo.png'></img>
  <br/><br/>
  <button type="button" class="btn btn-primary btn-lg" id="myBtn">Create a Room</button>
  <button type="button" class="btn btn-success btn-lg" id ="myBtn2">Join a Room</button></center>
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h4>Create Confrence room</h4>
    </div>
    <div class="modal-body">
      <p>Enter the Room name and hit the generate PIN button.</p>
      <form name>
  <div class="form-group">
    <label for="exampleInputEmail1">Room Name</label>
    <input type="text" class="form-control " id="roomname" aria-describedby="roomHelp" placeholder="Enter room name">
    <small id="roomHelp" class="form-text text-muted">Try to guess crazy uncommon names for better availablity.</small><br/>
    <button type="button" class="btn btn-success" onclick="checkname();">Check availablity</button>
    <button type="button" class="btn btn-success" onclick="genpin();">Genrate PIN</button><br/><br/>      
    <div id="generated_pin"style="display: none;font-family:Courier New;font-size:20px"></div><br/>
    <center><div id="availdiv" role ="alert"class = "alert alert-success" style="display: none;"></div></center>
    <center><div id="notavaildiv" role ="alert"class = "alert alert-danger" style="display: none;"></div></center>
     <button type="button" id="createroom" class="btn btn-primary" disabled="true" onclick="submitfunc();"> CREATE ROOM</button><br/><br/>
  </div>
  </form>
    </div>
    <div class="modal-footer">
      <small>powered by twilio API's for SaasLabs</small>
    </div>
  </div>

</div>

<div id="myModal2" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close2">&times;</span>
      <h4>Join Room</h4>
    </div>
    <div class="modal-body">
      <p>Enter the Room name and PIN to join confrence.</p>
      <form name>
  <div class="form-group">
    <label for="exampleInputEmail1">Room Name</label>
    <input type="text" class="form-control " id="roomloginname" placeholder="Enter room name"><br/>
   <input type="password" class="form-control " id="roomloginpin"  placeholder="Enter room PIN"><br/>
   <button type="button" id="joinroom" class="btn btn-primary" onclick="loginroom();">JOIN ROOM</button><br/><br/>
   <center><div id="joinalert" role ="alert"class = "alert alert-danger" style="display: none;"></div>
   <div id="joinsuccess" role ="alert" class = "alert alert-success" style="display: none;"></div></center>
  </div>
  </form>
    </div>
    <div class="modal-footer">
      <small>powered by twilio API's for SaasLabs</small>
    </div>
  </div>

</div>

</div>

<script>
var modal = document.getElementById("myModal");
var modal2 = document.getElementById("myModal2");
var btn = document.getElementById("myBtn");
var btn2 = document.getElementById("myBtn2");
var span = document.getElementsByClassName("close")[0];
var span2 = document.getElementsByClassName("close2")[0];

btn.onclick = function() {
  modal.style.display = "block";
}
btn2.onclick = function() {
  modal2.style.display = "block";
}
span.onclick = function() {
  modal.style.display = "none";
  modal2.style.display = "none";
}
span2.onclick = function() {
  modal2.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

</script>
</body>
</html>