<?php helper('html'); helper('auth'); helper('form');?>
<?= $this->extend("master")?>
<?= $this->section("content")?>
<style>
	select[readonly] {
	pointer-events: none;
	touch-action: none;
}
</style>
<?php $validation = \Config\Services::validation(); ?>
<?= script_tag('js/required/company-registration.js') ?>

<!-- multistep form -->
<form id="msform" action="<?= route_to('company/store') ?>" method="POST">
	<!-- progressbar -->
	<ul id="progressbar">
		<li class="active">Company Information</li>
		<li>Admin Information</li>
		<li>Payment Information</li>
	</ul>
	<?= view('Myth\Auth\Views\_message_block') ?>
	<!-- fieldsets -->
	<fieldset id="company-info">
		<h2 class="fs-title">Register Your Company</h2>
		<h3 class="fs-subtitle">Company Information</h3>
		<?php //if (isset($errors)) {
			//echo '<p class="alert alert-danger"><strong> There are some errors in the input fields </strong></p>';
		//} elseif (!empty($this->session->flashdata("error_message"))) {
		//	echo '<p class="alert alert-danger">' . $this->session->flashdata("error_message") . '</p>';
		//}
		?>
		<select name="plan" readonly class="form-control subscription_plan input-value">
			<option value="" disabled>Select A Plan</option>
			<?php //foreach ($plans as $plan) { ?>
				<option class="pre_selected" selected value="<?php //echo $plan['id'] ?>1"> BreakEven PRO&#174;
					$<?php echo number_format(getenv('LICENSE_SETUP_FEE'), 2) ?> start fee &
					$<?php //echo $plan['price'] ?> per month
				</option>
			<?php //} ?>
		</select>

		<p>
			<?php //echo form_error('plan'); ?>
			<?php //echo $this->session->flashdata('plan'); ?>
		</p>
		<input type="text" name="company_name" class="input-value" value="<?= old('company_name') ?>" placeholder="Company Name" required/>
		<input type="hidden" name="user_type" class="input-value" value="employee"/>
		<p>
			<?php echo $validation->getError('company_name'); ?>
			<?php //echo $this->session->flashdata('company_name'); ?>
		</p>
		<input type="text" name="owner_name" class="input-value" placeholder="Owner Name"
			   value="<?= old('company_name') ?>" required/>
		<p>
			<?php echo $validation->getError('owner_name'); ?>
			<?php //echo $this->session->flashdata('owner_name'); ?>
		</p>
		<input type="text" name="address" class="company_address input-value" placeholder="Address"
			   value="<?= old('company_name') ?>"/>
		<p>
			<?php echo $validation->getError('address'); ?>
			<?php //echo $this->session->flashdata('address'); ?>
		</p>

		<input type="text" name="city" class="company_city input-value" placeholder="City"
			   value="<?= old('city') ?>"/>
		<p>
			<?php echo $validation->getError('city'); ?>
			<?php //echo $this->session->flashdata('city'); ?>
		</p>

		<input type="text" name="state" class="company_state input-value" placeholder="State"
			   value="<?= old('state') ?>"/>
		<p>
			<?php echo $validation->getError('state'); ?>
			<?php //echo $this->session->flashdata('state'); ?>
		</p>

		<input type="text" name="postal_code" class="postal_code input-value" placeholder="Postal Code"
			   value="<?= old('postal_code') ?>"/>
		<p>
			<?php echo $validation->getError('postal_code'); ?>
			<?php //echo $this->session->flashdata('postal_code'); ?>
		</p>
		<input type="text" name="company_phone" class="input-value phone_us" placeholder="Phone"
			   value="<?= old('company_phone') ?>"/>
		<p>
			<?php //echo $this->session->flashdata('company_phone'); ?>
			<?php //echo $validation->getError('company_phone'); ?>
		</p>

		<div id="error-msg"></div>
		<button class="next action-button" type="button">Next</button>
	</fieldset>
	<fieldset id="employee-info">
		<h2 class="fs-title">Admin Employee Information</h2>
		<h3 class="fs-subtitle"></h3>

		<input type="text" placeholder="First Name" class="input-value" name="first_name"
			   value="<?= old('first_name') ?>" required/>
		<p>
			<?php echo $validation->getError('first_name'); ?>
			<?php //echo $this->session->flashdata('first_name'); ?>
		</p>

		<input type="text" placeholder="Last Name" class="input-value" name="last_name"
			   value="<?= old('last_name') ?>" required/>
		<p>
			<?php echo $validation->getError('last_name'); ?>
			<?php //echo $this->session->flashdata('last_name'); ?>
		</p>

		<input type="email" placeholder="Email" class="employee_email input-value check_email" name="email"
			   onblur="checkemail('employee');" onfocusout="match_email()"
			   value="<?= old('email') ?>"/>
		<input type="email" placeholder="Confrim Email" class="input-value check_confirm_email" name="confirm_email"
			   onfocusout="match_email()"/>
		<div id="email_error" style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
			<?php echo $validation->getError('email'); ?>
			<?php //echo $this->session->flashdata('email'); ?>
		</div>

		<div id="availability"></div>
		<div id="msg" class="pull-left" style="color: red"></div>
		<div class="email-mismatch pull-left" style="color: red"></div>

		<input type="password" placeholder="Password" class="input-value password" name="password"
			   onfocusout="match_password()"/>
		<input type="password" placeholder="Confirm Password" class="input-value confirm_password"
			   name="confirm_password" onfocusout="match_password()"/>
		<p>
			<?php echo $validation->getError('password'); ?>
			<?php //echo $this->session->flashdata('password'); ?>
		</p>
		<div class="password-mismatch pull-left" style="color: red"></div>

		<input type="text" placeholder="Mobile" class="input-value phone_us" name="mobile"
			   value="<?= old('mobile') ?>"/>

		<p>
			<?php echo $validation->getError('mobile'); ?>
			<?php //echo $this->session->flashdata('mobile'); ?>
		</p>

		<div id="error-msg"></div>
		<input type="button" name="previous" class="previous action-button" value="Previous"/>
		<button class="next action-button" type="button">Next</button>
	</fieldset>
	<fieldset id="payment-info">
		<div class="fs-subtitle">
			<p>
                <?= img('images/custom-images/logos/paypal.png') ?>
			</p>
			<p>
				<strong>You're just one step away from registering to the awesome BreakEven PRO<sup>®</sup></strong>
			</p>

			<p>
				<!--				<strong>You have just selected <span id="plan_name">-->
				<?php ////echo isset($subscription_plan['name']) ? $subscription_plan['name'].'plan' : '' ?><!--</span></strong>-->
				<strong>You have just selected <span id="plan_name"></span></strong>
			</p>
			<p>
				<!--				<strong>Get started with just <span id="plan_price">-->
				<?php //echo isset($subscription_plan['price']) ? '$'.$subscription_plan['price'] : '' ?><!--</span></strong>-->
				<strong><span style="font-size: 18px">$</span><span id="plan_price"></span> Per month with a <br> one
					time <span class="start-up-fee"><?php echo '$' . getenv('LICENSE_SETUP_FEE') ?></span> start
					fee</strong>
			</p>
		</div>
		<input type="button" name="previous" class="previous action-button" value="Previous"/>
		<button type="submit" class="action-button">Register</button>
	</fieldset>
