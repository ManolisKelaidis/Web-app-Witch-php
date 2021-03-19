function addToCart(pid){       
//  alert("product to put in cart is: "+pid);
//  alert(a);
  var a = document.getElementById("quantity"+pid).value;

  var xhr = new XMLHttpRequest();
  

  xhr.onreadystatechange = function(){
     if(xhr.readyState === 4 && xhr.status === 200){
         if(this.responseText === "1"){
            alert("lol ta piame");
         }else{
//             document.getElementById("cart").innerHTML += this.responseText;            
         //   document.getElementById("MyCartTable").innerHTML += x;
            
            
         }
        
         return;

      }
  };

    xhr.open("POST","cart.php",true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("pid="+pid +"&quantity="+a);
}
