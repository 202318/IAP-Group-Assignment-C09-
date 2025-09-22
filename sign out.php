<?php
require 'db_conn.php';
session_unset(); session_destroy();
header("Location: signin.php"); exit;