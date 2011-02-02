    function sendUserInfoRequest(userID){
          var xmlHttp = getXMLHttp();

          xmlHttp.onreadystatechange = function() {
            if(xmlHttp.readyState == 4) {
              HandleUserInfoResponse(xmlHttp.responseXML);
            }
          }
          xmlHttp.open("GET", "../Controller/getUserInfo.php?userID=" + userID, true); //+ Math.random()
          xmlHttp.send(null);
    }

    function HandleUserInfoResponse(response){
         var id = response.getElementsByTagName('id')[0].childNodes[0].nodeValue;
         var lastname = response.getElementsByTagName('lastname')[0].childNodes[0].nodeValue;
         var firstname = response.getElementsByTagName('firstname')[0].childNodes[0].nodeValue;
         var email = response.getElementsByTagName('email')[0].childNodes[0].nodeValue;
         var bday = response.getElementsByTagName('bday')[0].childNodes[0].nodeValue;

         document.getElementById('ok').value = "Speichern";
         document.getElementById('reset').value = "nicht Speichern";
         document.getElementById("delete").style.visibility = "visible";

         document.getElementById('id').value = id;
         document.getElementById('lastname').value = lastname;
         document.getElementById('firstname').value = firstname;
         document.getElementById('email').value = email;
         document.getElementById('bday').value = bday;

    }

