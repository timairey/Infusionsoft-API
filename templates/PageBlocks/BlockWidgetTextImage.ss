<article>
<div class="ImgAndTxtBox">
	<% if ImagePosition=='Left' %>
		<img src="$Image.URL" alt="" class="fl">
	<% end_if %>
	<% if ImagePosition=='Right' %>
		<img src="$Image.URL" alt="" class="fl-right">
	<% end_if %>
	<% if ShowTitle %>
		<h3>$Title</h3>
	<% end_if %>
	<p>$Content</p>
	
</div>
</article>