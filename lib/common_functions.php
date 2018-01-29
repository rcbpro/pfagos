<?php

class CommonFunctions{

	static $nationalityList = array(								
									"afghan" => "Afghan",
									"albanian" => "Albanian",
									"algerian" => "Algerian",
									"american" => "American",
									"andorran" => "Andorran",
									"angolan" => "Angolan",
									"antiguans" => "Antiguans",
									"argentinean" => "Argentinean",
									"armenian" => "Armenian",
									"australian" => "Australian",
									"austrian" => "Austrian",
									"azerbaijani" => "Azerbaijani",
									"bahamian" => "Bahamian",
									"bahraini" => "Bahraini",
									"bangladeshi" => "Bangladeshi",
									"barbadian" => "Barbadian",
									"barbudans" => "Barbudans",
									"batswana" => "Batswana",
									"belarusian" => "Belarusian",
									"belgian" => "Belgian",
									"belizean" => "Belizean",
									"beninese" => "Beninese",
									"bhutanese" => "Bhutanese",
									"bolivian" => "Bolivian",
									"bosnian" => "Bosnian",
									"brazilian" => "Brazilian",
									"british" => "British",
									"bruneian" => "Bruneian",
									"bulgarian" => "Bulgarian",
									"burkinabe" => "Burkinabe",
									"burmese" => "Burmese",
									"burundian" => "Burundian",
									"cambodian" => "Cambodian",
									"cameroonian" => "Cameroonian",
									"canadian" => "Canadian",
									"cape verdean" => "Cape Verdean",
									"central african" => "Central African",
									"chadian" => "Chadian",
									"chilean" => "Chilean",
									"chinese" => "Chinese",
									"colombian" => "Colombian",
									"comoran" => "Comoran",
									"congolese" => "Congolese",
									"congolese" => "Congolese",
									"costa rican" => "Costa Rican",
									"croatian" => "Croatian",
									"cuban" => "Cuban",
									"cypriot" => "Cypriot",
									"czech" => "Czech",
									"danish" => "Danish",
									"djibouti" => "Djibouti",
									"dominican" => "Dominican",
									"dominican" => "Dominican",
									"dutch" => "Dutch",
									"dutchman" => "Dutchman",
									"dutchwoman" => "Dutchwoman",
									"east timorese" => "East Timorese",
									"ecuadorean" => "Ecuadorean",
									"egyptian" => "Egyptian",
									"emirian" => "Emirian",
									"equatorial guinean" => "Equatorial Guinean",
									"eritrean" => "Eritrean",
									"estonian" => "Estonian",
									"ethiopian" => "Ethiopian",
									"fijian" => "Fijian",
									"filipino" => "Filipino",
									"finnish" => "Finnish",
									"french" => "French",
									"gabonese" => "Gabonese",
									"gambian" => "Gambian",
									"georgian" => "Georgian",
									"german" => "German",
									"ghanaian" => "Ghanaian",
									"greek" => "Greek",
									"grenadian" => "Grenadian",
									"guatemalan" => "Guatemalan",
									"guinea-bissauan" => "Guinea-Bissauan",
									"guinean" => "Guinean",
									"guyanese" => "Guyanese",
									"haitian" => "Haitian",
									"herzegovinian" => "Herzegovinian",
									"honduran" => "Honduran",
									"hungarian" => "Hungarian",
									"i-kiribati" => "I-Kiribati",
									"icelander" => "Icelander",
									"indian" => "Indian",
									"indonesian" => "Indonesian",
									"iranian" => "Iranian",
									"iraqi" => "Iraqi",
									"irish" => "Irish",
									"irish" => "Irish",
									"israeli" => "Israeli",
									"italian" => "Italian",
									"ivorian" => "Ivorian",
									"jamaican" => "Jamaican",
									"japanese" => "Japanese",
									"jordanian" => "Jordanian",
									"kazakhstani" => "Kazakhstani",
									"kenyan" => "Kenyan",
									"kittian and nevisian" => "Kittian and Nevisian",
									"kuwaiti" => "Kuwaiti",
									"kyrgyz" => "Kyrgyz",
									"laotian" => "Laotian",
									"latvian" => "Latvian",
									"lebanese" => "Lebanese",
									"liberian" => "Liberian",
									"libyan" => "Libyan",
									"liechtensteiner" => "Liechtensteiner",
									"lithuanian" => "Lithuanian",
									"luxembourger" => "Luxembourger",
									"macedonian" => "Macedonian",
									"malagasy" => "Malagasy",
									"malawian" => "Malawian",
									"malaysian" => "Malaysian",
									"maldivan" => "Maldivan",
									"malian" => "Malian",
									"maltese" => "Maltese",
									"marshallese" => "Marshallese",
									"mauritanian" => "Mauritanian",
									"mauritian" => "Mauritian",
									"mexican" => "Mexican",
									"micronesian" => "Micronesian",
									"moldovan" => "Moldovan",
									"monacan" => "Monacan",
									"mongolian" => "Mongolian",
									"moroccan" => "Moroccan",
									"mosotho" => "Mosotho",
									"motswana" => "Motswana",
									"mozambican" => "Mozambican",
									"namibian" => "Namibian",
									"nauruan" => "Nauruan",
									"nepalese" => "Nepalese",
									"netherlander" => "Netherlander",
									"new zealander" => "New Zealander",
									"ni-vanuatu" => "Ni-Vanuatu",
									"nicaraguan" => "Nicaraguan",
									"nigerian" => "Nigerian",
									"nigerien" => "Nigerien",
									"north korean" => "North Korean",
									"northern irish" => "Northern Irish",
									"norwegian" => "Norwegian",
									"omani" => "Omani",
									"pakistani" => "Pakistani",
									"palauan" => "Palauan",
									"panamanian" => "Panamanian",
									"papua new guinean" => "Papua New Guinean",
									"paraguayan" => "Paraguayan",
									"peruvian" => "Peruvian",
									"polish" => "Polish",
									"portuguese" => "Portuguese",
									"qatari" => "Qatari",
									"romanian" => "Romanian",
									"russian" => "Russian",
									"rwandan" => "Rwandan",
									"saint lucian" => "Saint Lucian",
									"salvadoran" => "Salvadoran",
									"samoan" => "Samoan",
									"san marinese" => "San Marinese",
									"sao tomean" => "Sao Tomean",
									"saudi" => "Saudi",
									"scottish" => "Scottish",
									"senegalese" => "Senegalese",
									"serbian" => "Serbian",
									"seychellois" => "Seychellois",
									"sierra leonean" => "Sierra Leonean",
									"singaporean" => "Singaporean",
									"slovakian" => "Slovakian",
									"slovenian" => "Slovenian",
									"solomon islander" => "Solomon Islander",
									"somali" => "Somali",
									"south african" => "South African",
									"south korean" => "South Korean",
									"spanish" => "Spanish",
									"sri lankan" => "Sri Lankan",
									"sudanese" => "Sudanese",
									"surinamer" => "Surinamer",
									"swazi" => "Swazi",
									"swedish" => "Swedish",
									"swiss" => "Swiss",
									"syrian" => "Syrian",
									"taiwanese" => "Taiwanese",
									"tajik" => "Tajik",
									"tanzanian" => "Tanzanian",
									"thai" => "Thai",
									"togolese" => "Togolese",
									"tongan" => "Tongan",
									"trinidadian or tobagonian" => "Trinidadian or Tobagonian",
									"tunisian" => "Tunisian",
									"turkish" => "Turkish",
									"tuvaluan" => "Tuvaluan",
									"ugandan" => "Ugandan",
									"ukrainian" => "Ukrainian",
									"uruguayan" => "Uruguayan",
									"uzbekistani" => "Uzbekistani",
									"venezuelan" => "Venezuelan",
									"vietnamese" => "Vietnamese",
									"welsh" => "Welsh",
									"welsh" => "Welsh",
									"yemenite" => "Yemenite",
									"zambian" => "Zambian",
									"zimbabwean" => "Zimbabwean"									
								);

