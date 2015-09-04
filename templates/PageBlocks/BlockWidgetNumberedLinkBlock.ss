<article>
	<% if ShowTitle %>
		<h2>$Title</h2>
	<% end_if %>
	<% loop Items %>
		<a class="WhatWeTackleBox" href="$TargetPage.URL" title="$Title#">
			<span>$Number</span>
			<p>$Title</p>
		</a>
	<% end_loop %>
</article>