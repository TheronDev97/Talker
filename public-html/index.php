<?php
$website='https://zavrel.net/';
?>

<!DOCTYPE html>  
<head>  
 <title>Hello World!</title>
</head>

<body>  
 <h1>Hello World!</h1>
 <a href="<?php echo $website;?>"><?php echo "Zavrel Consulting: $website";?></a>
 <p>
     <?php 
     $name=array('paul','john');
     $name[]='tom';
     
     print_r($name);
     
     ?>
 </p>
 <p><?php echo $name[1] . count($name) . strlen($name[1]);?></p>
 <p>
    <?php 
    $age=[
        "john"=>11,"paul"=>23,"agmed"=>51
    ];
    print_r($age);
    echo "<br>";
    echo $age["john"];
    ?>
</p>
<script>

        var cars=["Mercedes","Volvo","BMW","Tesla"];
        for (i in cars){
            console.log("The current car is "+cars[i]);
        }
</script>
<?php
    $cars=['Mercedes',"Volvo","BMW","Tesla"];
    foreach ($cars as $i){
        echo "The current car is $i<br>";
    }
?>
<p>
    <?php
    Class carBluePrint{
        //properties of class
        //public $colour="blue";
        //public $make="BMW";

        //Constructor
        public function __construct($newColor,$newMake){
            $this->colour=$newColor;
            $this->make=$newMake;
        }

        //methods of class
        //setter method for colour
        public function setColor($color){
            $this->colour=$color;
        }
        //getter method for colour
        public function getColor(){
            return "<br>New Color is: $this->colour<br>";
        }
    }

    $firstRealCar=new carBluePrint("GREEN","VOLVO");
    echo $firstRealCar->getColor() . $firstRealCar->make . "<br>";

    var_dump($firstRealCar);
    echo $firstRealCar->colour;

    $firstRealCar->setColor("BROWN");
    echo $firstRealCar->getColor();

    $secondRealCar=new carBluePrint("BLACK","VOLVO");
    echo $secondRealCar->getColor() . $secondRealCar->make . "<br>";

    $secondRealCar->setColor("PURPLE");
    echo $secondRealCar->getColor();
    var_dump($secondRealCar);
    ?>
</p>

<p>
    <?php
    class sportCarBluePrint extends carBluePrint{
        
        public function __construct($newColor,$newMake,$newSpoiler){
            parent::__construct($newColor,$newMake);
            $this->spoiler=$newSpoiler;
        }

        public function activateSpoiler(){
            return "<br><strong>SPOILER ACTIVE!</strong><br>";
        }
    }

    $firstSportCar=new sportCarBluePrint('magenta','Porsche','tail');
    $firstSportCar->setColor("PINK");
    var_dump($firstSportCar);
    echo $firstSportCar->activateSpoiler();

    ?>
</p>
<p>
    <?php
    function divideOnebyNumber($number){
        if($number==0){
            throw new Exception("Division by Zero is not allowed.");
        }
        return 1/$number;
    }
    try{
        echo "Result of Division: " . divideOnebyNumber(0);
    }
    catch(Exception $e){
        echo 'Message: ' . $e->getMessage();
    }
    ?>
</p>
</body>