	static $countryList = array(
	
								"Afghanistan" => "Afghanistan",
								"Aland Islands" => "Aland Islands",
								"Albania" => "Albania",
								"Algeria" => "Algeria",
								"American Samoa" => "American Samoa",
								"Andorra" => "Andorra",
								"Angola" => "Angola",
								"Anguilla" => "Anguilla",
								"Antarctica" => "Antarctica",
								"Antigua and Barbuda" => "Antigua and Barbuda",
								"Argentina" => "Argentina",
								"Armenia" => "Armenia",
								"Aruba" => "Aruba",
								"Australia" => "Australia",
								"Austria" => "Austria",
								"Azerbaijan" => "Azerbaijan",
								"Bahamas" => "Bahamas",
								"Bahrain" => "Bahrain",
								"Bangladesh" => "Bangladesh",
								"Barbados" => "Barbados",
								"Belarus" => "Belarus",
								"Belize" => "Belize",
								"Belgium" => "Belgium",
								"Benin" => "Benin",
								"Bermuda" => "Bermuda",
								"Bhutan" => "Bhutan",
								"Bolivia" => "Bolivia",
								"Bosnia and Herzegovina" => "Bosnia and Herzegovina",
								"Botswana" => "Botswana",
								"Bouvet Island" => "Bouvet Island",
								"Brazil" => "Brazil",
								"British Antarctic Territory" => "British Antarctic Territory",
								"British Indian Ocean Territory" => "British Indian Ocean Territory",
								"British Virgin Islands" => "British Virgin Islands",
								"Brunei" => "Brunei",
								"Bulgaria" => "Bulgaria",
								"Burkina Faso" => "Burkina Faso",
								"Burundi" => "Burundi",
								"Cambodia" => "Cambodia",
								"Cameroon" => "Cameroon",
								"Canada" => "Canada",
								"Canton and Enderbury Islands" => "Canton and Enderbury Islands",
								"Cape Verde" => "Cape Verde",
								"Cayman Islands" => "Cayman Islands",
								"Central African Republic" => "Central African Republic",
								"Chad" => "Chad",
								"Chile" => "Chile",
								"China" => "China",
								"Christmas Island" => "Christmas Island",
								"Cocos (Keeling) Islands" => "Cocos (Keeling) Islands",
								"Colombia" => "Colombia",
								"Comoros" => "Comoros",
								"Congo (Brazzaville)" => "Congo (Brazzaville)",
								"Congo (Kinshasa)" => "Congo (Kinshasa)",
								"Cook Islands" => "Cook Islands",
								"Costa Rica" => "Costa Rica",
								"Croatia" => "Croatia",
								"Cuba" => "Cuba",
								"Cyprus" => "Cyprus",
								"Czech Republic" => "Czech Republic",
								"Denmark" => "Denmark",
								"Djibouti" => "Djibouti",
								"Dominica" => "Dominica",
								"Dominican Republic" => "Dominican Republic",
								"Dronning Maud Land" => "Dronning Maud Land",
								"East Timor" => "East Timor",
								"Ecuador" => "Ecuador",
								"Egypt" => "Egypt",
								"El Salvador" => "El Salvador",
								"Equatorial Guinea" => "Equatorial Guinea",
								"Eritrea" => "Eritrea",
								"Estonia" => "Estonia",
								"Ethiopia" => "Ethiopia",
								"Falkland Islands" => "Falkland Islands",
								"Faroe Islands" => "Faroe Islands",
								"Fiji" => "Fiji",
								"Finland" => "Finland",
								"France" => "France",
								"French Guiana" => "French Guiana",
								"French Polynesia" => "French Polynesia",
								"French Southern Territories" => "French Southern Territories",
								"French Southern and Antarctic Territories" => "French Southern and Antarctic Territories",
								"Gabon" => "Gabon",
								"Gambia" => "Gambia",
								"Germany" => "Germany",
								"Georgia" => "Georgia",
								"Ghana" => "Ghana",
								"Gibraltar" => "Gibraltar",
								"Greece" => "Greece",
								"Greenland" => "Greenland",
								"Grenada" => "Grenada",
								"Guadeloupe" => "Guadeloupe",
								"Guam" => "Guam",
								"Guatemala" => "Guatemala",
								"Guinea" => "Guinea",
								"Guinea-Bissau" => "Guinea-Bissau",
								"Guyana" => "Guyana",
								"Haiti" => "Haiti",
								"Heard Island and McDonald Islands" => "Heard Island and McDonald Islands",
								"Honduras" => "Honduras",
								"Hong Kong S.A.R., China" => "Hong Kong S.A.R., China",
								"Hungary" => "Hungary",
								"Iceland" => "Iceland",
								"India" => "India",
								"Indonesia" => "Indonesia",
								"Ireland" => "Ireland",
								"Italy" => "Italy",
								"Iran" => "Iran",
								"Iraq" => "Iraq",
								"Israel" => "Israel",
								"Ivory Coast" => "Ivory Coast",
								"Jamaica" => "Jamaica",
								"Japan" => "Japan",
								"Johnston Island" => "Johnston Island",
								"Jordan" => "Jordan",
								"Kazakhstan" => "Kazakhstan",
								"Kenya" => "Kenya",
								"Kiribati" => "Kiribati",
								"Kuwait" => "Kuwait",
								"Kyrgyzstan" => "Kyrgyzstan",
								"Laos" => "Laos",
								"Latvia" => "Latvia",
								"Lebanon" => "Lebanon",
								"Lesotho" => "Lesotho",
								"Liberia" => "Liberia",
								"Libya" => "Libya",
								"Liechtenstein" => "Liechtenstein",
								"Lithuania" => "Lithuania",
								"Luxembourg" => "Luxembourg",
								"Macao S.A.R., China" => "Macao S.A.R., China",
								"Macedonia" => "Macedonia",
								"Madagascar" => "Madagascar",
								"Malawi" => "Malawi",
								"Malaysia" => "Malaysia",
								"Maldives" => "Maldives",
								"Mali" => "Mali",
								"Malta" => "Malta",
								"Marshall Islands" => "Marshall Islands",
								"Martinique" => "Martinique",
								"Mauritania" => "Mauritania",
								"Mauritius" => "Mauritius",
								"Mayotte" => "Mayotte",
								"Metropolitan France" => "Metropolitan France",
								"Mexico" => "Mexico",
								"Micronesia" => "Micronesia",
								"Midway Islands" => "Midway Islands",
								"Moldova" => "Moldova",
								"Monaco" => "Monaco",
								"Mongolia" => "Mongolia",
								"Montserrat" => "Montserrat",
								"Morocco" => "Morocco",
								"Mozambique" => "Mozambique",
								"Myanmar" => "Myanmar",
								"Namibia" => "Namibia",
								"Nauru" => "Nauru",
								"Nepal" => "Nepal",
								"Netherlands" => "Netherlands",
								"Netherlands Antilles" => "Netherlands Antilles",
								"New Zealand" => "New Zealand",
								"New Caledonia" => "New Caledonia",
								"Nicaragua" => "Nicaragua",
								"Niger" => "Niger",
								"Nigeria" => "Nigeria",
								"Niue" => "Niue",
								"Norfolk Island" => "Norfolk Island",
								"North Korea" => "North Korea",
								"North Vietnam" => "North Vietnam",
								"Northern Mariana Islands" => "Northern Mariana Islands",
								"Norway" => "Norway",
								"Oman" => "Oman",
								"Outlying Oceania" => "Outlying Oceania",
								"Pacific Islands Trust Territory" => "Pacific Islands Trust Territory",
								"Pakistan" => "Pakistan",
								"Palau" => "Palau",
								"Palestinian Territory" => "Palestinian Territory",
								"Panama" => "Panama",
								"Panama Canal Zone" => "Panama Canal Zone",
								"Papua New Guinea" => "Papua New Guinea",
								"Paraguay" => "Paraguay",
								"People's Democratic Republic of Yemen" => "People's Democratic Republic of Yemen",
								"Peru" => "Peru",
								"Philippines" => "Philippines",
								"Pitcairn" => "Pitcairn",
								"Poland" => "Poland",
								"Portugal" => "Portugal",
								"Puerto Rico" => "Puerto Rico",
								"Qatar" => "Qatar",
								"Reunion" => "Reunion",
								"Romania" => "Romania",
								"Russia" => "Russia",
								"Rwanda" => "Rwanda",
								"Saint Helena" => "Saint Helena",
								"Saint Kitts and Nevis" => "Saint Kitts and Nevis",
								"Saint Lucia" => "Saint Lucia",
								"Saint Pierre and Miquelon" => "Saint Pierre and Miquelon",
								"Saint Vincent and the Grenadines" => "Saint Vincent and the Grenadines",
								"Samoa" => "Samoa",
								"San Marino" => "San Marino",
								"Sao Tome and Principe" => "Sao Tome and Principe",
								"Saudi Arabia" => "Saudi Arabia",
								"Senegal" => "Senegal",
								"Serbia And Montenegro" => "Serbia And Montenegro",
								"Seychelles" => "Seychelles",
								"Sierra Leone" => "Sierra Leone",
								"Singapore" => "Singapore",
								"Slovakia" => "Slovakia",
								"Slovenia" => "Slovenia",
								"Solomon Islands" => "Solomon Islands",
								"Somalia" => "Somalia",
								"South Africa" => "South Africa",
								"South Georgia and the South Sandwich Islands" => "South Georgia and the South Sandwich Islands",
								"South Korea" => "South Korea",
								"Spain" => "Spain",
								"Sri Lanka" => "Sri Lanka",
								"Sudan" => "Sudan",
								"Suriname" => "Suriname",
								"Svalbard and Jan Mayen" => "Svalbard and Jan Mayen",
								"Swaziland" => "Swaziland",
								"Sweden" => "Sweden",
								"Switzerland" => "Switzerland",
								"Syria" => "Syria",
								"Taiwan" => "Taiwan",
								"Tajikistan" => "Tajikistan",
								"Tanzania" => "Tanzania",
								"Thailand" => "Thailand",
								"Togo" => "Togo",
								"Tokelau" => "Tokelau",
								"Tonga" => "Tonga",
								"Trinidad and Tobago" => "Trinidad and Tobago",
								"Tunisia" => "Tunisia",
								"Turkey" => "Turkey",
								"Turkmenistan" => "Turkmenistan",
								"Turks and Caicos Islands" => "Turks and Caicos Islands",
								"Tuvalu" => "Tuvalu",
								"U.S. Miscellaneous Pacific Islands" => "U.S. Miscellaneous Pacific Islands",
								"U.S. Virgin Islands" => "U.S. Virgin Islands",
								"Uganda" => "Uganda",
								"Ukraine" => "Ukraine",
								"United Arab Emirates" => "United Arab Emirates",
								"United States Minor Outlying Islands" => "United States Minor Outlying Islands",
								"United Kingdom" => "United Kingdom",
								"United States" => "United States",
								"Uruguay" => "Uruguay",
								"Uzbekistan" => "Uzbekistan",
								"Vanuatu" => "Vanuatu",
								"Vatican" => "Vatican",
								"Venezuela" => "Venezuela",
								"Vietnam" => "Vietnam",
								"Wake Island" => "Wake Island",
								"Wallis and Futuna" => "Wallis and Futuna",
								"Western Sahara" => "Western Sahara",
								"Yemen" => "Yemen",
								"Zambia" => "Zambia",
								"Zimbabwe" => "Zimbabwe"
							);

