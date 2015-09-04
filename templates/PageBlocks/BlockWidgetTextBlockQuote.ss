<article>
	<% if ShowTitle %>
		<h3>$Title</h3>
	<% end_if %>
	<% if QuotePosition=='Left'%>
		<div class="TxtAndBlockquoteBox-left">
			$Content
			<blockquote>$Quote</blockquote>
		</div>
	<% else %>
		<div class="TxtAndBlockquoteBox">
			$Content
			<blockquote>$Quote</blockquote>
		</div>
	<% end_if %>
</article>