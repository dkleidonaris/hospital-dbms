<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");

$PAGE_TITLE = "Login";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        echo "<script>alert('Username and password cannot be empty!');</script>";
    }
    $stmt = $dbh->prepare("SELECT * FROM User WHERE User.email=:email");
    $stmt->execute([':email' => $_POST['email']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($result)) {
        echo "<script>alert('Wrong email or password!');</script>";
    } else {
        if (password_verify($_POST['password'], $result['password'])) {
            echo "<script>alert('You have logged in!');</script>";

            $_SESSION['type'] = $result['type'];
            if ($result['type'] == 'doctor') {
                $_SESSION['doctor_id'] = $result['DoctorID'];

                $stmt = $dbh->prepare('SELECT FirstName, LastName FROM Doctor WHERE ID=:id');
                $stmt->execute([':id' => $result['DoctorID']]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $firstName = $result['FirstName'];
                $lastName = $result['LastName'];

                $_SESSION['message_type'] = 'success';
                $_SESSION['message'] = 'Welcome Dr. ' . $firstName . '!';
            } else {
                $_SESSION['nurse_id'] = $result['NurseID'];

                $stmt = $dbh->prepare('SELECT FirstName, LastName FROM Nurse WHERE ID=:id');
                $stmt->execute([':id' => $result['NurseID']]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $firstName = $result['FirstName'];
                $lastName = $result['LastName'];

                $_SESSION['message_type'] = 'success';
                $_SESSION['message'] = 'Welcome Nurse ' . $firstName . '!';
            }
            $_SESSION['first_name'] = $firstName;
            $_SESSION['last_name'] = $lastName;

            if ($_SESSION['type'] == 'doctor') {
                header('Location: ' . $_SESSION['last_page']);
                exit;
            } elseif ($_SESSION['type'] == 'nurse') {
                header('Location: ' . $_SESSION['last_page']);
                exit;
            } elseif ($_SESSION['type'] == 'admin') {
                header('Location: ' . $_SESSION['last_page']);
                exit;
            } else {
                echo "<script>alert('Wrong email or password!');</script>";
            }
        } else {
            echo "<script>alert('Wrong email or password!');</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/head-contents.php"); ?>
</head>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/navbar.php"); ?>
    <section class="pt-24 bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="/index.php" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="h-16 w-auto mr-2" src="/assets/img/logo_full.png" alt="logo">

            </a>
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Sign in to your account
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                        </div>
                        <button type="submit" class="w-full bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/body-scripts.php"); ?>
</body>

</html>