	static $languageList = array(
	
								"Chinese, Mandarin" => "Chinese, Mandarin",
								"English" => "English",
								"Spanish" => "Spanish",
								"Arabic" => "Arabic",
								"Bengali" => "Bengali",
								"Hindi" => "Hindi",
								"Russian" => "Russian",
								"Portuguese" => "Portuguese",
								"Japanese" => "Japanese",
								"German" => "German",
								"Chinese, Wu" => "Chinese, Wu",
								"Javanese" => "Javanese",
								"Korean" => "Korean",
								"French" => "French",
								"Turkish" => "Turkish",
								"Vietnamese" => "Vietnamese",
								"Telugu" => "Telugu",
								"Chinese, Yue(Cantonese)" => "Chinese, Yue(Cantonese)",
								"Marathi" => "Marathi",
								"Tamil" => "Tamil",
								"Italian" => "Italian",
								"Urdu" => "Urdu",
								"Chinese, Min Nan" => "Chinese, Min Nan",
								"Chinese, Jinyu" => "Chinese, Jinyu",
								"Gujarati" => "Gujarati",
								"Polish" => "Polish",
								"Ukrainian" => "Ukrainian",
								"Persian" => "Persian",
								"Chinese, Xiang" => "Chinese, Xiang",
								"Malayalam" => "Malayalam",
								"Chinese, Hakka" => "Chinese, Hakka",
								"Kannada" => "Kannada",
								"Oriya" => "Oriya",
								"Panjabi, Eastern" => "Panjabi, Eastern",
								"Panjabi, Western" => "Panjabi, Western",
								"Sunda" => "Sunda",
								"Romanian" => "Bhojpuri",
								"Bhojpuri" => "Bhojpuri",
								"Maithili" => "Maithili",
								"Hausa" => "Hausa",
								"Burmese" => "Burmese",
								"Serbo-Croatian4" => "Serbo-Croatian4",
								"Chinese, Gan" => "Chinese, Gan",
								"Awadhi" => "Awadhi",
								"Thai" => "Thai",
								"Dutch" => "Dutch",
								"Yoruba" => "Yoruba",
								"Sindhi" => "Sindhi",
								"Azerbaijani, South" => "Azerbaijani, South"	
							 );
							 
