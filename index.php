<?php
    //get data from json api
    $file = 'https://jsonplaceholder.typicode.com/posts';
    $data = file_get_contents($file);
    $result = json_decode($data, true);
?>

<?php 
    //connect to database
    $conn = mysqli_connect('localhost', 'daczecha', 'data123', 'json_saved');

    //check connection
    if(!$conn){
        echo 'Connection error' . mysqli_connect_error();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JSON API SAVER</title>
</head>
<body>

    <form action="index.php" method="post">
        <label for="submit">items will be uploaded to mysql only after clicking this button</label>
    <!--
        NOTE: CLICKING IT AGAIN AND AGAIN WILL ADD SAME DATA MULTIPLE TIMES
    -->
      <input type="submit" name='submit'  value="Add"/>
    </form>
</body>
</html>

<?php
    if(isset($_POST['submit'])){
        //add items to database
        foreach($result as $row){
            $title = mysqli_real_escape_string($conn, $row['title']);
            $body = mysqli_real_escape_string($conn, $row['body']);
            $userId = mysqli_real_escape_string($conn, $row['userId']);
        
            $sql = "INSERT INTO posts(title,body,userid) VALUES('$title','$body','$userId')";
        
            if(mysqli_query($conn, $sql)){
                echo 'Success';
            }else{
                echo 'query error: '. mysqli_error($conn);
            }
            header('Location:index.php');
        }
    }
?>