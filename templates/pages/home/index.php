<?php $this->layout( 'template' ); ?>

		<main>
			<section>

				<h1>Home</h1>

				<?php //echo $this->e( $greeting )?>

				<?=$greeting?>





			</section>
			<section>

				<h2>Actions:</h2>

				<ul>

					<li><a href="/website/new-pin/">Create new Pin</a></li>

					<li><a href="javascript:(function(){
					var open_page='<?=$this->e( $new_pin_url )?>?url='+document.location.href;
					window.open(
					open_page,
					'_blank',
					'resizable=1,location=1,menubar=0,toolbar=0,personalbar=0,scrollbar=1,status=0,width=1250,height=700'
					);
					})();" id="bookmarklet">CHO PIN</a> (Bookmarklet)</li>

					<li><input type="text" value="javascript:(function(){var open_page='<?=$this->e( $new_pin_url )?>?url='+document.location.href;window.open(open_page,'_blank','resizable=1,location=1,menubar=0,toolbar=0,personalbar=0,scrollbar=1,status=0,width=1250,height=700');})();">

					<li>&nbsp;</li>

					<li><a href="/files/">Images</a></li>
					<li><a href="/files/upload/">Upload Image</a></li>

				</ul>

			</section>
		</main>
