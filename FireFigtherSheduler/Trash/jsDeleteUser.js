    function sendDeleteUserRequest(userID){
          var xmlHttp = getXMLHttp();
          xmlHttp.onreadystatechange = function() {
            if(xmlHttp.readyState == 4) {
              HandleDeleteResponse(xmlHttp.responseText);
            }
          }
          //muss in POST geaendert werden
          xmlHttp.open("GET", "../Controller/deleteUser.php?userID=" + userID, true); //+ Math.random()
          xmlHttp.send(null);
    }

    function HandleDeleteResponse(response){
        document.getElementById('infobox').value = response;
    }