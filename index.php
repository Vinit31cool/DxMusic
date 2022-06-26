<?php
//Connecting to the database
$insert = false;
$server = "localhost";
$usrname = "root";
$password = "";
$database = "DxM";

//Creating a connection

$conn = mysqli_connect($server, $usrname, $password, $database);

if(!$conn){
  die("Sorry connection failed: ".mysqli_connect_error());
}




if($_SERVER['REQUEST_METHOD']=='POST'){
  $name = $_POST["name"];
  $rating = $_POST["rate"];
  $Cover = $_POST["file"];
  $Date = $_POST["dor"];
  $artist = $_POST["Artist"];

  $sql = "INSERT INTO `tsongs` ( `Cover Photo`, `Name`, `Date of release`, `Avg_rating`, `Artists`) VALUES ( '$Cover', '$name', '$Date', '$rating','$artist');";
  $result = mysqli_query($conn, $sql);

  if($result){
   $insert = true;
  }
  else{
    echo "Failed to insert, error -- > ".mysqli_error($conn);
  }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <title>DxMusic</title>


  </head>
  <body>



    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" >
        <a class="navbar-brand" href="#">DxMusic</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Contact Us</a>
              </li>
            
          </ul>
        
        </div>
      </nav>
<?php
if($insert){
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success !</strong> Song has been inserted successfully !
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
}
?>
    <!--edit modal -->
<button type="button" class="btn btn-primary" style="  position: absolute; left: 1200px; top: 100px; text-align:center;" data-toggle="modal" data-target="#editmodal">
  Add Song
</button>
<br><br>
<!-- Modal -->
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="editmodalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editmodalLabel">Add Song</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="/CRUD/index.php" method="post">
            <div class="form-group">
              <label for="name">Song Name</label>
              <input type="text" class="form-control" id="name" name = "name" aria-describedby="emailHelp">
            </div>
          <br>
          <div class ="form-group">
              Date Of release :
              <input type="date" id="dor"  name = "dor" >
              </div>
             <br>

            <div class="form-group">
              <label for="Artist">Artist</label>
              <input type="text" class="form-control" id="Artist" name = "Artist" aria-describedby="emailHelp">
            </div>
             
            Select image to upload:
            <br>
            <input type="file" name="file" id="file">
           <br><br><br>

            <div class="form-group">
              <label for="rate">Please Rate</label>
              <input type="number" id = "rate" name = "rate">
            </div>



            <button type="submit" class="btn btn-primary">Add Song</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<br><br><br><br><br><br>

<h1 style= "position: absolute; left: 200px; top: 100px;">Top 10 Songs</h1>

<div class="container">
<table class="table">
  <thead>
    <tr>
      <th scope="col">Ranking</th>
      <th scope="col">Cover</th>
      <th scope="col">Name</th>
      <th scope="col">Date of release</th>
      <th scope="col">Average rating</th>
      <th scope="col">Artists</th>
     
      
    </tr>
  </thead>
  <tbody>
  <?php
 $sql = 'SELECT * FROM tsongs  ORDER BY Avg_rating ASC';
 $result = mysqli_query($conn,$sql);
$sno = 0;
  while ($row = mysqli_fetch_assoc($result)) {
   $sno++;
    echo "<tr>
   <th scope='row'>".$sno. "</th>
   <th scope='row'>".'<img src="data:image/jpeg;base64,'.base64_encode( $row['Cover Photo'] ).'"/>'."</th>
   <td>".$row['Name']."</td>
   <td>".$row['Date of release']."</td>
   <td>".$row['Avg_rating']."</td>
   <td>".$row['Artists']."</td>
   </tr>";

   
  }
  ?>
  </tbody>
</table>

<hr><br><br>


    

<br><br>
<div class="container">
 
<!-- Button trigger modal -->
<button typse="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
 Add an artist
</button>
<br>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle"> Add an artist</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        

      <form action="/CRUD/index.php" method="post">
            <div class="form-group">
              <label for="aname">Artist Name</label>
              <input type="text" class="form-control" id="aname" name = "aname" aria-describedby="emailHelp">
            </div>
          <br>
          <div class ="form-group">
              Date Of birth :
              <input type="date" id="adob"  name = "adob" >
              </div>
             <br>

            <div class="form-group">
              <label for="Songs">Songs</label>
              <input type="text" class="form-control" id="Songs" name = "Songs" aria-describedby="emailHelp">
            </div>
           

            <button type="submit" class="btn btn-primary">Add Song</button>
          </form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>

<h1 style= "position: absolute; left: 200px; top: 2850px;">Top 10 Artists</h1>
<br>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Ranking</th>
      <th scope="col">Name</th>
      <th scope="col">Songs</th>
     
      
    </tr>
  </thead>
  <tbody>
  <?php
 $sql = 'SELECT * FROM tsongs  ORDER BY Avg_rating ASC';
 $result = mysqli_query($conn,$sql);
$sno = 0;
  while ($row = mysqli_fetch_assoc($result)) {
   $sno++;
    echo "<tr>
   <th scope='row'>".$sno. "</th>
   <td>".$row['Artists']."</td>
   <td>".$row['Name']."</td>
   </tr>";

   
  }
  ?>
  </tbody>
</table>



  
</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>