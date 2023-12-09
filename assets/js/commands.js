var elem = $("terminal");
function g0(cmd) {
  //strinlen
  if (cmd==="") cmd = "br";
  
  script = document.createElement("script");
  script.type = "text/javascript";
  var data = [];
  var array = cmd.split(" ");
  for (let index = 1; index < array.length; index++) {
    //const element = array[index];
    data[index - 1] = array[index];
  }
  console.log("g0", cmd.split(" ")[0], data);
  //TODO: Test for empty elements
  if (data.length === 0) {
    script.src = "./xterm.php?cmd=" + cmd
  } else {
    script.src = "./xterm.php?cmd=" + cmd.split(" ")[0] + "&argv=" + btoa(JSON.stringify(data));
  }
  
  elem.appendChild(script);
  elem.removeChild(script);
}
function s0(e) {
  console.log(e);
  
  if (e.run === "loopLines") {
    loopLines(e.data, "", 80);
  } else {
    addLine(e.data, "", 80);
    //term.write(e.data);
  }
}
