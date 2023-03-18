<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
</head>
<body>
    <form action = "test.php" method = "post"><!--form is a special html element that allows the user to input info. 
Passes the info to the php files, form acts as the middle man passing info from html to php. The action determines 
that test.php handles what happens with the form. The method tells the form what we are doing with it. -->
<!--Password: <input type = "password" name="password"> <br> will allow the user to input info to pass to php, type=text will give us a textbox , name describe what content your getting-->
<!--Apples:<input type= "checkbox" name ="fruits[]" value ="apples" > <br> when we use checkboxes store them in an array, value is the value that the checkbox will be associated with -->
<!--Oranges:<input type= "checkbox" name ="fruits[]" value ="oranges" > <br> -->
<!--Pears:<input type= "checkbox" name ="fruits[]" value ="pears" > <br>  -->
<!--<input type="text" name="student"> -->
<!--<input type="submit"> will create a submit button to submit all the info--> 
    <!-- What was your grade?
    <input type="text" name="grade">
    <input type="submit"> -->
    </form>

<?php 
class Movie{
    public $title; //keyword that tells  php what code is used to access this code in the program. public tells that this attribute is visible across the program. var does the same thing
    private $rating; // this keyword tells that any code outside of this class isn't gonna access the this attribute directly    

function __construct($title, $rating){
    $this->title = $title;
    $this->setRating($rating);
}
function getRating(){
    return $this->rating;
}

function setRating($rating){ 
    if ($rating == "G" || $rating == "PG") {
        $this->rating = $rating;
    }else{
        $this->rating = "NR";
    }
}

}

$avengers = new Movie("Avengers", "PG-13");

$avengers->setRating("G");

echo $avengers->getRating();
?>

    <?php 
    // class Student{
    //     var $name;
    //     var $major;
    //     var $gpa;

    // function __construct($name, $major, $gpa)
    // {
    //     $this->name = $name;
    //     $this->major = $major;
    //     $this->gpa = $gpa;
    // }
    // function hasHonors(){
    //     if ($this->gpa >= 3.5) {
    //         return "true";
    //     }
    //     return "false";
    // }

    // }
    // $student1 = new student("Jim", "Business", 2.8);
    // $student2 = new student("Pam", "Art", 3.6);
    // echo $student2->hasHonors();
    ?>
    <?php
    // class Book{ //creating a Book class. 
    //     var $title; // attributes of the Book class. 
    //     var $author;
    //     var $pages;

    //     function __construct($aTitle, $aAuthor, $aPages){// a special function inside a class, which will be called once we create an object of that class
    //         $this->title = $aTitle; //the this keyword refers to the current object thats being created. this title is = to the title that got passed in
    //         $this->author = $aAuthor;
    //         $this->pages = $aPages;
    //     }
    // }
    // $book1 = new Book("Harry Potter", "JK Rowling", 400);// create a new book data type. This is an object, an object is an instance of a class. new Book calls the constructor function
    // $book1->title = "Harry Potter";// assigning the attributes in the Book class
    // $book1->author = "JK Rowling";
    // $book1->pages = 400;
    // echo $book1->author;// printing the attributes

    // $book2 = new Book("Lord of the Rings", "Tolkien", 700);// create a new book data type. This is an object, an object is an instance of a class. new Book calls the constructor function
    // $book2->title = "Lord of the Rings";// assigning the attributes in the Book class
    // $book2->author = "Tolkien";
    // $book2->pages = 700;
    // echo $book2->author;// printing the attributes
    // echo $book1->title;
    ?>
    
    <?php
    //include "header.html" //includes a separate file into the php 
    // $index = 1;
    // do{
    //     echo "$index <br>";
    //     $index++;
    // }while($index <= 5);
    // $luckyNumbers = array(4,8,14,16,23,42);
    // for($i = 0; $i < count($luckyNumbers); $i++){
    //     echo "$luckyNumbers[$i] <br>";
    // }
    // $grade = $_POST["grade"];
    // switch($grade){
    //     case "A":
    //         echo "You did amazing";
    //         break;
    //     case "B":
    //         echo "You did pretty good";
    //         break;
    //     case "C":
    //         echo "You did alright";
    //         break;
    //     case "D":
    //         echo "You did poorly";
    //         break;
    //     case "F":
    //         echo "YOU FAIL";
    //         break;
    //     default:
    //     echo "Invalid Grade";
    // }
    // function getMax($num1, $num2, $num3){
    //     if($num1 >= $num2 && $num1 >= $num3){
    //         return $num1;
    //     }else if($num2 >= $num1 && $num2 >= $num3){
    //             return $num2;
    //         }else {
    //             return $num3;
    //         }
    // }
    //     echo getMax(3000,900,3000);
    // $isTall = true;
    // $isMale = false;
    // if($isMale || $isTall){
    //     echo "You are a tall Male";
    // }else if($isMale && !$isTall){
    //     echo "You are a short Male";
    // }else if(!$isMale && $isTall){
    //     echo "You are not Male but are tall";
    // }
    // else{
    //     echo "You are not a tall Male and not Tall";
    // }

    /*
    function cube($num){
        echo "Hello";// will print this out since it came before return
        return $num * $num * $num; // the return keyword RETURNS the value back to the caller, 
        echo "Hello"; //php will break out of the function once it comes across return, will never print Hello
    }*/
    //cube(4); // will give us the four cubed which is 64.

    /*function sayHi($name){ // small program to do a certain task
        echo "Hello $name";
    }
    sayHi("Avontae"); // call the function with a parameter*/
    //$grades = array("Jim"=>"A+", "Pam"=>"B-", "Oscar"=>"C+"); // associative arrays store key value pairs, the key need to be uniquely named, the values can be the same
    //echo $grades[$_POST["student"]]; // grabbing the value the user entered, then accessing that element in the associative array
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