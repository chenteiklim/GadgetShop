
var home = document.getElementById("home");
  
home.addEventListener("click", function(event) {
  event.preventDefault()
  window.location.href = "homepage.php";
});

var Login = document.getElementById("Login");

Login.addEventListener("click", function(event) {
  event.preventDefault()
  window.location.href = "login.html";
});

// Retrieve the value of the 'success' query parameter from the URL
const urlParams = new URLSearchParams(window.location.search);
const Param = urlParams.get('success');

if (Param === '1') { 

  //create Div
  const nameDiv = document.createElement('div');
  //add CSS class
  nameDiv.classList.add('nameMessage'); 
  
  // Set the inner text of the div to the success message
  nameDiv.innerText = 'Username already exists. Please choose a different username.';
  const nameContainer = document.getElementById('nameContainer');
  nameContainer.appendChild(nameDiv);
  }
  
  else if (Param === '2') {
  
  const emailDiv = document.createElement('div');
  emailDiv.classList.add('emailMessage'); 
  
  emailDiv.innerText = 'Email already exists. Please choose a different email.';
  
  const emailContainer = document.getElementById('emailContainer');
  emailContainer.appendChild(emailDiv);
  }
  
  else if (Param === '3') {
  
  const passwordDiv = document.createElement('div');
  passwordDiv.classList.add('passwordMessage');
  
  passwordDiv.innerText = 'Registration failed. Please choose a different password.';
  
  const passwordContainer = document.getElementById('passwordContainer');
  passwordContainer.appendChild(passwordDiv);
  }
  
  else if (Param === '4') {
  
  const confirmDiv = document.createElement('div');
  confirmDiv.classList.add('confirmMessage'); // Add the CSS class to the div
  
  confirmDiv.innerText = 'Password do not match with Confirm password.';
  
  const confirmContainer = document.getElementById('confirmContainer');
  confirmContainer.appendChild(confirmDiv);
  }
  
  
  
  
  if (Param === '6') { 
  const passwordDiv2 = document.createElement('div');
  passwordDiv2.classList.add('successMessage');
  
  passwordDiv2.innerText = 'Password do not match!';
  
  const successMessage2 = document.getElementById('successMessage2');
  successMessage2.appendChild(passwordDiv2);
  }
  
  
  if (Param === '7') { 
  const successDiv3 = document.createElement('div');
  successDiv3.classList.add('successMessage');
  
  successDiv3.innerText = 'Password change successfully!';
  
  const successMessage3 = document.getElementById('successMessage3');
  successMessage3.appendChild(successDiv3);
  }