<!doctype html>
<html >
<head>
    <meta charset="utf-8">
    <title>HEY</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<?php include_once('navbar.php'); ?>

<?php $posts = ["a", "b", "c"]; ?>
<?php foreach ($posts as $post): ?>
    <div><?php echo $post; ?></div>
<?php endforeach; ?>

<?php //include_once('footer.php'); ?>
</body>
</html>