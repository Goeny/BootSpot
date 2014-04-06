<?php
	function formResult2Xml($result) {
		$output = '<xml>';

        /*
         * First we output all errors, warnings and information fields
         */
		# output each field to the XML as seperate field, eg $createresult['username']
		# wil become <username>blah
		foreach($result as $key => $value) {
			$output .= '<' . $key . '>' . htmlspecialchars($value) . '</' . $key . '>';
		} # foreach
		
		# now output each formmessage 
		foreach($formmessages as $formMsgType => $formMsgValues) {
			foreach($formMsgValues as $value) {
				$output .= '<' . $formMsgType . '>' . htmlspecialchars($value) . '</' . $formMsgType . '>';
			} # foreach
		} # foreach
		
		$output .= '</xml>';
		return $output;
	} # formResult2Xml
