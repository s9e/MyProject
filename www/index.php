<?php

use My\Project\TextFormatter\Bundle as TextFormatter;
include __DIR__ . '/../vendor/autoload.php';

$text = $_POST['text'] ?? 'Hello *world*!';
$xml  = TextFormatter::parse($text);
$html = TextFormatter::render($xml);

?><!DOCTYPE html>
<html lang="en">
<head>
	<title>My\Project demo</title>
</head>
<body>
	<div><form action="index.php" method="post">
		<textarea name="text" cols="80" rows="10"><?= htmlspecialchars($text) ?></textarea><br>
		<input type="submit">
	</form></div>

	<h5>Result</h5>
	<pre><code><?= htmlspecialchars($html) ?></code></pre>

	<script>
		var el = document.querySelector('textarea');
		el.focus();
		el.setSelectionRange(el.value.length, el.value.length);
	</script>
</body>
</html>