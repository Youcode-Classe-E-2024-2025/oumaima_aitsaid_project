<?php


echo '<h1>Manage Categories</h1>';
foreach ($categories as $category) {
    echo "<div>{$category['id']}: {$category['name']}
          <form method='POST' action='index.php?action=delete_category.php'>
              <input type='hidden' name='id' value='{$category['id']}'>
              <button type='submit'>Delete</button>
          </form>
          </div>";
}
?>
