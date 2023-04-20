
		<style>
			html, body{
				margin: 0;
				padding: 0;
				height: 100%;
			}
			body{
				overflow: scroll;
			}
			body *,
			body *::after,
			body *::before{
				box-sizing: border-box;
			}
			main{
				display: flex;
				min-height: 100%;
				flex-direction: column;
			}
			@media only screen and ( min-device-width: 768px ){
				main{
					flex-direction: row;
				}
			}
			section{
				/*flex: 1;*/
				padding: 2rem;
			}
			#theImages{
				flex: 1;
				padding-right: 1rem;
				background-color: #f5f5f6;
			}
			#theForm{
				align-self: flex-start;
				position: sticky;
				top: 0;
				width: 100%;
			}
			@media only screen and ( min-device-width: 768px ){
				#theForm{
					width: unset;
				}
			}
			.directory-list{
				display: flex;
				flex-wrap: wrap;
				flex-direction: column;
				gap: 1rem;
				margin: 0;
				padding: 0;
				list-style: none;
			}
			.directory-list--item{
				position: relative;
			}
			.directory-list--item img{
				vertical-align: middle;
				margin-inline-end: 1rem;
			}
			.image-list{
				display: flex;
				flex-wrap: wrap;
				gap: 1rem;
				margin: 0;
				padding: 0;
				list-style: none;
			}
			.image-list--item{
				position: relative;
				border-radius: 0.25rem;
				font-size: 0;
			}
			.image-list--item.active{
				outline: 0.5rem solid #0085f2;
			}
			.image-list--item.active figcaption{
				background: #0085f2;
				color: #fff;
			}
			figure{
				margin: 0;
			}
			figure img{
				width: 100px;
				height: 100px;
				object-fit: cover;
			}
			@media only screen and ( min-device-width: 768px ){
				figure img{
					width: 200px;
					height: 200px;
				}
			}
			figure figcaption{
				position: absolute;
				bottom: 0;
				left: 0;
				padding-bottom: 0;
				padding-left: 0;
				padding-right: 0.65rem;
				padding-top: 0.4rem;
				border-top-right-radius: 0.5rem;
				background-color: #f5f5f6;
				font-size: 1rem;
			}
			select,
			input,
			textarea{
				width: 100%;
				padding: 0.25rem;
			}
			img{
				max-width: 100%;
			}
		</style>
