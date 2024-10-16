function insertThisInThere(thisChar, thereId) {
	function theCursorPosition(ofThisInput) {
		// set a fallback cursor location
		var theCursorLocation = 0;
		// find the cursor location via IE method...
		if (document.selection) {
			ofThisInput.focus();
			var theSelectionRange = document.selection.createRange();
			theSelectionRange.moveStart('character', -ofThisInput.value.length);
			theCursorLocation = theSelectionRange.text.length;
		} else if (ofThisInput.selectionStart || ofThisInput.selectionStart == '0') {
			// or the FF way 
			theCursorLocation = ofThisInput.selectionStart;
		}
		return theCursorLocation;
	}
	// now get ready to place our new character(s)...
	var theIdElement = document.getElementById(thereId);
	var currentPos = theCursorPosition(theIdElement);
	var origValue = theIdElement.value;
	var newValue = origValue.substr(0, currentPos) + thisChar + origValue.substr(currentPos);
	theIdElement.value = newValue;
}
