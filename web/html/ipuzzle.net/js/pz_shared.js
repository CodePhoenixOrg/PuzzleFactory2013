	function pz_getPath(thisObject) {
		//var p="document.all(\""+thisObject+"\")";
		var p="document.getElementById(\""+thisObject+"\")";
		if (eval(p))
			return p;
		else
			return false;
	}

	function pz_elements() {
		var i; var j;

		j=document.all.length;
		for(i=0;i<j;i++) {
			document.write(document.all[i]+"<br>");
		}
	}
