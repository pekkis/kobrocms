/**
 * Kobro tracker will challenge Google Analyticks in the future
 * and make good business for the foundation.
 * 
 * @author Yuyutsu Vettickanakudy
 *
 */
KobroTracker = function() {
	// We create kobros div to contain trackings
	document.write("<div id='kobrotracker' style='display: none;'></div>");	
};


KobroTracker.get = function() {
	
	var kt = new KobroTracker();
	
	// We set hashings and stuff to tracker!
	kt.strLocation = window.location.href;
	kt.strHash = window.location.hash.substr(1, window.location.hash.length);
	kt.strPrevLocation = "";
	kt.strPrevHash = "";
	 
	// This be how often we will be checkint for changes on locations.
	var intervalTime = 100;
	
	// Set java-script interval to check the location changes.
	setInterval( function() { kt.checkLocation(); }, intervalTime );
	
	return kt;
	
};
	

KobroTracker.prototype = {
    isSafeUrl: function (string) {
        // Don't track URLs which contain blacklisted characters. This is to prevent XSS injections. 
        var blackListedCharacters = new Array('<', '>' , "'", '"');
        
        for (var i = 0; i < blackListedCharacters.length; i++) {
            if(string.indexOf(blackListedCharacters[i]) !== -1) {
                return false;
            }
        }
        
        return true;
    },
		
	track: function() {
		// we append image to document to send stuff to dr. kobros tracker server.
        if (this.isSafeUrl(this.strLocation) && this.isSafeUrl(this.strHash)) {
            var appender = "<img src='http://dr-kobros.com/track.html?location=" + this.strLocation + "&anchor=" + this.strHash + "' />";  
            $("#kobrotracker").append(appender);
        }
	},
		
	// This be the method that we check changes in window locations.
	checkLocation: function() {
				
		// Check to see if the location has changed and if it has, we call tracker again. So smart!
		if (this.strLocation !== window.location.href){
			// Store the new and previous location so we track no again.
			this.strPrevLocation = this.strLocation;
			this.strPrevHash = this.strHash;
			this.strLocation = window.location.href;
			this.strHash = window.location.hash.substr(1, window.location.hash.length);
		 
			this.track();
			
		}
	}
	
};

