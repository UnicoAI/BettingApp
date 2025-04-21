function signUp() {
    // Get the value of the birthday input element
    const birthdayInput = document.getElementById('datepicker');
    const birthday = birthdayInput ? birthdayInput.value : '';

    // Check if the birthday is empty
    if (!birthday) {
        console.error('Birthday is missing');
        return;
    }

    // Data to be sent as form data
    const formData = new FormData();
    formData.append('bday', document.getElementById('datepicker').value);
    formData.append('country', document.getElementById('country').value);
    formData.append('email', document.getElementById('email').value);
    formData.append('first', document.getElementById('firstnamer').value);
    formData.append('last', document.getElementById('lastnamer').value);
    formData.append('rule', document.getElementById('rule').checked ? 1 : 0);
    formData.append('mobile', document.getElementById('phoner').value);
    formData.append('wallet', document.getElementById('wallet').value);
    formData.append('code', document.getElementById('code').value);
    formData.append('pass', document.getElementById('passwordr').value);
    formData.append('sex', document.querySelector('input[name="sex"]:checked').value);

    // Headers
    const headers = {
        'x-token': '123456789'
    };

    // Fetch options
    const options = {
        method: 'POST',
        headers: headers,
        body: formData
    };

    // URL to send the request
    const url = 'https://revencu.com/addCustomer';

    // Send the request
    fetch(url, options)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json(); // Return response as JSON
        })
        .then(data => {
            // Check if the response contains an error
            if (data.error) {
                // Display the error message in the browser
                document.getElementById('responseMessage').innerHTML= data.error;
            } else {
                // Handle other successful scenarios
                console.log('Success:', data);
                alert("Registered Successfully! Please Log In!");
            }
        })
        .catch(error => {
            // Handle errors
            console.error('There was a problem with the fetch operation:', error);
        });
}
