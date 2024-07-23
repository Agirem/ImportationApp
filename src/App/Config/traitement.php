
<?php
session_start();
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données communes du formulaire
    $source = $_POST["source"];

    // Validation des données communes (à adapter selon vos besoins)

    
    // include ('');

    // Traitements en fonction de la source
    switch ($source) {
        case 'index':
            $departure = $_POST["departure"];
            $destination = $_POST["destination"];
            $date = $_POST["date"];
          

            // Traitement spécifique pour affichage des résultats
            $sql = "SELECT
            T.tarifID,
            VD.nomVille AS lieuDepart,
            VD_destination.nomVille AS lieuDestination,
            T.tarif
        FROM
            tarifs T
            JOIN villes VD ON T.villeDepartID = VD.villeID
            JOIN villes VD_destination ON T.villeDestinationID = VD_destination.villeID
        WHERE
            VD.villeID = '$departure'
            AND VD_destination.villeID ='$destination';
            ";

            $sql2 = "SELECT
                HD.heureDepartID,
                HD.heureDepartVIP AS heureDepart,
                COALESCE(COUNT(R.reservationID), 0) AS nombreReservations
        FROM
            heuresdepart HD
            LEFT JOIN reservations R ON HD.heureDepartVIP = R.heureDepartID AND R.dateVoyage = '$date'
            LEFT JOIN tarifs T ON R.tarifID = T.tarifID
            LEFT JOIN villes VD ON T.villeDepartID = VD.villeID
            LEFT JOIN villes VD_destination ON T.villeDestinationID = VD_destination.villeID
        GROUP BY
        HD.heureDepartID, HD.heureDepartVIP;
        ";

            $request2 = $conn->query($sql2);


            if ($request1 && $request2) {
                $res = $request1->fetch_all(MYSQLI_ASSOC);
                $res2 = $request2->fetch_all(MYSQLI_ASSOC);
                $_SESSION['resultats'] = $res;
                $_SESSION['hours'] = $res2; 
            }
            $conn->close();
        
            header("Location: results");

            break;

        case 'results':

            $values = $_POST["hourBus"];
            
            $_SESSION['bus'] = $bus;


            header("Location: infos_client.php");

            break;


        default:
            // Gestion d'erreur si la source n'est pas reconnue
            echo "Source non reconnue.";
    }
    // Fermer la connexion
    $conn->close();
}
