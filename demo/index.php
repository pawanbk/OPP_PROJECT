<?php 
require '../core/init.php';
include "../components/header.php";
?>
<div class="Container">
    <div class='box-wrapper'>
        <div class="form-box">
        </div>
    </div>
    <div class="comment-wrapper">
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="page-header">
                <h1><small class="pull-right">45 comments</small> Comments </h1>
            </div> 
             <form method='post' action='handle.php'>
                <div class="form-group">
                    <textarea name='comment' class="form-control mr-3" placeholder="leave a comment.."></textarea>
                    <input type="hidden"  name='task_id' value="">
                    <button class="btn btn-info" name='addComment' type="submit">Comment</button>
                </div>
            </form>
            <div class="comments-list">
                <div class="media">
                    <p class="pull-right"><small>5 days ago</small></p>
                    <div class="media-body">
                        <h4 class="media-heading user_name">Baltej Singh</h4>
                        Wow! this is really great.
                        <p><small><a href="">Like</a> - <a href="">Share</a></small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
</div>
