<?php
class EmailMessagesController extends AppController {

	var $name = 'EmailMessages';
	var $helpers = array('Html', 'Form');
	var $uses = array('EmailMessage','EmailLetter','EmailTemplate','Ribbon','Tassel','Charm','Border');

	function index() {
		$this->EmailMessage->recursive = 0;
		$this->set('emailMessages', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid EmailMessage.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('emailMessage', $this->EmailMessage->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->EmailMessage->create();
			if ($this->EmailMessage->save($this->data)) {
				$this->Session->setFlash(__('The EmailMessage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The EmailMessage could not be saved. Please, try again.', true));
			}
		}
		$emailTemplates = $this->EmailMessage->EmailTemplate->find('list');
		$this->set(compact('emailTemplates'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid EmailMessage', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->EmailMessage->save($this->data)) {
				$this->Session->setFlash(__('The EmailMessage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The EmailMessage could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->EmailMessage->read(null, $id);
		}
		$emailTemplates = $this->EmailMessage->EmailTemplate->find('list');
		$this->set(compact('emailTemplates'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for EmailMessage', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->EmailMessage->del($id)) {
			$this->Session->setFlash(__('EmailMessage deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->EmailMessage->recursive = 0;
		$this->set('emailMessages', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid EmailMessage.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('emailMessage', $this->EmailMessage->read(null, $id));
	}

	function admin_add() {
		
		if (!empty($this->data)) {
			# Send email.
			$recipients = preg_split("/\n/", $this->data['EmailMessage']['recipients']);

			error_log("RECIP=".print_r($recipients,true));

			$subject = $this->data['EmailMessage']['subject'];
			$message = $this->data['EmailMessage']['custom_message'];
			# TODO ADD OTHER SNIPPETS.

			error_log("MESS=$message, SUB=$subject");

			$template = $this->data['EmailMessage']['email_template_id'];
			$emailTemplate = $this->EmailTemplate->read(null, $template);
			$this->set("emailTemplate", $emailTemplate);

			foreach($recipients as $email)
			{
				error_log("EMAIL='$email'");
				$customer = $this->Customer->find(" eMail_Address = '$email' ");
				if(!empty($this->data['EmailMessage']['create_account']))
				{
					 $account_type = $this->data['EmailMessage']['create_account'];
					 $billme = $this->data['EmailMessage']['allow_billme'];
					 $password = $this->data['EmailMessage']['account_password'];

					if (empty($customer)) {
						error_log("EMPTY CUSTOMER (NEW)");
					 	# Create since asked for and not existing.
					 	if(empty($password)) { $password = 'password2'; }

					 	$customer['Customer']['eMail_Address'] = $email;
					 	$customer['Customer']['Password'] = $password;
					 	$customer['Customer']['pricing_level'] = ($account_type == 'wholesale' ? 100 : 1);
					 	$customer['Customer']['is_wholesale'] = ($account_type == 'wholesale');
					 	$customer['Customer']['billme'] = $billme;
						$customer['Customer']['session_id'] = $this->Customer->generate_code(64);
						$customer['Customer']['dateAdded'] = date('Y-m-d H:i:s');

						$this->Customer->create();
						$this->Customer->save($customer);
					} else if(!empty($customer)) { # Make sure account is accurate.
						error_log("OTHER CUSTOMER (EXISTING)");
						$this->Customer->id = $customer['Customer']['customer_id'];
					 	$customer['Customer']['pricing_level'] = ($account_type == 'wholesale' ? 100 : 1);
					 	$customer['Customer']['is_wholesale'] = ($account_type == 'wholesale');
					 	$customer['Customer']['billme'] = $billme;
						$customer['Customer']['session_id'] = $this->Customer->generate_code(64);

						if(empty($customer['Customer']['Password']))
						{
							$customer['Customer']['Password'] = $password;
						}
						$this->Customer->save($customer);
					}
				}
				$this->data['Customer'] = $customer['Customer'];

				error_log("SENDING");
				$this->sendEmail($email, $subject, "email_message", $this->data);
			}

				error_log("DONE!");



			#############################################

			# Save in db.
			$this->EmailMessage->create();
			if ($this->EmailMessage->save($this->data)) {
				$this->Session->setFlash(__('The Email Message has been sent', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Email Message could not be sent. Please, try again.', true));
			}
		}
		$emailTemplates = $this->EmailMessage->EmailTemplate->find('list');
		$this->set(compact('emailTemplates'));

		$this->set("borders", $this->Border->find('list',array('order'=>'name ASC')));
		$this->set("ribbons", $this->Ribbon->find('list',array('fields'=>'color_name','order'=>'color_name ASC')));
		$this->set("tassels", $this->Tassel->find('list',array('fields'=>'color_name','order'=>'color_name ASC')));
		$this->set("charms", $this->Charm->find('list',array('order'=>'name ASC')));

		if(!empty($this->passedArgs['email_letter_id'])) # Fill out!
		{
			$emailLetter = $this->EmailLetter->read(null, $this->passedArgs['email_letter_id']);

			foreach($emailLetter['EmailLetter'] as $key => $val)
			{
				$this->data['EmailMessage'][$key] = $val;
			}

			$this->set("preview", true); # Auto preview!
			$this->data['EmailLetter'] = $emailLetter['EmailLetter'];
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid EmailMessage', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->EmailMessage->save($this->data)) {
				$this->Session->setFlash(__('The EmailMessage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The EmailMessage could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->EmailMessage->read(null, $id);
		}
		$emailTemplates = $this->EmailMessage->EmailTemplate->find('list');
		$this->set(compact('emailTemplates'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for EmailMessage', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->EmailMessage->del($id)) {
			$this->Session->setFlash(__('EmailMessage deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
