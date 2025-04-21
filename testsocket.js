const socketUrl = `wss://www.unicobet.co.uk/websocket`;
let socket = null; // Initialize socket variable

// Function to create WebSocket connection
// Function to create WebSocket connection
function createSocketConnection() {
    if (!socket || socket.readyState !== WebSocket.OPEN) {
        socket = new WebSocket(socketUrl);

        // Connection opened
        socket.addEventListener('open', function (event) {
            console.log('WebSocket connection established');
        });

        // Error handling
        socket.addEventListener('error', function (event) {
            console.error('WebSocket error:', event);
            // Attempt to reconnect
            setTimeout(createSocketConnection, 3000); // Reconnect after 3 seconds
        });

        // Connection closed
        socket.addEventListener('close', function (event) {
            console.log('WebSocket connection closed');
            // Attempt to reconnect
            setTimeout(createSocketConnection, 3000); // Reconnect after 3 seconds
        });
    }

    return socket;
}

let currentPage = localStorage.getItem('currentPage') || 1; // Initialize current page from localStorage
let currentSport = 'football'; // Initialize current sport from localStorage

function fetchDataAndUpdateSocket(pageNumber) {
    // Update `currentPage` and store it in local storage
    currentPage = pageNumber;
    localStorage.setItem('currentPage', currentPage);

    // Fetch data and update the UI and socket
    fetchData();

    // Send the message to the socket
    sendWebSocketMessage(currentSport, currentPage);
}

