<?php

require 'app/models/Post.php';

class PostController {
    public function index() {
        $posts = $this->getAllPosts();
        require 'public/views/posts.html';
    }

    public function create() {
        require 'public/views/add-post.html';
    }

    public function store () {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = trim($_POST['tite']);
            $content = trim($_POST['content']);

            if (strlen($title) < 5 || strlen($content) < 10) {
                // Show error if title or content is too short
                $error = "Title must be at least 5 characters and content at least 10 characters.";
                require 'public/views/add-post.html';
            } else {
                // Create a new Post
                $post = new Post($title, $content);
                // Assuming you have a database interaction here to save the post
                // $post->save(); // Implement save method in Post model
                header("Location: /posts");  // Redirect after successful submission
            }
        }
    }

    public function search()
    {
        if (isset($_GET['search'])) {
            $searchTitle = $_GET['search'];
            $posts = $this->searchPostsByTitle($searchTitle);  // Implement search functionality
            require 'public/views/posts.html';  // Display search results
        }
    }

    private function getAllPosts()
    {
        // Return all posts from database (simulate with an array for now)
        return [
            new Post('Post 1', 'Content of Post 1'),
            new Post('Post 2', 'Content of Post 2')
        ];
    }

    private function searchPostsByTitle($title)
    {
        // Simulate a search function (you can implement real search logic here)
        $allPosts = $this->getAllPosts();
        return array_filter($allPosts, function($post) use ($title) {
            return stripos($post->title, $title) !== false;
        });
    }
}
