/* jshint esversion: 6*/
function ajaxRequest () {
   let ajaxObject;
   ajaxObject = new XMLHttpRequest();

   ajaxObject.onreadystatechange = function () {

      if (ajaxObject.readyState === 4) {
         let ajaxTable = document.getElementById('ajaxTable');
         ajaxTable.innerHTML = ajaxObject.responseText;
         addStyles();
      }
   }

   let queryString = "?name=" + ((this.name)? this.name: "museum");
   
   ajaxObject.open("GET", "getuser.php" + queryString, true);
   ajaxObject.send(null);
}


function addStyles () {
    let table = document.getElementById('ajaxTable').children[0];
    table.classList.add('table', 'table-hover', 'table-striped');
    // table.setAttribute('contenteditable', true); //add when user will be signed in
    document.getElementsByTagName('tr')[0].classList.add('info');
}

let headers = document.querySelector('.events').children;

for (let i = 0; i < headers.length; i++) {
    headers[i].firstChild.addEventListener('click', ajaxRequest);
}

window.onload = ajaxRequest;

