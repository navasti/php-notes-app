<section class="list">
   <div class="message">
      <?php
      if (!empty($params['error'])) {
         switch ($params['error']) {
            case 'missingNoteId':
               echo "Invalid note's id";
               break;
            case 'noteNotFound':
               echo "Note has not been found";
               break;
         }
      }
      ?>
      <?php
      if (!empty($params['before'])) {
         switch ($params['before']) {
            case 'created':
               echo "Note has been created";
               break;
            case 'deleted':
               echo "Note has been deleted";
               break;
            case 'edited':
               echo "Note has been edited";
               break;
         }
      }
      ?>
   </div>

   <div class="tbl-header">
      <table cellpadding="0" cellspacing="0" border="0">
         <thead>
            <tr>
               <th>ID</th>
               <th>Title</th>
               <th>Date</th>
               <th>Options</th>
            </tr>
         </thead>
      </table>
   </div>

   <div class="tbl-content">
      <table cellpadding="0" cellspacing="0" border="0">
         <tbody>
            <?php foreach ($params['notes'] ?? [] as $note) : ?>
               <tr>
                  <td><?php echo $note['id'] ?></td>
                  <td><?php echo $note['title'] ?></td>
                  <td><?php echo $note['created'] ?></td>
                  <td>
                     <a href="/?action=show&id=<?php echo $note['id'] ?>"><button>Details</button></a>
                     <a href="/?action=delete&id=<?php echo $note['id'] ?>"><button>Delete</button></a>
                  </td>
               </tr>
            <?php endforeach; ?>
         </tbody>
      </table>
   </div>
</section>