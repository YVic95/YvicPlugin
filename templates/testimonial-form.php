<form id="yvic-testimonial-form" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">

	<div class="field-container">
		<input type="text" class="field-input" placeholder="Your Name" id="name" name="name" required>
		<div class="msg-holder" data-error="invalidName">
			<small class="field-msg error">Your Name is Required</small>
		</div>
	</div>

	<div class="field-container">
		<input type="email" class="field-input" placeholder="Your Email" id="email" name="email" required>
		<div class="msg-holder" data-error="invalidEmail">
			<small class="field-msg error">Your Email is Required</small>
		</div>
	</div>

	<div class="field-container text-box">
		<textarea name="message" id="message" class="field-input" placeholder="Your Message" required></textarea>
		<div class="msg-holder" data-error="invalidMessage">
			<small class="field-msg error">A Message is Required</small>
		</div>
	</div>
	
	<div class="field-container">
		<div>
            <button type="stubmit" class="btn btn-default btn-lg btn-sunset-form">Submit</button>
		</div>
		<div class="msg-holder js-form-submission">
			<small class="field-msg js-form-submission-msg">Submission in process, please wait&hellip;</small>
		</div>
		<div class="msg-holder js-form-success">
			<small class="field-msg success js-form-success-msg">Message Successfully submitted, thank you!</small>
		</div>
		<div class="msg-holder js-form-error">
			<small class="field-msg error js-form-error-msg">There was a problem with the Contact Form, please try again!</small>
		</div>
	</div>

	<input type="hidden" name="action" value="submit_testimonial">

</form>