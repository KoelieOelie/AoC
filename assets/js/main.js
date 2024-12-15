var before = $("before");
var liner = $("liner");
var command = $("typer");
var textarea = $("texter");
var terminal = $("terminal");
var git = 0;
var commands = [];
var pw = false;
window.process=false;

setTimeout(function () {
  g0("🎅");
  textarea.focus();
}, 100);

window.addEventListener("keyup", enterKey);

//init
textarea.value = "";
command.innerText = textarea.value;

function enterKey(e) {
  if (e.keyCode == 181) {
    document.location.reload(true);
  }
  if (e.keyCode == 13) {
    if (!window.process) {
      commands.push(command.innerText);
    }
    git = commands.length;
    addLine(command.innerText, "no-animation cmd", 0);
    commander(command.innerText.toLowerCase());
    command.innerText = "";
    textarea.value = "";
  }
  if (e.keyCode == 38 && git != 0) {
    git -= 1;
    textarea.value = commands[git];
    command.innerText = textarea.value;
  }
  if (e.keyCode == 40 && git != commands.length) {
    git += 1;
    if (commands[git] === undefined) {
      textarea.value = "";
    } else {
      textarea.value = commands[git];
    }
    command.innerText = textarea.value;
  }
}

function commander(cmd) {
  switch (cmd.toLowerCase()) {
    case "clear":
      setTimeout(function () {
        terminal.innerHTML = '<a id="before"></a>';
        before = document.getElementById("before");
      }, 1);
      break;
    case "banner":
      g0("banner");
      break;
    default:
      g0(cmd);
      break;
  }
}
