<?php 
  include_once 'functions/database/connexionDB.php';
  $bd = new ConnectDB();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>BattleKart</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="assets/Logo/LogoMini.png">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" media="screen" href="assets/Fonts/MontrealHeavy.ttf" type="text/css"/>
    <link rel="stylesheet" media="screen" href="assets/Fonts/SourceSansPro.ttf" type="text/css"/>
    <link rel="stylesheet" media="screen" href="assets/Fonts/Dimbo.ttf" type="text/css"/>
    <link rel="stylesheet" href="assets/style.css" type="text/css" media="screen" title="Styles de base" />
    <script>
        const parser = new DOMParser(); // DOMParser
    </script>
  </head>
  <body>

    <!--script>
        setInterval(async () => { // Après 5 secondes, on exécute la fonction asynchrone suivante.
            const query = await fetch(location.href); // Nouvelle requête sur la page actuelle
            const response = await query.text(); // Résultat sous forme de texte
            const newDiv = parser.parseFromString(response, 'text/html').querySelector('div.main'); // On récupère le nouveau 'div'

            newDiv.querySelectorAll('script').forEach(script => { // Pour chaque élément 'script' dans le nouveau 'div'
                const newScript = document.createElement('script'); // On crée un nouvel element 'script'
                [...script.attributes].forEach(attr => newScript.attributes.setNamedItem(attr.cloneNode())); // On clone les attribut des éléments 'script' d'origine dans le nouvelle élément 'script'
                newScript.innerHTML = script.innerHTML; // On copie le contenu de l'élément 'script' d'origine dans le nouvelle élément 'script'
                script.replaceWith(newScript); // On remplace l'élément 'script' d'origine par le nouvelle élément 'script'
            }); // Tout ça est requis pour s'assurer que les éléments 'script' charger depuis 'fetch' soit bien exécuter (étant donner que 'DOMParser.parseFromString' parse une string en un DOM mais n'exécute pas le javascript qu'il contient)
            const div = document.querySelector('.main'); // On récupère le 'div' actuel
            div.replaceWith(newDiv); // On le remplace par le nouveau.
        }, 5000);
    </script-->

    <div class="header">
      <img src="assets/Logo/LogoFull.png" width="10%">
    </div>

    <div class="topnav">
      <a class="active" href="#home">Home</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
      <div class="search-container">
        <form action="#">
          <input type="text" placeholder="Search.." name="search">
          <button type="submit"><img src="assets/iconsearch.png" alt="Search Icon" width="20" height="20"></button>
        </form>
      </div>
    </div>

    <div class="row">
      <div class="side">
        <h2>Games Modes</h2>
        <?php                    
          $req = $bd->bdd->query("SELECT * FROM gamemodes") or die(mysql_error());
          while($rep = $req->fetch()) {
        ?>
        <div class="container">
          <img id="imageGameMode" src="assets/GameModes/<?php echo $rep['Name']; ?>.png" alt="<?php echo $rep['Name']; ?>" width="1000" height="300">
          <div class="center"><?php echo $rep['Name']; ?></div>
        </div>
        <?php } ?>
      </div>

      <div class="main">
        <?php                    
          $reqGames = $bd->bdd->query("SELECT * FROM games ORDER BY Id ASC") or die(mysql_error());
          while($Games = $reqGames->fetch()) {
        ?>
        <div class="inlineBloc">
          <div class="pseudoPlayer">
            <h1><?php echo $Games['Date'].' : '.$Games['Name']; ?></h1>
          </div>
          
          <div class="fakeimg_player" style="height:10px;"><?php echo $Games['PlayersCount'].'/'.$Games['PlayersMax']; ?></div>
        </div>
        <?php               
          $reqGamesPlayers = $bd->bdd->query("SELECT * FROM gamesplayers g, players p WHERE g.PlayerId=p.Id AND g.GameId='".$Games['Id']."' ORDER BY g.Id ASC") or die(mysql_error());     
          while($GamesPlayers = $reqGamesPlayers->fetch()) {
        ?>
        <div id="form-div">
          <div class="inlineBloc">
            <div class="pseudoPlayer">
              <div class="containerPseudo">
                <img id="imageGameMode" src="assets/PseudoBackground.png" alt="PseudoBackground" width="1000" height="300">
                <div class="centerPseudo"><h1><?php echo $GamesPlayers['Pseudo']; ?></h1></div>
              </div>
            </div>
            
            <div class="fakeimg_player" style="height:10px;"><?php echo $Games['Status']; ?></div>
          </div>
          <div class="monTableau">
            <table class="scroll-table-container scroll-table">
              <thead id="entete">
                <tr>
                  <th>Id</th>
                  <th>Duration</th>
                  <th>Params</th>
                </tr>
              </thead>
              <tbody>
                <?php                    
                    $json = $Games['Content'];
                    $decoded_json = json_decode($json, true);
                    $rounds = $decoded_json['Rounds'];
                    foreach($rounds as $round) {
                        $propositions = $round['Propositions'];
                        foreach($propositions as $proposition) {
                ?>
                <tr>
                  <td><?php echo $proposition['Id']; ?></td>
                  <td><?php echo gmdate("H:i:s",$proposition['Duration']); ?></td>
                  <td>
                    <?php if(!empty($proposition['Params'])){ ?>
                      <table>
                        <thead>
                          <tr>
                            <th>MapId</th>
                            <th>Music</th>
                            <th>Theme</th>
                            <th>OBJ_OIL</th>
                            <th>OBJ_TURBO</th>
                            <th>ShowBrief</th>
                            <th>OBJ_ROCKET</th>
                            <th>OBJ_SHIELD</th>
                            <th>RainBow_Mode</th>
                            <th>OBJ_MACHINEGUN</th>
                            <th>AutoLarge_Circuit</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td><?php if(!empty($proposition['Params']['MapId'])) echo $proposition['Params']['MapId']; ?></td>
                            <td><?php if(!empty($proposition['Params']['Music'])) echo $proposition['Params']['Music']; ?></td>
                            <td><?php if(!empty($proposition['Params']['Theme'])) echo $proposition['Params']['Theme']; ?></td>
                            <td><?php if(!empty($proposition['Params']['OBJ_OIL'])) echo $proposition['Params']['OBJ_OIL']; ?></td>
                            <td><?php if(!empty($proposition['Params']['OBJ_TURBO'])) echo $proposition['Params']['OBJ_TURBO']; ?></td>
                            <td><?php if(!empty($proposition['Params']['ShowBrief'])) echo $proposition['Params']['ShowBrief']; ?></td>
                            <td><?php if(!empty($proposition['Params']['OBJ_ROCKET'])) echo $proposition['Params']['OBJ_ROCKET']; ?></td>
                            <td><?php if(!empty($proposition['Params']['OBJ_SHIELD'])) echo $proposition['Params']['OBJ_SHIELD']; ?></td>
                            <td><?php if(!empty($proposition['Params']['RainBow_Mode'])) echo $proposition['Params']['RainBow_Mode']; ?></td>
                            <td><?php if(!empty($proposition['Params']['OBJ_MACHINEGUN'])) echo $proposition['Params']['OBJ_MACHINEGUN']; ?></td>
                            <td><?php if(!empty($proposition['Params']['AutoLarge_Circuit'])) echo $proposition['Params']['AutoLarge_Circuit']; ?></td>
                          </tr>
                        </tbody>
                      </table>
                      <?php } ?>
                    </td>
                  </tr>
                <?php }} ?>
              </tbody>
            </table>
          </div>
        </div>
        <?php }} ?>
      </div>
    </div>

    <div class="footer">
      <h7>@Copyright 2022 By Lionel SONTIA</h7>
    </div>
  </body>
</html>