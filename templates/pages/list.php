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

   <?php
   $sort = $params['sort'] ?? [];
   $by = $sort['by'] ?? 'title';
   $order = $sort['order'] ?? 'desc';
   $page = $params['page'] ?? [];
   $size = $page['size'] ?? 10;
   $currentPage = $page['number'] ?? 1;
   $pages = $page['pages'] ?? 1;
   ?>

   <div class="sort">
      <form class="settings-form" action="/" method="GET">
         <div>
            <div>Sort by:</div>
            <label>Title:
               <input name="sortby" type="radio" value="title" <?php echo $by === 'title' ? 'checked' : '' ?>>
            </label>
            <label>Date:
               <input name="sortby" type="radio" value="created" <?php echo $by === 'created' ? 'checked' : '' ?>>
            </label>
         </div>
         <div>
            <div>Sort type:</div>
            <label>Ascending:
               <input name="sortorder" type="radio" value="asc" <?php echo $order === 'asc' ? 'checked' : '' ?>>
            </label>
            <label>Descending:
               <input name="sortorder" type="radio" value="desc" <?php echo $order === 'desc' ? 'checked' : '' ?>>
            </label>
         </div>
         <div>
            <div>Notes per page:</div>
            <label>1
               <input type="radio" name="pagesize" value="1" <?php echo $size === 1 ? 'checked' : '' ?>>
            </label>
            <label>5
               <input type="radio" name="pagesize" value="5" <?php echo $size === 5 ? 'checked' : '' ?>>
            </label>
            <label>10
               <input type="radio" name="pagesize" value="10" <?php echo $size === 10 ? 'checked' : '' ?>>
            </label>
            <label>25
               <input type="radio" name="pagesize" value="25" <?php echo $size === 25 ? 'checked' : '' ?>>
            </label>
         </div>
         <input type="submit" value="Apply">
      </form>
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

   <?php $paginationUrl = "&pagesize=$size?sortby=$by&sortorder=$order"; ?>

   <ul class="pagination">
      <?php if ($currentPage !== 1) : ?>
         <li>
            <a href="/?page=<?php echo $currentPage - 1 . $paginationUrl ?>">
               <button>prev</button>
            </a>
         </li>
      <?php endif; ?>
      <?php for ($i = 1; $i <= $pages; $i++) : ?> <li>
            <a href="/?page=<?php echo $i . $paginationUrl ?>">
               <button><?php echo $i; ?></button>
            </a>
         </li>
      <?php endfor; ?>
      <?php if ($currentPage < $pages) : ?>
         <li>
            <a href="/?page=<?php echo $currentPage + 1 . $paginationUrl ?>">
               <button>next</button>
            </a>
         </li>
      <?php endif; ?>
   </ul>
</section>