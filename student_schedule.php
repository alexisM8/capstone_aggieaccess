<!DOCTYPE html>
<html>
<style>
     .nav{
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333333;
        }

        li {
            float: left;
        }

        li a, .drop_button {
            display: inline-block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        li a:hover, .dropdown:hover .drop_button {
            background-color: green;
        }

        li.dropdown {
            display: inline-block;
        }

        .drop_content {
            display: none;
            position: absolute;
            background-color: #f2f2f2;
        }

        .drop_content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .drop_content a:hover {
            color: white;
            background-color: #4CAF50;
        }

        .dropdown:hover .drop_content {
            display: block;
        }
    .info{
        list-style-type: none;
        margin: 0;
        padding: 0;
        padding-top: 30px;
        padding-bottom: 5px;
        float: left;
    }

    table {
    border:2px solid black;
    border-collapse: collapse;
    }

    th, td{
        border-bottom: 1px solid #dddddd;
        text-align: left;
    }

    tr:nth-child(odd){
        background-color: #f2f2f2;
    }
    
    tr:nth-child(even) {
        background-color: #d6eeee;
    }   

    .print_btn{
        margin-top: 10px;
        float: right;
    }
</style>

<script>
function removeRow(btn) {
  var row = btn.parentNode.parentNode;
  var confirmRemove = confirm("Are you sure you want to remove this course?");
  if (confirmRemove) {
    row.parentNode.removeChild(row);
  }
}

</script>

    <head>
    </head>
    <body>
        <h1> View Schedule</h1>
        <div>
            <ul class="nav">

                <li>
                    <a href="student_home.php">Home</a>
                </li>
    
                <li class="dropdown">
                    <a href="#" class="drop_button">My Info</a>

                    <div class="drop_content">
                        <a href="student_schedule.php">View Schedule</a> 
                        <a href="#">Add Classes</a>     
                    </div> 
                </li>

                <li class="dropdown">        
                    <a href="#" class="drop_button">Contact Advisor</a>

                </li>
            </ul>
        </div>

        <div>
            <ul class="info">
                <li>Name: </li></br>
                <li>Classification: </li></br>
                <li>Major: </li></br>
            </ul>
        </div>

        <table style="width:100%">
    <tr>
        <th></th>
        <th>CRN</th>
        <th>Course</th>
        <th>Title</th>
        <th>Time</th>
        <th>Days</th>
        <th>Location</th>
        <th>Instructor</th>
    </tr>
    <tr>
        <td><button onclick="removeRow(this)">Remove</button></td>
        <td>Test1</td>
        <td>Test1</td>
        <td>Test1</td>
        <td>Test1</td>
        <td>Test1</td>
        <td>Test1</td>
        <td>Test1</td>
        
    </tr>
    <tr>
        <td><button onclick="removeRow(this)">Remove</button></td>
        <td>Test2</td>
        <td>Test2</td>
        <td>Test2</td>
        <td>Test2</td>
        <td>Test2</td>
        <td>Test2</td>
        <td>Test2</td>
        
    </tr>
    <tr>
        <td><button onclick="removeRow(this)">Remove</button></td>
        <td>Test3</td>
        <td>Test3</td>
        <td>Test3</td>
        <td>Test3</td>
        <td>Test3</td>
        <td>Test3</td>
        <td>Test3</td>
        
    </tr>
    </table>

        <button class="print_btn">Print Schedule</button>
    </body>
    </html>
