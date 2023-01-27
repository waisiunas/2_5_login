<?php require_once('./database/connection.php'); ?>

<?php

$name = $email = '';

if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $c_password = htmlspecialchars($_POST['cPassword']);

    if (empty($name)) {
        $error = 'Please enter your name!';
    } elseif (empty($email)) {
        $error = 'Please enter your email!';
    } elseif (empty($password)) {
        $error = 'Please enter your password!';
    } elseif ($password != $c_password) {
        $error = 'Merbani kr k password confirm krien!';
    } elseif (strlen($password) < 5) {
        $error = 'Minimum 5 characters are required!';
    } else {
        $sql = "SELECT * FROM `users` WHERE `email` = '$email'";
        $result = $conn->query($sql);
        if($result->num_rows != 0) {
            $error = 'Bhai jan Email change kr dien!';
        } else {
            $encrypted_password = sha1($password);
            $sql = "INSERT INTO `users`(`name`, `email`, `password`) VALUES ('$name','$email','$encrypted_password')";
            $result = $conn->query($sql);
            if($result) {
                $success = 'Magic has benn successfully spelled!';
                $name = $email = '';
                header('location: ./index.php');
            } else {
                $error = 'Magic has failed to spell!';
            }
            
        }
        
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Registration</h4>
                    </div>
                    <div class="card-body">
                        
                        <?php require_once('./partials/alerts.php'); ?>

                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name!" value="<?php echo $name; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email!" value="<?php echo $email; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password!">
                            </div>

                            <div class="mb-3">
                                <label for="cPassword" class="form-label">Confirm Password</label>
                                <input type="password" name="cPassword" id="cPassword" class="form-control" placeholder="Confirm your password!">
                            </div>

                            <div class="mb-3">
                                <input type="submit" value="Submit" name="submit" class="btn btn-primary">
                            </div>

                            <div>
                                Already have an account? <a href="./index.php">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>