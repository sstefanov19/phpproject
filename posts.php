<div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Create a New Post</h5>
                        <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] == 'emptyinput') {
            echo '<div class="alert alert-danger" role="alert">Please fill in all fields!</div>';
        } elseif ($_GET['error'] == 'stmtfailed') {
            echo '<div class="alert alert-danger" role="alert">Something went wrong, try again!</div>';
        } elseif ($_GET['error'] == 'none') {
            echo '<div class="alert alert-success" role="alert">Post created successfully!</div>';
        }
    }
    ?>
                        <form action="includes/posts.inc.php" method="post">
                            <div class="form-group">
                                <label for="postTitle">Post Title</label>
                                <input type="text" class="form-control" id="postTitle" placeholder="Enter title">
                            </div>
                            <div class="form-group">
                                <label for="postContent">Post Content</label>
                                <textarea class="form-control" id="postContent" rows="5" placeholder="Write your post here..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

