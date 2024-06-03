<?php
include_once "header.php";
require_once 'includes/dbh.inc.php';

// Fetch posts and corresponding user info
$sql = "SELECT posts.postId, posts.postTitle, posts.postContent, posts.postDate, posts.userId, users.usersUid 
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
                <img src="<?php echo isset($_SESSION['profilePic']) ? $_SESSION['profilePic'] : 'https://via.placeholder.com/150'; ?>"
                    class="card-img-top" alt="Profile Picture">
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
                        Here’s your profile information.
                    </p>
                    <form action="upload.php" method="POST" enctype="multipart/form-data">
                        <input type="file" name="profilePic">
                        <button type="submit" name="submit">Upload</button>
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
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        By <?php echo htmlspecialchars($post['usersUid']); ?>
                                        on <?php echo htmlspecialchars($post['postDate']); ?>
                                        <?php if (isset($_SESSION['userid']) && $_SESSION['userid'] != $post['userId']): ?>
                                            <form action="follow.php" method="POST" style="display:inline;">
                                                <input type="hidden" name="user_id" value="<?php echo $post['userId']; ?>">
                                                <button type="submit" name="follow" class="btn btn-link">Follow</button>
                                            </form>
                                        <?php endif; ?>
                                    </h6>
                                    <p class="card-text"><?php echo nl2br(htmlspecialchars($post['postContent'])); ?></p>
                                    <?php
                                    if (isset($_SESSION['userid']) && $_SESSION['userid'] == $post['userId']) {
                                        echo "<button class='btn btn-warning' onclick='openEditModal(" . json_encode($post) . ")'>Edit</button>";
                                        echo "<a href='delete.php?delete_id=" . htmlspecialchars($post['postId']) . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this post?\");'>Delete</a>";
                                    }
                                    ?>
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

<!-- Edit Post Modal -->
<div class="modal fade" id="editPostModal" tabindex="-1" role="dialog" aria-labelledby="editPostModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPostModalLabel">Edit Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editPostForm" action="edit_post.php" method="POST">
                    <input type="hidden" id="editPostId" name="postId">
                    <div class="form-group">
                        <label for="editPostTitle">Post Title</label>
                        <input type="text" class="form-control" id="editPostTitle" name="title">
                    </div>
                    <div class="form-group">
                        <label for="editPostContent">Post Content</label>
                        <textarea class="form-control" id="editPostContent" name="content" rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="script.js"></script>

</body>
</html>
