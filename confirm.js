
document.getElementById('back').addEventListener('click', function(e) {
    e.preventDefault();

    // Get the form data
    var formData = new FormData(document.getElementById('dataForm'));

    // Make an AJAX request to save the data in session
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'homepage.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Data saved successfully, handle the response if needed
            console.log('data saved successfully');
            window.location.href = 'homepage.php';
        } else {
            // Error occurred, handle the error if needed
            console.error('Error occurred while saving data.');
        }
    };
    xhr.onerror = function() {
        // Request error occurred, handle the error if needed
        console.error('Request error occurred.');
    };
    xhr.send(formData);
});