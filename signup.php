<?php
include_once "header.php";
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-body">
                    <h2 class="card-title text-center">Sign Up</h2>
                    <form action="includes/signup.inc.php" method="post">
                        <div class="form-group">
                            <?php

                            if (isset($_GET["error"])) {
                                if ($_GET["error"] == "emptyinput") {
                                    echo "<p>Fill in all fields</p>";
                                } else if ($_GET["error"] == "invaliduid") {
                                    echo "<p>Chose a proper username</p>";
                                } else if ($_GET["error"] == "invalidemail") {
                                    echo "<p>Chose a proper email</p>";
                                } else if ($_GET["error"] == "passwordsdontmatch") {
                                    echo "<p>Password doesnt match</p>";
                                } else if ($_GET["error"] == "smtfailed") {
                                    echo "<p>Something went wrong , try again</p>";
                                } else if ($_GET["error"] == "usernametaken") {
                                    echo "<p>Username already taken!</p>";
                                } else if ($_GET["error"] == "none") {
                                    echo "<p>You have signed up</p>";
                                }
                            }

                            ?>
                            <label>Full name:</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="text" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label>Username:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label>Password:</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="form-group">
                            <label>Repeat password:</label>
                            <input type="password" class="form-control" name="passwordRepeat" required>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary btn-block">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>