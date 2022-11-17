<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="60x60" href="img/favicon.png">
  <link rel="stylesheet" href="style.css">
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
</head>

<body>
  <?php
  include 'navbar.html';
  include 'dbconnection.php';

  // generate rondom string

  $length = 6;
  $uniqueId = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, $length);
  ?>
  <body>
    <div class="content_container">
      <div class="main">
      <h2 class="text-p">New Paste</h2>

      <form action="paste.php/<?php echo $uniqueId ?>" method="POST">
      <div class="text-vak">
        <textarea id="text-vak" name="code" rows="30" cols="100"></textarea>
        <br>
      </div>
      <hr>
      <label class="Choice" for="lang">Syntax Highlighting:</label>
      <select name="Prlanguage" id="language" onchange="getValue(this)">
        <option selected value="HTML">HTML</option>
        <option value="PHP">PHP</option>
        <option value="Javascript">Javascript</option>
        <option value="CSS">CSS</option>
        <option value="SQL">SQL</option>
      </select>
      <br>
      <label class="post_label" id="post_label" for="post_exp">Post Exposure:</label>
      <select name="post_exp" id="post_select">
        <option selected value="Public">Public</option>
        <option value="Private">Private</option>
      </select>
      <br>
      <label class="Choice" for="title">Post title:</label>
      <input name="title" class="title" type="text" placeholder="Type title ..." required>
      </select>
      <br>
      <input name="submit" type="submit" value="Create Paste" id="knop">
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
                <td><a class="title_link" href="paste.php/<?php echo $row['uniqueId']?>"><i class="fa fa-file-code-o" style="font-size:20px;color:black"></i><?php echo $row['title']?></a></td>
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
    <script type="text/javascript" src="highlight.js"></script>
  </body>

</html>