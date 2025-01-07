<?php

$conn = mysqli_connect("localhost", "root", "", "universitythesis") or die("Connection error: " . mysqli_connect_error());
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Thesis Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="output.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <script src="./assets/css/tailwindcss.css"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet" />
</head>

<body>
    <div class="flex bg-[#EBEFFF] w-full">
        <div class="w-full">
            <div class="w-[333px] mt-10">
                <h1 class="text-base font-medium bg-[#656ED3] text-white w-fit p-3 rounded-r-lg">
                    THESIS MANAGEMENT SYSTEM
                </h1>
            </div>

            <div class="flex justify-center items-center w-full">
                <div class="w-[416px] h-[400px]">
                    <div class="flex flex-col w-full mt-24 space-y-12">
                        <div class="text-center">
                            <h1 class="text-lg font-bold">Welcome Back!</h1>
                        </div>

                        <!-- Error message container (displayed if there's an error) -->
                        <?php if (isset($_SESSION['err'])) { ?>
                        <div class="bg-red-100 text-red-800 p-4 rounded-md text-center my-4 font-medium">
                            <?php echo $_SESSION['err']; ?>
                        </div>
                        <?php unset($_SESSION['err']);
                        } ?>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"
                            class="flex flex-col space-y-6">
                            <div class="flex flex-col space-y-2">
                                <label htmlFor="" class="font-medium text-lg mb-1">
                                    Email:
                                </label>
                                <input required type="text" name="email" placeholder=""
                                    class="p-2 border border-[#656ED3] rounded-full" />
                            </div>

                            <div class="flex flex-col space-y-2">
                                <label htmlFor="" class="font-medium text-lg mb-1">
                                    Password:
                                </label>
                                <input required type="password" name="password" placeholder=""
                                    class="p-2 border border-[#656ED3] rounded-full" />
                            </div>

                            <button type="submit" name="submit"
                                class="rounded-full bg-[#656ED3] text-white font-semibold w-full py-2">
                                Login
                            </button>
                        </form>

                        <div class="flex justify-center items-center mt-4">
                            <h1 class="font-semibold text-lg mr-2">
                                Dont have an account ?
                            </h1>
                            <a href="./register/index.php" class="text-[#656ED3] font-semibold text-lg">
                                Register Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-[478px] bg-[#AFB3FF] h-screen">
            <div class="relative">
                <img src="./assets/images/laptop.png" class="absolute top-[200px] right-[40%]" />
            </div>
        </div>
    </div>
</body>

</html>

<?php
if (isset($_REQUEST['submit'])) {
    $email = $_REQUEST['email'];
    $password = sha1($_REQUEST['password']); // Hash the password with sha1

    // Use prepared statements for secure database queries
    $stmt = $conn->prepare("SELECT id, email, name, username, role, avatar FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($rows = $result->fetch_assoc()) {
            // Set session variables
            $_SESSION['email'] = $rows['email'];
            $_SESSION['name'] = $rows['name'];
            $_SESSION['uname'] = $rows['username'];
            $_SESSION['id'] = $rows['id'];
            $_SESSION['role'] = $rows['role'];
            $_SESSION['profile'] = $rows['avatar'];

            // Redirect to the dashboard
            header("location: http://localhost/uni-thesis-backend-main/admin/dashboard.php");
            exit();
        }
    } else {
        // Login failed, show error
        $_SESSION['err'] = "Invalid email or password.";
        echo "<script>";
        echo "window.location.href = './index.php';";
        echo "</script>";
        exit();
    }
}
?>
