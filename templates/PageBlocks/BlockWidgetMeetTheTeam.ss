<article>
	<% if ShowTitle %>
		<h2>$Title</h2>
	<% end_if %>
	<% loop TeamMembers %>
		<a class="TeamMemberBox" href="$TargetPage.Link" title="$Name">
			<img alt="" src="$TeamMemberPhoto.CroppedImage(251,308).URL">
			<p>$Name</p>
			<br>
			<p>$JobTitle</p>
		</a>
	<% end_loop %>
</article>