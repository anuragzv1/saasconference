function genpin(){
var rand = Math.floor(Math.random() * (9000) ) + 1000;
document.getElementById("generated_pin").innerHTML = 'Generated Pin : '+'<span id="pin">'+rand+'</span>';
document.getElementById("generated_pin").style.display="block";

}

function checkname(){
    var name = document.getElementById("roomname").value;
    if(name===''){
        response = 'Room name cannot be Empty';
        document.getElementById('notavaildiv').innerText= response;
        document.getElementById('notavaildiv').style.display= "block";
        setTimeout(function(){
        document.getElementById('notavaildiv').style.display= "none";
        },1500);
    }
    else{
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
         if (this.readyState == 4 && this.status == 200) {
             
             if(this.responseText=='Name already taken'|| this.responseText=='Somtething in database failed'){
                  document.getElementById('notavaildiv').innerText= this.responseText;
                  document.getElementById('notavaildiv').style.display= "block";
                  setTimeout(function(){
                  document.getElementById('notavaildiv').style.display= "none";
                  },1500);
                  document.getElementById("createroom").disabled = true;
             }
             else if (this.responseText =='Name available'){
                document.getElementById('availdiv').innerText= this.responseText;
                  document.getElementById('availdiv').style.display= "block";
                  setTimeout(function(){
                  document.getElementById('availdiv').style.display= "none";
                  },1500); 
                  document.getElementById("createroom").disabled = false;

             }
             
        
    }
};
xhttp.open("GET", "../php/chkname.php?name="+name, true);
xhttp.send();
    }
}

function submitfunc(){
    var name=document.getElementById('roomname').value;
    var thestring =  document.getElementById("generated_pin").textContent;
    var thenum = thestring.substring(16);
    var num = parseInt(thenum,10);
    if(thestring.length===0){
        document.getElementById('notavaildiv').innerText= 'Please generate room PIN';
        document.getElementById('notavaildiv').style.display= "block";
        setTimeout(function(){
        document.getElementById('notavaildiv').style.display= "none";
        },1500);
    }
    else if(name ===''){
        document.getElementById('notavaildiv').innerText= 'Room name cannot be empty!';
        document.getElementById('notavaildiv').style.display= "block";
        setTimeout(function(){
        document.getElementById('notavaildiv').style.display= "none";
        },1500);
    }
    else {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
       // Typical action to be performed when the document is ready:
        alert(xhttp.responseText);
    }
};
xhttp.open("GET", "../php/createroom.php?name="+name+'&pin='+num, true);
xhttp.send();
    }
    
}

function loginroom(){
     var roomname=document.getElementById('roomloginname').value;
      var roompin=document.getElementById('roomloginpin').value;
      if(roomname ==='' || roompin===''){
         document.getElementById('joinalert').innerText= 'Room name/PIN cannot be empty!';
        document.getElementById('joinalert').style.display= "block";
        setTimeout(function(){
        document.getElementById('joinalert').style.display= "none";
        },1500);
      }
      else{
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var obj = JSON.parse(this.response)
        if(obj[0]==='true'){
        document.getElementById('joinsuccess').innerText= 'Taking you to the room';
        document.getElementById('joinsuccess').style.display= "block";
        setTimeout(function(){
        document.getElementById('joinsuccess').style.display= "none";
        },1500);
        window.location.href="/dashboard.php?code="+obj[1];
        }
        else{
        document.getElementById('joinalert').innerText= 'invalid credentials!';
        document.getElementById('joinalert').style.display= "block";
        setTimeout(function(){
        document.getElementById('joinalert').style.display= "none";
        },1500);
        }
    }
};
xhttp.open("GET", "../php/login.php?name="+roomname+'&pin='+roompin, true);
xhttp.send();
      }
      
}








