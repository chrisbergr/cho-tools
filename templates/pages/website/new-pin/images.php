<?php //print_r($request); ?>

<?php if ( 0 < count( $request ) ) : ?>

	<ul class="image-list">

		<?php foreach( $request['items'] as $row ) : ?>

			<?php if ( ( isset( $row['width'] ) && '' !== $row['width'] ) && ( isset( $row['height'] ) && '' !== $row['height'] ) ) : ?>

				<li class="image-list--item">
					<figure>
						<img src="<?=$this->e( $row['url'] )?>">
						<figcaption><?=$this->e( $row['width'] )?> x <?=$this->e( $row['height'] )?></figcaption>
					</figure>
				</li>

			<?php endif; ?>

		<?php endforeach; ?>

	</ul>

<?php endif; ?>