</form>


<!--Terms and conditions modal-->
<div class="modal fade" id="terms_conditions" tabindex="-1" role="dialog" aria-labelledby="full-modal-label"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" data-border-top="multi">
			<div class="modal-header">
				<h4 class="modal-title">terms of service, and privacy agreement</h4>
				<p>
					Effective Date: <span>01/01/2018</span>
				</p>
			</div>
			<div class="modal-body clearfix" id="surfaces-methods">
				<div class="row">
					<div class="col-md-12">
						<!-- Privacy Policy -->
						<div class="block">
							<div class="main-text h2">
								PRIVACY POLICY
							</div>
							<div class="block-content-outer">
								<div class="block-content-inner">

									<div class="block-content">

										<p>
											We collect certain information through our website, located at <a
													href="<?php echo base_url() ?>">
												BepHost.BreakEvenPro.com</a> (our <u><b>“Website”</b></u>), and through
											the BreakEven PRO products and
											services
											. This page (this <u><b>“Privacy Policy”</b></u>) lays out our policies and
											procedures surrounding the
											collection
											and handling of any such information that identifies or could be used to
											contact or locate a user who
											is an individual (and not a business) or a user’s customers who are
											individuals
											(<u><b>“Personally Identifiable Information”</b></u> or <u><b>“PII”</b></u>).
										</p>

										<p>
											This Privacy Policy applies only to our Website and to BreakEven PRO
											products and services
											It does not apply to any third party site or service linked to our Website
											or recommended
											or referred by our Website, through our products or services, or by our
											staff.
											And it does not apply to any other website, product, or service operated by
											our company,
											or to any of our offline activities.
										</p>
									</div>

									<div class="block-content">
										<h4><b><u>A. PII We Collect</u></b></h4>

										<p>
											We may collect the following Personally Identifiable Information from users
											who buy our products or
											services: names, e-mail addresses, telephone numbers, addresses, and credit
											card numbers.
										</p>

										<p>
											We may use “cookies” or other tools to collect certain information from all
											users, including Web
											visitors who don’t buy anything through our Website. A cookie is a string of
											data our system sends
											to your computer and then uses to identify your computer when you return to
											our Website or use
											BreakEven PRO products or services. Cookies give us usage data, like how
											often you visit,
											where you go at the site, and what you do.
										</p>

										<p>
											We do not knowingly collect PII through our Website or BreakEven PRO
											products or services from children
											under the age of 13. The Website and BreakEven PRO products and services are
											intended for and directed
											to adults.
										</p>

									</div>

									<div class="block-content">
										<h3><b><u>B. Our Use of PII</u></b></h3>

										<p>
											Personally Identifiable Information may be used to create your account, to
											communicate with you about
											products and services you’ve purchased, to offer you additional products and
											services, as part of your
											use of the products and services, and to bill you. We may also use that
											information to the extent
											necessary to enforce our Website and BreakEven PRO Terms of Service and to
											prevent imminent harm to
											persons or property.
										</p>

										<p>
											We may use cookies or other tools so that our Website, products and services
											can remember you and provide
											you with the information you’re most likely to need. For instance, when you
											return to our Website, cookies
											identify you and prompt the site to provide your username (not your
											password), so you can sign in more quickly.
											Cookies also allow our Website to remind you of your past purchases and to
											suggest similar products and
											services. Finally, we use information gained through cookies to compile
											statistical information about use
											of our Website, products and services such as the time users spend at the
											site and the pages they visit
											most often. Those statistics do not include PII.
										</p>
									</div>

									<div class="block-content">
										<h3><b><u>C. Protection of PII</u></b></h3>

										<p>
											We employ physical, technical and administrative safeguards to protect
											Personally Identifiable Information.
											Unfortunately, even with these measures, we cannot guarantee the security of
											PII. By using our Website,
											products and services, you acknowledge and agree that we make no such
											guarantee, and that you use our
											Website, products and services at your own risk.
										</p>
									</div>

									<div class="block-content">
										<h3><b><u>D. Contractor and Other Third Party Access to PII</u></b></h3>

										<p>
											We may give certain independent contractors and service providers access to
											Personally Identifiable Information.
											Those contractors assist us with maintaining and updating the website and
											BreakEven PRO products and services
											and providing additional services to BreakEven PRO users. All those
											contractors are required to sign contracts
											in which they promise to protect PII using procedures reasonably similar to
											ours. (Users are not third party
											beneficiaries of those contracts.) We also may disclose PII to attorneys,
											collection agencies, or law
											enforcement authorities to address potential AUP violations, other contract
											violations, or illegal behavior.
											And we disclose any information demanded in a court order or otherwise
											required by law or to prevent imminent
											harm to persons or property. Finally, we may share PII in connection with a
											corporate transaction, like a merger
											or sale of our company, or a sale of all or substantially all of our assets
											or of the product or service line
											you received from us, or a bankruptcy.
										</p>

										<p>
											As noted above, we compile Website and product and service usage statistics
											from data collected through cookies.
											We may publish those statistics or share them with third parties, but they
											don’t include PII.
										</p>

										<p>
											Except as set forth in this Privacy Policy, we do not share PII with third
											parties.
										</p>
									</div>

									<div class="block-content">
										<h3><b><u>E. Accessing and Correcting Your PII</u></b></h3>

										<p>
											You can access and change any Personally Identifiable Information we store
											through your access
											to your products and services.
										</p>
									</div>

									<div class="block-content">
										<h3><b><u>F. Amendment of This Privacy Policy</u></b></h3>

										<p>
											We may change this Privacy Policy at any time by posting a new version on
											this page or on a successor page.
											The new version will become effective on the date it’s posted, which will be
											listed at the top of the page
											as the new Effective Date.
										</p>
									</div>

								</div>
							</div>
						</div>

						<!-- Terms and Conditions -->
						<div class="block">
							<div class="main-text h2">
								TERMS OF SERVICE
							</div>
							<div class="block-content-outer">
								<div class="block-content-inner">

									<div class="block-terms">
										<p>
											<b>
												PLEASE READ THESE TERMS OF SERVICE CAREFULLY. BY CLICKING “ACCEPTED AND
												AGREED TO,” CUSTOMER AGREES TO THE
												TERMS AND CONDITIONS SET FORTH IN THIS TERMS OF SERVICE AGREEMENT. THE
												AUTHORIZED PARTY SIGNING OR
												ELECTRONICALLY SUBMITTING THE ORDER OR ACESSING THE SERVICES REPRESENTS
												THAT IT HAS THE AUTHORITY
												TO BIND THE CUSTOMER AND UNDERSTANDS AND AGREES TO THE PROVISIONS SET
												FORTH IN THE ORDER AND THESE TERMS OF
												SERVICE.
											</b>
										</p>

										<p>
											The applicable Order and these Terms of Service constitute an agreement
											(this “Agreement”) by and between Good
											Son Industries, LLC whose principal place of business is 888 East Belvidere
											Road, Suite 117, Grayslake,
											Illinois (“Vendor”) and the corporation, LLC, partnership, sole
											proprietorship, or other business entity
											executing this Agreement (“Customer”). This Agreement is effective as of the
											date Customer clicks
											“Accepted and Agreed To” (the “Effective Date”). Customer’s use of and
											Vendor’s provision of
											Vendor’s Service (as defined below in Section 1.6) are governed by this
											Agreement.
										</p>
									</div>

									<div class="block-definitions">
										<h4>
											<b>1. DEFINITIONS.</b>
										</h4>
										<div class="clear10"></div>

										<p>
											The following capitalized terms will have the following meanings whenever
											used in this Agreement.
										</p>

										<p>
											<b>1.1.</b> “Customer Data” means data in electronic form input or collected
											through the
											Service by or from Customer,
											including without limitation by Customer’s Users.
										</p>

										<p>
											<b>1.2.</b> “Documentation” means Vendor's standard manual related to use of
											the Service in
											printed
											or electronic form.
										</p>

										<p>
											<b>1.3.</b> “Order” means an order for access to the Service.
										</p>

										<p>
											<b>1.4.</b> “Privacy Policy” means Vendor’s privacy policy, currently posted
											at bep.breakevenpro.com
										</p>
										<p>
											<b>1.5.</b> “Service” means Vendor’s generally available
											software-as-a-service,
											BreakEven PRO for cost estimation for labor intense businesses primarily
											contractors, and subcontractors.
										</p>
										<p>
											<b>1.6.</b> “SLA” means Vendor’s standard service level agreement, currently
											posted at
											bephost.breakevenpro.com.
										</p>
										<p>
											<b>1.7.</b> “Term” is defined in Section 11.1 below.
										</p>

										<p>
											<b>1.8.</b> “Updates” means any corrections, bug fixes, new features or
											functions added to
											the Service, but shall not include any new versions that Vendor markets and
											sells separately.
										</p>

										<p>
											<b>1.9.</b> “User” means any individual who uses the Service on Customer’s
											behalf or through
											Customer’s account or passwords, whether authorized or not.
										</p>

									</div>

									<div class="block-definitions">
										<h4>
											<b>2. THE SERVICE. </b>
										</h4>
										<div class="clear10"></div>

										<p>
											<b> 2.1.</b> Use of the Service. During the Term, Customer may access and
											use the Service
											pursuant to the terms of this Agreement and any outstanding Order, including
											such features and functions as the Order requires.
										</p>

										<p>
											<b> 2.2.</b> Service Levels. Vendor shall provide the remedies listed in the
											SLA for any
											failure of the Service listed in the SLA. Such remedies are Customer’s sole
											remedy for
											any failure of the Service, and Customer recognizes and agrees that if the
											SLA does not
											list a remedy for a given failure, it has no remedy. Credits issued pursuant
											to the SLA
											apply to future invoices only and are forfeited upon termination of this
											Agreement. Vendor
											is not required to issue refunds or to make payments against such credits
											under any circumstances,
											including without limitation after termination of this Agreement.
										</p>

										<p>
											<b> 2.3.</b> Documentation: Customer may reproduce and use the Documentation
											solely as
											necessary to support Users’ use of the Service.
										</p>

										<p>
											<b> 2.4.</b> Service Revisions. Vendor may modify the Service features and
											functions or
											the SLA at any time, including without limitation by removing such features
											and functions
											or reducing service levels without notice to customer provided that such
											modification
											will not materially affect the Service. If any such revision to the Service
											will materially
											reduce features or functionality provided pursuant to an Order, Vendor will
											provide notice
											to Customer and Customer may within 30 days of receipt of said notice,
											terminate such Order,
											without cause, or terminate this Agreement without cause if such Order is
											the only one
											outstanding. If any such revision to the SLA materially reduces service
											levels provided
											pursuant to an outstanding Order, the revisions will not go into effect with
											respect to
											such Order until the start of the Term beginning 45 or more days after
											Vendor posts the
											revision and so informs Customer.
										</p>

										<p>
											<b> 2.5.</b><a href="<?php echo base_url() ?>"> _admin@breakevenpro.com</a>
											is the primary
											point of contact for and will address all issues raised by Customer.
										</p>

									</div>

									<div class="block-definitions">
										<h4>
											<b>3. SERVICE FEES. </b>
										</h4>
										<div class="clear10"></div>

										<p>
											<b>3.1. </b> Customer shall pay Vendor all fees in accordance with the terms
											set forth in
											each Order (the “Service Fee”). Vendor will not be required to refund the
											Service Fee
											under any circumstances. Updates to the Service are included in the Service
											Fee.
										</p>

										<p>
											<b>3.2. </b> All orders are subject to acceptance by Vendor in its
											discretion. All Customer
											ordering information must be current, complete and accurate and it is
											Customer’s responsibility
											to advise Vendor of any changes to its ordering information.
										</p>

									</div>

									<div class="block-definitions">
										<h4>
											<b>4. CUSTOMER DATA & PRIVACY. </b>
										</h4>
										<div class="clear10"></div>

										<p>
											<b>4.1. </b> Use of Customer Data. Unless it receives Customer’s prior
											written consent,
											Vendor: (a) shall not access, process, or otherwise use Customer Data other
											than as necessary
											to facilitate the Service; and (b) shall not intentionally grant any third
											party access to
											Customer Data, including without limitation Vendor’s other customers, except
											subcontractors
											that are subject to a reasonable nondisclosure agreement. Notwithstanding
											the foregoing,
											Vendor may disclose Customer Data as required by applicable law or by proper
											legal or
											governmental authority. Vendor shall give Customer prompt notice of any such
											legal or
											governmental demand and reasonably cooperate with Customer in any effort to
											seek a protective
											order or otherwise to contest such required disclosure, at Customer’s
											expense.
										</p>

										<p>
											<b>4.2. </b> Privacy Policy. The Privacy Policy applies only to the Service
											and does not
											apply to any third party website or service linked to the Service or
											recommended or referred
											to through the Service or by Vendor’s staff.
										</p>

										<p>
											<b>4.3.</b> Risk of Exposure. Customer recognizes and agrees that hosting
											data online
											involves risks of unauthorized disclosure or exposure and that, in accessing
											and using the
											Service, Customer assumes such risks. Vendor offers no representation,
											warranty, or guarantee
											that Customer Data will not be exposed or disclosed through errors or the
											actions of third parties.
										</p>

										<p>
											<b>4.4. </b> Data Accuracy. Vendor will have no responsibility or liability
											for the
											accuracy of data uploaded to the Service by Customer, including without
											limitation Customer
											Data and any other data uploaded by Users.
										</p>

										<p>
											<b>4.5. </b> Data Deletion. Vendor may permanently erase Customer Data if
											Customer’s
											account is delinquent, suspended, or terminated for 30 days or more.
										</p>

										<p>
											<b>4.6. </b> Excluded Data. Customer represents and warrants that Customer
											Data does not
											and will not include, and Customer has not and shall not upload or transmit
											to Vendor's
											computers or other media, any data (“Excluded Data”) regulated pursuant to
											(the "Excluded
											Data Laws"). CUSTOMER RECOGNIZES AND AGREES THAT: (a) VENDOR HAS NO
											LIABILITY FOR ANY
											FAILURE TO PROVIDE PROTECTIONS SET FORTH IN THE EXCLUDED DATA LAWS OR
											OTHERWISE TO PROTECT
											EXCLUDED DATA; AND (b) VENDOR’S SERVICES ARE NOT INTENDED FOR MANAGEMENT OR
											PROTECTION OF
											EXCLUDED DATA AND MAY NOT PROVIDE ADEQUATE OR LEGALLY REQUIRED SECURITY FOR
											EXCLUDED DATA.
										</p>

										<p>
											<b>4.7. </b> Aggregate & Anonymized Data. Notwithstanding the provisions
											above of this
											Article 4, Vendor may use, reproduce, sell, publicize, or otherwise exploit
											Aggregate Data
											in any way, in its sole discretion. (“Aggregate Data” refers to Customer
											Data with the
											following removed: personally identifiable information and the names and
											addresses of
											Customer and any of its Users or customers.)
										</p>

									</div>

									<div class="block-definitions">
										<h4>
											<b>5. CUSTOMER’S RESPONSIBILITIES & RESTRICTIONS.</b>
										</h4>
										<div class="clear10"></div>

										<p>
											<b>5.1. </b> Acceptable Use. Customer shall comply with the AUP. Customer
											shall not: (a)
											reverse engineer, decrypt, decompile, decode, disassemble, or otherwise
											attempt to obtain
											the source code to the Services; (b) use the Service for service bureau or
											time-sharing
											purposes or in any other way allow third parties to exploit the Service; (c)
											remove or
											destroy any copyright notices, proprietary markings or confidential legends
											placed upon or
											contained within the Services or any copies thereof; (d) provide Service
											passwords or other
											log-in information to any third party; (e) share non-public Service features
											or content
											with any third party; or (f) access the Service in order to build a
											competitive product or
											service, to build a product using similar ideas, features, functions or
											graphics of the
											Service, or to copy any ideas, features, functions or graphics of the
											Service; (g)
											knowingly or negligently use the Service in a manner that abuses or disrupts
											the Vendor’s
											network, security system, user account or Services of Vendor or other
											properties or
											services of any third party; (h) use the Service, or data provided by the
											Service,
											in violation of any Vendor policies, applicable laws, ordinances, or
											regulations; or (i)
											otherwise use the Service for any purpose that is not contemplated by this
											Agreement.
											In the event that it suspects any breach of the requirements of this Section
											5.1,
											including without limitation by Users, Vendor may suspend Customer’s access
											to the
											Service immediately without advanced notice, in addition to such other
											remedies as Vendor
											may have. Neither this Agreement nor the AUP requires that Vendor take any
											action against
											Customer or any User or other third party for violating the AUP, this
											Section 5.1, or this
											Agreement, but Vendor is free to take any such action it sees fit.
										</p>

										<p>
											<b>5.2. </b> Unauthorized Access. Customer shall take reasonable steps to
											prevent
											unauthorized access to the Service, including without limitation by
											protecting its passwords
											and other log-in information. Customer shall notify Vendor immediately of
											any known or
											suspected unauthorized use of the Service or breach of its security and
											shall use best
											efforts to stop said breach.
										</p>

										<p>
											<b>5.3. </b> Compliance with Laws. In its use of the Service, Customer shall
											comply with
											all applicable laws, including without limitation laws governing the
											protection of
											personally identifiable information and other laws applicable to the
											protection of
											Customer Data.
										</p>

										<p>
											<b>5.4. </b> Users & Service Access. Customer is responsible and liable for:
											(a) Users’
											use of the Service, including without limitation unauthorized User conduct
											and any User
											conduct that would violate the AUP or the requirements of this Agreement
											applicable to
											Customer; and (b) any use of the Service through Customer’s account, whether
											authorized or
											unauthorized.
										</p>
										<p>
											<b>5.5. </b> Data Use. Anonymous, aggregate information, comprising
											financial account
											balances, other financial account data, or other available data that is
											provided to
											Customer, may be used by our third party vendors to conduct certain
											analytical research,
											performance tracking and benchmarking. Such third party vendors may publish
											summary or
											aggregate results relating to metrics comprised of research data, from time
											to time, and
											distribute or license such anonymous, aggregated research data for any
											purpose, including
											helping to improve products and services and assisting in troubleshooting
											and technical
											support. Customer’s personally identifiable information will not be shared
											with or sold
											to third parties.
										</p>
										<p>
											<b>5.6. </b> Data Transfer. Customer agrees and acknowledges that Customer’s
											data,
											including financial or personal information, may be transferred to a third
											party located in
											a country that does not have adequate security controls to protect
											Customer’s data.
										</p>
										<p>
											<b>5.7. </b> Third Party Services. Customer understands that the Services
											may require
											access to certain third party services (“Third Party Services”). In order to
											use the Services
											that uses or collects data from the Third Party Services, Customer hereby
											authorizes third
											party service providers, including Intuit, to obtain Customer’s data from
											third parties and
											share it with Vendor for the Services. Such data may include Customer’s
											financial or
											personal information with third parties. In addition, Customer agrees that
											Vendor may
											provide Customer’s data to the third party service provider. Customer
											represents and
											warrants that Customer has the rights and authority to provide such
											authorizations to the
											third party service providers and Vendor. Customer’s use and/or access to
											Third Party
											Services shall be limited to those uses and access rights permitted by the
											third party
											service provider. If Customer accesses or uses the Third Party Services,
											Customer is
											responsible for reviewing and understanding any such terms and conditions
											governing such
											Third Party Services. Customer understands that Vendor has no control over
											the Third Party
											Services and that Customer’s ability to access and use the Third Party
											Services may be
											suspended or terminated at any time, for any reason, at the third party
											service provider’s
											discretion.
										</p>

										<p>
											<b>5.8. </b> Security. Customers are fully responsible for the security of
											data on
											Customer’s website or otherwise in Customer’s possession or control.
											Customers agree to
											comply with all applicable state and federal laws and rules in connection
											with its
											collection, security and dissemination of any personal, financial, credit
											card, or
											transaction information (defined as “Data”) on its website. Customer agrees,
											where
											applicable, it shall be compliant with the Payment Card Industry Data
											Security Standards
											(PCI-DSS) and the Payment Application Data Security Standards (PA-DSS), as
											applicable.
											It is Customer’s responsibility to comply with these standards.
										</p>

										<p>
											<b>5.9. </b> Third Party Beneficiary. Customer acknowledges that Intuit is a
											third party
											beneficiary under this Agreement with rights to enforce the terms of this
											Agreement.
										</p>
									</div>

									<div class="block-definitions">
										<h4>
											<b>6. IP & FEEDBACK. </b>
										</h4>
										<div class="clear10"></div>

										<p>
											<b>6.1. </b> IP Rights to the Service. Vendor retains all right, title, and
											interest in
											and to the Service, including without limitation all software used to
											provide the Service
											and all graphics, user interfaces, logos, and trademarks reproduced through
											the Service;
											and all modifications, derivative works, and upgrades. This Agreement does
											not grant
											Customer any intellectual property license or rights in or to the Service or
											any of its
											components. Customer recognizes that the Service and its components are
											protected by
											copyright and other laws.
										</p>

										<p>
											<b>6.2. </b> Feedback. Vendor has not agreed to and does not agree to treat
											as
											confidential any Feedback (as defined below) Customer or Users provide to
											Vendor, and
											nothing in this Agreement or in the parties’ dealings arising out of or
											related to this
											Agreement will restrict Vendor’s right to use, profit from, disclose,
											publish, keep secret,
											or otherwise exploit Feedback, without compensating or crediting Customer or
											the User in
											question. Notwithstanding the provisions of Article 7 below, Feedback will
											not be considered
											Confidential Information, provided information Customer transmits with
											Feedback or related
											to Feedback may be considered Confidential Information. (“Feedback” refers
											to any suggestion
											or idea for improving or otherwise modifying any of Vendor’s products or
											services.)
										</p>
									</div>

									<div class="block-definitions">
										<h4>
											<b>7. CONFIDENTIAL INFORMATION. </b>
										</h4>
										<div class="clear10"></div>

										<p>
											“Confidential Information” refers to the following items Vendor discloses to
											Customer:
											(a) any document Vendor marks “Confidential”; (b) any information Vendor
											orally designates
											as “Confidential” at the time of disclosure, provided Vendor confirms such
											designation in
											writing within ten (10) business days; (c) the Documentation whether or not
											marked or
											designated confidential; and (d) any other nonpublic, sensitive information
											Customer should
											reasonably consider a trade secret or otherwise confidential.
											Notwithstanding the foregoing,
											Confidential Information does not include information that: (i) is in
											Customer’s possession
											at the time of disclosure; (ii) is independently developed by Customer
											without use of or
											reference to Confidential Information; (iii) becomes known publicly, before
											or after
											disclosure, other than as a result of Customer’s improper action or
											inaction; or (iv) is
											approved for release in writing by Vendor. Customer is on notice that the
											Confidential
											Information may include Vendor’s valuable trade secrets.
										</p>

										<p>
											<b>7.1. </b> Nondisclosure. Customer shall not use Confidential Information
											for any
											purpose other than in conjunction with accessing and using the Service (the
											“Purpose”).
											Customer: (a) shall not disclose Confidential Information to any employee or
											contractor
											of Customer unless such person needs access in order to facilitate the
											Purpose and executes
											a nondisclosure agreement with Customer with terms no less restrictive than
											those of this
											Article 7; and (b) shall not disclose Confidential Information to any other
											third party
											without Vendor’s prior written consent. Without limiting the generality of
											the foregoing,
											Customer shall protect Confidential Information with the same degree of care
											it uses to
											protect its own confidential information of similar nature and importance,
											but with no less
											than reasonable care. Customer shall promptly notify Vendor of any misuse or
											misappropriation of Confidential Information that comes to Customer’s
											attention.
											Notwithstanding the foregoing, Customer may disclose Confidential
											Information as
											required by applicable law or by proper legal or governmental authority.
											Customer
											shall give Vendor prompt notice of any such legal or governmental demand and
											reasonably
											cooperate with Vendor in any effort to seek a protective order or otherwise
											to contest
											such required disclosure, at Vendor’s expense.
										</p>

										<p>
											<b>7.2. </b> Injunction. Customer agrees that breach of this Article 7 would
											cause Vendor
											irreparable injury, for which monetary damages would not provide adequate
											compensation, and
											that in addition to any other remedy, Vendor will be entitled to injunctive
											relief against
											such breach or threatened breach, without proving actual damage or posting a
											bond or other
											security.
										</p>

										<p>
											<b>7.3. </b> Termination & Return. With respect to each item of Confidential
											Information,
											the obligations of Section 7.1 above (Nondisclosure) will terminate thirty
											(30) days after
											the date of disclosure; provided that such obligations related to
											Confidential Information
											constituting Vendor’s trade secrets will continue so long as such
											information remains
											subject to trade secret protection pursuant to applicable law. Upon
											termination of this
											Agreement, Customer shall return all copies of Confidential Information to
											Vendor or certify,
											in writing, the destruction thereof.
										</p>

										<p>
											<b>7.4. </b> Retention of Rights. This Agreement does not transfer ownership
											of
											Confidential Information or grant a license thereto. Vendor will retain all
											right, title,
											and interest in and to all Confidential Information.
										</p>

										<p>
											<b>7.5. </b> Exception & Immunity. Pursuant to the Defend Trade Secrets Act
											of 2016, 18
											USC Section 1833(b), Recipient is on notice and acknowledges that,
											notwithstanding the
											foregoing or any other provision of this Agreement:

										<ul style="list-style-type:none">
											<li>
												<b>(a)</b> Immunity. An individual shall not be held criminally or
												civilly liable
												under
												any Federal or State trade secret law for the disclosure of a trade
												secret
												that- (A) is made- (i) in confidence to a Federal, State, or local
												government
												official, either directly or indirectly, or to an attorney; and (ii)
												solely for
												the purpose of reporting or investigating a suspected violation of law;
												or (B)
												is made in a complaint or other document filed in a lawsuit or other
												proceeding,
												if such filing is made under seal.
											</li>
											<li>
												<b>(b)</b> Use of Trade Secret Information in Anti-Retaliation Lawsuit.
												An individual
												who files a lawsuit for retaliation by an employer for reporting a
												suspected
												violation of law may disclose the trade secret to the attorney of the
												individual
												and use the trade secret information in the court proceeding, if the
												individual-
												(A) files any document containing the trade secret under seal; and (B)
												does not
												disclose the trade secret, except pursuant to court order.
											</li>
										</ul>
										</p>

									</div>

									<div class="block-definitions">
										<h4>
											<b>8. REPRESENTATIONS & WARRANTIES. </b>
										</h4>
										<div class="clear10"></div>

										<p>
											<b>8.1. </b> Disclaimer. CUSTOMER ACKNOWLEDGES AND AGREES THAT THE SERVICES,
											ANY THIRD
											PARTY SERVICES AND ANY DATA PROVIDED VIA THE THIRD PARTY SERVICES OR
											SERVICES ARE PROVIDED
											“AS IS” AND “AS AVAILABLE.” VENDOR, ITS LICENSORS AND THIRD PARTY SERVICE
											PROVIDERS MAKE NO
											WARRANTY, EXPRESS, IMPLIED, OR STATUTORY AND DISCLAIM ANY AND ALL WARRANTIES
											WITH RESPECT
											TO THE SERVICES, ANY THIRD PARTY SERVICES OR ANY DATA PROVIDED VIA THE THIRD
											PARTY SERVICES
											OR SERVICES, IN WHOLE OR IN PART, INCLUDING WITHOUT LIMITATION ANY IMPLIED
											WARRANTY OF
											FITNESS FOR A PARTICULAR PURPOSE, MERCHANTABILITY, OR NON-INFRINGEMENT.
											CUSTOMER UNDERSTANDS
											AND AGREES THAT ANY USE OF THE SERVICES, THIRD PARTY SERVICES OR DATA
											PROVIDED VIA THE THIRD
											PARTY SERVICES OR SERVICES WILL BE AT CUSTOMER’S SOLE RISK, AND THAT, IF
											THERE IS ANY
											LIABILITY IN CONNECTION WITH THE SERVICES, INCLUDING LIABILITY ARISING FROM
											A SECURITY
											BREACH OR VENDOR’S LACK OF COMPLIANCE WITH APPLICABLE LAWS OR REGULATIONS OR
											DATA PRIVACY
											PROTECTION, SUCH LIABILITY IS SOLELY WITH THE VENDOR AND NOT ITS LICENSORS
											OR THIRD PARTY
											SERVICE PROVIDERS. WITHOUT LIMITING THE GENERALITY OF THE FOREGOING: (a)
											VENDOR HAS NO
											OBLIGATION TO INDEMNIFY OR DEFEND CUSTOMER OR USERS AGAINST CLAIMS RELATED
											TO INFRINGEMENT
											OF INTELLECTUAL PROPERTY; (b) VENDOR DOES NOT REPRESENT OR WARRANT THAT THE
											SERVICE WILL
											PERFORM WITHOUT INTERRUPTION OR ERROR; AND (c) VENDOR DOES NOT REPRESENT OR
											WARRANT THAT
											THE SERVICE IS SECURE FROM HACKING OR OTHER UNAUTHORIZED INTRUSION OR THAT
											CUSTOMER DATA
											WILL REMAIN PRIVATE OR SECURE. Vendor makes no warranty and will have no
											responsibility
											for any claim arising out of:

										<ul style="list-style-type:none">
											<li>
												<b>(i)</b> a modification of the Service made by anyone other than
												Vendor unless
												Vendor approves such modification in writing.
											</li>
											<li>
												<b>(ii)</b> use of the Service in combination with any operating system
												not
												authorized in the documentation.
											</li>
										</ul>
										</p>

										<p>
											<b>8.2. </b> From Customer. Customer represents and warrants that: (a) it
											has the full
											right and authority to enter into, execute, and perform its obligations
											under this
											Agreement and that no pending or threatened claim or litigation known to it
											would have a
											material adverse impact on its ability to perform as required by this
											Agreement; (b) it
											has accurately identified itself and it has not provided any inaccurate
											information about
											itself to or through the Service; and (c) it is a corporation, the sole
											proprietorship of
											an individual 18 years or older, or another entity authorized to do business
											pursuant to
											applicable law.
										</p>
									</div>

									<div class="block-definitions">
										<h4>
											<b>9. INDEMNIFICATION. </b>
										</h4>
										<div class="clear10"></div>

										<p>
											Customer shall defend, indemnify, and hold harmless Vendor and the Vendor
											Associates
											(as defined below) against any “Indemnified Claim,” meaning any third party
											claim, suit,
											or proceeding arising out of or related to Customer's alleged or actual use
											of, misuse of,
											or failure to use the Service, including without limitation: (a) claims by
											Users or by
											Customer's employees, as well as by Customer’s own customers; (b) claims
											related to
											unauthorized disclosure or exposure of personally identifiable information
											or other
											private information, including Customer Data; and (c) claims related to
											infringement or
											violation of a copyright, trademark, trade secret, or privacy or
											confidentiality right by
											written material, images, logos or other content uploaded to the Service
											through Customer’s
											account, including without limitation by Customer Data. Indemnified Claims
											include, without
											limitation, claims arising out of or related to Vendor’s negligence.
											Customer’s obligations
											set forth in this Article 9 include retention and payment of attorneys and
											payment of court
											costs, as well as settlement at Customer’s expense and payment of judgments.
											Vendor will
											have the right, not to be exercised unreasonably, to reject any settlement
											or compromise
											that requires that it admit wrongdoing or liability or subjects it to any
											ongoing
											affirmative obligations. (The “Vendor Associates” are Vendor’s officers,
											directors,
											shareholders, parents, subsidiaries, agents, successors, and assigns.)
										</p>
									</div>

									<div class="block-definitions">
										<h4>
											<b>10. LIMITATION OF LIABILITY.</b>
										</h4>
										<div class="clear10"></div>

										<p>
											<b>10.1. </b> VENDOR’S LIABILITY ARISING OUT OF OR RELATED TO THIS AGREEMENT
											WILL NOT
											EXCEED THE TOTAL AMOUNT OF FEES PAID AND PAYABLE BY CUSTOMER TO VENDOR
											DURING THE TWELVE
											MONTH PERIOD IMMEDIATELY PRECEEDING THE FIRST ACT GIVING RISE TO LIABILITY.
											IN NO EVENT
											WILL VENDOR BE LIABLE TO CUSTOMER FOR ANY CONSEQUENTIAL, INDIRECT, SPECIAL,
											INCIDENTAL,
											OR PUNITIVE DAMAGES ARISING OUT OF OR RELATED TO THIS AGREEMENT. THE
											LIABILITIES LIMITED
											BY THIS ARTICLE 10 APPLY: (a) TO LIABILITY FOR NEGLIGENCE; (b) REGARDLESS OF
											THE FORM OF
											ACTION, WHETHER IN CONTRACT, TORT, STRICT PRODUCT LIABILITY, OR OTHERWISE;
											(c) EVEN IF
											VENDOR IS ADVISED IN ADVANCE OF THE POSSIBILITY OF THE DAMAGES IN QUESTION
											AND EVEN IF SUCH
											DAMAGES WERE FORESEEABLE; AND (d) EVEN IF CUSTOMER’S REMEDIES FAIL OF THEIR
											ESSENTIAL
											PURPOSE. If applicable law limits the application of the provisions of this
											Article 10,
											Vendor’s liability will be limited to the maximum extent permissible. For
											the avoidance
											of doubt, Vendor’s liability limits and other rights set forth in this
											Article 10 apply
											likewise to Vendor’s affiliates, licensors, suppliers, advertisers, agents,
											sponsors,
											directors, officers, employees, consultants, and other representatives.
										</p>
									</div>

									<div class="block-definitions">
										<h4>
											<b>11. Term & Termination. </b>
										</h4>
										<div class="clear10"></div>

										<p>
											<b>11.1. </b> Term. The term of this Agreement (the “Term”) will commence on
											the
											Effective Date and continue for the period set forth in the Order or, if
											none, for one year.
											Thereafter, the Term will renew for successive one year periods, unless
											either party refuses
											such renewal by written notice 30 or more days before the renewal date.
										</p>

										<p>
											<b>11.2. </b> Termination for Cause. Either party may terminate this
											Agreement for the
											other’s material breach by written notice specifying in detail the nature of
											the breach,
											effective in 30 days unless the other party first cures such breach. Vendor
											may terminate
											this Agreement effective immediately if Customer, or one of Customer’s
											Users, breaches any
											of the provisions set forth in Section 5.1 of this Agreement.
										</p>

										<p>
											<b>11.3. </b> Effects of Termination. Termination of this Agreement by
											either party will
											not release the Customer from its obligation to all fees and expenses that
											accrued prior
											to the effective date of termination. On the effective date of termination
											of this
											Agreement, Vendor shall have the right to cancel Customer’s access to the
											Service and
											Customer shall cease all use of the Service and delete, destroy, or return
											all copies of
											the Documentation in its possession or control. The following provisions
											will survive
											termination or expiration of this Agreement: 3 (Service Fees), Section 6 (IP
											& Feedback),
											7 (Confidential Information), 9 (Indemnification), and 10 (Limitation of
											Liability); and
											any other provision of this Agreement that must survive to fulfill its
											essential purpose.
										</p>
									</div>

									<div class="block-definitions">
										<h4>
											<b>12. MISCELLANEOUS. </b>
										</h4>
										<div class="clear10"></div>

										<p>
											<b>12.1. </b> Independent Contractors. The parties are independent
											contractors and shall
											so represent themselves in all regards. Neither party is the agent of the
											other, and
											neither may make commitments on the other’s behalf.
										</p>

										<p>
											<b>12.2. </b> Notices. All notices required under this Agreement shall be in
											writing.
											Vendor may send notices pursuant to this Agreement to Customer’s email
											contact points
											provided by Customer, and such notices will be deemed received 24 hours
											after they are
											sent. Customer may send notices pursuant to this Agreement to <a
													href="mailto:admin@breakevenpro.com">
												admin@breakevenpro.com</a>, and such notices will be deemed received 72
											hours after they are sent.
										</p>

										<p>
											<b>12.3. </b> Force Majeure. No delay, failure, or default, other than a
											failure to pay fees
											when due, will constitute a breach of this Agreement, but only for so long
											as the force
											majeure event persists. Force majeure events may include: natural disasters,
											acts of war,
											terrorism (including cyberterrorism, data breach and hacking), activities of
											Internet
											Service Providers, other acts of God or of nature, strikes or other labor
											disputes, riots
											or other acts of civil disorder, embargoes, acts of government or other
											causes beyond the
											performing party’s reasonable control.
										</p>

										<p>
											<b>12.4. </b> Assignment & Successors. Customer may not assign this
											Agreement or any of
											its rights or obligations hereunder without Vendor’s express written
											consent. Except to the
											extent forbidden in this Section 12.4, this Agreement will be binding upon
											and inure to the
											benefit of the parties’ respective successors and assigns.
										</p>

										<p>
											<b>12.5. </b> Severability. To the extent permitted by applicable law, the
											parties hereby
											waive any provision of law that would render any clause of this Agreement
											invalid or
											otherwise unenforceable in any respect. In the event that a provision of
											this Agreement
											is held to be invalid or otherwise unenforceable, such provision will be
											interpreted to
											fulfill its intended purpose to the maximum extent permitted by applicable
											law, and the
											remaining provisions of this Agreement will continue in full force and
											effect.
										</p>

										<p>
											<b>12.6. </b> No Waiver. Neither party will be deemed to have waived any of
											its rights
											under this Agreement by lapse of time or by any statement or representation
											other than by
											an authorized representative in an explicit written waiver. No waiver of a
											breach of this
											Agreement will constitute a waiver of any other breach of this Agreement.

										</p>

										<p>
											<b>12.7. </b> Choice of Law & Jurisdiction: This Agreement and all claims
											arising out of or
											related to this Agreement will be governed solely by the internal laws of
											the State of
											Illinois, including without limitation applicable federal law, without
											reference to:
											(a) any conflicts of law principle that would apply the substantive laws of
											another
											jurisdiction to the parties’ rights or duties; (b) the 1980 United Nations
											Convention on
											Contracts for the International Sale of Goods; or (c) other international
											laws. The parties
											consent to the personal and exclusive jurisdiction of the federal and state
											courts of Lake
											County, Illinois. This Section 12.7 governs all claims arising out of or
											related to this
											Agreement, including without limitation tort claims.
										</p>

										<p>
											<b>12.8. </b> Conflicts. In the event of any conflict between this Agreement
											and any
											Vendor policy posted online, including the Privacy Policy, the terms of this
											Agreement
											will govern.
										</p>

										<p>
											<b>12.9. </b> Technology Export. Customer shall not: (a) permit any third
											party to
											access or use the Service in violation of any U.S. law or regulation; or (b)
											export any
											software provided by Vendor or otherwise remove it from the United States
											except in
											compliance with all applicable U.S. laws and regulations. Without limiting
											the generality
											of the foregoing, Customer shall not permit any third party to access or use
											the Service in,
											or export such software to, a country subject to a United States embargo as
											of the Effective
											Date of the Agreement.
										</p>

										<p>
											<b>12.10. </b> Entire Agreement. This Agreement sets forth the entire
											agreement of the
											parties and supersedes all prior or contemporaneous writings, negotiations,
											and discussions
											with respect to its subject matter. Neither party has relied upon any such
											prior or
											contemporaneous communications.
										</p>

										<p>
											<b>12.11. </b> Amendment. Vendor may amend this Agreement from time to time
											by posting
											an amended version at its Website and sending Customer written notice
											thereof. Such
											amendment will be deemed accepted and become effective 30 days after such
											notice
											(the “Proposed Amendment Date”) unless Customer first gives Vendor written
											notice of
											rejection of the amendment. In the event of such rejection, this Agreement
											will continue
											under its original provisions, and the amendment will become effective at
											the start of
											Customer’s next Term following the Proposed Amendment Date (unless Customer
											first terminates
											this Agreement pursuant to Article 11, Term & Termination). Customer’s
											continued use of the
											Service following the effective date of an amendment will confirm Customer’s
											consent thereto.
											This Agreement may not be amended in any other way except through a written
											agreement by
											authorized representatives of each party. Notwithstanding the foregoing
											provisions of this
											Section 12.11, Vendor may revise the Privacy Policy and Acceptable Use
											Policy at any time by
											posting a new version of either at the Website, and such new version will
											become effective
											on the date it is posted.
										</p>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

			<!-- modal footer -->
			<div class="modal-footer">
				<div class="agree_sentence">
					<input type="checkbox" class="agreement_checkbox">
					<p>I agree to the terms of service, and privacy agreement.</p>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">agree</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<!--End Terms and conditions modal-->

<?= script_tag('js/dropzone.js') ?>
<?= script_tag('js/required/jquery.mask.min.js') ?>
<?= script_tag('js/required/users.js') ?>
<script>
	var base_url = '<?php echo base_url()?>';
</script>

<script>
	// confirm email
	function match_email() {
		if ($('.check_email').val() === $('.check_confirm_email').val()) {
			$('.email-mismatch').text('');
			$('.submit_button').prop('disabled', false);
			// $('#msform').submit();
		} else {
			$('.email-mismatch').text('Email And Confirm Email Does Not Match');
			$('.submit_button').prop('disabled', true);
		}
	}

	// terms and conditions modal
	$(window).on('load', function () {
		$('#terms_conditions').modal({
			backdrop: 'static',
			keyboard: false
		});

		var $submit = $(".close").hide(),
				$cbs = $('.agreement_checkbox').click(function () {
					$submit.toggle($cbs.is(":checked"));
				});

	});

	$(document).ready(function () {
		var value = $('.subscription_plan .pre_selected').val();
		$(".subscription_plan .pre_selected").attr({selected: "selected"});
		$.ajax({
			url: base_url + "company/get_subscription",
			type: "POST",
			data: {id: value},
			dataType: 'json',
			success: function (response) {
				$('#subscription_name').text(response.name);
				$('#plan_name').text(response.name);
				$('#subscription_price').text(response.price);
				$('#plan_price').text(response.price);
			}
		});
	});


</script>

<?= $this->endSection()?>
