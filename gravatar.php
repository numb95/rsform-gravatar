<?php


$servername = "localhost";//set the Mysql server name
$username = "USERNAME"; //database username
$password = "PASSWORD"; //database password
$db_name= "DATABASE"; //database name
$connection = new mysqli($servername, $username, $password, $db_name); //mysql connection based on object oriented .it's obvious ")
$default_image = "http://wiki.lfkf.org/w/skins/logo.png";// if a username hasn't any username it shows this image :)
$size = 50;//the size of the image



echo '<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donators</title>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <style>
        #image-avatar{
	height:50px;
	width:50px;
        border-radius:10px;
        margin: 5px;
        border: dashed 1px #000;
        -webkit-filter: grayscale(100%) blur(0.75px);
	    filter: grayscale(100%) blur(0.75px);
        }

        #image-avatar:hover{
        -webkit-filter: grayscale(0) blur(0);
	    filter: grayscale(0) blur(0);
	    -webkit-transition: .3s ease-in-out;
	    transition: .3s ease-in-out;

        }
    </style>

</head>
<body>
';//the head section of html and style .using pure.css ( url: purecss.io) to have a good reponsive image :)

    echo '<div id=container>';//the main div that contain the main blocks
    if (!$connection){
        die("connection Lost: " . mysqli_connect_error());//if the connection between database and program lost it shows connection lost :).this if section also check if the connection established or not
    }

    $sql_query = 'select FieldValue from PREFIX_rsform_submission_values where FieldName = "email" AND formid = 5 AND "_STATUS" = 1);'; //the hardest part of the program.thanks to @smmsadrnezh to rewrite my Sql query.it brings the emails of donators with Status of 1 that means their payment is successfull
   //you can also user this query 'select FieldValue from sfd93_rsform_submission_values where FieldName = "email" AND formid = 5 AND SubmissionId IN (select SubmissionId from sfd93_rsform_submission_values where FieldName = "_STATUS" AND FieldValue = 1);'
    $sql_result = $connection->query($sql_query);//set the variable to the query of the database

    if ($sql_result->num_rows > 0)
        while($row = $sql_result->fetch_assoc()) {
            echo '<img class="pure-image" id="image-avatar" src="http://www.gravatar.com/avatar/'.md5(trim(strtolower($row["FieldValue"]))). urlencode( $default_image ) . "&s=" . $size . 'alt=""/>';
        }//according to the gravatar document , the url of the avatars are the md5hashed of the emails
//so i md5 it and trim it to forget the spaces in the start and the end of the line.strtolower is for if the emails entered in Uppercase change it to lower
//other part is obvious and it's easy to read :)



    $connection->close();//close the connection of database



    echo '
        </div>
</body>
</html>' //close the program :)
?>




