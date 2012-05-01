<?php
require_once "db_login.php";
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
mysql_select_db($db_database, $db_server); 

$query = "CREATE TABLE `Album` (`ID` INT NOT NULL, 
								`Name` VARCHAR(100) NOT NULL,
								`ArtistID` INT NOT NULL,
								PRIMARY KEY(`ID`)
								) ENGINE = MYISAM";
								
$result = mysql_query($query) or die(mysql_error());

$query = "CREATE TABLE `Artist` (`ID` INT NOT NULL,
								 `Name` VARCHAR(50) NOT NULL,
								 `Bio` TEXT NOT NULL,
								 `Image` VARCHAR(300) NOT NULL,
								 PRIMARY KEY(`ID`)
								) ENGINE = MYISAM";

$result = mysql_query($query) or die(mysql_error());

$query = "CREATE TABLE `Ratings` (`StanzaID` INT NOT NULL,
								  `WordID` INT NOT NULL,
								  `UserID` INT NOT NULL,
								  PRIMARY KEY (`StanzaID`, `WordID`, `UserID`)
								 ) ENGINE = MYISAM";

$result = mysql_query($query) or die(mysql_error());

$query = "CREATE TABLE `Tags`  (`WordID` INT NOT NULL,
								`Word` VARCHAR(20) NOT NULL,
								PRIMARY KEY(`WordID`)
								) ENGINE = MYISAM";
				
$result = mysql_query($query) or die(mysql_error());

$query = "CREATE TABLE `Profile` (`ID` INT NOT NULL,
								  `Username` VARCHAR(32) NOT NULL,
								  `Password` VARCHAR(128) NOT NULL,
								  `Email` VARCHAR(100) NOT NULL,
								  PRIMARY KEY(`ID`)
								  ) ENGINE = MYISAM";

$result = mysql_query($query) or die(mysql_error());

$query = "CREATE TABLE `PotBuddies` (`UserID1` INT NOT NULL,
									 `UserID2` INT NOT NULL,
									 PRIMARY KEY(`UserID1`, `UserID2`)
									 ) ENGINE = MYISAM";

$result = mysql_query($query) or die(mysql_error());

$query = "CREATE TABLE `Stanza` (`StanzaID` INT NOT NULL,
								 `Text` TEXT NOT NULL,
								 PRIMARY KEY(`StanzaID`)
								 ) ENGINE = MYISAM";

$result = mysql_query($query) or die(mysql_error());

$query = "CREATE TABLE `Log` (`UserID` INT NOT NULL,
							  `TimeOfAction` TImeSTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
							  `Action` VARCHAR(255) NOT NULL,
							  PRIMARY KEY(`UserID`, `TimeOfAction`)
							  ) ENGINE = MYISAM";

$result = mysql_query($query) or die(mysql_error());

$query = "CREATE TABLE `Songs` (`ID` INT NOT NULL,
								`AlbumID` INT NOT NULL,
								`SongName` VARCHAR(63) NOT NULL,
								PRIMARY KEY(`ID`)
								) ENGINE = MYISAM";

$result = mysql_query($query) or die(mysql_error());

$query = "CREATE TABLE `AlbumHasSong` (`AlbumID` INT NOT NULL,
									   `SongID` INT NOT NULL,
									   PRIMARY KEY(`AlbumID`, `SongID`)
									   ) ENGINE = MYISAM";

$result = mysql_query($query) or die(mysql_error());

$query = "CREATE TABLE `SongHasRating` (`SongID` INT NOT NULL,
										`StanzaID` INT NOT NULL,
										`WordID` INT NOT NULL,
										PRIMARY KEY(`SongID`, `StanzaID`, `WordID`)
										) ENGINE = MYISAM";

$result = mysql_query($query) or die(mysql_error());

$query = "CREATE TABLE `SongArtist` (`SongID` INT NOT NULL,
									 `ArtistID` INT NOT NULL,
									 PRIMARY KEY(`SongID`, `ArtistID`)
									 ) ENGINE = MYISAM";
									 
$result = mysql_query($query) or die(mysql_error());



mysql_close($db_server);
?>











