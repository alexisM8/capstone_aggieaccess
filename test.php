<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
</head>
<body>
    <form action = "test.php" method = "post"><!--form is a special html element that allows the user to input info 
passes the info to the php programs, form acts as the middle man passing info from html to php. The action determines 
that test.php handles what happens with the form. The method tells the form what we are doing with it. -->
<!--Password: <input type = "password" name="password"> <br> will allow the user to input info to pass to php, type=text will give us a textbox , name describe what
content your getting-->
<!--Apples:<input type= "checkbox" name ="fruits[]" value ="apples" > <br> when we use checkboxes store them in an array, value is the value that the checkbox will be associated with -->
<!--Oranges:<input type= "checkbox" name ="fruits[]" value ="oranges" > <br> -->
<!--Pears:<input type= "checkbox" name ="fruits[]" value ="pears" > <br>  -->
<input type="submit"> <!--will submit all the info--> 
    </form>

    <?php
    //$fruits = $_POST["fruits"]; // storing all the fruits that the user check and submitted
    //echo $fruits[1];// what the first fruit that was checked is
    //$friends = array("Kevin","Karen","Oscar","Jim"); // declaring an array, store multiple pieces of data
    //echo count($friends); // counts how many elements are in the array
    //echo $_POST["password"]; // will do the same thing as get but it is more secure, will not show info in url
    //echo $_GET["name"];//gets the entered name from the form, displays the entered name, the parameters have to match in the form
    //$num = 10; // can store integer values
    //echo floor(3.3); // no matter what it will round the number down
    //echo ceil(3.3); // no matter what it will round the number up
    //echo round(3.7); // will round up or down depending on the number behind the decimal point
    //echo min(2, 10); // tells us which number is the smallest
    //echo max(2, 10); // tells us which of the two numbers is bigger
    //echo sqrt (144); // gives us twelve back
    //echo pow(2,4); // gives us two raised to the fourth power as an answer
    //echo abs(-100);// gives back the absolute value of one-hundred
    //$num += 25; // adds twenty-five to number. other shorthand assignment operators: -=, /=, *= 
    //$num--; //adds or subtracts one to the number 
    //echo $num; // print the integer values
    //echo (4 + 5) * 10;// php performs order of operations, will do the arithmetic by precedence.
    //echo 5 + 9; // will echo out the answer of five plus nine. php does the arithmetic for the user.
    //echo -40.484; // in php you can type out the number, no use of quotation marks at all
    //$phrase = "Giraffe Academy";
    //echo substr($phrase, 8, 3); takes three parameters. the string and the index number.prints the chosen substring.The last parameter dictates how many characters you want to grab.
    //echo str_replace("ffe", "Panda", $phrase); // replaces a word in a string with another word. takes three parameters.
    //$phrase[0] = "B"; // can modify the individual characters in the string 
    //echo $phrase[0]; // prints out the index in the string of characters 
    // $string = "To be or not to be";
    // $age = 30; // integer
    // $gpa = 30.2; // float or double
    // $bool = true; // boolean
    // null; // no value
    // $name = "Tom"; // creates a variable, the data type is based off its value, can store different values
    // $age = 80;
    // echo "<h1>Avontae's site </h1>"; /*print statement, can write any html code and it can run in browser 
    // in php tags*/ 
    // echo "<hr>";
    // echo "There once was a man named $name <br> "; // insert the value inside the print statement
    // echo "He was $age years old <br> ";
    // $name ="Mike "; // updates the name variable, can modify the variables through the program
    // echo "He really liked the name $name <br> ";
    // echo "But he didn't like being $age <br> ";
    ?>

</body>
</html>