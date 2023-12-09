String.prototype.cmd = function () {
  //console.log(this);
  // utf8 to latin1
  var s = unescape(encodeURIComponent(this));
  var h = "";
  for (var i = 0; i < s.length; i++) {
    h += s.charCodeAt(i).toString(16) + " ";
  }
  return h;
};
function newTab(link) {
  setTimeout(function () {
    window.open(link, "_blank");
  }, 500);
}

function addLine(text, style, time) {
  var t = "";
  for (let i = 0; i < text.length; i++) {
    if (text.charAt(i) == " " && text.charAt(i + 1) == " ") {
      t += "&nbsp;&nbsp;";
      i++;
    }  else {
      if (text.charAt(i) == "\x1b") {
        i++;
        switch (text.charAt(i)) {
          case "1":
            t += '<span class="index">';
            break;
          case "2":
            t += '<span class="command">';
            break;
          case "3":
            t += '<span class="color2">';
            break;
          case "0":
            t += "</span>";
            break;
          default:
            console.log(text.charAt(i));
            t += "</span>";
            break;
        }
        //t += "HOHOHOHO";
      } else {
        t += text.charAt(i);
      }
      //t += text.charAt(i);
    }
  }
  setTimeout(function () {
    var next = document.createElement("p");
    next.innerHTML = t;
    next.className = style;
    next.setAttribute("data-user", liner.getAttribute("data-user"));
    next.setAttribute("data-pwd", liner.getAttribute("data-pwd"));
    
    before.parentNode.insertBefore(next, before);

    window.scrollTo(0, document.body.offsetHeight);
  }, time);
}

function loopLines(name, style, time) {
  name.forEach(function (item, index) {
    addLine(item, style, index * time);
  });
}
