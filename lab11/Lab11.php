<?php
//Fill this place
  $db = new Mysqli("localhost","root","ijyt0809","travel");
  if($db->errno){
    die("connection failed");
  }
  // connect mysql
  if($_GET["continent"] !== "0" && $_GET["country"] !== "0"){
    $continentCode = $_GET["continent"];
    $countryISO = $_GET["country"];
    $cities = filterByContinentAndCountry($db,$continentCode,$countryISO);
  }
  else if($_GET["country"] !== "0"){
    $countryISO = $_GET["country"];
    $cities = filterByCountry($db,$countryISO);
  }
  else if($_GET["continent"] !== "0"){
    $continentCode = $_GET["continent"];
    $cities = filterByContinent($db,$continentCode);
  }
  else{
    $cities = getAllCities($db);
  }
  $continents = getData($db,"continents");
  $countries = getData($db,"countries");

  function getData($db,$tableName){
    $sql = "SELECT * FROM $tableName";
    $result = $db->query($sql);
    return $result;
  }
  function getAllCities($db){
    $sql = "SELECT * FROM ImageDetails";
    $result = $db->query($sql);
    return $result;
  }
  function filterByContinent($db,$continentCode){
    $sql = "SELECT * FROM ImageDetails WHERE ContinentCode = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s",$continentCode);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
  }
  function filterByCountry($db,$countryISO){
    $sql = "SELECT * FROM ImageDetails WHERE CountryCodeISO = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s",$countryISO);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
  }
  function filterByContinentAndCountry($db,$continentCode,$countryISO){
    $sql = "SELECT * FROM ImageDetails WHERE ContinentCode = ? AND CountryCodeISO = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ss",$continentCode,$countryISO);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
  }
//****** Hint ******
//connect database and fetch data here
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Lab11</title>

      <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    
    

    <link rel="stylesheet" href="css/captions.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.css" />    

</head>

<body>
    <?php include 'header.inc.php'; ?>
    


    <!-- Page Content -->
    <main class="container">
        <div class="panel panel-default">
          <div class="panel-heading">Filters</div>
          <div class="panel-body">
            <form action="Lab11.php" method="get" class="form-horizontal">
              <div class="form-inline">
              <select name="continent" class="form-control">
                <option value="0">Select Continent</option>
                <?php
                //Fill this place
                
                //****** Hint ******
                //display the list of continents

                while($row = $continents->fetch_assoc()) {
                  echo '<option value=' . $row['ContinentCode'] . '>' . $row['ContinentName'] . '</option>';
                }
                ?>
              </select>     
              
              <select name="country" class="form-control">
                <option value="0">Select Country</option>
                <?php 
                //Fill this place

                //****** Hint ******
                /* display list of countries */ 
                while($row = $countries->fetch_assoc()) {
                  echo '<option value=' . $row['ISO'] . '>' . $row['CountryName'] . '</option>';
                }
                ?>
              </select>    
              <input type="text"  placeholder="Search title" class="form-control" name=title>
              <button type="submit" class="btn btn-primary">Filter</button>
              </div>
            </form>

          </div>
        </div>     
                                    

		<ul class="caption-style-2">
            <?php 
            while($row = $cities->fetch_assoc()){
              echo "<li>";
              echo "<a href='detail.php?id=".$row["ImageID"]."'class=img-responsive>";
              echo "<img src='images/square-medium/".$row["Path"]."'alt=????>";
              echo "<div class=caption>";
              echo "<div class=blur></div>";
              echo "<div class=caption-text>";
              echo "<p>".$row["Title"]."</p>";
              echo "</div>";
              echo "</div>";
              echo "</a>";
              echo "</li>";
            }
            //Fill this place

            //****** Hint ******
            /* use while loop to display images that meet requirements ... sample below ... replace ???? with field data
            <li>
              <a href="detail.php?id=????" class="img-responsive">
                <img src="images/square-medium/????" alt="????">
                <div class="caption">
                  <div class="blur"></div>
                  <div class="caption-text">
                    <p>????</p>
                  </div>
                </div>
              </a>
            </li>        
            */ 
            ?>
       </ul>       

      
    </main>
    
    <footer>
        <div class="container-fluid">
                    <div class="row final">
                <p>Copyright &copy; 2017 Creative Commons ShareAlike</p>
                <p><a href="#">Home</a> / <a href="#">About</a> / <a href="#">Contact</a> / <a href="#">Browse</a></p>
            </div>            
        </div>
        

    </footer>


        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>