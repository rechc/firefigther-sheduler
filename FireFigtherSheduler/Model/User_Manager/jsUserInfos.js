    function sendUserInfoRequest(userID){
          var xmlHttp = getXMLHttp();

          xmlHttp.onreadystatechange = function() {
            if(xmlHttp.readyState == 4) {
              HandleResponse(xmlHttp.responseXML);
            }
          }
          xmlHttp.open("GET", "../Model/User_Manager/getUserInfo.php?userID=" + userID, true); //+ Math.random()
          xmlHttp.send(null);
    }

    function HandleResponse(response){
         var lastname = response.getElementsByTagName('lastname')[0].childNodes[0].nodeValue;
         var firstname = response.getElementsByTagName('firstname')[0].childNodes[0].nodeValue;

         document.getElementById('lastname').value = lastname;
         document.getElementById('firstname').value = firstname;
    }

  function createNewUser(){
        var lastname = document.getElementById('lastname').value;
        var firstname = document.getElementById('firstname').value;
        var email = document.getElementById('email').value;
        var bday = document.getElementById('bday').value;

        var xmlHttp = getXMLHttp();

        xmlHttp.onreadystatechange = function() {
          if(xmlHttp.readyState == 4) {
             HandleResponse(xmlHttp.responseText);
            }
         }

          xmlHttp.open("POST", "../Controller/configUsera.php?lastname=" + lastname +
          "&firstname=" + firstname + "&email=" + email + "&bday=" + bday + "", true); //+ Math.random()
          xmlHttp.send(null);
    }

    function deleteUser(id){
        var xmlHttp = getXMLHttp();

        xmlHttp.onreadystatechange = function() {
          if(xmlHttp.readyState == 4) {
             HandleResponse(xmlHttp.responseText);
            }
         }

          xmlHttp.open("POST", "../Controller/configUsera.php?id=" + id);
          xmlHttp.send(null);
    }
