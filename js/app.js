


function popupLogin() {
  document.getElementById('popupLogin').style.display = "block";
  document.getElementById('popupRegister').style.display = "none";
}

function popupRegister() {
  document.getElementById('popupRegister').style.display = "block";
  document.getElementById('popupLogin').style.display = "none";
}

function eventCheckbox() {
  if(document.getElementById('loopCheck-event').checked == true){
    document.getElementById('jours-event-loop').style.display = "block";
  } else {
    document.getElementById('jours-event-loop').style.display = "none";
  }
}

function changeRole() {
  document.getElementById("collegueManagement").submit();
}
