<!-- code taken from https://formcarry.com/blog/how-to-create-a-simple-html-contact-form/#option-1-html-form-processing-with-php -->

<?php
if (isset($_POST['email'])) {

    // REPLACE THIS 2 LINES AS YOU DESIRE
    $email_to = "torresen@umich.edu";
    $email_subject = "TUTOR REQUEST";

    function problem($error)
    {
        echo "Looks like there is some problem with your form data: <br><br>";
        echo $error . "<br><br>";
        echo "Please fix those to proceed.<br><br>";
        die();
    }

    // validation expected data exists
    if (
        !isset($_POST['studentname']) ||
        !isset($_POST['email']) ||
        !isset($_POST['message'])
    ) {
        problem('Please fill out all required fields');
    }

    $studentname = $_POST['studentname']; // required
    $submittername = $_POST['submittername'];
    $email = $_POST['email']; // required
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $email)) {
        $error_message .= 'Email address does not seem valid.<br>';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if (!preg_match($string_exp, $studentname)) {
        $error_message .= 'Name does not seem valid.<br>';
    }

    if (strlen($message) < 2) {
        $error_message .= 'Message should not be less than 2 characters<br>';
    }

    if (strlen($error_message) > 0) {
        problem($error_message);
    }

    $email_message = "Form details following:\n\n";

    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    $email_message .= "Student: " . clean_string($studentname) . "\n";
    $email_message .= "Submitter: " . clean_string($submittername) . "\n";
    $email_message .= "Email: " . clean_string($email) . "\n";
    $email_message .= "Subject: " . clean_string($subject) . "\n";
    $email_message .= "Message: " . clean_string($message) . "\n";

    // create email headers
    $headers = 'From: ' . $email . "\r\n" .
        'Reply-To: ' . $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    @mail($email_to, $email_subject, $email_message, $headers);
?>

    <!-- Replace this as your success message -->

    Thanks for reaching out. I will get back to you as soon as possible. -AnneMarie

<?php
}
?>
