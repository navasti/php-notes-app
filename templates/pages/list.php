<div class="message">
   <?php
   if (!empty($params['before'])) {
      switch ($params['before']) {
         case 'created':
            echo "Note has been created";
            break;
      }
   }
   ?>
</div>

<h3>List of notes</h3>
<div>
   <b><?php echo $params['resultList'] ?? "" ?></b>
</div>