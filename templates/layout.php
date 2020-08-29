<html>

<head>
   <title>Notepad</title>
   <meta charset="utf-8">
   <script src="https://kit.fontawesome.com/ea3e93cd21.js" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="/public/styles.css">
</head>

<body class="body">
   <div class="wrapper">
      <div class="header">
         <h1><i class="far fa-clipboard"></i>My notes</h1>
      </div>

      <main class="container">
         <nav class="menu">
            <ul>
               <li><a href="/">List of notes</a></li>
               <li><a href="/?action=create">New note</a></li>
            </ul>
         </nav>

         <div class="page">
            <?php
            require_once("templates/pages/$page.php");
            ?>
         </div>
      </main>

      <footer class="footer">
         <p>Notepad created during PHP course.</p>
      </footer>
   </div>
</body>

</html>