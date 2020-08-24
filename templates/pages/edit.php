<h3>Edit the note</h3>
<div>
   <?php if (!empty($params['note'])) :  ?>
      <?php $note = $params['note'] ?>
      <form action="/?action=edit" method="POST" class="note-form">
         <input name="id" type="hidden" value="<?php echo $note['id'] ?>">
         <ul class="ul">
            <li>
               <label>Title <span class="required">*</span></label>
               <input type="text" name="title" class="feild-long" value="<?php echo $note['title'] ?>">
            </li>
            <li>
               <label>Description</label>
               <textarea name="description" id="field5" class="field-long field-textarea"><?php echo $note['description'] ?></textarea>
            </li>
            <li>
               <input type="submit" value="Submit">
            </li>
         </ul>
      </form>
   <?php else : ?>
      <div>
         <p>No informations to display</p>
         <a href="/">
            <button>Get back to the notes</button>
         </a>
      </div>
   <?php endif; ?>
</div>