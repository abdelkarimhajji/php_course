<?php
    // config
    class Tranche {
        public $borneMin;
        public $borneMax;
        public $tarif;

        function __construct($bmin, $bmax, $tar){
            $this->borneMin = $bmin;
            $this->borneMax = $bmax;
            $this->tarif = $tar;
        }

        function infos(){
            echo "Borne min: $this->borneMin. Borne max: $this->borneMax. Tarif: $this->tarif";
        }
    }
    $tva = 14;
    $timbre = 0.45;
    $redevance= [
        "small" => 22.65,
        "medium" => 37.05,
        "large" => 46.20
    ];
    $traches = [
        "tranche 1",
        "tranche 2",
        "tranche 3",
        "tranche 4",
        "tranche 5",
        "tranche 6"
    ];
    $trachesarab = [
      "الشطر 1",
      "الشطر 2",
      "الشطر 3",
      "الشطر 4",
      "الشطر 5",
      "الشطر 6"
  ];
  
    //$redevance = array("small" => 22.65, "medium" => 37.05, "large" => 46.20);
    $tarifs = [
        new Tranche(0, 100, 0.794), 
        new Tranche(101, 150, 0.883),
        new Tranche(151, 210, 0.9451),
        new Tranche(211, 310, 1.0489),
        new Tranche(311, 510, 1.2915),
        new Tranche(511, null, 1.4975)
    ];

    $oldIndex;
    $newIndex;
    $consommation;
    $montantsFacture = array(); // tableau où on va stocker les montants facturés
    $montantsHT = array(); // tableau où on va stocker les montants HT
    $totalMontantsHT = [];
    if (isset($_POST["submit"])) {
        $oldIndex = $_POST["oldIndex"];
        $newIndex = $_POST["newIndex"];
        $calibre = $_POST["calibre"];
        $consommation = $newIndex - $oldIndex;
        // $consommation <= 150
        if($consommation <= 150) {
            // $consommation <= 100
            if($consommation <= $tarifs[0]->borneMax) {
                $montantsFacture[0] = $consommation;
                $montantsHT[0] = $consommation * $tarifs[0]->tarif;
                $traches[0];

            }
            // 100 < $consommation <= 150
            else {
                $montantsFacture[0] = 100;
                $montantsFacture[1] = $consommation - $montantsFacture[0];
                $montantsHT[0] = $montantsFacture[0] * $tarifs[0]->tarif;
                $montantsHT[1] = $montantsFacture[1] * $tarifs[1]->tarif;
                $totaltranche2 = ($montantsHT[0]* $tva /100)+($montantsHT[1]* $tva /100);
                $karim2 =  $montantsHT[0]+$montantsHT[1];
                
            }
        }
        // $consommation > 150
        else {
            if($consommation <= $tarifs[2]->borneMax) {
                $montantsFacture[2] = $consommation;
                $montantsHT[2] = $consommation * $tarifs[2]->tarif;
                $traches[2];
            }
            else if($consommation <= $tarifs[3]->borneMax) {
                $montantsFacture[3] = $consommation;
                $montantsHT[3] = $consommation * $tarifs[3]->tarif;
                $traches[3];
            }
            else if($consommation <= $tarifs[4]->borneMax) {
                $montantsFacture[4] = $consommation;
                $montantsHT[4] = $consommation * $tarifs[4]->tarif;
                $traches[4];
            }
            else{
                $montantsFacture[5] = $consommation;
                $montantsHT[5] = $consommation * $tarifs[5]->tarif;
                $traches[5];
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="bootstrap.min.css" rel="stylesheet">
    <title >calcul</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="exemple.php" method="POST">
        <label for="">Index 1:</label>
        <input type="text" name="oldIndex"class="input">
        <label for="">Index 2:</label>
        <input type="text" name="newIndex"class="input"> 
        <label for="">Type De Compteur :</label>
        <input type="radio" value="small" name="calibre" class="calibre">small
        <input type="radio" value="medium" name="calibre"class="calibre2" >medium
        <input type="radio" value="large" name="calibre" class="calibre3">large 
        <input type="submit" value="calcul" name="submit" class="submit">
    </form>

    </table>
    <table class="table">
    <thead>
    <tr>
      <th scope="col">CONSOMMATION ELECTRICITE</th>
      <th scope="col">Facturé</th>
      <th scope="col">P.U</th>
      <th scope="col">Montant HT</th>
      <th scope="col">Taux TVA</th>
      <th scope="col">Montant Taxes</th>
      <th scope="col" class="th">إستھلاك الكھرباء</th>
    </tr>
  </thead>
    <?php
        if (isset($_POST["submit"])) {
            foreach($montantsFacture as $key => $value) {
               
                $karim = $montantsHT[$key];
        ?>
 
  
    <tr>
      <th scope="row"><?php echo $traches[$key] ?></th>
      <td><?php echo $value ?></td>
      <td><?php echo $tarifs[$key]->tarif ?></td>
      <td><?php echo $montantsHT[$key] ?></td>
      <td><?php echo $tva . "%";?></td>
      <td><?php echo $montantsHT[$key] * $tva /100 ?></td>
      <td class="th"><?php echo $trachesarab[$key]?></td>
    </tr>
    <?php
            }
            
        }
        
        ?>
    
    <tr>
      <th scope="row">REDEVANCE FIXE ELECTRICITE </th>
      <td colspan="2"></td>
      <td><?php echo $redevance[$calibre]?></td>
      <td><?php echo $tva . "%";?></td>
      <td><?php echo $redevance[$calibre] * $tva /100 ?></td>
      <th scope="row"class="th">اثاوة ثابتة الكهرباء</th>
    </tr>
    <tr>
      <th scope="row">TAXES POUR LE COMPTE DE L’ETAT </th>
      <td colspan="2"></td>
      <td></td>
      <td></td>
      <td></td>
      <th scope="row"class="th">الرسوم المؤدات لفائدة الدولة</th>
    </tr>
    
    <tr>
      <td scope="row">TVA T </td>
      <td colspan="2"></td>
      <td></td>
      <td></td>
      <td><?php 
                if($consommation>=$tarifs[1]->borneMin && $consommation <= $tarifs[1]->borneMax){
                    echo $totaltranche2+($redevance[$calibre] * $tva /100);
                }
                else{
                    echo ($redevance[$calibre] * $tva /100)+($karim * $tva /100);   
                }
                
                ?>
                
                
                </td>
      <th scope="row" class="th">مجموع ض.ق.م</th>
    </tr>
    <tr>
      <td scope="row">TIMBRE </td>
      <td colspan="2"></td>
      <td></td>
      <td></td>
      <td><?php echo $timbre ?></td>
      <th scope="row" class="th">الطابع</th>
    </tr>
    <tr>
      <th scope="row">SOUS-TOTAL</th>
      <td colspan="2"></td>
      <td><?php
      if($consommation>=$tarifs[1]->borneMin && $consommation <= $tarifs[1]->borneMax){
            echo $karim2 + $redevance[$calibre];
      }
      else{
            echo $karim + $redevance[$calibre];
        }
       ?></td>
      <td></td>
      <td><?php 
                if($consommation>=$tarifs[1]->borneMin && $consommation <= $tarifs[1]->borneMax){
                    echo $totaltranche2+($redevance[$calibre] * $tva /100)+$timbre;
                }
                else{
                     echo ($redevance[$calibre] * $tva /100)+($karim * $tva /100)+$timbre;
                }
                ?>
                </td>
      <th scope="row" class="th"> المجموع الجزئي</th>
    </tr>
    <tr>
      <th scope="row">TOTAL ÉLECTRICITÉ</th>
      <td colspan="2"></td>
      <td><?php 
       if($consommation>=$tarifs[1]->borneMin && $consommation <= $tarifs[1]->borneMax){
        echo ($totaltranche2+($redevance[$calibre] * $tva /100)+$timbre)+($karim2 + $redevance[$calibre]);
    }
    else{
         echo (($redevance[$calibre] * $tva /100)+($karim * $tva /100)+$timbre)+($karim + $redevance[$calibre]);
    }
        ?>
        </td>
      <td></td>
      <td></td>
      <th scope="row" class="th">المجموع الكهربائي </th>
    </tr>
  </tbody>
 
</table>
 <script src=bootstrap.bundle.min.js></script>
</body>
</html>




