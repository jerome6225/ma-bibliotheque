<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" > 
	<head>
		<title><?php echo $titre; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>" />
		<meta name="viewport" content="width=device-width, minimum-scale=0.25, maximum-scale=1.6, initial-scale=1.0" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="Robots" content="none" />
        <?php foreach($css as $url): ?>
		    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $url; ?>" />
        <?php endforeach; ?>
	</head>
	<body>
		<div id="contenu">
			<div class="col-xs-12 jr_banner"><?php echo $banner; ?></div>
			<?php if ($menu != ''): ?>
				<div class="jr_sidebar hidden-xs hidden-sm"><?php echo $menu; ?></div>
				<div class="jr_content"><?php echo $output; ?></div>
			<?php else: ?>
			<div class="jr_content_without_menu"><?php echo $output; ?></div>
			<?php endif; ?>
		</div>

        <?php foreach($js as $url): ?>
		    <script type="text/javascript" src="<?php echo $url; ?>"></script> 
        <?php endforeach; ?>
	</body>
</html>