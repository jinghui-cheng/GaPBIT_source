<!DOCTYPE html>
<html>
<head>
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,500,700' rel='stylesheet' type='text/css'>
	<title>GaPBIT</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="img/favicon.ico">
</head>
<body>
  <?php
    //efficacy-centered patterns
    $effRatio = 1140/3155;
    $effBoxWidth = 375 * $effRatio;
    $effBoxHeight = 125 * $effRatio;
    $effSpaceWidth = 151 * $effRatio;
    $effSpaceHeight = 117 * $effRatio;
    $effPaddingX = 338 * $effRatio;
    $effPaddingY = 50 * $effRatio;

    $effBoxNumberRow = 5;
    $effBoxNumberCol = 5;

    $effPatternPos = array(
      '1' => 'effp1',
      '5' => 'effp12',
      '6' => 'effp3',
      '7' => 'effp6',
      '8' => 'effp7',
      '9' => 'effp10',
      '10' => 'effp5',
      '11' => 'effp4',
      '13' => 'effp9',
      '14' => 'effp14',
      '15' => 'effp2',
      '17' => 'effp11',
      '19' => 'effp13',
      '22' => 'effp8'
    );

    //Read patterns name
    $fh = fopen('data/eff-patterns.csv', 'r');
    while (($data = fgetcsv($fh, 0, ",")) !== FALSE) {
      if ($data[0] == "id") {
        continue;
      }
      $effPatternName[$data[0]] = $data[2];
    }

    //Experience-centered patterns
		$expRatio = 1140/3155;

    $expBoxWidth = 375 * $expRatio;
    $expBoxHeight = 167 * $expRatio;
    $expSpaceWidth = 151 * $expRatio;
    $expSpaceHeight = 124 * $expRatio;
    $expPaddingX = 338 * $expRatio;
    $expPaddingY = 50 * $expRatio;

    $expBoxNumberRow = 4;
    $expBoxNumberCol = 5;

    $expPatternPos = array(
      '1' => 'expp1',
      '2' => 'expp9',
      '3' => 'expp7',
      '4' => 'expp8',
      '5' => 'expp11',
      '6' => 'expp6',
      '7' => 'expp4',
      '11' => 'expp5',
      '12' => 'expp3',
      '13' => 'expp2',
      '16' => 'expp10'
    );

    //Read patterns name
    $fh = fopen('data/exp-patterns.csv', 'r');
    while (($data = fgetcsv($fh, 0, ",")) !== FALSE) {
      if ($data[0] == "id") {
        continue;
      }
      $expPatternName[$data[0]] = $data[2];
    }
  ?>
  <h1>Effective-centered patterns</h1>
  <?php
    for ($i=0; $i<$effBoxNumberRow; $i++) {
      for ($j=0; $j<$effBoxNumberCol; $j++) {
          $index = $j + $effBoxNumberCol * $i;
          if (array_key_exists($index, $effPatternPos)) {
            $x = $effPaddingX;
            $y = $effPaddingY;
            if ($j != 0) {
              $x = $j*$effBoxWidth + $j*$effSpaceWidth + $effPaddingX;
            }
            if ($i != 0) {
              $y = $i*$effBoxHeight + $i*$effSpaceHeight + $effPaddingY;
            }
            $ex = $x+$effBoxWidth;
            $ey = $y+$effBoxHeight;
            echo '&lt;area shape="rect" coords="'.round($x).','.round($y).','.round($ex).','.round($ey).'"
                  href="eff-pattern.php?id='.$effPatternPos[$index].'" alt="'.$effPatternName[$effPatternPos[$index]].'"
									data-maphilight=\'{"shadow":true,"fill":false,"strokeWidth":4, "strokeColor":"555555"}\'&gt;<br>';
          }
      }
    }
  ?>

  <h1>Experience-centered patterns</h1>
  <?php
    for ($i=0; $i<$expBoxNumberRow; $i++) {
      for ($j=0; $j<$expBoxNumberCol; $j++) {
          $index = $j + $expBoxNumberCol * $i;
          if (array_key_exists($index, $expPatternPos)) {
            $x = $expPaddingX;
            $y = $expPaddingY;
            if ($j != 0) {
              $x = $j*$expBoxWidth + $j*$expSpaceWidth + $expPaddingX;
            }
            if ($i != 0) {
              $y = $i*$expBoxHeight + $i*$expSpaceHeight + $expPaddingY;
            }
            $ex = $x+$expBoxWidth;
            $ey = $y+$expBoxHeight;
            echo '&lt;area shape="rect" coords="'.round($x).','.round($y).','.round($ex).','.round($ey).'"
                  href="exp-pattern.php?id='.$expPatternPos[$index].'" alt="'.$expPatternName[$expPatternPos[$index]].'"
									data-maphilight=\'{"shadow":true,"fill":false,"strokeWidth":4, "strokeColor":"555555"}\'&gt;<br>';
          }
      }
    }
  ?>
</body>
</html>
