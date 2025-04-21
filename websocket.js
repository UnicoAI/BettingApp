const token = generateRandomValue();

// Step 1: Generate a random value for X-WS header
const xWsValue = generateRandomValue();

// Step 2: Create a WebSocket connection
const wsUri = `wss://revencu.com/wsk?token=${token}`;
const socket = new WebSocket(wsUri, [], {

});
socket.binaryType = 'arraybuffer';

socket.onopen = function(event) {
   console.log("WebSocket connection established.");
};

// Step 3: Register with "/register-ws" endpoint
const formData = new FormData();
formData.append('t', token);

fetch("https://revencu.com/register-ws", {
   method: "POST",
   headers: {
       'Content-Type': 'application/x-www-form-urlencoded', // Set content type to form-encoded
       'x-ws': xWsValue,
       'x-token' : '123456789'
   },
   body: new URLSearchParams(formData) // Convert FormData to URLSearchParams
})
.then(response => {
   if (response.ok) {
       console.log("Registration successful.");
   } else {
       console.error("Registration failed:", response.statusText);
   }
})
.catch(error => {
   console.error("Error during registration:", error);
});
// Step 4: Handle incoming messages from the WebSocket
socket.onmessage = function(event) {
   // Decompress the incoming data using Pako
   var inflatedData = pako.inflate(event.data, { to: 'string' });
   var data = JSON.parse(inflatedData);
   console.log("Received data from WebSocket:", data);
};


socket.onerror = function(error) {
   console.error("WebSocket error:", error);
};

socket.onclose = function(event) {
   console.log("WebSocket connection closed.");
};

// Function to generate a random value for X-WS header
function generateRandomValue() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
       const randomValues = new Uint8Array(1);
       crypto.getRandomValues(randomValues);
       const r = randomValues[0] % 16;
       const v = c === 'x' ? r : (r & 0x3 | 0x8);
       return v.toString(16);
   });
}
