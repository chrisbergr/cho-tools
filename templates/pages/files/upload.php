<?php $this->layout( 'template' ); ?>

		<main>
			<section>

				<h1>File upload</h1>

				<form method="post" enctype="multipart/form-data">
					Upload a File:
					<input type="text" name="the_path" id="the_path" value="/">
					<input type="file" name="the_file" id="the_file">
					<input type="submit" name="submit" value="Start Upload">
				</form>

			</section>
		</main>
