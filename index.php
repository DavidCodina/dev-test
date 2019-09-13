<?php include 'scripts/script.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Developer Test</title>
  <link rel="stylesheet" href="styles/style.css">
</head>


<body>
  <div id="top"></div>

  <header>
    <div class="header-content">
        <nav id="section-navigation">
        <a href="#section-1">Section 1</a>
        <a href="#section-2">Section 2</a>
      </nav>
      <h1>Dev Test</h1>
    </div>
  </header>

  <main>
    <section id="section-1">
      <h2 class="list-h2">Units with an <span>area</span> value of <span>1</span> : </h2>
      <?php echo isset($lists) ? $lists['area_is_1_list'] : '<p class="curl_err">Whoops! Something went wrong!' . $curl_err . '</p>';  ?>
    </section>

    <section id="section-2">
      <h2 class="list-h2">Units with an <span>area</span> value greater than <span>1</span> : </h2>
      <a class="back-to-top-link" href="#top">Back to Top</a>
      <?php echo isset($lists) ? $lists['area_is_not_1_list'] : '<p class="curl_err">Whoops! Something went wrong!' . $curl_err . '</p>'; ?>
      <a class="back-to-top-link" href="#top">Back to Top</a>
      </section>
  </main>

</body>
</html>
