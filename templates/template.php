<!doctype html>
<html lang="en" class="no-js" prefix="og: http://ogp.me/ns#">
    <head>
		<?=$this->insert( 'partials/meta', [
			'title' => $this->e( $title ),
			'canonical' => $this->e( $root_url )
		] )?>
		<?=$this->insert( 'partials/styles' )?>

	</head>
	<body>
		<?=$this->section( 'content' )?>

	</body>
</html>
