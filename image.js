function image(pid) { 
var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function(){
     if(xhr.readyState === 4 && xhr.status === 200){
         if(this.responseText === "1"){
            alert("lol ta piame");
         }else{
            var a = this.responseText;
            document.getElementById("image_div").innerHTML = a;
   
         }
         return;
      }
  };

    xhr.open("POST","image.php",true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("pid="+pid );

}
