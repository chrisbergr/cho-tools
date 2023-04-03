<?php $this->layout( 'template' ); ?>

		<main>
			<section id="theImages"><p>Source missing</p></section>
			<section id="theForm">
				<?php if ( ! isset( $_GET['url'] ) ) : ?>
					<form action="/website/new-pin/" method="get">
						<p><input type="text" id="url" name="url" placeholder="URL"></p>
						<p><input type="submit" value="Submit"></p>
					</form>
					<p>&nbsp;</p>
					<p><a href="/">Back</a></p>
				<?php else : ?>
					<form action="/website/new-pin/receiver/" method="post">
						<p>
							<label>Title<br>
								<input type="text" id="form_title" name="form_title">
							</label>
						</p>
						<p>
							<label>Image<br>
								<input type="text" id="form_image" name="form_image">
							</label>
						</p>
						<p>
							<label>Bookmark<br>
								<input type="text" id="form_bookmark" name="form_bookmark" value="<?php echo $_GET['url']; ?>">
							</label>
						</p>
						<p>
							<label>Description<br>
								<textarea id="form_description" name="form_description" rows="5" cols="33"></textarea>
							</label>
						</p>
						<p id="form_tags_container"></p>
						<p>
								<input type="submit" value="Submit">
						</p>
					</form>
					<p><a href="/website/new-pin/">Back</a></p>
				<?php endif; ?>
			</section>
		</main>

		<script>
			function use_image_for_form( url ) {
				document.querySelector( '#form_image' ).value = url;
			}
			function remove_active_image() {
				var elm = document.querySelector( '.image-list--item.active' );
				if ( elm ) {
					elm.classList.remove( 'active' );
				}
			}
			function proceed_images() {
				var elms = document.querySelectorAll( '.image-list--item' );
				console.log(elms);
				for ( var i = 0; i < elms.length; i++ ) {
					elms[i].addEventListener( 'click', function() {
						remove_active_image();
						this.classList.add( 'active' );
						use_image_for_form( this.querySelector( 'img' ).src );
						console.log(this);
					} );
				}
			}
			function get_images_from_url( url ) {
				var data = 'site_url=' + url;
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function () {
					var elm = document.querySelector('#theImages');
					console.log(xhttp.readyState);
					if ( xhttp.readyState === 1 ) {
						elm.innerHTML = 'loading';
					}
					if ( xhttp.readyState === 4 ) {
						elm.innerHTML = xhttp.responseText;
						proceed_images();
					}
				};
				xhttp.open( "POST", "/website/new-pin/images/", true );
				xhttp.setRequestHeader( "Content-Type", "application/x-www-form-urlencoded; charset=UTF-8" );
				xhttp.send( data );
			}
			function get_tags() {
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function () {
					var elm = document.querySelector('#form_tags_container');
					console.log(xhttp.readyState);
					if ( xhttp.readyState === 1 ) {
						elm.innerHTML = 'loading';
					}
					if ( xhttp.readyState === 4 ) {
						elm.innerHTML = xhttp.responseText;
					}
				};
				xhttp.open( "GET", "/website/new-pin/tags/", true );
				xhttp.setRequestHeader( "Content-Type", "application/x-www-form-urlencoded; charset=UTF-8" );
				xhttp.send();
			}
			<?php if ( isset( $_GET['url'] ) ) : ?>
				get_images_from_url( '<?php echo $_GET['url']; ?>' );
				get_tags();
			<?php endif; ?>


		</script>
