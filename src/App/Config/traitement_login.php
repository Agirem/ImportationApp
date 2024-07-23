<?php        
session_start();  
include('config.php');
//on va commencer par verifier si le pseudo est le mot de passe ont été saisis  
if (empty($_POST['pseudo']) || empty ($_POST['password']))  
{  
echo "le pseudo et le mot de passe doivent être forcement saisis";  
}  
else   
{  

$pseudo = $_POST['pseudo'];  
$password = $_POST['password'];  
/*nous allons selectionner l'id et le mot de passe dans la table membres, 
 là où pseudo egal au pseudo envoyé par le formulaire*/   


  $sql = "SELECT
           nom, prenom, numTelephone, mdp, localisation
        FROM
           employes
        WHERE
            nom = '$pseudo'
            AND mdp ='$password';
            ";
 $request1 = $conn->query($sql);
 $res = $request1->fetch_all(MYSQLI_ASSOC);
 $_SESSION['resultats'] = $res;

 var_dump( $_SESSION['resultats']);
/*on verifie si le mot de passe saisi correspond  
au mot de passe du membre et on ouvre la session*/  
if ( $_SESSION['resultats']['0']["mdp"] == $password)  
{  
$_SESSION['pseudo'] = $pseudo;  
$_SESSION['id'] = $res[0]['id'];  
header("Location: main"); 
}  
else  
{  
echo "Desolé! connexion echouée";  
}  
}   