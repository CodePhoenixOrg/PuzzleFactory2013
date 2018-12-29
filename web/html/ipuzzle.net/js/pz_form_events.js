function runForm(thisForm) {
	document.forms(thisForm).event.value='onRun';
	document.forms(thisForm).submit();
}

function unloadForm(thisForm) {
	document.forms(thisForm).event.value='onUnload';
	document.forms(thisForm).submit();
}
