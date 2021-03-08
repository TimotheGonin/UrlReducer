<!-- SENDING FORM -->
<?php
    if(isset($_POST['userUrl'])){
        //VARIABLE
        $url = $_POST['userUrl'];

        //VERIFICATION
        if(!filter_var($url, FILTER_VALIDATE_URL)){
            //NOT A lINK
            header('location: index.php?error=true&message=Adresse url non valide');
            exit();
        }

        //SHORTCUT
        $shortcut = crypt($url, rand());

        //HAS BEEN ALREADY SEND
        $bdd = new PDO('mysql:host=localhost;dbname=bitly;charset=utf8', 'root', '');
        $req = $bdd->prepare('SELECT COUNT(*) AS x FROM links WHERE url = ?');
        $req->execute(array($url));

        while($result['x'] != 0){
            header('location: index.php?error=true&message=Adresse déjà raccourcie');
            exit();
        }

        //SENDING
        $req = $bdd->prepare('INSERT INTO links(url,shortcut) VALUES (?, ?)');
        $req->execute(array($url, $shortcut));

        header('location: index.php?short='.$shortcut);
        exit();
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="design/default.css">
    <link rel="icon" type="image/png" href="pictures/favico.png"/>
    <title>Url Reducer</title>
</head>
<body>
<!-- HEADER -->
    <header id="hello">
        <div>
            <img src="pictures/logo.png" alt="logo blanc, Bitly" id="mainLogo">
        </div>
        <h1 class="center white fontWNormal">UNE URL LONGUE ? RACCOURCISSEZ-LA ?</h1>
        <h2 class="center white fontSNormal">Largement meilleur et plus court que les autres.</h2>
        <!-- url form -->
        <form method="post" action="index.php" class="center">
            <input type="url" name="userUrl" placeholder="Collez un lien à raccourcir">
            <button type="submit" class="white fontWBold">RACCOURCIR</button>
        </form>
        <?php
            if(isset($_GET['error']) && isset($_GET['message'])){ ?>
                <div id="resultUser" class="center">
                    <h3 class="center white fontSNormal">URL RACCOURCIE : <span class="fontWNormal">http://www.test.fr</span></h3>
                </div>
            <?php } ?>
    </header>
<!-- SECTION -->
    <section>
        <h2 class="center fontSNormal orange">CES MARQUES NOUS FONT CONFIANCE</h2>
        <div class="entrepiseImg center"><img src="pictures/1.png" alt="logo gris, Entrepreneur magazine" ><img src="pictures/2.png" alt="logo gris, Kaiser Permanente"><img src="pictures/3.png" alt="logo gris, PBS" ><img src="pictures/4.png" alt="logo gris, montage"></div>
    </section>
<!-- FOOTER -->
    <footer>
        <div><img src="pictures/logo2.png" alt="logo orange, Bitly" id="footerLogo"></div>
        <p id="copyright" class="center ">2021 © Bitly</p>
        <p id="footerLink" class= "center fontWBold"><a href="#" class="orange">Contact</a> - <a href="http://" class="orange">A Propos</a></p>
    </footer>
</body>
</html>