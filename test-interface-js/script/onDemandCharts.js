window.onload = function() {
    formulaire.addEventListener('submit', (event) => {
        event.preventDefault();
        
            
            // Handler de la requete à l'API Open AI
            var oaipass = document.getElementById("oaipass").value;
            var prompt = document.getElementById("prompt").value;
            
            $.ajax({
        url: 'https://api.openai.com/v1/threads/runs',
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + oaipass,
            'OpenAI-Beta': 'assistants=v1',
        },
        data: JSON.stringify({
            "assistant_id": "asst_rxdHY63u4Z1NToF7zD8ae2Nr",
            "thread": {
                "messages": [{
                    "role": "user",
                    "content": "here is the data you will analyze:" + enregistrementLocalStorage + " " + prompt + " Please when you plot the data to represent a dimension, don't display the id but rather the name of the dimension, thaa I give you here after :" + JSON.stringify(meteo) + JSON.stringify(typeRoute) + JSON.stringify(typeTraffic) + JSON.stringify(manoeuvres)
                }]
            }
        }),
        responseType: 'json',
        success: function(data) {
            //console.log(data);
            // On récupère le message de réponse
            // On extrait la valeur de la clé "status" du message de réponse
            var status = data.status;
            var threadId = data.thread_id;
            var runId = data.id;
            document.getElementById("response").innerHTML = "<br><br> Bien joué votre requête OpenAI API est:" + status + ", <br> votre diagramme est en cours de construction. <div style=\"text-align:center;\"><img src='./ld.gif' alt='diagramme' width='70' height='70'></div>";
            // Create a function that calls sendRequest with the necessary arguments
            var sendRequestWithArgs = function() {
                sendRequest(threadId, runId, oaipass, intervalId);
            // Call sendRequestWithArgs every 7000 milliseconds (7 seconds)
            };
            var intervalId = setInterval(sendRequestWithArgs, 7000);
        },
        error: function(error) {
            console.log('Error:', error);
        }
        });
        
        ////essaie de récupérer l'image toutes les 5 secondes
        function sendRequest(thread_id,run_id,oai_pass,interval_id) {
            $.ajax({
                url: 'https://api.openai.com/v1/threads/' + thread_id + '/runs/' + run_id,
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + oai_pass,
                    'OpenAI-Beta': 'assistants=v1',
                },
                responseType: 'json',
                success: function(data) {
                    //console.log(data);
                    //console.log(data.status);
                    // Check if the data is 'complete'
                    if (data.status === 'completed') {
                        // If it is, stop the interval
                        clearInterval(interval_id);
                        var imageId = getImageId(thread_id, oai_pass);
                        //console.log(imageId);
                            }
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        }
        
        

        function getImageId(thread_id, oai_pass) {

            $.ajax({
                url: 'https://api.openai.com/v1/threads/' + thread_id + '/messages',
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + oai_pass,
                    'OpenAI-Beta': 'assistants=v1',
                    'Accept': 'application/json',
                    'Response-Type': 'json'
                },
                success: function(data) {
                    try {
                        var imageFileId = data.data[0].content[0].image_file.file_id;
                        var gptText = data.data[0].content[1].text.value;
                        //console.log(imageFileId);
                        getImageFile(imageFileId, oai_pass, gptText);
                        return imageFileId;
                    } catch (error) {
                        document.getElementById("response").innerHTML = "<br><br>Navrés mais notre chatbot n'a pas compris votre requête, veuillez reformuler votre demande et utiliser de préferrence l'anglais.";
                        console.log('Error:', error);
                    }
                    
                },
                error: function(error) {
                    document.getElementById("response").innerHTML = "<br><br>Navrés mais notre chatbot n'a pas réponsu, veuillez réessayer plus tard ou vérifier votre pass API et vos crédits.";
                    console.log('Error:', error);
                }
            });
        }

            function getImageFile(image_id, o_ai_pass, gpt_text) {
                $.ajax({
                    url: 'https://api.openai.com/v1/files/' + image_id + '/content',
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/octet-stream',
                        'Authorization': 'Bearer ' + o_ai_pass,
                        'OpenAI-Beta': 'assistants=v1',
                    },
                    xhrFields: {
                    responseType: 'blob'
                                        },
                    success: function(data) {
                        //console.log(data);
                        // Use FileSaver.js to save the blob as chart.png
                        saveAs(data, "chart.png", {type: 'application/octet-stream'});
                        
                        // Create a Blob URL from the data
                        var url = URL.createObjectURL(data);

                        // Set the src attribute of the img tag to the Blob URL
                        document.getElementById("response").innerHTML = '<br>' + gpt_text+ '<br><br><img src="' + url + '" alt="diagramme" width="400px">';
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
            }
    });
}