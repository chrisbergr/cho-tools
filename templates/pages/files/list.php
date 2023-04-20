<?php $this->layout( 'template' ); ?>

		<main>
			<section>

				<h1>View Files</h1>

				<?php if ( isset( $query['dir_up'] ) ) : ?>
					<p><a href="?path=<?=$this->e( $query['dir_up'] )?>">Back</a></p>
				<?php else : ?>
					<p>&nbsp;</p>
				<?php endif; ?>

				<?php if ( 0 < $query['size'] ) : ?>

				<ul class="directory-list">

					<?php foreach( $query['items'] as $row ) : ?>

						<?php if ( 'file' === $row['type'] ) : ?>

							<li class="directory-list--item directory-list-item--image">
								<?=$this->insert( 'partials/model-file', [
									'data' => $row,
								] )?>

							</li>

						<?php endif; ?>

						<?php if ( 'dir' === $row['type'] ) : ?>

							<li class="directory-list--item directory-list-item--dir">
								<?=$this->insert( 'partials/model-dir', [
									'data' => $row,
								] )?>

							</li>

						<?php endif; ?>

					<?php endforeach; ?>

				</ul>

				<?php endif; ?>


			</section>
		</main>
