<div class="show">
   <?php $note = $params['note'] ?? null; ?>
   <?php if ($note) : ?>
      <ul>

         <li>ID: <?php echo $note['id'] ?></li>
         <li>Title: <?php echo $note['title'] ?></li>
         <li>Description: <?php echo $note['description'] ?></li>
         <li>Created: <?php echo $note['created'] ?></li>
      </ul>
      <a href="/?action=edit&id=<?php echo $note['id'] ?>">
         <button>Edit</button>
      </a>
   <?php else : ?>
      <h3>No notes to display</h3>
   <?php endif; ?>
   <a href="/"><button>Get back to the notes</button></a>
</div>