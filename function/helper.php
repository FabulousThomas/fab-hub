<?php

// Message function
function flashMsg($name = '', $message = '', $class = 'alert alert-success')
{
   if (!empty($name)) {
      if (!empty($message) && empty($_SESSION[$name])) {
         if (!empty($_SESSION[$name])) {
            unset($_SESSION[$name]);
         }

         if (!empty($_SESSION[$name . '_class'])) {
            unset($_SESSION[$name . '_class']);
         }

         $_SESSION[$name] = $message;
         $_SESSION[$name . '_class'] = $class;
      } elseif (empty($message) && !empty($_SESSION[$name])) {
         $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
         echo '<div class="text-center ' . $class . ' py-2" id="msg-flash">' . $_SESSION[$name] . '</div>';
         unset($_SESSION[$name]);
         unset($_SESSION[$name . '_class']);
      }
   }
}

// RANDOM NUMBER FUNCTION
function random_num($length)
{
   $text = "";
   if ($length < 5) {
      $length = 5;
   }
   $len = rand(4, $length);

   for ($i = 0; $i < $len; $i++) {
      $text .= rand(0, 9);
   }
   return $text;
}

function redirect($page)
{
   header('Location: ' . $page);
}

function getDistinct($column, $table) {
   global $conn;
   $stmt = $conn->prepare("SELECT DISTINCT $column FROM $table");
   $stmt->execute();
   return $stmt->get_result();
}
function getAll($table) {
   global $conn;
   $stmt = $conn->prepare("SELECT * FROM $table");
   $stmt->execute();
   return $stmt->get_result();
}

function getAllById($table, $id) {
   global $conn;
   $stmt = $conn->prepare("SELECT * FROM $table WHERE product_id=$id LIMIT 1");
   // $stmt->bind_param('i', $product_id);
   $stmt->execute();
   return $stmt->get_result();
}
