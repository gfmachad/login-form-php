<?php
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: login.php?error=true');
  exit;
}
