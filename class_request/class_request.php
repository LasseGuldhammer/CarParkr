<?php



class Request {
	
	/*	
	 *	Uses CURL to retrive the contens of a file
	 */
	public function getFile($url) {
		//  Initiate curl
		$ch = curl_init();
			// Disable SSL verification
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// Will return the response, if false it print the response
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// Set the url
			curl_setopt($ch, CURLOPT_URL,$url);
		// Execute
		$result=curl_exec($ch);
		// Close the connection
		curl_close($ch);

		// return as JSON
		return($result);
	}
}