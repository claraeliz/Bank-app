<?php
session_start();
$_SESSION['selected_idx'] = null;
header('Location: index.php');
exit;
