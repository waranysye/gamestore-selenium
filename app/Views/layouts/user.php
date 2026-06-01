
<?php
$activePage = $activePage ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Game Store</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root {
    --sidebar-bg:#1a2238;
    --main-bg:#12182b;
    --card-bg:#1c2541;
    --accent:#3a86ff;
    --text-main:#fff;
    --text-dim:#a0a0b8;
}
*{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif;}
body{background:var(--main-bg);color:var(--text-main);}


</style>
</head>
<script src="https://cdn.tailwindcss.com"></script>

<body>

<!-- GLOBAL HEADBAR -->
<?= view('partials/headbar') ?>

<?= $this->renderSection('content') ?>

</body>
</html>