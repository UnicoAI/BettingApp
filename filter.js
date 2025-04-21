 // Define global variables
 let fetchInterval;
 let globalInputName = '';

 // Function to update the search results in the DOM
 function updateSearchResults(foundMarkets) {
     // Get the results container and search results elements
     const resultsContainer = document.getElementById('resultsContainer');
     const searchResults = document.getElementById('searchResults');
     searchResults.innerHTML = ''; // Clear previous results
     resultsContainer.style.display = 'block'; // Display the results container

     // Output the results in HTML
     if (Object.keys(foundMarkets).length > 0) {
         for (const marketId in foundMarkets) {
             const marketInfo = foundMarkets[marketId];
             const market = marketInfo.market;
             const sport = marketInfo.sport;
             const eventid =  market && market.event ? market.event.name : '';

             // Create a new market element
             const marketElement = document.createElement('div');
             marketElement.classList.add('market');
             marketElement.setAttribute('data-market-id', marketId);

             // Add market details
             marketElement.innerHTML = `
                 <div class="main-progress-wrap">
                     <div class="progress-slider-items">
                         <span class="gameId" style="display:none" id="gameId">${marketId}</span>
                         <div class="title">
                             <span class="text">${getCountryFlag(market.marketDefinition.countryCode)} ${market.marketDefinition.countryCode || ""} - <span class='market-status'>${market.marketDefinition.status}</span></span>
                             <span class="text" style="margin-left:30%"><i class="fas fa-hand-holding-usd"></i> <span class='totalMatched'> ${typeof market.tv === 'number' ? market.tv.toFixed(2) : '0'}</span></span>
                             <span class="eventid" style="display:none">${eventid}</span>

                             </div>
                         <div class="match-pointing" style="overflow-x:scroll; max-width:100%; min-width:300px;">
                             <div class="match-pointing-box" style="background: transparent; width:100%; min-width:300px;">
                                 <span class="title">${new Date(market.marketStartTime).toLocaleString()}</span>
                                 <span class="title">${sport.toUpperCase()} - ${market.event.name || ''}</span>
                               
                                 ${market.live?.[0]?.score?.home?.score !== undefined && market.live?.[0]?.score?.away?.score !== undefined ? `
                                     <span class="title">${market.live[0].score.home.score} : ${market.live[0].score.away.score}</span>` : ''}
                                 ${market.live?.[0]?.timeElapsed !== undefined ? `
                                     <span class="title">${market.live[0].timeElapsed}'</span>` : ''}
                                
                                 <table class="filtertable">
                                     <tr>
                                         <th>PLAYER</th>
                                         <th>BACK</th>
                                         <th>LAY</th>
                                     </tr>
                                     <tbody class="runner-list"></tbody>
                                 </table>
                             </div>
                         </div>
                     </div>
                 </div>
             `;

             // Add runners in the market
             const runnerList = marketElement.querySelector('.runner-list');
             for (const runner of marketInfo.runners) {
                 const runnerElement = document.createElement('tr');
                 runnerElement.classList.add('runner');
                 runnerElement.setAttribute('data-selection-id', runner.selectionId);
                 runnerElement.setAttribute('data-market-id', marketId);

                 runnerElement.innerHTML = `
                     <tr>
                         <td class="match-pointing-box" style="border: 2px solid #14A876">
                             <h5>${runner.runnerName || "N/A"}</h5>
                             <p style="display: none;">${runner.selectionId}</p>
                             <p class='status'>${market.marketDefinition?.runners?.find(runnerDef => runnerDef.id === runner.id)?.status || 'Unknown'}</p>
                         </td>
                         <td class="match-pointing-box" style="border: 2px solid #14A876">
                             <div class="layorback">
                                 <p class="textback">
                                     <span class="atbvalue1">${runner.bdatb[0][1]}</span>
                                     <span class="backText" style="display: none;">BACK</span>
                                 </p>
                             </div>
                             <span class="atbvalue2">£${runner.bdatb[0][2]}</span>
                         </td>
                         <td class="match-pointing-box" style="border: 2px solid #14A876">
                             <div class="layorback">
                                 <p class="textlay">
                                     <span class="atlvalue1">${runner.bdatl[0][1]}</span>
                                     <span class="layText" style="display: none;">LAY</span>
                                 </p>
                             </div>
                             <span class="atlvalue2">£${runner.bdatl[0][2]}</span>
                         </td>
                     </tr>
                 `;

                 // Append the runner element to the runner list
                 runnerList.appendChild(runnerElement);
             }

             // Append market element to the search results container
             searchResults.appendChild(marketElement);
         }
     } else {
         // If no runners found, display a message
         searchResults.innerHTML = `<p>No runners found with the name '${globalInputName}'.</p>`;
     }
 }

 // Function to request a search from the server
 async function requestSearch() {
     try {
         // Define the server URL for the search request
         const serverURL = `https://www.unicobet.co.uk/BETFAIR/search.php?inputName=${globalInputName}&totalPages=10`;

         // Make the request to the server
         const response = await fetch(serverURL);

         // Check if the response is okay
         if (!response.ok) {
             console.error(`HTTP error! Status: ${response.status}`);
             return;
         }

         // Parse the JSON data from the response
         const foundMarkets = await response.json();

         // Update the search results in the DOM
         updateSearchResults(foundMarkets);
     } catch (error) {
         console.error(`Error fetching data: ${error.message}`);
     }
 }

 // Event listener for form submission
 document.getElementById('searchForm').addEventListener('submit', async (event) => {
     event.preventDefault();

     // Get the input name from the form
     const inputName = document.getElementById('searchInput').value.trim();

     // Validate input length and format
     if (inputName.length < 1) {
         alert("Please input a runner or team.");
         return;
     } else if (inputName.length > 50) {
         alert("Invalid input length. Please enter a name between 1 and 50 characters.");
         return;
     } else if (!/^[a-zA-Z\s]+$/.test(inputName)) {
         alert("Invalid input format. Please enter a valid name.");
         return;
     }

     // Store the input name globally
     globalInputName = inputName;

     // Perform the initial search and update the results
     await requestSearch();

     // Clear any existing interval before setting a new one
     if (fetchInterval) {
         clearInterval(fetchInterval);
     }

     // Set an interval to call requestSearch every 2 seconds
     fetchInterval = setInterval(requestSearch, 2000);
 });

 // Function to handle clicks on the search results container
 document.getElementById('searchResults').addEventListener('click', function(event) {
     // Find the target element that was clicked
     const target = event.target;

     // Check if the click was inside a runner element
     const runnerElement = target.closest('.runner');
     
     if (runnerElement) {
         // Retrieve relevant data from the runner element
         const runnerName = runnerElement.querySelector('.match-pointing-box h5').textContent;
         const selectionId = runnerElement.querySelector('.match-pointing-box p').textContent;
         const marketId = runnerElement.closest('.market').getAttribute('data-market-id');
        const eventid = runnerElement.closest('.progress-slider-items').querySelector('.eventid').textContent;


         // Determine if the click was on a back or lay value
         const targetSpan = target.closest('span');
         let clickedValue = '';
         let layOrBack = '';
         if (targetSpan) {
             clickedValue = targetSpan.textContent;
             if (targetSpan.classList.contains('atlvalue1') || targetSpan.classList.contains('atlvalue2')) {
                 layOrBack = 'LAY';
             } else if (targetSpan.classList.contains('atbvalue1') || targetSpan.classList.contains('atbvalue2')) {
                 layOrBack = 'BACK';
             }
         }

         // Inject the form and populate it with the clicked values
         injectFormAndAttachListeners(marketId, selectionId, runnerName, layOrBack, clickedValue,eventid);
     }
 });

 // Function to inject the form and populate it with the clicked values
 function injectFormAndAttachListeners(marketId, selectionId, runnerName, layOrBack, clickedValue,eventid) {
     // Create the form
     const form = document.createElement('form');
     form.innerHTML = `
         <div class="progress-slider-items" style="max-width:100% !important;">   
         <label for="eventid" style="display:none" >EVENT ID:</label>
         <input type="text" style="display:none" id="eventid" name="eventid" value="${eventid}" readonly>

             <label style="display: none;" for="marketId">Market ID:</label>
             <input type="text" style="display: none;" id="marketId" name="marketId" value="${marketId}" readonly>
             
             <label style="display: none;" for="selectionId">Selection ID:</label>
             <input type="text" style="display: none;" id="selectionId" name="selectionId" value="${selectionId}" readonly>
             
             <div class="match-fixing">
                 <div class="match-items">
                     <div class="match-items-left">
                         <div class="cont">
                             <div class="icon">
                                 <img src="assets/img/header/right-icon/bets.svg" alt="icon"> Bet Details   
                             </div>
                             <label style="display: none;" for="runnerName">Player:</label>
                             <input type="text" id="runnerName" name="runnerName" value="${runnerName}" readonly>
                             
                             <table>
                                 <tr>
                                     <td>
                                         <label style="display: none;" for="updatelayOrBack">Lay or Back:</label>
                                         <input type="text" id="updatelayOrBack" name="updatelayOrBack" value="${layOrBack}" readonly>
                                     </td>
                                     <td>
                                         <label style="display: none;" for="clickedValue">Clicked Value:</label>
                                         <input type="text" id="clickedValue" name="clickedValue" value="${clickedValue}" readonly>
                                     </td>
                                 </tr>
                             </table>
                         </div>
                     </div>
                     <div class="match-items-left">
                         <div class="cont">
                             <div class="icon"></div>
                               <label style="display:none;" for="type">Type</label>
                             <select name="type" id="betTypeSelect">
                                 <option value="PERSIST">Persist</option>
                                 <option value="LAPSE">Lapse</option>
                                 <option value="MARKET_ON_CLOSE">Market On Close</option>
                             </select>
                         </div>
                     </div>
                     <div class="match-items-right">
                         <div class="icon"></div>
                         <table>
                             <tr>
                                 <td><label for="rate">Rate:</label></td>
                                 <td><input type="number" min="1.01" name="rate" step="0.01"  id="betRate" value="${clickedValue || 0}" required></td>
                             </tr>
                         </table>
                     </div>
                     <div class="match-items-right">
                         <table>
                             <tr>
                                 <td><label for="betAmount"><i class="fas fa-hand-holding-usd"></i>Stake:</label></td>
                                 <td><input type="number" min="1.00" id="betAmount" step="0.01"  name="betAmount" value="1" required></td>
                             </tr>
                         </table>
                     </div>
                     <div id="loadingAnimation"></div>
                     <div class="possible-win">
                         <p class="total-win"></p>
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
                                        alert("Please log in to place a bet."); // Alert message added
                                        
                    
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
                                    if (amount > userBalance) {
                                        stopLoadingAnimation();
                                        alert('Insufficient balance. Please deposit more funds.');
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
                   totalLayWin = (betvalue*rate - betvalue)*0.9 + betvalue;

                                        totalWinElem.textContent = `Payout: £${totalLayWin.toFixed(2)} Liability: £${betvalue.toFixed(2)}`;
                                        totalWinElem.classList.add('btn--two');
                                    } else {
                                        // Calculation for non-LAY bet
                                        totalWin = (amount * rate) * fee;
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
                    
 // Attach the function to the close button
 document.getElementById('closeResultsBtn').addEventListener('click', () => {
     // Hide the results container
     const resultsContainer = document.getElementById('resultsContainer');
     resultsContainer.style.display = 'none';

     // Clear the interval
     if (fetchInterval) {
         clearInterval(fetchInterval);
     }
 });