	static $languageAbility = array("Strong", "Acceptable", "Poor");						 
	
	static $postions_in_cfcp = array("Goalkeepers", "Fullback", "Center Back", "Center Mid", "Forward", "Winger");							
	
	/* This fucntion will return the Nationality list */
	static function retrieve_nationality_list(){
	
		return self::$nationalityList;
	} 
	/* End of the function */

	/* This fucntion will return the country list */
	static function retrieve_country_list(){
	
		return self::$countryList;
	} 
	/* End of the function */
	
	/* This fucntion will return the language list */
	static function retrieve_language_list(){
	
		return self::$languageList;
	} 
	/* End of the function */

	/* This fucntion will return the allTitles list */
	static function retrieve_language_ability_list(){
	
		return self::$languageAbility;
	} 
	/* End of the function */

	/* This fucntion will return the country list */
	static function retrieve_cfcp_positions(){
	
		return self::$postions_in_cfcp;
	} 
	/* End of the function */	
	
	/**
	 * Returns an array of $_GET and $_POST data
	 * @param array
	*/
	static function parse_param(){

		$params = array();
		if (ini_get('magic_quotes_gpc') == 1){
			if (!empty($_POST)){	
				$params = (!empty($params)) ? array_merge($params, CommonFunctions::stripslashes_deep($_POST)) : null;
			}else{	
				$params = (!empty($params)) ? array_merge($params, $_POST) : null;				
			}
		}
		if (ini_get('magic_quotes_gpc') == 1){
			if (!empty($_GET)){
				$params = (!empty($params)) ? array_merge($params, CommonFunctions::stripslashes_deep($_GET)) : null;
			}else{	
				$params = (!empty($params)) ? array_merge($params, $_GET) : null;
			}
		}
		return $params;
	}

