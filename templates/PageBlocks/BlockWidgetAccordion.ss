<article>
	<% if ShowTitle %>
		<h2>$Title</h2>
	<% end_if %>
	<% loop Items %>
		<h2 class="AccordeonHeader">$Title</h2>
		<div class="AccordeonContent">
			<p>$Content</p>
		</div>
	<% end_loop %>
</article>