function fetchData() {
    // Fetch data from JSON file based on current page and sport
    fetch(`https://www.unicobet.co.uk/BETFAIR/eventsInfo/football/page${currentPage}.json`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch data');
            }
            return response.json();
        })
        .then(data => {
            // Directly update the UI with the fetched data
            updateUI(data);
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

function sendWebSocketMessage(sport, page) {
    // Create the WebSocket connection if not already established
    if (!socket || socket.readyState !== WebSocket.OPEN) {
        // Create the connection and set up an event listener
        socket = createSocketConnection();
        socket.addEventListener('open', function() {
            // Send the message immediately when the connection is open
            const message = {
                action: 'market',
                sport: sport,
                page: page
            };
            socket.send(JSON.stringify(message));
        });
    } else {
        // Send the message immediately if the connection is already open
        const message = {
            action: 'market',
            sport: sport,
            page: page
        };
        socket.send(JSON.stringify(message));
    }
}


// Function to handle pagination and fetch data for the next page
function nextPage() {
    if (currentPage < totalPages) {
        currentPage++;
        fetchDataAndUpdateSocket(currentPage);
    }
}

// Function to handle pagination and fetch data for the home page
function homePage() {
    currentPage = 1;
    fetchDataAndUpdateSocket(currentPage);
}

// Function to handle pagination and fetch data for the previous page
function previousPage() {
    if (currentPage > 1) {
        currentPage--;
        fetchDataAndUpdateSocket(currentPage);
    }
}


function updateUI(data) {
    // Update the UI with the new data
    const gamesContainer = document.getElementById('gamesContainer');
  // gamesContainer.innerHTML = '';

    // Display a loading indicator
   gamesContainer.innerHTML = '<div class="loadinggames"></div>';

    // Create WebSocket connection
    const socket = createSocketConnection();

    // Send market IDs to the server after the connection is opened
    socket.addEventListener('open', function (event) {
        console.log('WebSocket connection established');

       // Prepare message to send to the server
       const message = {
        action: 'market',
        sport: currentSport,
        page: currentPage
    };
        socket.send(JSON.stringify(message));
    });

    // Message event listener
    socket.addEventListener('message', function (event) {
        try {
            // Parse the received JSON data
            const mergedData = JSON.parse(event.data);

            // Remove the loading indicator
            gamesContainer.innerHTML = '';

            // Update the games container with new data
           // Update the games container with the fetched data and the merged data
           updateGamesContainer(data, mergedData, currentPage, currentSport);
        } catch (error) {
            //console.error('Error parsing JSON:', error);
            // Display an error message in the games container
        }
    });
}





function mergeData(jsonData) {
    jsonData.sort((a, b) => {
        // Convert market start times to Date objects for comparison
        const startTimeA = new Date(a.marketStartTime);
        const startTimeB = new Date(b.marketStartTime);

        // Format date and time
        const formatDate = date => `${date.getDate().toString().padStart(2, '0')}/${(date.getMonth() + 1).toString().padStart(2, '0')}/${date.getFullYear()}`;
        const formatTime = date => `${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`;

        // Compare formatted dates
        const formattedDateA = formatDate(startTimeA);
        const formattedDateB = formatDate(startTimeB);
        if (formattedDateA !== formattedDateB) {
            return formattedDateA.localeCompare(formattedDateB);
        }

        // Compare formatted times if dates are equal
        const formattedTimeA = formatTime(startTimeA);
        const formattedTimeB = formatTime(startTimeB);
        return formattedTimeA.localeCompare(formattedTimeB);
    });

    return jsonData;
}

function createRunnersHtml(gameID, mergedData) {
    // Define a function to retrieve runners from JSON data
    function getRunnersFromJson(gameID, mergedData) {
        // Find the corresponding game data in JSON data
        const gameData = mergedData.find(item => item.marketId === gameID);

        // Return the runners if found and available, otherwise return an empty array
        return gameData && gameData.runners ? gameData.runners : [];
    }

    // Use runners from marketData if available, or from marketDefinition if defined
    let runners = mergedData.runners || mergedData.marketDefinition?.runners || getRunnersFromJson(gameID, mergedData);

    // Ensure runners is an array
    if (!Array.isArray(runners)) {
        console.error(`Runners is not defined or not an array. GameID: ${gameID}, MarketData:`, mergedData);
        return ''; // Return an empty string if runners is not defined or not an array
    }

    // Generate HTML for runners
    const runnersHtml = runners.map((runner) => {
        const runnerId = runner.selectionId;

        // Initialize default values
        let atlvalue1 = "x";
        let atlvalue2 = 0;
        let atbvalue1 = "x";
        let atbvalue2 = 0;

        // Find `rcEntry` for the current runner ID in the market data
        const rcEntry = mergedData.runners?.find((entry) => entry.id === runnerId);

        // Update the last known values if new data is available
        if (rcEntry) {
            // Update `bdatl` values if available and different from the last known values
            if (rcEntry.bdatl) {
                const newBdatl = rcEntry.bdatl.find(entry => entry[0] === 0);
                if (newBdatl && (newBdatl[1] !== atlvalue1 || Math.round(newBdatl[2]) !== atlvalue2)) {
                    atlvalue1 = newBdatl[1];
                    atlvalue2 = Math.round(newBdatl[2]);
                }
            }
            
            // Update `bdatb` values if available and different from the last known values
            if (rcEntry.bdatb) {
                const newBdatb = rcEntry.bdatb.find(entry => entry[0] === 0);
                if (newBdatb && (newBdatb[1] !== atbvalue1 || Math.round(newBdatb[2]) !== atbvalue2)) {
                    atbvalue1 = newBdatb[1];
                    atbvalue2 = Math.round(newBdatb[2]);
                }
            }
        }
        
        // Retrieve the market definition entry and runner status
        const marketDefinitionEntry = mergedData.marketDefinition?.runners?.find((entry) => entry.id === runnerId);
        const runnerstatus = marketDefinitionEntry ? marketDefinitionEntry.status : '';


    // Construct the HTML for the runner
    return `
  
        <tr>
        
            <td class="match-pointing-box" style="border: 2px solid #14A876">
                <h5>${runner.runnerName || "N/A"}</h5>
                <p style="display: none;">${runner.selectionId}</p>
                <p style="display: none;">${runnerstatus || ""}</p>
            </td>
            <td class="match-pointing-box" style="border: 2px solid #14A876" >
                <div class="layorback">
                    <p class="textback">
                        <span class="atbvalue1">${atbvalue1}</span>
                        <span class="backText" style="display: none;">BACK</span>
                    </p>
                </div>
                <span class="atbvalue2">£${atbvalue2}</span>
            </td>
            <td class="match-pointing-box" style="border: 2px solid #14A876" >
           
            <div class="layorback">
                    <p class="textlay">

                        <span class="atlvalue1">${atlvalue1}</span>
                        <span class="layText" style="display: none;">LAY</span>
                    </p>
                    <span class="atlvalue2">£${atlvalue2}</span>
                </div>
              
               
            </td>
        </tr>`;
}).join('') || '';

return runnersHtml;
}

// Function to add an overlay to a market container if the status is CLOSED
function addOverlayToContainer(marketInfo) {
    // Check if the marketInfo element exists
    if (!marketInfo) {
        console.error('Market container not found');
        return;
    }

    // Check if an overlay already exists
    let overlay = marketInfo.querySelector('.overlay');
    if (!overlay) {
        // Create a new overlay element
        overlay = document.createElement('div');
        overlay.className = 'overlay-games';
        
        // Add content to the overlay
        overlay.innerHTML = `
            <div class="overlay-games-content">
                <p>SUSPENDED</p>
            </div>
        `;
        
        // Append the overlay to the market container
        marketInfo.appendChild(overlay);
    }

    // Display the overlay
    overlay.style.display = 'block';
}

// Function to remove the overlay from a market container
function removeOverlayFromContainer(marketInfo) {
    // Check if the marketInfo element exists
    if (!marketInfo) {
        console.error('Market container not found');
        return;
    }

    // Find the overlay element in the market container
    const overlay = marketInfo.querySelector('.overlay');

    // Hide the overlay if it exists
    if (overlay) {
        overlay.style.display = 'none';
    }
}

function updateGamesContainer(jsonData, mergedData) {
   //console.log('JSON Data:', jsonData);
//console.log('Websocket Data:', mergedData);
   

    const gamesContainer = document.getElementById('gamesContainer');
    // Remove the loading indicator
    gamesContainer.innerHTML = '';

   // const mergedData = mergeData(jsonData, mergedData);
//console.log(mergedData);
    for (const marketId in mergedData) {
        if (mergedData.hasOwnProperty(marketId)) {
            const marketData = mergedData[marketId];
            const marketInfo = document.createElement('div');
            marketInfo.classList.add('market-container'); // Add a class to the market container
            marketInfo.style.position = 'relative'; // Set the market container to relative positioning

         const gameID =  mergedData[marketId].marketId || mergedData[marketId].id ;
        
            if (!marketData || (!marketData.runners && !marketData.rc)) {
                marketInfo.textContent = '';
                gamesContainer.appendChild(marketInfo);
                continue;
            }
            const runnerName1 = mergedData[marketId]?.runners && mergedData[marketId].runners.length > 0 ? mergedData[marketId].runners[0].runnerName : "Closed";
           // console.log(runnerName1);
            const runnerName2 = mergedData[marketId]?.runners && mergedData[marketId].runners.length > 0 ? mergedData[marketId].runners[1].runnerName : "Closed";
           // console.log(runnerName2);
            
            const marketDefinition = marketData.marketDefinition;
            const countryCode = marketData && marketData.event ? marketData.event.countryCode : '';
            const eventid =  marketData && marketData.event ? marketData.event.name : '';
            const marketStartTime = mergedData[marketId]?.marketStartTime;
            let formattedDateTimeHTML = ''; // Define it here so it's accessible outside the if block
            if (marketStartTime) {
                const dateObj = new Date(marketStartTime);
                const formattedDate = `${dateObj.getDate().toString().padStart(2, '0')}/${(dateObj.getMonth() + 1).toString().padStart(2, '0')}/${dateObj.getFullYear()}`;
                const formattedTime = `${dateObj.getHours().toString().padStart(2, '0')}:${dateObj.getMinutes().toString().padStart(2, '0')}`;
                const formattedDateTime = `Date: ${formattedDate} Time: ${formattedTime}`;

                // Now you can use formattedDateTime in your HTML
                formattedDateTimeHTML = `<span class="title">${formattedDateTime}</span>`;
                //console.log(formattedDateTimeHTML); 
            }

          // Create HTML for the runners in the current market
          const runnersHtml = createRunnersHtml(gameID, marketData);


const runnerstopHtml = `
<div class="main-progress-wrap">
<span class="gameId" style="display:none" id="gameId">${gameID}</SPAN>
<span>
</span>
    <div class="cart-item" style="margin-left:1%;margin-right:1%;">
        <div class="card">
        <div class="percent">
        <svg>
            <circle cx="55" cy="55" r="45"></circle>
            <circle cx="55" cy="55" r="45" style="--percent: 28"></circle>
        </svg>
      
        <div class="content-area">
            <div class="icon">
                <img src="assets/img/banner-freature/football.svg" alt="flag">
            </div>
            <div class="number">
                <h3><span></span></h3>
            </div>
                    <div class="title" style="text-align:center;">
                        <span style="min-width:100px !important ;color:white;background-color:#101f29;border:20px;border-radius:10px;border-bottom:3px solid green;">${runnerName1}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="margin-right:-10%;width:10%;margin-bottom:50px;border-bottom: 3px solid green;border-radius:10px;text-align:center"> 
      
    <span class="rchome" style="position:relative;bottom:-78px" > ${generateRedCards(mergedData[marketId]?.live && mergedData[marketId]?.live[0]?.score?.home?.numberOfRedCards
        !== undefined ? 
        (mergedData[marketId].live[0].score.home.numberOfRedCards || 0) : 0)}</span>
        <span class="ychome" style="position:relative;bottom:-78px">   ${generateYellowCards(mergedData[marketId]?.live && mergedData[marketId]?.live[0]?.score?.home?.numberOfYellowCards
        !== undefined ? 
        (mergedData[marketId].live[0].score.home.numberOfYellowCards || 0) : 0)}</span>
    
    
   
    </div>
    <div class="cart-item cart-middle-item" >
        <div class="card"">
            <div class="percent">
                <div class="pro1">
                    <div class="pro2">
                        <div class="pro3">
                        </div>
                    </div>
                </div>
                <div class="content-area middle-bg" >
                    <div class="icon">
                        <span class="scorew" style="color:white;background-color:#101f29;border:20px;border-radius:10px;">

                        <span class="ycaway">${(mergedData[marketId]?.live && mergedData[marketId]?.live[0]?.score?.home?.score
                            !== undefined) ? 
                            (mergedData[marketId].live[0].score.home.score || "0") : "0"}</span>:
                            <span class="rcaway">${(mergedData[marketId]?.live && mergedData[marketId]?.live[0]?.score?.away?.score
                                !== undefined) ? 
                                (mergedData[marketId].live[0].score.away.score || "0") : "0"}</span>
                         


                        </span>
                        <br/>
                        <span style="background-color:#101f29;color:white;border:20px;border-radius:10px;">${(mergedData[marketId]?.live && mergedData[marketId]?.live[0]?.timeElapsed
                            !== undefined) ? 
                            (mergedData[marketId].live[0].timeElapsed || "0") : "0"}'</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="margin-left:-10%;width:10%;margin-bottom:50px;border-bottom: 3px solid green;border-radius:10px;text-align:center">
  
    <span class="rcaway" style="position:relative;bottom:-78px">  ${generateRedCards(mergedData[marketId]?.live && mergedData[marketId]?.live[0]?.score?.away?.numberOfRedCards
        !== undefined ? 
        (mergedData[marketId].live[0].score.away.numberOfRedCards || 0) : 0)}</span>
        <span class="ycaway" style="position:relative;bottom:-78px">  ${generateYellowCards(mergedData[marketId]?.live && mergedData[marketId]?.live[0]?.score?.away?.numberOfYellowCards
        !== undefined ? 
        (mergedData[marketId].live[0].score.away.numberOfYellowCards || 0) : 0)}</span>


    </div>
    <div class="cart-items" style="margin-right:10%;margin-left:-2%;">
        <div class="card">
            <div class="percent">
                <svg>
                    <circle cx="55" cy="55" r="45"></circle>
                    <circle cx="55" cy="55" r="45" style="--percent: 28"></circle>
                </svg>
              
                <div class="content-area">
                    <div class="icon">
                        <img src="assets/img/banner-freature/football.svg" alt="flag">
                    </div>
                    <div class="number">
                        <h3><span></span></h3>
                    </div>
                    <div class="title" style="text-align:center">
                        <span style="min-width:100px !important ;color:white;background-color:#101f29;border:20px;border-radius:10px;border-bottom:3px solid green;">${runnerName2}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

`;



            const template = `
            <div class="progress-slider-items">
                <div class="title">
                    <span class="text">${getCountryFlag(countryCode)} ${countryCode || ""}</span><span style="display:NONE">${gameID || ""}</span>-<Span class="text"> ${marketDefinition ? marketDefinition.status : "OPEN"}</span>
                    <span class="text" style="margin-left:30%">Matched: <i class="fas fa-hand-holding-usd"></i> <span class="matched">${(mergedData[marketId].tv || 0).toFixed(2)}</span></span>
                <span class="eventid" style="display:none">${eventid}</span>
                    </div>

                ${runnerstopHtml}
                <div class="match-pointing" style="overflow-x:scroll">
                    <div class="match-pointing-box" style="max-width: 100% !important; transform: scale(0.9); transform-origin: bottom top; background: transparent">
                        <span class="title">${formattedDateTimeHTML || ""}</span>
                        <table class="match-pointing-box" style="background-color:#14A876">
                            <tr>
                                <th>PLAYER</th>
                                <th>BACK</th>
                                <th>LAY</th>
                            </tr>
                            ${runnersHtml}
                        </table>
                    </div>
                </div>
            </div>
        `;

            marketInfo.innerHTML = template;
            gamesContainer.appendChild(marketInfo);
 
           // Check market status and add overlay if the status is CLOSED
           if (marketDefinition && marketDefinition.status === 'CLOSED' || marketDefinition && marketDefinition.status === 'SUSPENDED') {
            addOverlayToContainer(marketInfo);
        } else {
            removeOverlayFromContainer(marketInfo);
        }

            // Add event listeners to atlvalue1 and atbvalue1 spans
            const atlvalue1Elements = document.querySelectorAll('.atlvalue1');
            const atbvalue1Elements = document.querySelectorAll('.atbvalue1');

            atlvalue1Elements.forEach(element => {
                element.addEventListener('click', () => {
                    displayBetFormModal();
                });
            });

            atbvalue1Elements.forEach(element => {
                element.addEventListener('click', () => {
                    displayBetFormModal();
                });
            });

            // Add event listener to close button
            const closeButton = document.querySelector('.close-button');
            closeButton.addEventListener('click', () => {
                hideBetFormModal();
            });
            let layOrBackInput; // Declare layOrBackInput variable
            let clickedValue;
            
            marketInfo.addEventListener('click', function(event) {
                const runnerElement = event.target.closest('tr');
                if (runnerElement) {
                    const runnerName = runnerElement.querySelector('.match-pointing-box h5').textContent;
                    const selectionId = runnerElement.querySelector('.match-pointing-box p').textContent;
                    const marketId = runnerElement.closest('.progress-slider-items').querySelector('.gameId').textContent;
            const eventid = runnerElement.closest('.progress-slider-items').querySelector('.eventid').textContent;
                    const targetSpan = event.target.closest('span');
                    if (targetSpan) {
            
                        // Retrieve the clicked value and its class
                        clickedValue = targetSpan.textContent;
                        const valueClass = targetSpan.classList.contains('atlvalue1') ? 'atlvalue1' : targetSpan.classList.contains('atbvalue1') ? 'atbvalue1' : '';
                        const layOrBackText = targetSpan.parentElement.querySelector('.layText') || targetSpan.parentElement.querySelector('.backText');
                        layOrBackValue = layOrBackText.textContent;
                        layOrBackInput = document.getElementById('updatelayOrBack'); // Define layOrBackInput within this block
                        // Assign clicked value to HTML element by ID
                        const clickedValueInput = document.getElementById('clickedValue');
                        // Select betRateInput and betAmountInput
                        const betRateInput = document.getElementById('betRate');
                        // Set initial rate equal to clickedValue
            
                        if (clickedValueInput) {
                            clickedValueInput.setAttribute('value', clickedValue !== undefined ? clickedValue : '');
                            betRateInput.setAttribute('value', clickedValue !== undefined ? clickedValue : '');
                        } else {
                           // console.error('Element with ID "clickedValue" not found');
                        }
            
                        // Update layOrBackInput value if found
                        if (layOrBackInput) {
                            // Update based on clicked value class
                            if (valueClass === 'atlvalue1' || valueClass === 'atlvalue2') {
                                layOrBackInput.value = 'LAY';
                            } else if (valueClass === 'atbvalue1' || valueClass === 'atbvalue2') {
                                layOrBackInput.value = 'BACK';
                            }
                        } else {
                            //console.error('Element with ID "updatelayOrBack" not found');
                        }
            
                          console.log('Clicked Value:', clickedValue);
                      console.log('Clicked ValueInput:', clickedValueInput);
                         console.log('Value Class:', valueClass);
                          console.log('Lay or Back Value:', layOrBackValue);
            
            
                    }
            
                    // Function to inject the form and attach event listeners
                    function injectFormAndAttachListeners() {
            
                        // Create and populate the form
                        const form = document.createElement('form');
                        form.innerHTML = `
            
                        <div class="progress-slider-items" style="max-width:100% !important;" >   
                        <label for="eventid" style="display:none" >EVENT ID:</label>
                                        <input type="text" style="display:none" id="eventid" name="eventid" value="${eventid}" readonly>
                                        <label for="marketId" style="display:none" >Market ID:</label>
                                        <input type="text" style="display:none" id="marketId" name="marketId" value="${marketId}" readonly>
                                        <label style="display:none;" for="selectionId">Selection ID:</label>
                                        <input type="text" style="display:none;" id="selectionId" name="selectionId" value="${selectionId}" readonly>
                                        
                                
                            <div class="match-fixing">
                                <div class="match-items">
                                    <div class="match-items-left">
                                        <div class="cont">
            
                                            <div class="icon">
                                                <img src="assets/img/header/right-icon/bets.svg" alt="icon"> Bet Details   
                                            </div>
                                            <label style="display:none;" for="runnerName">PLAYER:</label>
                                            <input   type="text" id="runnerName" name="runnerName" value="${runnerName}" readonly>
                                            
                                            <table>
    <tr>
        <td>
            <label style="display:none;" for="updatelayOrBack">Value:</label>
            <input type="text" id="updatelayOrBack" value="${layOrBackValue ? layOrBackValue : 'LAY'}" readonly>
        </td>
        <td>
            <label style="display:none;" for="clickedValue">Value:</label>
            <input type="text" id="clickedValue" name="clickedValue" value="${clickedValue ? clickedValue: '0'}" readonly>
        </td>
    </tr>
</table>

                                        </div>
                                      
                                        <div class="match-items-left">
                                            <div class="cont">
                                                <div class="icon"></div>
                                                  <label style="display:none;" for="type">Type</label>
                                                <select name="type" id="betTypeSelect" >
                                                    <option  value="PERSIST">Persist</option>
                                                    <option  value="LAPSE">Lapse</option>
                                                    <option  value="MARKET_ON_CLOSE">Market On Close</option>
                                                </select>
                                            </div>
                                        </div>
                                       
                                        <div class="match-items-right">
                                            <div class="icon"></div>
            
                                            <table>
                                            <tr>
                                                <td>
                                          
                                            <label for="rate">Rate:</label>
                                            </td>
        <td>
                                            <input  type="number" min="1,01" name="rate" id="betRate" step="0.01"  value="${clickedValue ? clickedValue: '0'}" required>
                                            </td>
                                            </tr>
                                        </table>
                                            </div>
                                       
                                        <div class="match-items-right">
                                        <table>
    <tr>
        <td>
                                            <label for="betAmount"> <i class="fas fa-hand-holding-usd"></i>Stake:</label>
                                            </td>
                                            <td>
                                            <input  type="number" min="1.00" id="betAmount" name="betAmount" value="1" step="0.01"  required>
                                            </td>
                                            </tr>
                                        </table>
                                        </div>
                                        <div id="loadingAnimation">
                                       
                                    </div>
                                        <div class="possible-win">
                                            <p class="total-win"></p>
                                        </div>
                                      
                                    </div>
                                </div>
                            </div>
                           </div>
            
                    `;
            
                        // Display the form to the user
                        const formContainer = document.getElementById('formContainer');
                        formContainer.innerHTML = ''; // Clear previous form if any
                        formContainer.appendChild(form);
            
                        // Get references to the input elements and total win paragraph
                        const betRateInput = document.getElementById('betRate');
                        const betAmountInput = document.getElementById('betAmount');
                        const totalWinParagraph = document.querySelector('.total-win');
            
                        // Attach event listeners if elements are found
                        if (betRateInput && betAmountInput && totalWinParagraph) {
                            // Add event listener to betRateInput and betAmountInput
                            betRateInput.addEventListener('input', calculateTotalWinnings);
                            betAmountInput.addEventListener('input', calculateTotalWinnings);
                        } else {
                           // console.error('Elements with IDs "betRate", "betAmount", or class "total-win" not found');
                        }
            
                       // Function to calculate total winnings
function calculateTotalWinnings() {
    let amountInputed = document.getElementById('betAmount');
    let rateInputed = document.getElementById('betRate');
    let amount = parseFloat(amountInputed.value);
    let rate = parseFloat(rateInputed.value);
    let option = document.getElementById('updatelayOrBack').value;

    if (!isNaN(amount) && !isNaN(rate)) {
        // Fetch user balance from the PHP script
        fetch("fetch_user_balance.php")
            .then(response => {
                if (!response.ok) {
                    stopLoadingAnimation();
                    totalWinElem.textContent = `Please Log In to place a bet!`;
                    totalWinElem.classList.add('btn--two');
                    

                    return;
                }
                return response.json();
            })
            .then(userData => {
                // Ensure that userData is an object containing user balance
                if (typeof userData !== 'object' || !userData.hasOwnProperty('balance')) {
                    throw new Error("User balance not found in the response");
                }

                const userBalance = parseFloat(userData.balance);

                if (isNaN(userBalance)) {
                    throw new Error("Invalid user balance");
                }

               
                 // Check if the amount exceeds the user's balance
                 if ((option === 'BACK' && amount > userBalance) || (option === 'LAY' && amount * (rate - 1) > userBalance))  {
                    stopLoadingAnimation();
                   // alert('Insufficient balance. Please deposit more funds.');
                   totalWinElem.textContent = `Insufficient Balance!`;
                   totalWinElem.classList.add('btn--two');
                    // Clear the amount input field
                    amountInputed.value = '';
                    return;
                }
                

                // Proceed with the calculation if the balance is sufficient
                const fee = 0.9;
                let totalWin;
                let totalLayWin;
                const totalWinElem = document.querySelector('.total-win');

                // Handle LAY and non-LAY scenarios
                if (option === 'LAY') {
                    // Calculation for LAY bet
                  
                  //  betvalue =(amount*rate) - amount;
                   // totalLayWin = (amount*fee) + betvalue;
                   betvalue = (rate-1)*amount;
                   totalLayWin = (amount*rate - amount)*0.9 + amount;
                    totalWinElem.textContent = `Payout: £${totalLayWin.toFixed(2)} Liability: £${betvalue.toFixed(2)}`;
                    totalWinElem.classList.add('btn--two');
                } else {
                    // Calculation for non-LAY bet
                    totalWin = (amount * rate -amount) * fee + amount;
                    totalWinElem.textContent = `Payout: £${totalWin.toFixed(2)}`;
                    
                    totalWinElem.classList.add('btn--two');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    } else {
        const totalWinElem = document.querySelector('.total-win');
        totalWinElem.textContent = ''; // Clear the display if amount or rate is invalid
    }
}

// Add event listeners to input fields
// Listen for 'input' and 'change' events on betAmount and betRate input fields
document.getElementById('betAmount').addEventListener('input', calculateTotalWinnings);
document.getElementById('betAmount').addEventListener('change', calculateTotalWinnings);

document.getElementById('betRate').addEventListener('input', calculateTotalWinnings);
document.getElementById('betRate').addEventListener('change', calculateTotalWinnings);

                    }
                 
                    
            
                    // Call the function to inject the form and attach event listeners
                    injectFormAndAttachListeners();
                }
            });
        }}}    



// Call the function to fetch data and update WebSocket connection for the initial page
fetchDataAndUpdateSocket(currentPage);

// Function to get the total number of pages
function getTotalPages() {
    // Assume total pages are 10 for demonstration
    return 10;
}

// Total number of pages
const totalPages = getTotalPages();



// Function to get the country flag based on the country code
function getCountryFlag(countryCode) {
    // Map of country codes to flag emojis
    const flagMap = {
        "US": "<img src='https://flagicons.lipis.dev/flags/4x3/um.svg' width='26px' height='auto' style='margin-left:-15%;margin-right:5px;padding:5px,border-bottom:2px solid green'>", // United States
        "UK": "<img src='https://flagicons.lipis.dev/flags/4x3/gb.svg' width='26px' height='auto' style='margin-left:-15%;margin-right:5px;padding:5px,border-bottom:2px solid green'>", // United Kingdom
        "RU": "<img src='https://flagicons.lipis.dev/flags/4x3/ru.svg' width='26px' height='auto' style='margin-left:-15%;margin-right:5px;padding:5px,border-bottom:2px solid green'>", // Russia
        "RO": "<img src='https://flagicons.lipis.dev/flags/4x3/ro.svg' width='26px' height='auto' style='margin-left:-15%;margin-right:5px;padding:5px,border-bottom:2px solid green'>",// Romania
        "FR": "<img src='https://flagicons.lipis.dev/flags/4x3/fr.svg' width='26px' height='auto' style='margin-left:-15%;margin-right:5px;padding:5px,border-bottom:2px solid green'>", // France
        "DE": "<img src='https://flagicons.lipis.dev/flags/4x3/de.svg' width='26px' height='auto' style='margin-left:-15%;margin-right:5px;padding:5px,border-bottom:2px solid green'>", // Germany
        "IT": "<img src='https://flagicons.lipis.dev/flags/4x3/it.svg' width='26px' height='auto' style='margin-left:-15%;margin-right:5px;padding:5px,border-bottom:2px solid green'>",// Italy
        "CO": "<img src='https://flagicons.lipis.dev/flags/4x3/co.svg' width='26px' height='auto' style='margin-left:-1%;margin-right:5px;padding:5px,border-bottom:2px solid green'>", // Colombia
        "AR": "<img src='https://flagicons.lipis.dev/flags/4x3/ar.svg' width='26px' height='auto' style='margin-left:-1%;margin-right:5px;padding:5px,border-bottom:2px solid green'>",// Argentina
        "BR": "<img src='https://flagicons.lipis.dev/flags/4x3/br.svg' width='26px' height='auto' style='margin-left:-1%;margin-right:5px;padding:5px,border-bottom:2px solid green'>", // Brazil
        "MX": "<img src='https://flagicons.lipis.dev/flags/4x3/mx.svg' width='26px' height='auto' style='margin-left:-1%;margin-right:5px;padding:5px,border-bottom:2px solid green'>", // Mexico
        "SV": "<img src='https://flagicons.lipis.dev/flags/4x3/sv.svg' width='26px' height='auto' style='margin-left:-1%;margin-right:5px;padding:5px,border-bottom:2px solid green'>",// El Salvador
        "PK": "<img src='https://flagicons.lipis.dev/flags/4x3/pk.svg' width='26px' height='auto' style='margin-left:-1%;margin-right:5px;padding:5px,border-bottom:2px solid green'>", // Pakistan
        "NZ": "<img src='https://flagicons.lipis.dev/flags/4x3/nz.svg' width='26px' height='auto' style='margin-left:-1%;margin-right:5px;padding:5px,border-bottom:2px solid green'>", // Pakistan
        "AU": "<img src='https://flagicons.lipis.dev/flags/4x3/au.svg' width='26px' height='auto' style='margin-left:-1%;margin-right:5px;padding:5px,border-bottom:2px solid green'>", // Pakistan
        "GB": "<img src='https://flagicons.lipis.dev/flags/4x3/gb.svg' width='26px' height='auto' style='margin-left:-1%;margin-right:5px;padding:5px,border-bottom:2px solid green'>", // United Kingdom

        // Add more country codes and flags here
    };

    // Check if the countryCode exists in the flagMap
    if (flagMap.hasOwnProperty(countryCode)) {
        // Return the flag emoji corresponding to the countryCode
        return flagMap[countryCode];
    } else {
        // If countryCode not found, return a default flag emoji or empty string
        return "<img src='https://flagicons.lipis.dev/flags/4x3/sc.svg' width='26px' height='auto' style='margin-left:0%;margin-right:5px;padding:5px,border-bottom:2px solid green'>"; // Default flag emoji
    }
}
             
function placeBet() {
    startLoadingAnimation();
    // Retrieve bet data from the input elements
    const marketId = document.getElementById('marketId').value;
    const selectedId = document.getElementById('selectionId').value;
    const runnerName = document.getElementById('runnerName').value;
    const type = document.getElementById('updatelayOrBack').value;
    const rate = document.getElementById('betRate').value;
    const stake = document.getElementById('betAmount').value;
    const betChoice = document.getElementById('betTypeSelect').value; // Retrieve selected bet type
    const eventid = document.getElementById('eventid').value;
    // Retrieve user details from localStorage
    const userId = localStorage.getItem("userId");
    const phone = localStorage.getItem("phone");
    const loggedIn = localStorage.getItem("loggedIn");
    // Calculate adjusted stake if option is LAY
    let adjustedStake = stake; // Default to regular stake

    if (type === 'LAY') {
        
        //adjustedStake = ((rate - 1)*stake).toFixed(2);
        adjustedStake = stake;
    }
    // Create a JSON object with the bet data
    const betData = {
        loggedIn: loggedIn,
        userId: userId,
        phone: phone,
        game_id: marketId,
        selectedId: selectedId,
        runnerName: runnerName,
        type: type,
        rate: rate,
        stake: adjustedStake,
        eventid: eventid,
        betChoice: betChoice // Add betChoice to the betData object
    };

    // Send the bet data to the PHP script using the fetch API
    fetch('placebet.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(betData)
    })
    .then(response => {
        if (!response.ok) {
            stopLoadingAnimation();
            throw new Error('Failed to place bet');
        }
        // Return the JSON response
        
        return response.json();
    })
    .then(data => {
        // Handle the JSON response
        if (data.message) {
            // Bet placed successfully, show the message in the form
            stopLoadingAnimation();
            
            // Update the form with the success message
            const totalWinElem = document.querySelector('.total-win');
            if (totalWinElem) {
                totalWinElem.textContent = data.message;
                totalWinElem.style.color = 'white'; // Optional: change text color to green for success
            }
            
            // Optionally hide the bet form modal
           // hideBetFormModal();
            
        } else if (data.error) {
            // Show error message in the form
            stopLoadingAnimation();
            
            // Update the form with the error message
            const totalWinElem = document.querySelector('.total-win');
            if (totalWinElem) {
                totalWinElem.textContent = data.error;
                totalWinElem.style.color = 'white'; // Optional: change text color to red for error
            }
        } else {
            // Unexpected response, show a generic error in the form
            stopLoadingAnimation();
            
            // Update the form with a generic error message
            const totalWinElem = document.querySelector('.total-win');
            if (totalWinElem) {
                totalWinElem.textContent = 'Failed to place bet';
                totalWinElem.style.color = 'white';
            }
        }
    })
    .catch(error => {
        // Handle any errors that occur during the fetch
        stopLoadingAnimation();
        console.error('Error:', error);
        
        // Display an error message in the form
        const totalWinElem = document.querySelector('.total-win');
        if (totalWinElem) {
            totalWinElem.textContent = 'An error occurred while placing the bet.';
            totalWinElem.style.color = 'white';
        }
    });
}
// Function to start the loading animation
function startLoadingAnimation() {
    const animationElement = document.getElementById('loadingAnimation');
    if (animationElement) {
        animationElement.style.display = 'block';
    }
}

// Function to stop the loading animation
function stopLoadingAnimation() {
    const animationElement = document.getElementById('loadingAnimation');
    if (animationElement) {
        animationElement.style.display = 'none';
    }
}
            document.addEventListener('DOMContentLoaded', function() {
               
            
                const placeBetButton = document.getElementById('placeBetButton');
               // console.log(placeBetButton); // Check if the button is correctly selected
                if (placeBetButton) {
                    placeBetButton.addEventListener('click', placeBet);
                } else {
                    // console.error('Button with ID "placeBetButton" not found.');
                }
            });
            
              // Function to display the betFormModal
              function displayBetFormModal() {
                const betFormModal = document.getElementById('betFormModal');
                betFormModal.style.display = 'block';
            }

            // Function to hide the betFormModal
            function hideBetFormModal() {
                const betFormModal = document.getElementById('betFormModal');
                betFormModal.style.display = 'none';
            }
            function generateYellowCards(number) {
                let cardsHTML = '';
                // Loop to create cards based on the number
                for (let i = 0; i < number; i++) {
                    // Add yellow card image
                    cardsHTML += `<img src="Yellow_card.png" alt="Yellow Card" class="card" style="width:10px;height:20px;display: inline-block;">`;
                }
                // Return the generated HTML
                return cardsHTML;
            }
            function generateRedCards(number) {
                let cardsHTML = '';
                // Loop to create cards based on the number
                for (let i = 0; i < number; i++) {
                    // Add yellow card image
                    cardsHTML += `<img src="Red_card.png" alt="Yellow Card" class="card" style="width:10px;height:20px;display: inline-block;">`;
                }
                // Return the generated HTML
                return cardsHTML;
            }
            
      