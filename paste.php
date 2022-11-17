<?php

include 'dbconnection.php';

if (isset($_POST['submit'])) {
    
    $url = $_SERVER['REQUEST_URI'];
    $uniqueId = substr($url, strrpos($url, '/') + 1);
    $pastedData = $_POST['code'];
    $prLanguage = $_POST['Prlanguage'];
    $timePasted = date('m/d/Y h:i:s a', time());
    $postExp = $_POST['post_exp'];
    $title = $_POST['title'];
    $conn->beginTransaction();
    $conn->exec("INSERT INTO databin (uniqueId, userInput, datePasted, prlanguage, post_expo, title) VALUES ('$uniqueId', '$pastedData', '$timePasted', '$prLanguage', '$postExp', '$title')");
    $conn->commit();
}


$unId = basename($_SERVER['REQUEST_URI']);

$stmt = $conn->prepare("select * from databin where uniqueId = '" . $unId . "'");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $title = $row['title'];
    $pastedData = $row['userInput'];
    $prLanguage = $row['prlanguage'];
    $timePasted = $row['datePasted'];
    $postExp = $row['post_expo'];
}
$count = $conn->prepare("select count(*) from databin where uniqueId = '" . $unId . "'");
$count->execute();

$rows = (int)$count->fetchColumn();

if ($rows == 0) {
    header("Location: ../index.php");
} elseif ($unId == "paste.php") {
    header("Location: ../index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="60x60" href="..img/favicon.png">
  <link rel="stylesheet" href="../style.css">
  <title>Pastebin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/theme/erlang-dark.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.38.0/codemirror.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.38.0/codemirror.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.38.0/mode/javascript/javascript.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.38.0/mode/go/go.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.38.0/mode/css/css.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/mode/htmlmixed/htmlmixed.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/mode/xml/xml.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/mode/clike/clike.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/mode/php/php.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/mode/sql/sql.js"></script>
  <script src="https://codemirror.net/addon/hint/show-hint.js"></script>
  <script src="https://codemirror.net/addon/hint/css-hint.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://codemirror.net/addon/hint/show-hint.css">
  <link rel="stylesheet" href="../navbar.css"`>
</head>

<body>
  <header>
    <a href="index.php" class="logo">
      <img src="../img/logo_transparent.png" alt="logo">
    </a>
    
    <nav>
      <ul class="nav-links">
        <li><a href="index.php">+Paste</a></li>
        <li><a href="team.php">Team</a></li>
      </ul>
    </nav>
    <button id="kleur-knop" onclick="changeTheme()">Dark mode</button>
  </header>

  <script>
    let target = document.body;
    let theme = localStorage.getItem("theme");
    if (theme != null) {
      target.classList.toggle("theme-dark");
    }
    function changeTheme() {
      let theme = localStorage.getItem("theme");
      if (theme != null) {
        localStorage.removeItem("theme");
      } else {
        localStorage.setItem("theme", "theme-dark");
      }
      target.classList.toggle("theme-dark");
    }
    if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
    <div class="content_container">
      <div class="main">
      <h2 class="text-p">Old Paste</h2>

      <div class="text-vak">
        <textarea id="text-vak" name="code" rows="30" cols="100"><?php echo $pastedData ?> </textarea>
        <br>
      </div>
      <hr>
      <label class="Choice" for="lang">Syntax Highlighting:</label>
      <select name="Prlanguage" id="language">
        <option value="HTML" <?php if($prLanguage == 'HTML'){ echo ' selected="selected"'; } ?>>HTML</option>
        <option value="PHP"<?php if($prLanguage == 'PHP'){ echo ' selected="selected"'; } ?>>PHP</option>
        <option value="Javascript"<?php if($prLanguage == 'Javascript'){ echo ' selected="selected"'; } ?>>Javascript</option>
        <option value="CSS"<?php if($prLanguage == 'CSS'){ echo ' selected="selected"'; } ?>>CSS</option>
        <option value="SQL"<?php if($prLanguage == 'SQL'){ echo ' selected="selected"'; } ?>>SQL</option>
      </select>
      <form action="../index.php" method="POST">
      <input name="submit" type="submit" value="Home page" id="knop">
      </form>
      </div>
      <div class="side_bar">
      <h1>Public pastes</h1>
      <hr>
      <table class="zigzag">
        <thead>
          <tr>
            <th class="header">Title</th>
            <th class="header">Syntax</th>
            <th class="header">Pasted</th>
          </tr>
        </thead>
        <tbody>
          <?php
            // displaying public posts

            $sql = $conn->prepare("SELECT uniqueId, userInput, title, datePasted, prlanguage FROM databin WHERE post_expo = '" . "Public" . "' ORDER BY datePasted DESC LIMIT 10");
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
              ?>
              <tr>
                <td><a class="title_link" href="../paste.php/<?php echo $row['uniqueId']?>"><i class="fa fa-file-code-o" style="font-size:20px;color:black"></i><?php echo $row['title']?></a></td>
                <td><?php echo $row['prlanguage']?></td>
                <td><?php echo $row['datePasted']?></td>
              </tr>

              <?php
              }
              ?>
        </tbody>
      </table>
      </div>
    </div>
    <script type="text/javascript" src="../highlight.js"></script>
  </body>

</html>