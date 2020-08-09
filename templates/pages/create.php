<h3>New note</h3>
<div>
   <?php if (!$params['created']) : ?>
      <form action="/?action=create" method="POST" class="note-form">
         <ul class="ul">
            <li>
               <label>Title <span class="required">*</span></label>
               <input type="text" name="title" class="feild-long">
            </li>
            <li>
               <label>Description</label>
               <textarea name="description" id="field5" class="field-long field-textarea"></textarea>
            </li>
            <li>
               <input type="submit" value="Submit">
            </li>
         </ul>
      </form>
   <?php else : ?>
      <div>
         <p>Title of new created note: <?php echo $params['title'] ?></p>
         <p>Description of new created note: <?php echo $params['description'] ?></p>
      </div>
   <?php endif ?>

</div>