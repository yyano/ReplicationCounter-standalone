<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <title><?= $title ?></title>
  <link href="output.css" rel="stylesheet">
</head>

<body class="w-full bg-white">
  <div class="m-3 p-3 shadow bg-gray-100">
    <?= $formContent?? '' ?>
  </div>

  <div class="m-3 p-3 shadow bg-gray-100">
    <h2>Status</h2>
    <?= $statusContent?? '' ?>
    <?= $printValue?? '' ?>
  </div>
</body>

</html>
