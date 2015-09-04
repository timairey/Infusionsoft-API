<form id="Form_SoftDataCaptureForm" action="{$Link}form" method="post" enctype="application/x-www-form-urlencoded" class="ebook-form">
	<h2>Get instant access</h2>
	<p>Enter your name and email address below and we'll immediatley send you a copy of the Ecommerce startup checklist.</p>
	<% if ErrorMessage %>
		<p>$ErrorMessage</p>
	<% end_if %>
	<% loop InfusionFormFields %>
		$Output
	<% end_loop %>
	<p class="submit">		
	<button type="submit" name="action_doCapture" value="Send my copy now" class="action" id="Form_SoftDataCaptureForm_action_doCapture">
		Send my copy now
	</button>


		
	</p>
</form>