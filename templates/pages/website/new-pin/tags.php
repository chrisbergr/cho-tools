<?php //print_r($request); ?>

<?php if ( 0 < count( $request ) ) : ?>

	<label>Tags<br>
		<select name="form_tags[]" id="form_tags" multiple size="10">

			<?php foreach( $request['items'] as $row ) : ?>

				<option value="<?=$this->e( $row['id'] )?>"><?=$this->e( $row['name'] )?></option>'

			<?php endforeach; ?>

		</select>
	</label>

<?php endif; ?>
