<div class="show">
   <?php $note = $params['note'] ?? null; ?>
   <?php if ($note) : ?>
      <ul>

         <li>ID: <?php echo (int) $note['id'] ?></li>
         <li>Title: <?php echo htmlentities($note['title']) ?></li>
         <li>Description: <?php echo htmlentities($note['description']) ?></li>
         <li>Created: <?php echo htmlentities($note['created']) ?></li>
      </ul>
   <?php else : ?>
      <h3>No notes to display</h3>
   <?php endif; ?>
   <a href="/"><button>Get back to the notes</button></a>
</div>