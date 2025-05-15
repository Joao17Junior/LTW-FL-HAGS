<?php
    $msg = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once __DIR__ . '/../Core/Signin.php';
        $signin = new Signin(
            $_POST['username'],
            $_POST['password']
        );
        $result = $signin->signinUser();
        if ($result == -1) {
            $msg = "User does not exist.";
        } elseif ($result == 1) {
            $msg = "Incorrect password.";
        } else {
            // On successful login, redirect to dashboard or home page
            echo "<script>
                setTimeout(function() {
                    window.location.href = '/_PROJ/index.php';
                }, 2000);
            </script>";
            $msg = "Login successful! Redirecting...";
        }
    }
    include __DIR__ . '/../Views/signin_view.php';
?>