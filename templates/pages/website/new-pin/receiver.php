<?php $this->layout( 'template' ); ?>

		<main>
			<section>

				<?php if ( isset( $request['message'] ) ) : ?>
					<?php print_r( $request['message'] ); ?>
				<?php else : ?>
					<p>New Post <a href="<?=$this->e( $request['link'] )?>" target="_blank"><?=$this->e( $request['title']['rendered'] )?></a> created.</p>
				<?php endif; ?>

				<p><a href="/website/new-pin/">Back</a></p>

			</section>
		</main>
