
var inps = document.querySelectorAll("input")
for(var x=0; x<inps.length; x++){
   inps[x].oninput = function(e){
   
      if(e.target.name == "password") var maxlen = 7;
      if(e.target.name == "confirmpassword") var maxlen = 7;
   
      this.style.backgroundColor = this.value.length >= maxlen ? "#F5C2C7" : "#D9ECF1";
   }
}

/*const btn = document.querySelector('#send')

btn.addEventListener('click', function(event){
   event.preventDefault()
  const email = document.querySelector("#email")
  const value = email.value
  console.log(value)
})*/
