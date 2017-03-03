<!DOCTYPE html>
<html>
<head>
	<title>Example of using the request class</title>

</head>
<body>
	<h1>Using the <em>request</em> class</h1>

<?php
include('class_request.php');
$request = new Request();

// get JSON data about a post
// - first get the data
$post = $request->getFile("https://jsonplaceholder.typicode.com/posts/1");
?>
<textarea>
<?php var_dump($post);?>
</textarea>
<?php 


// - secondly, decode the JSON into a Php object
$post = json_decode($post);
?>
<h2><?php echo $post->title;?></h2>
<p><?php echo $post->body;?></p>

<textarea>
<?php var_dump($post);?>
</textarea>

</body>
</html>