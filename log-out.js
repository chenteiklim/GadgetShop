const logOut = document.getElementById('logOut');

// Add a click event listener to the logout button
logOut.addEventListener('click', confirmLogout);

// Function to display the confirmation dialog
function confirmLogout() {
  // Create the confirmation dialog elements
  
  const dialog = document.createElement('div');
  dialog.classList.add('confirmation-dialog');

  const heading = document.createElement('h2');
  heading.innerText = 'Logout Confirmation';

  const message = document.createElement('p');
  message.innerText = 'Are you sure you want to logout?';

  const buttons = document.createElement('div');
  buttons.classList.add('buttons');

  const cancelButton = document.createElement('button');
  cancelButton.innerText = 'Cancel';
  cancelButton.addEventListener('click', closeDialog);

  const logoutButton = document.createElement('button');
  logoutButton.innerText = 'Logout';
  logoutButton.addEventListener('click', logout);

  // Append elements to the dialog
  buttons.appendChild(cancelButton);
  buttons.appendChild(logoutButton);

  dialog.appendChild(heading);
  dialog.appendChild(message);
  dialog.appendChild(buttons);

  // Append dialog to the body
  document.body.appendChild(dialog);
}

// Function to close the confirmation dialog
function closeDialog() {
  const dialog = document.querySelector('.confirmation-dialog');
  if (dialog) {
    dialog.remove();
  }
}

// Function to perform the logout
function logout() {
  // Perform your logout logic here
  // This could include clearing session data, redirecting to a login page, etc.
  window.location.href = 'register.html?success=4';
}