<!-- <?php
$name='name';
$email='email';
$subject='subject';
$message='message';

$to=$email;

$message="From:$name <br />".$message;

//$headers = "MIME-Version: 1.0" . "\r\n";
//$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

// More headers
$headers .= 'From: <syaibatulhamdi18@gmail.com>' . "\r\n";
mail($to,$subject,$message,$headers);
exit();
if(mail)
{
echo "<script> alert('Email sent successfully !!'); window.location = '$admin_url'+'index.php';</script>";
}
?> -->

<?php
$name='name';
$email='email';
$subject='subject';
$message='message';

$to=$email;

$message="From:$name <br />".$message;

//$headers = "MIME-Version: 1.0" . "\r\n";
//$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

// More headers
$headers = "From: <syaibatul0022@students.amikom.ac.id>"."\r\n";
mail($to,$subject,$message,$headers);
exit();
if(mail)
{
echo "<script> alert('Email sent successfully !!'); window.location = '$admin_url'+'index.php';</script>";
}
?>