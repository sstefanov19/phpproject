<?php 
include_once "header.php";
require_once 'includes/dbh.inc.php'; 



$sql = "SELECT posts.postTitle, posts.postContent, posts.postDate, users.usersUid 
        FROM posts 
        JOIN users ON posts.userId = users.usersId 
        ORDER BY posts.postDate DESC";
$result = mysqli_query($conn, $sql);
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<div class="container mt-5">
    <div class="row">
        <!-- Profile Section -->
        <div class="col-md-3">
            <div class="card">
               
                 <div class="card-body">
                    <h5 class="card-title">
                        <?php
                        if (isset($_SESSION['username'])) {
                            echo htmlspecialchars($_SESSION['username']);
                        } else {
                            echo "Guest";
                        }
                        ?>
                    </h5>
                    <p class="card-text">Welcome back,
                        <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?>!
                        Here’s your profile information.</p>
                    <form action="upload.php" method="POST" enctype="multipart/form-data">
                        <input type="file" name="profilePic">
                        <button type="submit" name="submit">Upload</button>
                        <?php include_once 'profile_pic.php'; ?>
                    </form>
                </div>
            </div>
        </div>

        <!-- Posts Display Section -->
        <div class="col-md-9">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h1 class="mb-4 text-center">Posts</h1>

                    <?php if (isset($_SESSION['userid'])): ?>
                        <!-- Post Creation Section -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Create a New Post</h5>
                                <form action="includes/posts.inc.php" method="POST">
                                    <div class="form-group">
                                        <label for="title">Post Title</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            placeholder="Enter title">
                                    </div>
                                    <div class="form-group">
                                        <label for="content">Post Content</label>
                                        <textarea class="form-control" id="content" name="content" rows="5"
                                            placeholder="Write your post here..."></textarea>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($posts)): ?>
                        <?php foreach ($posts as $post): ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($post['postTitle']); ?></h5>
                                    <h6 class="card-subtitle mb-2 text-muted">By
                                        <?php echo htmlspecialchars($post['usersUid']); ?> on
                                        <?php echo htmlspecialchars($post['postDate']); ?></h6>
                                    <p class="card-text"><?php echo nl2br(htmlspecialchars($post['postContent'])); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="card">
                            <div class="card-body">
                                <p class="card-text">No posts yet. Be the first to create a post!</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
