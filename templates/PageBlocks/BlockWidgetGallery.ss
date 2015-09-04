<article>
	<div class="SliderWrapper">
		<% if ShowTitle %>
			<h2>$Title</h2>
		<% end_if %>
		<ul class="bxslider">
			<% loop Images %>
				<li><img src="$Image.URL" alt="$Title" /></li>
			<% end_loop %>
		</ul>
		<div id="slide-counter-01" class="slide-counter"></div>
	</div>
</article>