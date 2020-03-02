<?php 
require_once('private/initialize.php'); 

$errors = [];
$upload_error = false;
$upload_success = false;

echo "<pre>";
print_r($_FILES);
echo "</pre>";

  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty($_FILES['fileToUpload']['name'])) {
      array_push($errors, $errors_list['no_file_chosen']);
    } else {
      $target_dir = "uploads/";
      $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
      $upload_error = false;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      // Check if image file is a actual image or fake image
  
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      $image_type = $check[2];
      
      if(in_array($image_type , array(IMAGETYPE_JPEG, IMAGETYPE_PNG))) {
        $upload_error = false;
      } else {
        $upload_error = true;
        array_push($errors, $errors_list['wrong_file_format']);
      }
  
      // Check file size
      if ($_FILES["fileToUpload"]["size"] > 100000) {
          $upload_error = true;
          array_push($errors, $errors_list['wrong_file_size']);
      }
     
      if ($upload_error == true) {
      } else {
        // if everything is ok, generate unique name and try to upload file
        $uniqid = time().uniqid(rand());
        $ext = pathinfo($target_file, PATHINFO_EXTENSION);
        $path = $target_dir . $uniqid . "." . $ext;
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $path)) {
          $upload_error = false;
          $upload_success = true;
        } else {
          $upload_error = true;
          array_push($errors, $errors_list['upload_failed']);
        }
      }
    }
  }

?>


<?php include(SHARED_PATH . '/header.php'); ?>
<section class="section">
  <div class="container">
    <h1 class="section__title section__title--centered">Dodaj zdjęcie</h1>
    <?php if ($upload_success): ?>
      <p>Plik został dodany</p>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data"  class="form form--center-items">
      <div class="form__row form__row--centered">
        <label for="fileToUpload" class="form__label">Wybierz plik</label>
        <input type="file" id="fileToUpload" name="fileToUpload" class="form__file-input"
              accept=".jpg, .jpeg, .png">
        <input type="hidden" value="">

        <!-- <input type="file" name="fileToUpload" id="file-2" class="inputfile inputfile-2"/>
        <label for="file-2">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> 
          <span>Wybierz plik&hellip;</span> -->
        </label>

      </div>
      <?php 
      if ($errors):
        foreach ($errors as $error) {
      ?>
        <p class="form__error form__error--file form__error--centered visible"><?php echo $error; ?></p>
      <?php
        }
      endif;
      ?>
      <button class="cta-btn form__btn" type="submit" name="btn-submit">Dodaj</button>
    </form>
    
  </div>
</section>
<script src="assets/js/custom-file-input.js"></script>
<?php include(SHARED_PATH . '/footer.php'); ?>