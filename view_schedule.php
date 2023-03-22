<!DOCTYPE html>
<html>
<style>
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



    <head>
        <link rel="stylesheet" href="nav_style.css"/>
        <script type="text/javascript" src="remove_button.js"></script>
        <title>View Schedule</title>
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
                        <a href="view_schedule.php">View Schedule</a> 
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

        <button class="print_btn" onclick="window.print()">Print Schedule</button>
    </body>
    </html>
