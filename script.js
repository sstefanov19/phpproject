function openEditModal(post) {
    document.getElementById('editPostId').value = post.postId;
    document.getElementById('editPostTitle').value = post.postTitle;
    document.getElementById('editPostContent').value = post.postContent;
    $('#editPostModal').modal('show');
}

document.getElementById('editPostForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);

    fetch('edit_post.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            console.error('Error:', data.error);
        }
    })
    .catch(error => console.error('Error:', error));
});