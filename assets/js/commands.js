var elem = $("terminal");
String.prototype.getCMDType = function () {
  //this.forEach((element) => {});
  console.log(this);
}
function g0(input) {
  //strinlen
  if (input==="") input = "br";
  
  script = document.createElement("script");
  script.type = "text/javascript";
  
  input.split("|").forEach(element => {
    var data = [];
    var cmd = element.split(" ");
    for (let index = 1; index < cmd.length; index++) {
      //const element = array[index];
      data[index - 1] = cmd[index];
    }
    console.log("g0", cmd[0], data);
    //TODO: Test for empty elements
    if (data.length === 0) {
      script.src = "./xterm.php?cmd=" + cmd;
    } else {
      //console.log(data);
      for (let index = 0; index < data.length; index++) {
        const element = data[index];

        console.log(element.replaceAll("-", ""), element.getCMDType());
      }
      script.src = `./xterm.php?cmd=${cmd[0]}&argv=${btoa(JSON.stringify(data))}`;
    }

    elem.appendChild(script);
    elem.removeChild(script);
  });
  
}
function s0(e) {
  console.log(e);
  switch (e.run) {
    case "loopLines":
      loopLines(e.data, "", 80);
      break;  
    default:
      addLine(e.data, "", 80);
      break;
  }
}
