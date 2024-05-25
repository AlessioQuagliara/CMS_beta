<?php 
if (!file_exists('../conn.php')) {
  header("Location: error");
  exit();
} else {
  include ('../app.php');
  subscribe();
}
?>