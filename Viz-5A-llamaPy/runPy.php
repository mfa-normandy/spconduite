<?php
// Enable error reporting
//error_reporting(E_ALL);

// Execute the Python script and get the output
//$output = shell_exec('python hello.py 2>&1');

// Get the prompt from the URL parameters
$prompt = $_POST['prompt'];
//$token = $_POST['token'];

// Execute the Python script and get the output
//$output = shell_exec('python hello.py ' . escapeshellarg($prompt) . ' ' . escapeshellarg($token) . ' 2>&1');
$output = shell_exec('python hello.py ' . escapeshellarg($prompt) . ' 2>&1');

// Split the output at each #
$parts = explode("#", $output, 7); // We need 7 parts: 1 before the first #, and 6 for the 6 #

// Get the first three # and their following text, and join them into a string
$first_three = implode("#", array_slice($parts, 1, 3));

// Get the next three # and their following text, and join them into a string
$next_three = implode("#", array_slice($parts, 4, 3));

// Output the first three # and their following text, a <br>, and then the next three # and their following text
echo " <br> " . $first_three . " <br> " . $next_three;