	/**
	 * Strips out escape charactors
	 * @param $value
	 * @Return $value
	*/
	static function stripslashes_deep($value){

		return is_array($value) ? array_map("CommonFunctions::stripslashes_deep", $value) : stripslashes($value);
	}
	
	/* This function will return a html content for print as a drop down select menu for date functionalities */
	static function print_date_selecting_drop_down($selecteGroupName, $selectedD, $selectedM, $selectedY, $submitStatus, $date_input_error, $curr_url, $required_status, $spec_requirement=""){

		$htmlDropDown = "";
		if (($submitStatus) && ($required_status)){
			$classD = (($selectedD == '') || ($date_input_error == true)) ? "errorsIndicatedFields smallDropDownMenuWrapDiv" : "smallDropDownMenuWrapDiv";		
			$classM = (($selectedM == '') || ($date_input_error == true)) ? "errorsIndicatedFields smallDropDownMenuWrapDiv" : "smallDropDownMenuWrapDiv";		
			$classY = (($selectedY == '') || ($date_input_error == true)) ? "errorsIndicatedFields smallDropDownMenuWrapDiv" : "smallDropDownMenuWrapDiv";						
		}elseif (($submitStatus) && (!$required_status)){
			$classD = ($date_input_error == true) ? "errorsIndicatedFields smallDropDownMenuWrapDiv" : "smallDropDownMenuWrapDiv";		
			$classM = ($date_input_error == true) ? "errorsIndicatedFields smallDropDownMenuWrapDiv" : "smallDropDownMenuWrapDiv";		
			$classY = ($date_input_error == true) ? "errorsIndicatedFields smallDropDownMenuWrapDiv" : "smallDropDownMenuWrapDiv";						
		}else{
			$classD = $classM = $classY = "smallDropDownMenuWrapDiv";		
		}	
		
		$htmlDropDown .= "<div class='smallDropDownMenuMainWrapDiv'>";				
			// Date Drop Down
			$htmlDropDown .= "<div class='{$classD}'>";
			$htmlDropDown .= "<select name='".$selecteGroupName."[day]' class='smallDropDownMenu dd'>";
			$htmlDropDown .= "<option value=''>dd&nbsp;</option>";			
			for($i=1; $i<= 31; $i++){
				$val = str_pad($i, 2, "0", STR_PAD_LEFT);
				$selected = ($selectedD == $i) ? "selected = 'selected'" : ""; 
				$htmlDropDown .= "<option value='{$i}' {$selected}>{$val}</option>";
			}
			$htmlDropDown .= "</select>";
			$htmlDropDown .= "</div>";		
				
			// Month Drop Down
			$htmlDropDown .= "<div class='{$classM}'>";
			$htmlDropDown .= "<select name='".$selecteGroupName."[month]' class='smallDropDownMenu mm'>";
			$htmlDropDown .= "<option value=''>&nbsp;&nbsp;&nbsp;mmmm</option>";			
			for ($i = 1; $i <= 12; $i++){
				/*** get the month ***/
				$mon = date("F", mktime(0, 0, 0, $i+1, 0, 0, 0));
				$selected = ($selectedM == $i) ? "selected = 'selected'" : ""; 			
				$htmlDropDown .= "<option value='{$i}' {$selected}>{$mon}</option>";
			}
			$htmlDropDown .= "</select>";
			$htmlDropDown .= "</div>";				
			
			// Year Drop Down
			$htmlDropDown .= "<div class='{$classY}'>";
			$htmlDropDown .= "<select name='".$selecteGroupName."[year]' class='smallDropDownMenu yy'>";
			$htmlDropDown .= "<option value=''>&nbsp;yyyy</option>";
			if ($spec_requirement == "new"){
				for ($i = date("Y"); $i <= date("Y")+100; $i++){
					$selected = ($selectedY == $i) ? "selected = 'selected'" : ""; 					
					$htmlDropDown .= "<option value='{$i}' {$selected}>{$i}</option>";
				}
			}elseif ($spec_requirement == "both"){
				for ($i = date("Y")-50; $i <= date("Y")+50; $i++){
					$selected = ($selectedY == $i) ? "selected = 'selected'" : ""; 					
					$htmlDropDown .= "<option value='{$i}' {$selected}>{$i}</option>";
				}
			}else{
				for ($i = date("Y"); $i >= date("Y")-75; $i--){
					$selected = ($selectedY == $i) ? "selected = 'selected'" : ""; 					
					$htmlDropDown .= "<option value='{$i}' {$selected}>{$i}</option>";
				}
			}	
			$htmlDropDown .= "</select>";
		$htmlDropDown .= "</div>";								
					
		return $htmlDropDown;
	}	
	/* End of the function */
	
