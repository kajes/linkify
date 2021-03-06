<?php

//================================================================================================
// Initiate database connection
//================================================================================================
$dbConnectString = 'mysql:host=localhost;port=3306;dbname=kajes_linkify;charset=utf8';
$dbUser = 'root';
$dbPassword = 'root';
// FIXME: Change db user to something else than root

try {
    $dbConnection = new PDO($dbConnectString, $dbUser, $dbPassword);
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo '<h1 style="text-align: center;">Unable to connect to database.</h1>';
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'resources/logs/errorlog.txt', $e->getMessage()."\n", FILE_APPEND);
}

//================================================================================================
// Register and change user data
//================================================================================================
$registerUserQuery = <<<'EOT'
INSERT INTO users (name, email, password)
VALUES (:name, :email, :password)
EOT;

$registerUser = $dbConnection->prepare($registerUserQuery);

$updateUserQuery = <<<'EOT'
UPDATE users
SET email = :email, password = :password, bio = :userBio, avatarID = :avatarID, avatarImageType = :avatarImageType
WHERE uid = :uid
EOT;

$updateUser = $dbConnection->prepare($updateUserQuery);

//================================================================================================
// User sign in
//================================================================================================
$loginQuery = <<<'EOT'
SELECT * FROM users
WHERE email = :email
LIMIT 1
EOT;

$userVerify = $dbConnection->prepare($loginQuery);

//================================================================================================
// Post CUD (Create, Update, Delete) prepares
//================================================================================================
$postCreateQuery = <<<'EOT'
INSERT INTO posts (authorID, post_title, post_link, post_content, posted_on, updated_on, parent_id)
VALUES (:authorID, :post_title, :post_link, :post_content, :posted_on, :updated_on, :parent_id)
EOT;

$createPost = $dbConnection->prepare($postCreateQuery);

$postEditQuery = <<<'EOT'
UPDATE posts
SET post_content = :post_content, updated_on = :updated_on
WHERE postID = :postID
EOT;

$postEdit = $dbConnection->prepare($postEditQuery);

$postDeleteQuery = <<<'EOT'
DELETE FROM posts
WHERE postID = :postID
AND authorID = :user
EOT;

$postDelete = $dbConnection->prepare($postDeleteQuery);

//================================================================================================
// Voting update
//================================================================================================
$voteQuery = <<<'EOT'
UPDATE posts, users
SET posts.voteCount = posts.voteCount + (:vote), users.votedOn = :json
WHERE posts.postID = :postID
AND users.uid = :uid
EOT;

$registerVote = $dbConnection->prepare($voteQuery);

//================================================================================================
// Prepare ingredients for baking cookie
//================================================================================================
$bowl = <<<'EOT'
INSERT INTO tokens (uid, first, second, expire)
VALUES (:uid, :first, :second, :expire)
EOT;

$oven = $dbConnection->prepare($bowl);

//================================================================================================
// Set table for eating cookie
//================================================================================================
$plate = <<<'EOT'
SELECT * FROM tokens
WHERE uid = :uid
AND first = :first
AND second = :second
LIMIT 1
EOT;

$hand = $dbConnection->prepare($plate);

//================================================================================================
// Main Post feed queries
//================================================================================================

// Multiple posts
$query = <<<'EOT'
SELECT
    @postID:=posts.postID AS 'postID',
    posts.post_title AS 'title',
    posts.post_link AS 'link',
    posts.post_content AS 'content',
    posts.posted_on AS 'postDate',
    posts.updated_on AS 'updateDate',
    posts.voteCount AS 'voteCount',
    posts.parent_id AS 'parent',
    (SELECT COUNT(*) FROM posts WHERE parent_id = @postID) AS 'commentCount',
    users.uid AS 'userID',
    users.name AS 'author',
    users.avatarID AS 'avatarID',
    users.avatarImageType AS 'imgType'
FROM posts
INNER JOIN users
ON users.uid = posts.authorID
WHERE posts.parent_id = :parentID
ORDER BY 	posts.voteCount DESC, posts.posted_on DESC
EOT;

$mainPosts = $dbConnection->prepare($query);

// Single post query
$singleQuery = <<<'EOT'
SELECT
    posts.postID AS 'postID',
    posts.post_title AS 'title',
    posts.post_link AS 'link',
    posts.post_content AS 'content',
    posts.posted_on AS 'postDate',
    posts.updated_on AS 'updateDate',
    posts.voteCount AS 'voteCount',
    posts.parent_id AS 'parent',
    (SELECT COUNT(*) FROM posts WHERE parent_id = :parent) AS 'commentCount',
    users.uid AS 'userID',
    users.name AS 'author',
    users.avatarID AS 'avatarID',
    users.avatarImageType AS 'imgType'
FROM posts
INNER JOIN users
ON users.uid = posts.authorID
WHERE posts.postID = :postID
EOT;

$singlePost = $dbConnection->prepare($singleQuery);
