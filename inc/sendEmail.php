<?php

include_once('mailer.lib.php');

if($_POST) {
    /**
 	 * @param Object $error 에러 오브젝트
 	 */
    $error = null;

    /**
 	 * @param String $ownersEmail 관리자 이메일
 	 */
    $ownersEmail = 'iampet1@naver.com';

    /**
 	 * @param String $message 메일 내용
 	 */
    $message = '';

    /**
 	 * @param String $name 송신자 명
 	 */
    $name = trim(stripslashes($_POST['contactName']));

    /**
 	 * @param String $email 송시자 메일
 	 */
    $email = trim(stripslashes($_POST['contactEmail']));

    /**
 	 * @param String $subject 메일 제목
 	 */
    $subject = trim(stripslashes($_POST['contactSubject']));

    /**
 	 * @param String $contact_message 송신 내용
 	 */
    $contact_message = trim(stripslashes($_POST['contactMessage']));

    // 입력항목에 대해 유효성검증을 한다.
    if (strlen($name) < 2) {
        $error['name'] = "Please enter your name.";
    }
    if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
        $error['email'] = "Please enter a valid email address.";
    }
    if (strlen($contact_message) < 15) {
        $error['message'] = "Please enter your message. It should have at least 15 characters.";
    }
    if ($subject == '') {
        $subject = "Contact Form Submission"; 
    }

    // 컨텐츠 내용을 설정한다.
    $message .= "Email from: " . $name . "<br />";
    $message .= "Email address: " . $email . "<br />";
    $message .= "Message: <br />";
    $message .= $contact_message;
    $message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

    if ($error == null) {
        mailer($name, $ownersEmail, $ownersEmail, $subject, $message, 1);
        echo "OK"; 
    }
    else {
        $response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
        $response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
        $response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;
        
        echo $response;
    }
}
?>