	/* This fucntion will check the given number is odd or even */	
	static function checkNum($num){
	 	return ($num % 2) ? true : false;
	}	
	/* End of the fucntion */
	
	/* This function will prepare the value entered by the user to put it in to the database */
	static function mysql_preperation($value){		
	
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists("mysql_real_escape_string"); // i.e. PHP >= v4.3.0
		if ($new_enough_php){ // PHP v4.3.0 or higher
				// undo any magic quote effects so mysql_real_escape_string can do the work
			if ($magic_quotes_active){ 
				$value = stripslashes($value); 
			}
				$value = mysql_real_escape_string($value);
		}else{ // before PHP v4.3.0
				// if magic quotes aren't already on then add slashes manually
			if (!$magic_quotes_active){ 
				$value = addslashes( $value ); 
			}
				// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}
	/* End of the function */
	
	/* This fucntion will check a given date is greater than the another given date */
	static function check_date_greater_than_another($start_date, $end_date){
	
		return (strtotime($start_date) > strtotime($end_date)) ? true : false;
	}
	/* End of the function */
	
	/** 
	 * The letter l (lowercase L) and the number 1 
	 * have been removed, as they can be mistaken 
	 * for each other. 
	 */ 	
	static function createRandomPassword(){ 
	
		$chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
		srand((double)microtime()*1000000); 
		$i = 0; 
		$pass = '' ;
		
		while ($i <= 7){ 
			$num = rand() % 33; 
			$tmp = substr($chars, $num, 1); 
			$pass = $pass . $tmp; 
			$i++; 
		} 
		return $pass; 
	} 
	
	/* This function will validate the email */
	static function check_email_address($email) {
	  // First, we check that there's one @ symbol, 
	  // and that the lengths are right.
	  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
		// Email invalid because wrong number of characters 
		// in one section or wrong number of @ symbols.
		return false;
	  }
	  // Split it into sections to make life easier
	  $email_array = explode("@", $email);
	  $local_array = explode(".", $email_array[0]);
	  for ($i = 0; $i < sizeof($local_array); $i++){
		
		if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&?'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])){
			  return false;
			}
		 }
	  // Check if domain is IP. If not, 
	  // it should be valid domain name
	  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])){
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2){
			return false; // Not enough parts to domain
		}
		for ($i = 0; $i < sizeof($domain_array); $i++){
		  if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])| ?([A-Za-z0-9]+))$", $domain_array[$i])){
			return false;
		  }
		}
	  }
	  return true;
	}
}
?>