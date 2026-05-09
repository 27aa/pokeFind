<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>pokeFind</title>
  <style>
    body{
        text-align: center;
    }
    tr, td, th {
        border: 1px solid black;
        text-align: center;
        padding : 0px 20px;
    }
    div {
        display: flex;
        justify-content: center;
    }
    /* h1 {
        text-align: center;
    } */
  </style>
</head>
<h1>Recherche de pokemon</h1>
<body>
    <div>
        <form action="./index.php" method="GET">
          <label>
              Par index : 
              <input type="text" name="pokeSearch">
          </label>
        </form>
    </div>
</body>
</html>

<?php

//fonction pour recup les données d'une API
function RequeteAPI(string $url)
{
    $curl = curl_init();
    curl_setopt_array($curl, [
    CURLOPT_URL => "$url",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",]);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    if ($err) 
    {
    echo "cURL Error #:" . $err;
    } 
    else 
    {
        $tableau = json_decode($response, true);
        return $tableau;
    }
}

//fonction qui affiche un pokemon avec toutes ses données
function AffichePokemon(int $nb)
{
    if($nb === $nb && $nb >= 1 && $nb <= 1025)
    {
        $pokeUrl = "https://pokeapi.co/api/v2/pokemon/$nb";
        $pokeTab = RequeteAPI($pokeUrl);

        


        echo "<h1> Caracteristique de " . $pokeTab['name'] . "</h1>";

        //tableau des pokemons
        echo "<div>";
            echo "<table>";
                echo "<tr>";
                    echo "<th>";
                        echo "Index";
                    echo "</th>";
                    echo "<th>";
                        echo "Nom";
                    echo "</th>";
                    echo "<th>";
                        echo "Image";
                    echo "</th>";
                    echo "<th>";
                        echo "Cri";
                    echo "</th>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>";
                        echo $pokeTab["id"];
                    echo "</td>";
                    echo "<td>";
                        echo $pokeTab["name"];
                    echo "</td>";
                    echo "<td>";
                        echo "<img src=" . $pokeTab["sprites"]["front_default"] . ">";
                    echo "</td>";
                    echo "<td>";
                        echo "<audio controls>" . "<source src=" . $pokeTab["cries"]["latest"] . " type=audio/ogg>" . "</audio>";
                    echo "</td>"; 
                echo "</tr>";
            echo "</table>";  
        echo "</div>";

        
        echo "<h1> Abilité de " . $pokeTab['name'] . "</h1>";

        //tableau des abilitées
        $htmlTab = "<div><table><tr><th>Index</th><th>Nom</th><th>Description</th></tr>";

        //compte le nombre d'abilité 
        $tailleDeTabAbility = count($pokeTab['abilities']);

        for ($i=0; $i < $tailleDeTabAbility; $i++) 
        {   
            $abilityUrl = $pokeTab['abilities'][$i]['ability']['url'];
            $abilityTab = RequeteAPI($abilityUrl);

            $htmlTab .= "<tr><td>" . ($i + 1) . "</td><td>" . $pokeTab['abilities'][$i]['ability']['name'] . "</td><td>" . $abilityTab['effect_entries'][0]['effect'] . "</td></tr>";
            
        }       
        $htmlTab .= "</div>";

        echo $htmlTab;

        
        //         echo "<tr>";
        //             echo "<td>";
        //                 echo $abilityTab["id"];
        //             echo "</td>";
        //             echo "<td>";
        //                 echo $pokeTab['abilities'][0]['ability']['name'];
        //             echo "</td>";
        //             echo "<td>";
        //                 echo $abilityTab['effect_entries'][0]['effect'];
        //             echo "</td>";
        //         echo "</tr>";
        //     echo "</table>"; 
        // echo "</div>";


    }
    else
    {
        echo "Veuillez rentrer un nombre entre 1 et 1025";
    }
}

$idSearch = filter_input(INPUT_GET, "pokeSearch", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if (filter_var($idSearch, FILTER_VALIDATE_INT))
{
    AffichePokemon($idSearch);
}
else
{
    echo "Veuillez rentrer un nombre entre 1 et 1025 !";
}

// script de test : <script>alert("test")</script>


?>