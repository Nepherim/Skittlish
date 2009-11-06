/* base class extensions */
String.prototype.trim = function() {
  return this.replace(/^\s+/, '').replace(/\s+$/, '');
}
Array.prototype.indexOf = function(elem) {
  for (var i=0; i<this.length; i++) {
    if (this[i] == elem) return i;
  }
  return -1;
}

/* dom helpers */
function hasClass(elem, name) {
  var arr = elem.className.split(' ');
  if (arr.indexOf(name) != -1) {
    return true;
  }
  return false;
}
function addClass(elem, name) {
  var arr = elem.className.split(' ');
  if (arr.indexOf(name) == -1) {
    arr.push(name);
    elem.className = arr.join(" ");
  }
}
function removeClass(elem, name) {
  var arr = elem.className.split(' ');
  var arr2 = [];
  for (var i=0; i<arr.length; i++) {
    if (arr[i] != name) {
      arr2.push(arr[i]);
    }
  }
  elem.className = arr2.join(" ");
}
// we want to touch the className only once
// yeah, it's not dry :p
function replaceClass(elem, old_class, new_class) {
  var arr = elem.className.split(' ');
  var arr2 = [];
  for (var i=0; i<arr.length; i++) {
    if (arr[i] != old_class) {
      arr2.push(arr[i]);
    }
  }
  arr2.push(new_class);
  elem.className = arr2.join(" ");
}

/* cookie helpers */
function setCookie(name, value, permanent) {
  var expires = '';
  if (permanent) {
    expires = '; expires=' + (new Date()).toGMTString().replace(/20\d\d/, 2020);
  }
  document.cookie = name+"="+value+expires+"; path=/";
}
function getCookie(name) {
  var i, crumbs, crumb;
  crumbs = document.cookie.split(';');
  for (var i=0; i<crumbs.length; i++) {
    crumb = crumbs[i].trim();
    if (crumb.indexOf(name + "=") == 0) {
      return crumb.substring((name + "=").length);
    }
  }
  return '';
}

/* el customizer */
function loadPreferences() {
  document.getElementsByTagName('body')[0].className = (getCookie('skittlish') || g_DefaultStyle);
}
window.onload = function() {
  var o = document.getElementById("options");
  if (o) {
	  var lis = o.getElementsByTagName("LI");

	  for (var i=0; i< lis.length; i++) {
		 li = lis[i];
		 parts = li.id.split("_");
		 li.title = parts[1] + ": " + parts[2];

		 li.onclick = function() {
			var body = document.getElementsByTagName('BODY')[0];
			var new_option_group = this.id.split("_")[1];
			var new_option = this.id.split("_")[2];
			if (new_option_group == 'size') {
			  if (new_option == 'fluid') {
				 replaceClass(body, 'fixed', 'fluid');
			  } else {
				 replaceClass(body, 'fluid', 'fixed');
			  }
			} else {
			  var colors = 'blue,cyan,green,orange,pink,red,violet'.split(',');
			  var current_color = '';
			  for (var i=0; i<colors.length; i++) {
				 if (hasClass(body, colors[i])) {
					current_color = colors[i];
					break;
				 }
			  }
			  if (new_option != current_color) {
				 replaceClass(body, current_color, new_option);
			  }
			}
			setCookie('skittlish', body.className, true);
			return false;
		 }

	  }
	}
}
